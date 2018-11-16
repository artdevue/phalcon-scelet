<?php
/**
 * Created by Artdevue.
 * User: artdevue - AbstractModule.php
 * Date: 25.02.17
 * Time: 16:44
 * Project: phalcon-blank
 *
 * Class AbstractModule  * @package Apps\Commons
 */

namespace Apps\Commons;

use Phalcon\Loader,
    Phalcon\Mvc\View,
    Phalcon\DiInterface,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View\Engine\Volt,
    Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Logger;
use Phalcon\Http\Request;
use Phalcon\Logger\Adapter\File as FileAdapter;
use Phalcon\Mvc\Application;

abstract class AbstractModule implements ModuleDefinitionInterface
{
    /**
     * @var \Phalcon\DiInterface
     */
    protected $di;

    /**
     * @var \Phalcon\Config
     */
    protected $config;

    /**
     * @var string Module Name
     */
    protected $module;

    /**
     * @var string Module Namespace
     */
    protected $namespace;

    /**
     * @var string Module Path
     */
    protected $path;

    /**
     * Registers the module auto-loader
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $this->registerModuleAutoloaders($di);

        $loader = new Loader();

        $namespaces_array = [
            $this->namespace . '\Controllers' => $this->path . '/controllers/',
            $this->namespace . '\Models'      => $this->path . '/models/',
            $this->namespace . '\Form'        => $this->path . '/forms/'
        ];

        /**
         * Load subfolder
         */
        foreach ($namespaces_array as $nsp => $path)
        {
            // Check subfolders
            if (is_dir($path))
            {
                foreach ($iterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($path,
                        \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST) as $item)
                {
                    // Note SELF_FIRST, so array keys are in place before values are pushed.
                    $subPath = $iterator->getSubPathName();
                    if ($item->isDir())
                    {
                        // Create a new array key of the current directory name.
                        $namespaces_array[$nsp . '\\' . ucfirst(strtolower($subPath))] = $path . $subPath . '/';
                    }
                }
            }
        }

        $loader->registerNamespaces($namespaces_array);

        $loader->register();
    }

    /**
     * Register module-only Autoloaders
     */
    protected function registerModuleAutoloaders(DiInterface $di)
    {

    }

    /**
     * Registers the module-only services
     *
     * @param \Phalcon\DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        $this->config = $di->get('config');
        $this->di     = $di;

        $this->registerConfig($di);
        $this->registerDispatcher($di);

        $this->registerModuleServices($di);
        $this->registerViewService($di);
    }

    /**
     * Register module Dispatcher Service
     */
    protected function registerDispatcher(DiInterface $di)
    {
        $namespace              = $this->namespace;
        $this->di['dispatcher'] = function () use ($namespace, $di)
        {
            /*$evManager = $di->getShared('eventsManager');
            $evManager->attach('dispatch:beforeException', function($event, $dispatcher, $exception) {
                switch ($exception->getCode()) {
                    case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward(
                            array(
                                'module' => 'core',
                                'controller' => 'error',
                                'action' => 'e404',
                            )
                        );
                        return false;
                }
            });*/

            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace($namespace . '\Controllers');
            $dispatcher->setEventsManager($di['eventsManager']);

            return $dispatcher;
        };
    }

    /**
     * Register module Config
     */
    protected function registerConfig(DiInterface $di)
    {
        /**
         * Read configuration
         */
        if (file_exists($this->path . "/config/config.php"))
        {
            $config = include $this->path . "/config/config.php";
            $this->di->set('config', $this->config->merge($config), true);
        }
    }

    protected function registerModuleServices(DiInterface $di)
    {
        $module = $this->module;

        // This component makes use of adapters to store the logged messages.
        $di->setShared('logger', function () use ($module)
        {
            return new FileAdapter(PROJECT_PATH . "storage/logs/" . $module . ".log");
        });
    }

    protected function registerViewService(DiInterface $di)
    {
        $patch  = $this->path;
        $module = $this->module;

        // We verify the existence of a directory
        if (!file_exists(PROJECT_PATH . 'cache/volt/' . $module))
        {
            if (!mkdir(PROJECT_PATH . 'cache/volt/' . $module, 0777, true))
            {
                die('Unable to create directory ...');
            }
        }

        /**
         * Register Volt Engine
         */
        $this->di['volt'] = function ($view, $di) use ($module)
        {
            $volt = new Volt($view, $di);

            $volt->setOptions([
                'compiledPath'      => PROJECT_PATH . 'cache/volt/' . $module . '/',
                'compiledSeparator' => '_'
            ]);

            $volt->getCompiler()->addFilter('hash', 'md5');
            $volt->getCompiler()->addFunction('strtotime', 'strtotime');

            return $volt;
        };

        /**
         * Register View Service
         */
        $this->di['view'] = function () use ($patch, $module)
        {
            $view = new View();
            $view->setViewsDir($patch . '/views/');
            $view->setPartialsDir(PROJECT_PATH . 'apps/commons/views/partials/');

            $view->registerEngines([
                '.volt'  => function ($view, $di) use ($module)
                {

                    $volt = new Volt($view, $di);

                    $volt->setOptions([
                        'compiledPath'      => PROJECT_PATH . 'cache/volt/' . $module . '/',
                        'compiledSeparator' => '_'
                    ]);

                    return $volt;
                },
                '.phtml' => 'Phalcon\Mvc\View\Engine\Php',
                '.php'   => 'Phalcon\Mvc\View\Engine\Php'
            ]);

            return $view;
        };

        $config = $di->get('config');

        $debugbar_api = $config->get('debugbar_api');
        $debug        = $config->get('debug');

        $request = new Request();

        /**
         * Connect debag bar
         */
        $serviceNames = [
            'dispatch' => ['dispatcher'],
            'view'     => ['view']
        ];

        /**
         * If there is a connection to the database then add a service to display
         */
        try
        {
            if ($di->has('db') && $di->get('db')->fetchAll('SELECT 1'))
            {
                $serviceNames['db'] = ['db'];
            }
        } catch (\Exception $e)
        {

        }

        /**
         * If the active debug then connect
         */
        if ($debug && (count($debugbar_api) == 0 || in_array($request->getClientAddress(), $debugbar_api)))
        {
            (new \Library\PDW\DebugWidget($di, $serviceNames));
        }
    }
}
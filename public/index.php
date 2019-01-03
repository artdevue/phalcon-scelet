<?php
/**
 * Created by Artdevue.
 * User: artdevue - index.php
 * Date: 25.02.17
 * Time: 15:46
 * Project: PhalconScelet
 */

define('PHALCONSTART', microtime(true));
define('PROJECT_PATH', dirname(dirname(__FILE__)) . '/');

use Phalcon\Mvc\Application,
    Phalcon\Loader,
    Phalcon\Logger,
    Phalcon\Logger\Adapter\File as FileAdapter,
    Phalcon\Di\Exception;

date_default_timezone_set('UTC');

try
{
    require_once PROJECT_PATH . 'apps/bootstrap.php';

    //debug
    if ($config->debug)
    {
        error_reporting(E_ALL);
        $debug = new \Phalcon\Debug();
        $debug->listen();
    } else
    {
        //error_reporting(0);
    }

    $loader = new Loader();

    $loader->registerNamespaces([
        'Apps\Commons\Models' => PROJECT_PATH . 'apps/commons/models/',
        'Library'             => PROJECT_PATH . 'library/'
    ]);

    $loader->registerClasses([
        'Apps\Commons\AbstractModule' => PROJECT_PATH . 'apps/commons/AbstractModule.php',
    ]);

    $loader->register();

    /**
     * Include services
     */
    require PROJECT_PATH . 'config/services.php';
    require PROJECT_PATH . 'config/repos.php';

    /**
     * Handle the request
     */
    $application = new Application($di);
    $di['app'] = $application;

    /**
     * Assign the DI
     *
     * @var Phalcon\DI\FactoryDefault $di
     */
    $application->setDI($di);
    //$application->useImplicitView(false);

    /**
     * Register application modules
     */
    $modules = [];

    foreach ($config->modules as $index => $modul)
    {
        $modules[$index] = [
            'className' => $modul->className,
            'path'      => $modul->dir . 'Module.php'
        ];
    }

    $application->registerModules($modules);

    //echo $application->handle()->getContent();

    $response = $application->handle();

    $response->send();

} catch (Exception $e)
{
    if (!$config->debug)
    {
        // Log the exception
        $logger = new FileAdapter($config->application->errorLog);
        $logger->error('test');
        // Show an static error page
        $response = new \Phalcon\Http\Response();
        $response->setContent('Fatal Error. Please view the log file');
        $response->send();
        die();
    } else
    {
        echo " PhalconException : happened in " . get_class($e) . " class <br/> \n";
        echo " ExceptionMessage : <strong style='color:red'>" . $e->getMessage() . "</strong><br/>\n";
        echo " File=" . $e->getFile();
        echo " Line=" . $e->getLine() . "<br/>\n<hr>";
        echo nl2br(htmlentities($e->getTraceAsString()));
    }
}
<?php

namespace Library\PDW;

use Phalcon\DiInterface,
    Phalcon\Db\Profiler as Profiler,
    Phalcon\Escaper as Escaper,
    Phalcon\Mvc\Url as URL,
    Phalcon\Mvc\View as View;

/**
 * Class DebugWidget
 * This code was taken as the basis https://github.com/jymboche/phalcon-debug-widget
 *
 * @package Library\PDW
 */
class DebugWidget implements \Phalcon\DI\InjectionAwareInterface
{

    protected $_di;
    private   $startTime;
    private   $endTime;
    private   $queryCount     = 0;
    protected $_profiler;
    protected $_viewsRendered = [];
    protected $_serviceNames  = [];
    public    $panels         = ['server', 'request', 'views'];

    /**
     * DebugWidget constructor.
     *
     * @param       $di
     * @param array $serviceNames
     */
    public function __construct(
        $di,
        $serviceNames =
        [
            'db'       => ['db'],
            'dispatch' => ['dispatcher'],
            'view'     => ['view']
        ]
    ) {
        $this->_di       = $di;
        $this->startTime = microtime(true);
        $this->_profiler = new Profiler();

        if (!empty($serviceNames['db']))
        {
            array_push($this->panels, 'db');
        }

        $eventsManager = $di->get('eventsManager');

        foreach ($di->getServices() as $service)
        {
            $name = $service->getName();
            foreach ($serviceNames as $eventName => $services)
            {
                if (in_array($name, $services))
                {
                    $service->setShared(true);
                    $di->get($name)->setEventsManager($eventsManager);
                    break;
                }
            }
        }
        foreach (array_keys($serviceNames) as $eventName)
        {
            $eventsManager->attach($eventName, $this);
        }
        $this->_serviceNames = $serviceNames;
    }

    /**
     * @param DiInterface $di
     */
    public function setDI(DiInterface $di)
    {
        $this->_di = $di;
    }

    /**
     * @return mixed
     */
    public function getDI()
    {
        return $this->_di;
    }

    /**
     * @param $event
     *
     * @return mixed
     */
    public function getServices($event)
    {
        return $this->_serviceNames[$event];
    }

    /**
     * @param $event
     * @param $connection
     */
    public function beforeQuery($event, $connection)
    {
        $this->_profiler->startProfile(
            $connection->getRealSQLStatement(),
            $connection->getSQLVariables(),
            $connection->getSQLBindTypes()
        );
    }

    /**
     * @param $event
     * @param $connection
     */
    public function afterQuery($event, $connection)
    {
        $this->_profiler->stopProfile();
        $this->queryCount++;
    }

    /**
     * Gets/Saves information about views and stores truncated viewParams.
     *
     * @param unknown $event
     * @param unknown $view
     * @param unknown $file
     */
    public function beforeRenderView($event, $view, $file)
    {
        $params = [];
        $toView = $view->getParamsToView();
        $toView = !$toView ? [] : $toView;
        foreach ($toView as $k => $v)
        {
            if (is_object($v))
            {
                $params[$k] = get_class($v);
            } elseif (is_array($v))
            {
                $array = [];
                foreach ($v as $key => $value)
                {
                    if (is_object($value))
                    {
                        $array[$key] = get_class($value);
                    } elseif (is_array($value))
                    {
                        $array[$key] = 'Array[...]';
                    } else
                    {
                        $array[$key] = $value;
                    }
                }
                $params[$k] = $array;
            } else
            {
                $params[$k] = (string)$v;
            }
        }

        $this->_viewsRendered[] = [
            'path'       => $view->getActiveRenderPath(),
            'params'     => $params,
            'controller' => $view->getControllerName(),
            'action'     => $view->getActionName(),
        ];
    }

    /**
     * @param $event
     * @param $view
     * @param $viewFile
     */
    public function afterRender($event, $view, $viewFile)
    {
        $this->endTime = microtime(true);
        $content       = $view->getContent();
        $scripts       = $this->getInsertScripts();
        $scripts       .= "</head>";
        $content       = str_replace("</head>", $scripts, $content);
        $rendered      = $this->renderToolbar();
        $rendered      .= "</body>";
        $content       = str_replace("</body>", $rendered, $content);

        $view->setContent($content);
    }

    /**
     * Returns scripts to be inserted before <head>
     * Since setBaseUri may or may not end in a /, double slashes are removed.
     *
     * @return string
     */
    public function getInsertScripts()
    {
        $escaper = new Escaper();
        $url     = $this->getDI()->get('url');
        $scripts = "";

        $css = ['pdw-assets/style.css', 'pdw-assets/lib/prism/prism.css'];
        foreach ($css as $src)
        {
            $link = $url->get($src);
            //$link = str_replace("//", "/", $link);
            $scripts .= "<link rel='stylesheet' type='text/css' href='" . $escaper->escapeHtmlAttr($link) . "' />" . PHP_EOL;
        }

        $js = [
            'pdw-assets/jquery.min.js',
            'pdw-assets/lib/prism/prism.js',
            'pdw-assets/pdw.js'
        ];
        foreach ($js as $src)
        {
            $link = $url->get($src);
            //$link = str_replace("//", "/", $link);
            $scripts .= "<script tyle='text/javascript' src='" . $escaper->escapeHtmlAttr($link) . "'></script>" . PHP_EOL;
        }

        return $scripts;
    }

    /**
     * @return string
     */
    public function renderToolbar()
    {
        $view    = new View();
        $viewDir = dirname(__FILE__) . '/views/';
        $view->setViewsDir($viewDir);

        // set vars
        $view->debugWidget = $this;

        $content = $view->getRender('toolbar', 'index');

        return $content;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @return array
     */
    public function getRenderedViews()
    {
        return $this->_viewsRendered;
    }

    /**
     * @return int
     */
    public function getQueryCount()
    {
        return $this->queryCount;
    }

    /**
     * @return Profiler
     */
    public function getProfiler()
    {
        return $this->_profiler;
    }
}

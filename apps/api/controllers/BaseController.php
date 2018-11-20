<?php
/**
 * Created by Artdevue.
 * User: artdevue - BaseController.php
 * Date: 25.02.17
 * Time: 17:02
 * Project: PhalconScelet
 *
 * Class ControllerBase  * @package Apps\Api\Controllers
 */

namespace Apps\Api\Controllers;

use Phalcon\Mvc\Controller;

class BaseController extends Controller
{
    /**
     * Allow to globally initialize the controller in the request
     *
     * @Triggered on Controllers
     */
    public function initialize()
    {

    }

    /**
     * @return array
     */
    public function exceptionAction()
    {
        /**
         * @var $exception \Exception
         */
        $exception = $this->di->get('dispatcher')->getParam('exception');

        $message = $exception->getMessage();

        if (empty($message))
        {
            $message = 'Houston we have got a problem';
        }

        $code = $exception->getCode();

        if ($this->config->debug == true)
        {
            switch ($code)
            {
                case 500:
                    $this->logger->critical((string)$exception);
                    break;
                default:
                    $this->logger->debug((string)$exception);
                    break;
            }
        }
        else
        {
            $this->logger->debug((string)$exception);
            $message = '';
        }

        $message_code = $this->helpers->getHttpStatusMessage($code);

        if ($this->config->debug == false && !empty($message_code))
        {
            $this->response->setStatusCode($code, $message_code);
        }

        $output = [
            'success' => false,
            'message' => $message
        ];

        if(!empty($message_code))
        {
            $output['status_code'] = $code . ' - ' . $message_code;
        }

        return $output;
    }

    /**
     * @return array
     */
    public function route404Action()
    {
        $this->response->setStatusCode(404, 'Not found');
        $this->logger->debug('Error to handle: ' . $this->request->getURI());

        return [
            'success' => false,
            'status_code' => '404 - Not Found',
            'url' => $this->request->getURI(),
            'parameters' => $this->dispatcher->getParams()
        ];
    }
}
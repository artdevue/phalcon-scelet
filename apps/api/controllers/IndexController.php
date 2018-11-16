<?php
/**
 * Created by Artdevue.
 * User: artdevue - IndexController.php
 * Date: 25.02.17
 * Time: 19:11
 * Project: phalcon-blank
 *
 * Class IndexController  * @package Apps\Api\Controllers
 */

namespace Apps\Api\Controllers;

class IndexController extends BaseController
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * Status code for Exception
     * @link Library\Helpers\getHttpStatusMessage
     *
     * @return array
     */
    public function indexAction()
    {
        //throw new \Exception('Just because');
        //throw new \Exception('Just because', 401);
        //return $this->route404Action();
        return ['test'];
    }
}
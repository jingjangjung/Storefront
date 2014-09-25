<?php

/**
 * Created by PhpStorm.
 * User: João Carreira
 * Date: 9/24/14
 * Time: 7:41 PM
 */

class Storefront_IndexController extends Zend_Controller_Action
{
    public function init()
    {

    }

    public function indexAction()
    {
        $this->view->headTitle('Welcome', 'PREPEND');
    }
}
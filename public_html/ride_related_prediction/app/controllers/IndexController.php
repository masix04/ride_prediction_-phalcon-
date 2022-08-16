<?php

class IndexController extends ControllerBase
{
    public function indexAction()
    {

    }

    public function dashboardAction($username) 
    {
        echo 'I have got you'."\n".'and We are in  Dashboard Action';

        $username = $this->dispatcher->getParam('username');
        $this->view->dashboard = $username;
    }
}


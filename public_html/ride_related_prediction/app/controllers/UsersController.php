<?php

class UserController extends ControllerBase
{
    public function indexAction() 
    {
        $this->view->users = Users::find();
    }
}
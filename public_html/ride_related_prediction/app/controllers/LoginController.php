<?php

use Phalcon\Mvc\View\Simple;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Db\Adapter\Pdo\MySQL as Connection;

class LoginController extends ControllerBase 
{
    public function indexAction() 
    {

    }
    public function confirmIdentityAction() 
    {
        $user = new Users();
        
        // echo "<pre>";
        // print_r($this->request->getPost('email'));

        $success = $user->query()
            ->where("email = '".$this->request->getPost('email')."'")
            ->andWhere("password = '".$this->request->getPost('password')."'")
            ->execute();
            
        if(count($success)) {
            // $phql = "UPDATE `users` SET `active` = 1 WHERE `users`.`email` = '".$this->request->getPost('email')."'";

            // $save = $connection->query($phql);
            // $save = $this->modelsManager->executeQuery($phql);
            $user->email = $this->request->getPost('email');
            $user->active = 1;
            $save = $user->save();
            // foreach ($save as $s) {
            //     echo $s;
            // }
            // $save = $user->query()->execute("UPDATE `users` SET `active` = 1 WHERE `users`.`email` = '".$this->request->getPost('email')."'");
            // $save = $this->modelsManager->createQuery("UPDATE `users` SET `active` = 1 WHERE `users`.`email` = '".$this->request->getPost('email')."'");
            // $save = $this->modelsManager->createQuery("select * from `users`");
            // echo(count($save));
            // $save = $query->execute();
            // $save = $user->updateOrInsert(
            //     [$this->request->getPost('email'), 1],
            //     ["id", "firstname", "lastname", "email", "password", "gender", "contact_number","image", "birth_date", "active" ]
            // );

            if($save) {
                $this->flash->success('User Status has Updated!');
            } else {
                $this->flash->error('User Status has not Updated.');
            }

            $this->flash->success('You have login Successfully!');
            
            $view = new Simple();
            $view->setViewsDir('../app/views/');
            $view->setVar('email', $this->request->getPost('email'));

            echo $view->render(
                'confirmIdentity/index',
                [
                    'email' => $this->request->getPost('email')
                ],
            );

        }
        else {
            $this->flash->error('login Failed!');

        }
    }
}
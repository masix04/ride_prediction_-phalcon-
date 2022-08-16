<?php

use Phalcon\Mvc\View\Simple;

class SignUpController extends ControllerBase
{
    public function indexAction()
    {

    }    
    public function registerAction() 
    {
        // echo "<pre>";
        // print_r($this->request->getPost('email'));
        // echo "</pre>";
        $POST_DATA = $this->request->getPost();
        foreach($POST_DATA as $key => $data) {
            if($key == 'gender')
            {
                switch ($data) {
                    case 'male':
                        $POST_DATA[$key] = 1; 
                        // echo $data;
                        break;
                    case 'female':
                        $POST_DATA[$key] = 2;
                        // echo $data;
                        break;
                    case 'rns':
                        $POST_DATA[$key] = 0;
                        // echo $data;
                        break;
                        default:
                        $POST_DATA[$key] = 99;
                        // echo $data;
                }
            }
        }
        $user = new Users();

        /** Validation of User is based on It's Email AND Contact number
         * -- Possible Situations
         *  1- If user already Exists , then check for it's Contact Number, If this is not Null and not same as the inputed One
         */
        $isUserExists = $user->find([
            'email' => $this->request->getPost('email')
        ]);

        if(!count($isUserExists) ) {
            $user_id = count($user->find()) + 1;
        }
        else if(count($isUserExists) ) {
            /** If phone Number No matches */
            {
                $isPhoneNumberNotMatched = $user->query()
                    ->where("contact_number != '".$this->request->getPost('contact_number')."'")
                    ->orWhere("contact_number != NULL")
                    ->execute();
                /** Because Both Situation 1- if user found with not null | another Contact_number OR not found -> means a new user will Add So Id will be incremented */
                $user_id = count($user->find()) + 1;
            }

            /** If phone Number matches */
            {
                $isPhoneNumberMatched = $user->query()
                    ->where("contact_number = '".$this->request->getPost('contact_number')."'")
                    ->orWhere("contact_number = NULL")
                    ->execute();

                // echo count($isPhoneNumberMatched);

                if(count($isPhoneNumberMatched)) {
                    // echo "<pre>";
                    // print_r($isPhoneNumberMatched['_rows']);
                    echo "User Already Exists with this Contact Number ". $this->request->getPost('contact_number')." .";
                    $this->response->redirect('phalcon/public_html/ride_related_prediction/signup');
                    // return; // End of Validation
                }
                // echo($isUserExists);
            }
        }
        // echo "\n".$user_id."\n";
        
        $POST_DATA = array_merge($POST_DATA, ['id' => $user_id, 'active' => 0]);
        
        // echo "<pre>";
        // print_r($POST_DATA);
        // echo "</pre>";

        if($user_id) {
            $success = $user->save(
                $POST_DATA,
                [
                    "id", "firstname", "lastname", "email", "password", "gender", "contact_number","image", "birth_date", "active" 
                ]  
            );
        
            if($success) {
                // echo "Thanks you for signing up!";

                {
                    /** Helps to render views without hierarchical levels */
                    // $view = new Simple();
                    // $view->setViewsDir('../app/views/');
                    // Move to Dashboard, if Signed Up SuccessFully.
                    // $this->view->pick('dashboard/index') = $POST_DATA['firstname'] . ' ' . $POST_DATA['lastname'];
                    // return $view;
                    // $this->dashboardAction($view, $POST_DATA['firstname'] . ' ' . $POST_DATA['lastname']);
                    // $view->dashboard = $username;
                    // echo $view->render(
                    //     'dashboard/index',
                    //     [
                    //         "username" => $POST_DATA['firstname'] . ' ' . $POST_DATA['lastname']
                    //     ]
                    // );

                    /** Sends to another Controller  */
                    $this->dispatcher->forward([
                        'controller' => "index",
                        'action' => "dashboard",
                        'params' => 
                            [
                                "username" => $POST_DATA['firstname'] . ' ' . $POST_DATA['lastname']
                            ]
                    ]);
                }
            }
            else {
                echo "Oops, seems like the following issues were encountered: ";
                $messages = $user->getMessages();

                foreach ($messages as $message) {
                    echo $message->getMessage(), "<br/>";
                }
            }
        }

    }
    // public function dashboardAction($view, $username) 
    // {
    //     $view->dashboard = $username;
    // }
}
<?php


namespace App\Controllers;


use App\Flash;
use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;
use Core\Controller;
use Core\View;

/**
 * Class Register
 * @package App\Controllers
 */
class Register extends Controller
{
    /**
     * Shows the registration page or index
     * page where register form is present
     */
    public function indexAction()
    {
        // TODO: Client side field validation
        $this->requireGuest();
        //header('Location: http://'.$_SERVER['HTTP_HOST'].'/Home/index');
        View::renderBlade('register/index');

    }

    /**
     * Persist and register new user
     */
    public function createAction()
    {
        var_dump($_POST);
        exit();
        $user = new User($_POST);

        //if($user->save()){

        if($user_id=$user->save()){

            // Send the activation email
            //$user->sendActivationEmail();

            // Login the user
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user_id;
            //$_SESSION['course_id'] = $user->course_name;

            /*$ug = new UserGroup($_SESSION);
            $ug->firstSubscription();*/

            // Flash the success message
            Flash::addMessage('Account Created Successfully');
            Flash::addMessage('Please check your email for activation link');

//            $this->redirect('/payment/new');
            $this->redirect('/Account/welcome');

        }else{

            foreach($user->errors as $error){
                Flash::addMessage($error,'danger');
            }
            View::renderBlade('register.index',['arr'=>$_POST]);

        }

    }

    /**
     * Shows success page
     */
    public function successAction(){
        View::renderBlade('register/success');
    }

    /**
     * Activate a new account
     *
     * @return void
     */
    public function activateAction()
    {
        User::activate($this->route_params['token']);

        $this->redirect('/register/activated');
    }

    /**
     * Show the activation success page
     *
     * @return void
     */
    public function activatedAction()
    {
        View::renderBlade('register/activated');
    }

}
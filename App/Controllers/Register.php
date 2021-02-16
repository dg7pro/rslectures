<?php


namespace App\Controllers;


use App\Flash;
use App\Initials;
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
        View::renderBlade('register/index2');

    }

    /**
     * Persist and register new user
     */
    public function createAction()
    {
        var_dump($_POST);
        //exit();
        $user = new User($_POST);

        //if($user->save()){

        if($user_id=$user->save()){

            // Send the activation email
            $user->sendActivationEmail();

            // Login the user. Comment out first 2 lines
            /*session_regenerate_id(true);
            $_SESSION['user_id'] = $user_id;*/

            //$_SESSION['course_id'] = $user->course_name;

            /*$ug = new UserGroup($_SESSION);
            $ug->firstSubscription();*/

            // Flash the success message
            Flash::addMessage('Account Created Successfully');
            Flash::addMessage('Please check your email to activate your account');

//            $this->redirect('/payment/new');
            //$this->redirect('/Account/welcome');
            $this->redirect('/register/success');

        }else{

            foreach($user->errors as $error){
                Flash::addMessage($error,'danger');
            }
            View::renderBlade('register.index2',['arr'=>$_POST]);

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
        $process = User::activate($this->route_params['token']);

        if($process){
            Flash::addMessage('Account activated successfully','success');
            $this->redirect('/Login/index');
        }else{
            Flash::addMessage('Oops! Can\'t activate your account. Activation link is too old or wrong.','danger');
            $this->redirect('/register/activation');
        }


    }

    /**
     * Show the activation success page
     *
     * @return void
     */
    public function activationAction()
    {
        View::renderBlade('register/activation');
    }

}
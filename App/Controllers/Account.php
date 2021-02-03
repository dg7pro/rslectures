<?php


namespace App\Controllers;


use App\Auth;
use App\Flash;
use App\Models\User;
use Core\View;

/**
 * Account Controller
 *
 * @package App\Controllers
 */
class Account extends Authenticated
{

    /**
     *  Logout User
     */
    public function logoutAction()
    {
        // logout
        Auth::logout();

        // Redirect after logout
        $this->redirect('/');
    }

    /**
     *  Show User Dashboard
     */
    public function welcomeAction()
    {
        // This page requires login
        $this->requireLogin();

        // Fetch user
        $user = Auth::getUser();

        $courses2 = $user->groups();
        $num = count($courses2);

        //$courses2 = $user->groupsNew();
       /* var_dump($courses);
        exit();*/


        if(empty($courses2)){
            Flash::addMessage('Oops! You have not subscribed to any course yet. Please subscribe below:', Flash::DANGER);
            $this->redirect('/Subscribe/index');
        }
        else{

            if($num<2){
                $this->redirect('/Page/list-subject?gid='.$courses2[0]->id);
            }else{

                // Render view
                View::renderBlade('account.welcome',[
                    'authUser'=>$user,
                    'courses2'=>$courses2
                ]);
            }
        }

    }

    public function editProfileAction(){

        $user = Auth::getUser();
        View::renderBlade('account.edit_profile',['user'=>$user]);


    }

    public function changePasswordAction(){

        //var_dump($_POST);

        $user = Auth::getUser();

        if(!password_verify($_POST['current_password'], $user->password_hash)){

            Flash::addMessage('Current Password is not correct. If you forgot your current password please use forget password link to reset', Flash::DANGER);
            $this->redirect('/account/edit-profile');
            exit();
        }

        if (strlen($_POST['password1']) < 8) {

            Flash::addMessage('Password must be at least 8 characters or more', Flash::DANGER);
            $this->redirect('/account/edit-profile');
            exit();
        }

        if ($_POST['password1'] !== $_POST['password2']) {

            Flash::addMessage('Confirm password does not match', Flash::DANGER);
            $this->redirect('/account/edit-profile');
            exit();
        }

        if($user->updatePassword($_POST['password1'])){

            Auth::logout();
            $this->redirect('/login/again');

        }

    }

}
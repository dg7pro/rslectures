<?php


namespace App\Controllers;


use App\Auth;
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

        var_dump($_POST);
        exit();

        //$user = Auth::getUser();
        //View::renderBlade('account.edit_profile',['user'=>$user]);


    }

}
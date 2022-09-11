<?php


namespace App\Controllers;


use App\Auth;
use App\Models\Group;
use Core\Controller;
use Core\View;

class Subscribe extends Controller
{

    public function indexAction(){

        $new_user_flag = 0;
        $course_list = array();
        if($user = Auth::getUser()){
            $course_list = array_values($user->subscribedGroups());
            if(count($course_list)<1){
                $new_user_flag = 1;
            }
        }

        /*var_dump($course_list);
        exit();*/

        $groups = Group::fetchAllVisible();

        /*var_dump($groups);
        exit();*/

        View::renderBlade('/subscribe/index_new',['groups'=>$groups,'subscribed'=>$course_list,'new_user_flag'=>$new_user_flag]);
    }

}
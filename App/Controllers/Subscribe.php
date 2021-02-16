<?php


namespace App\Controllers;


use App\Auth;
use App\Models\Group;
use Core\View;

class Subscribe extends Authenticated
{

    public function indexAction(){


        $user = Auth::getUser();
        $course_list = array_values($user->subscribedGroups());

        //var_dump($course_list);
        //exit();

        $groups = Group::fetchAllActive();

        /*var_dump($groups);
        exit();*/

        View::renderBlade('/subscribe/index',['groups'=>$groups,'subscribed'=>$course_list]);
    }

}
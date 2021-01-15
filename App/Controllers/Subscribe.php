<?php


namespace App\Controllers;


use App\Auth;
use App\Models\Group;
use Core\Controller;
use Core\View;

class Subscribe extends Controller
{

    public function indexAction(){


        $user = Auth::getUser();
        $course_list = array_values($user->subscribedGroups());

        //var_dump($course_list);
        //exit();

        $groups = Group::fetchAllActive();

        View::renderBlade('/subscribe/index',['groups'=>$groups,'subscribed'=>$course_list]);
    }

}
<?php


namespace App\Controllers;


use App\Auth;
use App\Models\Group;
use Core\Controller;
use Core\View;

class Subscribe extends Controller
{

    public function indexAction(){

        $course_list = array();
        if($user = Auth::getUser()){
            $course_list = array_values($user->subscribedGroups());
        }

        /*var_dump($course_list);
        exit();*/

        $groups = Group::fetchAll();

        /*var_dump($groups);
        exit();*/

        View::renderBlade('/subscribe/index',['groups'=>$groups,'subscribed'=>$course_list]);
    }

}
<?php

namespace App\Controllers;

use App\Auth;
use App\Models\Group;
use Core\Controller;
use Core\View;

class Course extends Controller
{

    /**
     * Render text content
     *
     * @return void
     */
    public function detailsAction(){

        $group_id = $_GET['id'];
        if(empty($group_id)){
            $this->redirect('/home/page-not-found');
        }
        $group = Group::fetch($group_id);


        $new_user_flag = 0;
        $course_list = array();
        if($user = Auth::getUser()){
            $course_list = array_values($user->subscribedGroups());
            if(count($course_list)<1){
                $new_user_flag = 1;
            }
        }

        //var_dump($group);
        View::renderBlade('course.details',['group'=>$group,'subscribed'=>$course_list,'new_user_flag'=>$new_user_flag]);

    }

}
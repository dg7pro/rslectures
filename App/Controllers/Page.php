<?php


namespace App\Controllers;


use App\Flash;
use App\Lib\Helpers;
use App\Models\Content;
use App\Models\Group;
use App\Models\Subject;
use App\Models\UserGroup;
use Core\Controller;
use Core\View;

class Page extends Controller
{

    /*public function showAction(){

        $group_id = $_GET['gid'];

        $user_id = 6;

        $flag = UserGroup::isLinked($group_id,$user_id);

        if($flag){

            //$items = Item::getAll($group_id);
            //Helpers::dnd($items);

            View::renderBlade('page.show',['items'=>$items]);

        }


        var_dump($flag);

    }*/

    /**
     *  list all the subjects for students
     */
    public function listSubjectAction(){

        $group_id = $_GET['gid'];

        $course = Group::fetch($group_id);

        if(!$course){

            Flash::addMessage('Oops! that course does not exist.', Flash::WARNING);
            $this->redirect('/home/page-not-found');
        }

        $flag = UserGroup::isLinked($course['id'],$_SESSION['user_id']);

        if(!$flag){
            Flash::addMessage('Please subscribe to this course', Flash::INFO);
            $this->redirect('/subscribe/index');
        }

        $first = Subject::first($group_id);
        $subjects = Subject::fetchAll($group_id);

        View::renderBlade('page.list_subject',['course'=>$course, 'first'=>$first, 'subjects'=>$subjects]);

    }

    /**
     *  list all the subjects for students
     */
    public function listSubjectNewAction(){

        $group_id = $_GET['gid'];

        $course = Group::fetch($group_id);

        if(!$course){

            Flash::addMessage('Oops! that course does not exist.', Flash::WARNING);
            $this->redirect('/home/page-not-found');
        }

        $flag = UserGroup::isLinked($course['id'],$_SESSION['user_id']);

        if(!$flag){
            Flash::addMessage('Please subscribe to this course', Flash::INFO);
            $this->redirect('/subscribe/index');
        }

        //$first = Subject::first($group_id);
        $subjects = Subject::fetchAll($group_id);

        View::renderBlade('page.list_subject_new',['course'=>$course, 'subjects'=>$subjects]);

    }


    /**
     *  list all the contents of particular subject
     */
    public function listContentAction(){

        $subject_id = $_GET['sid'];

        $subject = Subject::fetch($subject_id);

        $contents = Content::fetchAll($subject_id);

        View::renderBlade('page.list_content',['subject'=>$subject,'contents'=>$contents]);
    }

    /**
     *  list all the contents of particular subject
     */
    public function listContentNewAction(){

        $subject_id = $_GET['sid'];

        $subject = Subject::fetch($subject_id);

        $contents = Content::fetchFileContentWithUnit($subject_id);

        /*var_dump($contents);
        exit();*/

        View::renderBlade('page.list_content_new',['subject'=>$subject,'contents'=>$contents]);
    }

    /**
     *  list all the contents of particular subject
     */
    public function chaptersAction(){

        $subject_id = $_GET['sid'];

        $subject = Subject::fetch($subject_id);

        $contents = Content::fetchPublishedChaptersWithUnit($subject_id);

//        Helpers::dnd($contents);
//        exit();

        View::renderBlade('page.chapters',['subject'=>$subject,'contents'=>$contents]);
    }

    /**
     *  list all the subjects for students
     */
    public function loadAction(){

        $group_id = $_GET['gid'];

        $course = Group::fetch($group_id);

        if(!$course){

            Flash::addMessage('Oops! that course does not exist.', Flash::WARNING);
            $this->redirect('/home/page-not-found');
        }

        $flag = UserGroup::isLinked($course['id'],$_SESSION['user_id']);

        if(!$flag){
            Flash::addMessage('Please subscribe to this course', Flash::INFO);
            $this->redirect('/subscribe/index');
        }

        $first = Subject::first($group_id);
        $subjects = Subject::fetchAll($group_id);

        View::renderBlade('page.my_chapters',['course'=>$course, 'first'=>$first, 'subjects'=>$subjects]);

    }





}
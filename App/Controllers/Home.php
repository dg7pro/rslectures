<?php

namespace App\Controllers;


use App\Auth;
use App\Flash;
use App\Lib\Helpers;
use App\Mail;
use App\Models\Content;
use App\Models\File;
use App\Models\Group;
use App\Models\Order;
use App\Models\Subject;
use App\Models\UserGroup;
use Core\Controller;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderBlade('home/index');
    }

    /**
     * Show error page not found page
     *
     * @return void
     */
    public function pageNotFoundAction()
    {
        View::renderBlade('404');
    }

    /**
     * Show error unauthorized access page
     *
     * @return void
     */
    public function unAuthorizedAccessAction()
    {
        View::renderBlade('401');
    }

    /**
     * Show internal server error page
     *
     * @return void
     */
    public function internalServerErrorAction()
    {
        View::renderBlade('500');
    }


    /* ***********************************************
     *  For Testing Purpose
     * *********************************************** */

    public function sessionAction()
    {

        /*var_dump($_SESSION);
         exit();*/

        /*$currentOrder = Order::findByOrderId('ORDS16157389841');

        $arr = array();
        $arr['course_id']=$currentOrder->course_id;
        $arr['user_id']=$currentOrder->user_id;
        $ug = new UserGroup($arr);
        $ug->firstSubscription();*/

    }

    public function groupAction(){
        $results = Subject::fetchAllWithLesson(1);
        //$results = Group::fetchGroupWithSubDetails(1);
        Helpers::dnd($results);
    }

    public function testAction(){
        //var_dump(json_encode(UserGroup::subscription()));


        /*var_dump($_SESSION);
        exit();*/


        $results = Content::fetchAllWithUnit(2);
        var_dump($results);
        //echo json_encode($result);

        $arr = array();
        $newKey = 0;
        foreach ($results as $k=>$v){

            //echo $k;
            if(!in_array($k,$arr)){
                $newKey++;
                $arr[$newKey]['no']=$k;
                $arr[$newKey]['lessons']=$v;
            }

        }

        echo '<br><br><br>';
        var_dump($arr);


        echo '<br><br><br>';

        foreach ($arr as $unit){

            echo 'Unit: '.$unit['no'];
            echo '<br>';
            if(count($unit['lessons'])>0){

                foreach ($unit['lessons'] as $u){

                    echo $u['title'];
                    echo '<br>';

                }

            }

        }

    }

    public function newTestAction(){

        /*$results = Content::fetchFileContentWithUnit(2);
        var_dump($results);*/

        $result = File::getSingle(47);
        //$result = File::testDelFile('PythonNotesForProfessionals.pdf');
        var_dump($result);

    }

    public function unattachedFilesAction(){

        $files = File::getUnattachedFiles();
        var_dump($files);



    }

    public function testSendingEmailAction(){

        $to = 'getkabirjaiswal@gmail.com';
        $sub = 'Test Sending Email Action';
        $txt = 'This is just a test email send for RS Lectures Web App';
        $htm = '<b><i>This is just a test email send for RS Lectures Web App through New</i></b>';

        Mail::sendNew($to, $sub, $txt, $htm);

    }

    public function testJsPaytmAction(){

        View::renderBlade('home/js_paytm');

    }

    public function showUserAction(){

        $user = Auth::getUser();
        var_dump($user);


    }

    public function showLoginAction(){

        Auth::logout();
        Flash::addMessage('Confirm password does not match', Flash::DANGER);
        $this->redirect('/login/index');


    }



}

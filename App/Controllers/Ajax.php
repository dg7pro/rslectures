<?php


namespace App\Controllers;


use App\Models\Content;
use App\Models\User;
use Core\Controller;

/**
 * Class Ajax
 *
 * @package App\Controllers
 */
class Ajax extends Controller
{

    /**
     * Error message
     *
     * @var array
     */
    public $errors = [];

    /**
     * Validate First Name
     */
    public function checkFirstnameAction(){

        if(isset($_POST['fn'])){

            $fn = $_POST['fn'];

            if($fn == ''){
                $n=0;
                $ht = '<span class="text-danger">This is empty</span>';
            }
            elseif (!preg_match("/^([a-zA-Z ]{3,15})$/",$fn)) {
                $n=0;
                $ht = '<span class="text-danger">Enter valid firstname</span>';
            }
            else{
                $n=1;
                $ht = '<span class="text-success">Looks Good!</span>';
            }
        }

        $re = ['n'=>$n,'ht'=>$ht];
        echo json_encode($re);

    }

    /**
     * Validate Last Name
     */
    public function checkLastnameAction(){

        if(isset($_POST['ln'])){

            $ln = $_POST['ln'];

            if($ln == ''){
                $n=0;
                $ht = '<span class="text-danger">This is empty</span>';
            }
            elseif (!preg_match("/^([a-zA-Z ]{3,15})$/",$ln)) {
                $n=0;
                $ht = '<span class="text-danger">Enter valid lastname</span>';
            }
            else{
                $n=1;
                $ht = '<span class="text-success">Looks Good!</span>';
            }
        }

        $re = ['n'=>$n,'ht'=>$ht];
        echo json_encode($re);
    }


    /**
     * Validate User Mobile
     */
    public function checkMobileAction(){

        if(isset($_POST['mb'])){

            $mb = $_POST['mb'];

            if($mb == '' ){
                $n=0;
//                $ht = 'Empty value';
                $ht = '<span class="text-danger">Enter mobile no.</span>';
            }
            elseif (!preg_match("/^[6-9]\d{9}$/",$mb)) {
                $n=0;
                $ht = '<span class="text-danger">Enter 10 digits valid mobile no.</span>';
            }
            else{

                $user = User::findByMobile($mb);

                if($user){
                    $n=0;
                    $ht = '<span class="text-danger">This mobile exist in our database</span>';
                }else{
                    $n=1;
                    $ht = '<span class="text-success">Looks Good!</span>';
                }
            }
        }

        $re = ['n'=>$n,'ht'=>$ht];
        echo json_encode($re);

    }

    /**
     * Validate User Email
     */
    public function checkEmailAction(){

        if(isset($_POST['em'])){

            $em = $_POST['em'];

            if($em=='' ){
                $n=0;
                $ht = '<span class="text-danger">Empty value</span>';
            }
            elseif (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
                $n=0;
                $ht = '<span class="text-danger">Enter valid email address</span>';
            }
            else{

                $user = User::findByEmail($em);

                //var_dump($num);
                if($user){
                    $n=0;
                    $ht = '<span class="text-danger">This email exist in our database</span>';
                }else{
                    $n=1;
                    $ht = '<span class="text-success">Looks Good!</span>';
                }
            }
        }

        $re = ['n'=>$n,'ht'=>$ht];
        echo json_encode($re);
    }

    /**
     * Validate User Password
     */
    public function checkPasswordAction(){

        if(isset($_POST['pw'])){

            $pw = $_POST['pw'];

            if($pw == '' ){
                $n=0;
                $ht = '<span class="text-danger">Empty value</span>';
            }
            // !preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*^#?&]{7,}$/",$pw)
            // ^(?=.*[a-zA-Z]).{7,}$
            elseif (!preg_match("/^([A-Za-z\d@$!%*^#?&]){7,}$/",$pw)) {
                $n=0;
                $ht = '<span class="text-danger">minimum 7 char long</span>';
            }
            else{
                $n=1;
                $ht = '<span class="text-success">Looks Good!</span>';
            }
        }

        $re = ['n'=>$n,'ht'=>$ht];
        echo json_encode($re);
    }

    /**
     * Fetch all lessons
     * Used in list_subject view
     */
    public function fetchLessonRecords(){

        if(isset($_POST['readlesson'])){
            $data = '<table class="table table-bordered">
                <thead style="background-color: #dd4444">
                <tr>
                    <th colspan="2">'.$_POST['title'].'</th>
                                           
                </tr></thead><tbody>';

            $arr = Content::fetchAllWithUnit($_POST['sid']);
            $num = count($arr);

            if($num>0){
                foreach($arr as $unit) {
                    $counter = count($unit['lessons']);
                    if($counter>0){
                        $data .= '<tr><td colspan="2">'.'Unit: '.$unit['no'].'</td></tr>';
                        foreach ($unit['lessons'] as $row){
                            $data .= '<tr>
                            <td>'.$row['id'].'</td>
                            <td><a href="/lesson/index?cid='.$row['id'].'">'.$row['title'].'</a></td>
                            </tr>';
                        }
                    }

                }
            }else{
                $data .= '<tr>
                    <td colspan="2">No lessons found.....</td>
                </tr>';
            }

            $data .='</tbody></table>';
            echo $data;

        }
    }

    /**
     * Fetch all lessons
     * Used in list_subject view
     */
    public function fetchPublishedLessonRecords(){

        if(isset($_POST['readlesson'])){
            $data = '<table class="table table-bordered">
                <thead class="tbl-header">
                <tr>
                    <th colspan="3" class="my-heading">'.$_POST['title'].'</th>
                                           
                </tr></thead><tbody>';

            $arr = Content::fetchPublishedChaptersWithUnit($_POST['sid']);
            $num = count($arr);

            if($num>0){
                foreach($arr as $unit) {
                    $counter = count($unit['lessons']);
                    if($counter>0){
                        $data .= '<tr><td colspan="3">'.'Unit: '.$unit['no'].'</td></tr>';
                        foreach ($unit['lessons'] as $row){
                            $data .= '<tr>
                            <td>'.$row['sno'].'</td>';

                            if($row['type']=='editor'){
                                $data .= '<td><a href="/lesson/index?cid='.$row['id'].'" target="_blank">'.$row['title'].'</a></td>
                                            <td><span><i class="fa fa-chrome icon-web"  aria-hidden="true"></i></span></td>';
                            }else{
                                $data .= '<td><a href="/lesson/file?pdf='.$row['name'].'" target="_blank">'.$row['title'].'</a></td>
                                            <td><span><i class="fa fa-file-pdf icon-pdf" aria-hidden="true"></i></span></td>';
                            }

                            $data .='</tr>';
                        }
                    }
                }
            }else{
                $data .= '<tr>
                    <td colspan="2">No lessons found.....</td>
                </tr>';
            }

            $data .='</tbody></table>';
            echo $data;
        }
    }

    /**
     * Fetch lesson links for sidebar
     * Used in lesson
     */
    /*public function fetchLessonLinks(){

        if(isset($_POST['lesson_links'])){
            $data = '<p>'.$_POST['s_name'].'</p>';

            $results = Content::fetchAll($_POST['s_id']);
            $num = count($results);

            if($num>0){
                foreach($results as $row) {

                    $data .= '<li><a href="/lesson/index?cid='.$row['id'].'">'.$row['title'].'</a></li>';

                }
            }else{
                $data .= '<li><a href="#">No lessons</a></li>';
            }
            echo $data;

        }
    }*/

}
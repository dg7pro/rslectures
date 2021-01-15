<?php


namespace App\Controllers;


use App\Models\Content;
use App\Models\File;
use App\Models\Group;
use App\Models\Subject;
use App\Models\User;
use App\Models\Lesson;

/**
 * Class Adjax Controller
 *
 * @package App\Controllers
 */
class Adjax extends Administered
{
    /**
     *  Fetch all Groups
     */
    public function fetchGroupRecords(){

        if(isset($_POST['readrecord'])){
            $data = '<table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price(INR)</th>
                     <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                     <th scope="col">Manage</th>
                      <th scope="col">Colour</th>
                           
                </tr></thead><tbody>';

            $results = Group::fetchAll();
            $num = count($results);

            if($num>0){
                foreach($results as $row) {
                    $data .= '<tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['name'].'<span class="small text-danger mark"><em>'.( $row['open']!=1?' Currently Closed ':'' ).'</em></span></td>
                    <td>Rs. '.$row['price'].'</td>
                    <td><button onclick="getGroupInfo('.$row['id'].')" type="button" class="mb-1 btn btn-sm btn-info">Edit</button></td>                 
                    <td><button onclick="deleteGroupInfo('.$row['id'].')" type="button" class="mb-1 btn btn-sm btn-danger">Del</button></td>
                    <td><a href="/admin/list-subject?gid='.$row['id'].'" class="mb-1 btn btn-sm btn-warning">Subjects</a></td>
                    <td><div style="width:25px; height:25px; background-color: '.$row['color'].'" ></div></td>
                </tr>';
                }
            }

            $data .='</tbody></table>';
            echo $data;

        }
    }

    /**
     *  Fetch all Files
     */
    public function fetchFileRecords(){

        if(isset($_POST['readrecord'])){
            $data = '<table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>                   
                    <th scope="col">Delete</th>                    
                           
                </tr></thead><tbody>';

            $results = File::fetchAllUnattached();
            $num = count($results);

            if($num>0){
                foreach($results as $row) {
                    $data .= '<tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['name'].'</td>                                               
                    <td><button onclick="deleteFileInfo('.$row['id'].')" type="button" class="mb-1 btn btn-sm btn-danger">Del</button></td>                   
                </tr>';
                }
            }

            $data .='</tbody></table>';
            echo $data;

        }
    }

    /**
     *  Delete File
     */
    public function deleteFileRecord(){

        if(isset($_POST['id'])){

            $re = File::deleteRecord($_POST['id']);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Deleted File Permanently';

        }

    }

    /**
     *  Fetch Group
     */
    public function fetchSingleGroupRecord(){

        if(isset($_POST['groupId']) && isset($_POST['groupId'])!=''){

            $group_id = $_POST['groupId'];
            $groupInfo = Group::fetch($group_id);
            $num = count($groupInfo);
            if($num>0){
                $response = $groupInfo;
            }else{
                $response['status']=200;
                $response['message']="No data found!";
            }
            echo json_encode($response);

        }
    }

    /**
     *  Insert New Group
     */
    public function insertNewGroupRecord(){

        if(isset($_POST['name']) && $_POST['name']!=''){

            $re = Group::insert($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'New Group Created';

        }
    }

    /**
     *  Update Group
     */
    public function updateSingleGroupRecord(){

        if(isset($_POST['id'])){

            $re = Group::update($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Basic Info Updated';

        }

    }

    /**
     *  Delete Group
     */
    public function deleteGroupRecord(){

        if(isset($_POST['id'])){

            $re = Group::deleteRecord($_POST['id']);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Deleted Group Permanently';

        }

    }


    /* ******************************************************************
     * Subject Ajax Functions
     *
     * ****************************************************************** */

    /**
     * Fetch all Subjects
     */
    public function fetchSubjectRecords(){

        $groupId = $_POST['groupId'];
        if(isset($_POST['readrecord'])){
            $data = '<table class="table table-bordered">
                <thead>
                <tr>                   
                    <th scope="col">Name</th>
                    <th scope="col">Manage</th>
                    <th scope="col">Write</th> 
                    <th scope="col">Change</th>                   
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                     
                           
                </tr></thead><tbody>';

            $results = Subject::fetchAll($groupId);
            $num = count($results);

            if($num>0){
                foreach($results as $row) {
                    $data .= '<tr>                    
                    <td>'.$row['name'].' <span class="small text-muted mark"><em>No. of units: '.$row['units'].'</em></span></td>                   
                    
                     <td><a href="/admin/list-lesson?sid='.$row['id'].'" class="mb-1 btn btn-sm btn-primary">PDF Lessons</a></td>
                    <td><a href="/admin/list-content?sid='.$row['id'].'" class="mb-1 btn btn-sm btn-warning">Editable</a></td>                   
                    <td><a href="/admin/change-order?sid='.$row['id'].'" class="mb-1 btn btn-sm btn-dark">Order</a></td>                   
                    <td><button onclick="getSubjectInfo('.$row['id'].')" type="button" class="mb-1 btn btn-sm btn-info">Edit</button></td>                 
                    <td><button onclick="deleteSubjectInfo('.$row['id'].')" type="button" class="mb-1 btn btn-sm btn-danger">Del</button></td>
                    
                </tr>';
                }
            }

            $data .='</tbody></table>';
            echo $data;
        }
    }

    /**
     *  Fetch Subject
     */
    public function fetchSingleSubjectRecord(){

        if(isset($_POST['subjectId']) && isset($_POST['subjectId'])!=''){

            $subject_id = $_POST['subjectId'];
            $subjectInfo = Subject::fetch($subject_id);
            $num = count($subjectInfo);
            if($num>0){
                $response = $subjectInfo;
            }else{
                $response['status']=200;
                $response['message']="No data found!";
            }
            echo json_encode($response);

        }
    }

    /**
     *  Insert New Subject
     */
    public function insertNewSubjectRecord(){

        if(isset($_POST['name']) && $_POST['name']!=''){

            $re = Subject::insert($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'New Subject Created';

        }
    }

    /**
     *  Update Subject
     */
    public function updateSingleSubjectRecord(){

        if(isset($_POST['id'])){

            $re = Subject::update($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Basic Info Updated';

        }

    }

    /**
     *  Delete Subject
     */
    public function deleteSubjectRecord(){

        if(isset($_POST['id'])){

            $re = Subject::deleteRecord($_POST['id']);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Deleted Subject Permanently';

        }
    }





    /**
     *  Fetch Lesson
     */
    public function fetchSingleLessonRecord(){

        if(isset($_POST['lessonId']) && isset($_POST['lessonId'])!=''){

            $lesson_id = $_POST['lessonId'];
            $lessonInfo = Lesson::fetchTitle($lesson_id);
            $num = count($lessonInfo);
            if($num>0){
                $response = $lessonInfo;
            }else{
                $response['status']=200;
                $response['message']="No data found!";
            }
            echo json_encode($response);

        }
    }

    /**
     * Admin Section
     * Insert New Lesson
     */
    public function insertNewLessonRecord(){

        if(isset($_POST['title']) && $_POST['title']!=''){

            $re = Content::insertFileContent($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'New Lesson Created';

        }
    }

    /**
     *  Update Lesson
     */
    public function updateSingleLessonRecord(){

        if(isset($_POST['id'])){

            $re = Lesson::updateTitle($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Basic Info Updated';

        }

    }

    /**
     *  Delete Lesson
     */
    public function deleteLessonRecord(){

        if(isset($_POST['id'])){

            $re = Content::deleteRecord($_POST['id']);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Deleted Lesson Permanently';

        }

    }






    /* ******************************************************************
    * Users Ajax Functions
    *
    * ****************************************************************** */

    public function searchUser(){

        $limit = 5;
        $page = 1;

        if($_POST['page'] > 1){
            $start = (($_POST['page']-1) * $limit);
            $page = $_POST['page'];
        }else{
            $start = 0;
        }

        $results = User::liveSearch($start,$limit);
        $total_data = User::liveSearchCount();

        $output = '<label>Total Records - '.$total_data.'</label>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>id</th>
                    <th>first name</th>
                    <th>last name</th>
                    <th>email</th>
                    <th>Edit</th></tr>';

        if($total_data > 0){

            foreach($results as $row){
                $output .= '<tr>
                <td>'.$row->id.'</td>
                <td>'.$row->first_name.'</td>
                <td>'.$row->last_name.'</td>
                <td>'.$row->email.'</td>
                <td><button onclick="getContentInfo('.$row->id.')" type="button" class="mb-1 btn btn-sm btn-info">Edit</button></td>
                </tr>';
            }

        }
        else{

            $output .= '<tr><td colspan="4">No data found</td></tr>';

        }

        $output .= '</table></br>
            <div align="center">
                <ul class="pagination">
        ';

        $total_links = ceil($total_data/$limit);
        $previous_link = '';
        $next_link = '';
        $page_link ='';

        if($total_links > 4){
            if($page<5){
                for($count=1; $count<=5; $count++){

                    $page_array[]=$count;
                }
                $page_array[]='...';
                $page_array[]=$total_links;
            }else{
                $end_limit = $total_links - 5 ;
                if($page > $end_limit){

                    $page_array[] = 1;
                    $page_array[] = '...';

                    for($count=$end_limit; $count<=$total_links; $count++){
                        $page_array[]=$count;
                    }
                }else{
                    $page_array[]=1;
                    $page_array[]='...';
                    for($count = $page-1; $count<=$page+1; $count++){
                        $page_array[]=$count;
                    }
                    $page_array[]=1;
                    $page_array[]=$total_links;
                }
            }
        }
        else{
            for($count=1; $count <= $total_links; $count++){
                $page_array[] = $count;
            }
        }
        // checked

        for($count = 0; $count < count($page_array); $count++)
        {
            if($page == $page_array[$count])
            {
                $page_link .= '<li class="page-item active">
                      <a class="page-link" href="#">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
                    </li>
                    ';

                $previous_id = $page_array[$count] - 1;
                if($previous_id > 0)
                {
                    $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'">Previous</a></li>';
                }
                else
                {
                    $previous_link = '<li class="page-item disabled">
                        <a class="page-link" href="#">Previous</a>
                      </li>
                      ';
                }
                $next_id = $page_array[$count] + 1;
                if($next_id >= $total_links)
                {
                    $next_link = '<li class="page-item disabled">
                        <a class="page-link" href="#">Next</a>
                      </li>';
                }
                else
                {
                    $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'">Next</a></li>';
                }
            }
            else
            {
                if($page_array[$count] == '...')
                {
                    $page_link .= '
                      <li class="page-item disabled">
                          <a class="page-link" href="#">...</a>
                      </li>
                      ';
                }
                else
                {
                    $page_link .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" 
                    data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>';
                }
            }
        }

        $output .= $previous_link . $page_link . $next_link;
        $output .= '</ul></div>';

        echo $output;

    }

    public function fetchUserRecords(){

        //var_dump($_POST);

        $result = User::userRecords($_POST);

        $data = array();


        $filtered_rows = User::userRecordsCount();

        foreach($result as $row)
        {

            $sub_array = array();
            $sub_array[] = $row["id"];
            $sub_array[] = $row["first_name"];
            $sub_array[] = $row["last_name"];
            $sub_array[] = '<button type="button" name="update" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button>';
            $sub_array[] = '<button type="button" name="delete" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Delete</button>';
            $data[] = $sub_array;
        }
        $output = array(
            "draw"    => intval($_POST["draw"]),
            "recordsTotal"  =>  $filtered_rows,
            "data"    => $data
        );
        echo json_encode($output);

    }

    public function insertUserRecord(){

        $result = User::insertUserAjaxRecord($_POST);
        if(!empty($result))
        {
            echo 'Data Inserted/Updated Successfully';
        }
    }

    public function fetchSingleUserRecord(){

        $output = array();
        $result = User::fetchSingleUserAjaxRecord($_POST);

        foreach($result as $row)
        {
            $output["first_name"] = $row["first_name"];
            $output["last_name"] = $row["last_name"];

        }
        echo json_encode($output);
    }

    public function deleteUserRecord(){

        $result = User::deleteUserAjaxRecord($_POST);

        if(!empty($result))
        {
            echo 'Data Deleted';
        }
    }

}
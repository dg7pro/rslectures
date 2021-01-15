<?php


namespace App\Controllers;


use App\Models\Content;

class AjaxEditorContent extends Administered
{

    /* ******************************************************************
     * Editor Content Ajax Functions
     *
     * ****************************************************************** */

    /**
     *  Fetch all contents
     */
    public function fetchContentRecords(){

        $subjectId = $_POST['subjectId'];
        if(isset($_POST['readrecord'])){
            $data = '<table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Title</th>
                    <th scope="col">Update</th>
                    <th scope="col">Delete</th>
                    
                </tr></thead><tbody>';

            $results = Content::fetchAll($subjectId);
            $num = count($results);

            if($num>0){
                foreach($results as $row) {
                    $data .= '<tr>
                    <td>'.$row['id'].'</td>
                    <td><a href="/admin/content?id='.$row['id'].'">'.$row['title'].'</a></td>                    
                    <td><button onclick="getContentInfo('.$row['id'].')" type="button" class="mb-1 btn btn-sm btn-info">Edit</button></td>                 
                    <td><button onclick="deleteContentInfo('.$row['id'].')" type="button" class="mb-1 btn btn-sm btn-danger">Del</button></td>
                   
                </tr>';
                }
            }

            $data .='</tbody></table>';
            echo $data;

        }
    }

    /**
     *  Fetch all contents
     */
    public function fetchEditorContentRecordsWithUnit(){

        $subjectId = $_POST['subjectId'];
        if(isset($_POST['readrecord'])){
            $data = '<table class="table table-bordered">
                <tbody>';

            $arr = Content::fetchEditorContentWithUnit($subjectId);

            $num = count($arr);

            if($num>0){
                foreach ($arr as $unit){
                    $counter = count($unit['lessons']);
                    if($counter>0){
                        $data .= '<tr><td colspan="5">'.'Unit: '.$unit['no'].'</td></tr>';
                        foreach($unit['lessons'] as $row) {
                            $data .= '<tr>
                            <td>'.$row['sno'].'</td>                          
                            <td><img src="/images/doc2.png" alt="doc"> <a href="/admin/content?id='.$row['id'].'">'.$row['title'].'</a></td>                    
                            <td><button onclick="getContentInfo('.$row['id'].')" type="button" class="mb-1 btn btn-sm btn-info">Edit</button></td>                 
                            <td><button onclick="deleteContentInfo('.$row['id'].')" type="button" class="mb-1 btn btn-sm btn-danger">Del</button></td>
                            </tr>';
                        }
                    }
                }

            }

            $data .='</tbody></table>';
            echo $data;

        }
    }


    /**
     *  Fetch Content
     */
    public function fetchSingleContentRecord(){

        if(isset($_POST['contentId']) && isset($_POST['contentId'])!=''){

            $content_id = $_POST['contentId'];
            $contentInfo = Content::fetchTitle($content_id);
            $num = count($contentInfo);
            if($num>0){
                $response = $contentInfo;
            }else{
                $response['status']=200;
                $response['message']="No data found!";
            }
            echo json_encode($response);

        }
    }

    /**
     *  Insert New Content
     */
    public function insertNewContentRecord(){

        if(isset($_POST['title']) && $_POST['title']!=''){

            $re = Content::insertEditorContent($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'New Content Created';

        }
    }

    /**
     *  Update Content
     */
    public function updateSingleContentRecord(){

        if(isset($_POST['id'])){

            $re = Content::updateTitle($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Basic Info Updated';

        }

    }

    /**
     *  Delete Content
     */
    public function deleteContentRecord(){

        if(isset($_POST['id'])){

            $re = Content::deleteRecord($_POST['id']);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Deleted Subject Permanently';

        }

    }





}
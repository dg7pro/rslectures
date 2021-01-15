<?php


namespace App\Controllers;


use App\Models\Content;
use App\Models\File;

class AjaxFileContent extends Administered
{

    /**
     * Admin Section
     */

    /**
     *  Insert New Content
     */
    public function insertNewFileContentRecord(){

        if(isset($_POST['title']) && $_POST['title']!=''){

            $re = Content::insertFileContent($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'New Content Created';

        }
    }

    /**
     *  Fetch all File contents
     */
    public function listContentsForChangingOrder(){

        $subjectId = $_POST['subjectId'];
        if(isset($_POST['readrecord'])){
            $data = '<table class="table table-bordered">
                <tbody>';

            $arr = Content::fetchFileContentWithUnitForOrder($subjectId);

            $lessons = Content::getLessons($subjectId);
            $sno = count($lessons);
            $sno_arr=array();
            for ($i=1;$i<=$sno;$i++){
                array_push($sno_arr,$i);
            }

            if(count($arr)>0){
                foreach ($arr as $unit){
                    $counter = count($unit['lessons']);
                    if($counter>0){
                        $data .= '<tr><td colspan="4">'.'Unit: '.$unit['no'].'</td></tr>';
                        foreach($unit['lessons'] as $row) {
                            $data .= '<tr>
                            <td>'.$row['sno'].'</td>                           
                            <td>
                                <a href="/lesson/display?pdf='.$row['name'].'" target="_blank">'.$row['title'].'</a>
                                <span class="small text-muted mark"><em>( '.$row['type'].' )</em></span>
                            </td>
                            <td>'.$row['sno'].'</td>
                            <td>
                                <select class="form-control" id="exampleFormControlSelect1" name="sno'.$row['id'].'" onchange="setSno('.$row['id'].',this.value)">
                                    <option>Change Order</option>
                                    ';
                                for($i=1;$i<=$sno;$i++){
                                    $data .='<option value="'.$i.'">'.$i.'</option>';
                                }
                            $data .='
                                </select>
                            </td>
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
     * Change Order of File Contents
     */
    public function changeOrderAction(){

        if(isset($_POST['id']) && isset($_POST['sno'])){

            $re = Content::updateOrder($_POST['sno'],$_POST['id']);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Order Updated Successfully';

        }

    }


    /**
     *  Fetch all File contents
     */
    public function fetchFileContentRecordsWithUnit(){

        $subjectId = $_POST['subjectId'];
        $type = 'pdf';
        if(isset($_POST['readrecord'])){
            $data = '<table class="table table-bordered">
                <tbody>';

            $arr = Content::fetchFileContentWithUnit($subjectId,$type);

            $num = count($arr);

            if($num>0){
                foreach ($arr as $unit){
                    $counter = count($unit['lessons']);
                    if($counter>0){
                        $data .= '<tr><td colspan="8">'.'Unit: '.$unit['no'].'</td></tr>';
                        foreach($unit['lessons'] as $row) {
                            $data .= '<tr>
                            <td>'.$row['sno'].'</td>
                            <td><img src="/images/pdf.png" alt="doc"> <a href="/lesson/display?pdf='.$row['name'].'" target="_blank">'.$row['title'].'</a></td>';

                            if($row['name']==''){
                                $data .=
                                    '<td><button onclick="attachFile('.$row['id'].')" type="button" class="mb-1 btn btn-sm btn-success">Attach</button></td>';
                            }else{
                                $data .=
                                    '<td><button type="button" class="mb-1 btn btn-sm btn-success disabled">Attach</button> <span class="small text-muted mark"><em>'.$row['name'].'</em></span></td>';
                            }

                            if($row['publish']==1 || $row['name']==''){
                                $data .= '<td><button onclick="alertPublishedContent()" type="button" class="mb-1 btn btn-sm btn-warning">Remove</button></td>';
                            }else{
                                $data .= '<td><button onclick="detachContentRequest('.$row['fid'].')" type="button" class="mb-1 btn btn-sm btn-warning">Remove</button></td>';
                            }


                            $data .='
                            <td><button onclick="getFileContentInfo('.$row['id'].')" type="button" class="mb-1 btn btn-sm btn-info">Edit</button></td>                 
                            <td><button onclick="deleteFileContentInfo('.$row['id'].')" type="button" class="mb-1 btn btn-sm btn-danger">Del</button></td>';

                            if($row['publish']==0 && $row['name']!=''){
                                $data .=
                                    '<td><button onclick="publishContent('.$row['id'].')" type="button" class="mb-1 btn btn-sm btn-success">Publish</button></td>';
                            }else{
                                $data .='<td><button type="button" class="mb-1 btn btn-sm btn-success disabled">Publish</button></td>';
                            }

                            if($row['publish']==1 && $row['name']!=''){
                                $data .='<td><button onclick="unPublishContent('.$row['id'].')" type="button" class="mb-1 btn btn-sm btn-warning ">Un-publish</button></td>';

                            }else{
                                $data .='<td><button type="button" class="mb-1 btn btn-sm btn-warning disabled ">Un-publish</button></td>';
                            }

                            $data .='</tr>';
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
    public function fetchSingleFileContentRecord(){

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
     *  Update Content
     */
    public function updateSingleFileContentRecord(){

        if(isset($_POST['id'])){

            $re = Content::updateTitle($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Basic Info Updated';

        }

    }

    /**
     *  Publish Content
     */
    public function publishFileContentRecord(){

        if(isset($_POST['id'])){

            $re = Content::publishContent($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Content Published Successfully';

        }

    }

    /**
     *  unPublish Content
     */
    public function unpublishFileContentRecord(){

        if(isset($_POST['id'])){

            $re = Content::unpublishContent($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Content UnPublished Successfully';

        }

    }

    /**
     *  Delete File Content
     */
    public function deleteFileContentRecord(){

        if(isset($_POST['id'])){

            $re = Content::deleteRecord($_POST['id']);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Deleted Subject Permanently';

        }

    }


    /**
     * Fetch unattached files
     */
    public function fetchUnattachedFilesRecord(){

        $data = File::getUnattachedFiles();
        echo json_encode($data);


    }

    /**
     * Attach Contents
     */
    public function attachContentToFile(){

        if(isset($_POST['file_id']) && $_POST['content_id']!=''){

            $re = File::attachContentToFile($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Content attached to file';

        }

    }

    /**
     * Detach Content
     */
    public function detachContentFromFile(){

        if(isset($_POST['file_id']) && $_POST['file_id']!=''){

            $re = File::detachContentFromFile($_POST);
            if(!$re){
                echo 'Something went Wrong';
            }
            echo 'Content detached from file';

        }else{
            echo 'Nothing to detach';
        }


    }

}
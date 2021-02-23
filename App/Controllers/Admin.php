<?php


namespace App\Controllers;


use App\Auth;
use App\Flash;
use App\Models\Content;
use App\Models\File;
use App\Models\Group;
use App\Models\Media;
use App\Models\Subject;
use Core\View;

/**
 * Class Admin
 *
 * @package App\Controllers
 */
class Admin extends Administered
{
    /**
     * Show index page
     */
    public function indexAction()
    {
        View::renderBlade('admin.index');
    }

    /*---------------Start Group Section------------------*/

    /**
     *  List Groups
     */
    public function listGroupAction(){

        //$groups = Group::fetchAll();
        View::renderBlade('admin.list_group');
    }

    /**
     *  Change Group Order
     */
    public function changeGroupOrderAction(){

        //$sid = $_GET['sid'];
        $groups = Group::fetchAll();

        View::renderBlade('admin.change_group_order',['groups'=>$groups]);

    }

    /*---------------End Group-------------------*/


    /**
     *  List Subjects
     */
    public function listSubjectAction(){

        $gid = $_GET['gid'];            // group id
        $group = Group::fetch($gid);
        //$subjects = Subject::fetchAll($group_id);
        View::renderBlade('admin.list_subject',['group'=>$group]);
    }

    /**
     *  List Contents
     */
    public function listContentAction(){

        $sid = $_GET['sid'];            // subject id
        $subject = Subject::fetch($sid);
        View::renderBlade('admin.list_content',['sid'=>$sid, 'subject'=>$subject]);

    }

    /**
     *  List Lesson
     */
    public function listLessonAction(){

        $sid = $_GET['sid'];            // subject id
        $subject = Subject::fetch($sid);
        View::renderBlade('admin.list_lesson',['sid'=>$sid, 'subject'=>$subject]);

    }

    /**
     *  Change Order
     */
    public function changeOrderAction(){

        $sid = $_GET['sid'];
        $subject = Subject::fetch($sid);

        View::renderBlade('admin.change_order',['sid'=>$sid, 'subject'=>$subject]);

    }


    /**
     * List all Users
     */
    public function listUsersAction(){

        //$groups = Group::fetchAll();
        View::renderBlade('admin.list_user_new');


    }

    /**
     * List all pdf files
     */
    public function listFilesAction(){

        View::renderBlade('admin.list_files');

    }

    /**
     * List all Payment Orders
     */
    public function paymentOrdersAction(){

        //$groups = Group::fetchAll();
        View::renderBlade('admin.payment_orders');


    }

    //=============================================================================
    // Contents Update through ck editor
    //=============================================================================

    /**
     * Show text editor for content editing
     */
    public function contentAction(){

        $id = $_GET['id'];
        $content = Content::fetch($id);
        Auth::rememberBackPage();
        View::renderBlade('admin.content',['content'=>$content]);

    }

    /**
     *  Save edited content
     */
    public function saveContentAction(){

        if(isset($_POST['update_content'])){

            $result = Content::update($_POST);
            if($result){
                Flash::addMessage('Content Updated Successfully', Flash::SUCCESS);
                $this->redirect(Auth::getBackToPage());
            }
        }else{

            Flash::addMessage('Could not update. Something went wrong', Flash::DANGER);
            $this->redirect(Auth::getBackToPage());
        }

    }

    //=============================================================================
    // Images Upload Section
    //=============================================================================

    /**
     *  Fetch Images from -
     *  Image folder
     */
    public function imageFolderAction(){

        $pics = Media::getAll();
        //var_dump($pics);
        View::renderBlade('admin.image_folder',['pics'=>$pics]);

    }

    /**
     *  Upload Image to -
     *  Images folder with record
     */
    public function uploadImageAction(){

        if (isset($_POST['submit'])) {

            //echo $_FILES['file']['tmp_name'];
            if(Media::insert($_FILES)){
                if(move_uploaded_file( $_FILES['file']['tmp_name'], 'media/'.$_FILES['file']['name'])){

                    echo "Photo Saved...!!";
                    $this->redirect('/Admin/image-folder?CKEditor=mytextarea&CKEditorFuncNum=1&langCode=en');
                }else{
                    echo "Upload Failed";
                }
            }else{
                echo "Insert Failed";
            }
        }

    }

    //=============================================================================
    // Files Upload Section
    //=============================================================================

    /**
     * Render new uploadify view
     */
    public function uploadFilesNewAction(){

        View::renderBlade('admin.upload_files_new');

    }

    /**
     * Check if file exist with same name
     */
    public function checkExistsAction(){

        // Relative to the root and should match the upload folder in the uploader script
        $targetFolder = '/uploads';

        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $targetFolder . '/' . $_POST['filename'])) {
            echo 1;
        } else {
            echo 0;
        }

    }

    /**
     * Manage file upload
     * through Uploadify
     */
    public function uploadifiveAction(){

        $sqlVal = array();

        // Set the uplaod directory
        $uploadDir = '/uploads/';

        // Set the allowed file extensions
        $fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'pdf'); // Allowed file extensions

        $verifyToken = md5('unique_salt' . $_POST['timestamp']);

        if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
            $tempFile   = $_FILES['Filedata']['tmp_name'];
            $uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;
            $targetFile = $uploadDir . $_FILES['Filedata']['name'];

            $sqlVal['file_name'] = $_FILES['Filedata']['name'];
            $sqlVal['file_type'] = $_FILES['Filedata']['type'];
            $sqlVal['file_size'] = $_FILES['Filedata']['size'];

            // Validate the filetype
            $fileParts = pathinfo($_FILES['Filedata']['name']);
            if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

                // Save the file
                $uploadOk = move_uploaded_file($tempFile, $targetFile);
                if(!empty($sqlVal) && $uploadOk) {
                    File::upload($sqlVal);
                }
                echo 1;

            } else {

                // The file type wasn't allowed
                echo 'Invalid file type.';

            }
        }


    }


    /**
     * Upload Files (Traditional way)
     */
    public function uploadFilesAction(){

        View::renderBlade('admin.upload_files');

    }

    /**
     * Handle Files Upload (Traditional way)
     */
    public function handleUploadAction(){

        //var_dump($_FILES);

        if(isset($_POST['submit'])){

            $uploadsDir = "../public/uploads/";
            $allowedFileType = array('jpg','png','jpeg','pdf');
            //$fileArray[] = '';
            $sqlVal = array();

            // Validate if files exist
            if (!empty(array_filter($_FILES['file']['name']))) {

                foreach ($_FILES['file']['name'] as $id=>$val){

                    // Get files upload path
                    $fileName        = $_FILES['file']['name'][$id];
                    $tempLocation    = $_FILES['file']['tmp_name'][$id];
                    $targetFilePath  = $uploadsDir . $fileName;
                    $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                    $uploadDate      = date('Y-m-d H:i:s');
                    $uploadOk = 1;


                    if(in_array($fileType, $allowedFileType)){
                        if(move_uploaded_file($tempLocation, $targetFilePath)){

                            $sqlVal['file_name'] = $_FILES['file']['name'][$id];
                            $sqlVal['file_type'] = $_FILES['file']['type'][$id];
                            $sqlVal['file_size'] = $_FILES['file']['size'][$id];

                        } else {

                            Flash::addMessage('Some file could not be uploaded', Flash::DANGER);
                            //$this->redirect('/admin/upload-files');
                            $uploadOk = 0;

                        }

                    } else {

                        Flash::addMessage('Only .jpg, .jpeg and .png file formats allowed.', Flash::DANGER);
                        //$this->redirect('/admin/upload-files');
                        $uploadOk = 0;

                    }

                    // Add into MySQL database
                    if(!empty($sqlVal) && $uploadOk) {

                        if (File::upload($sqlVal)) {
                            $msg = $sqlVal['file_name']." successfully uploaded.";
                            Flash::addMessage($msg, Flash::SUCCESS);

                        } else {
                            $msg = $sqlVal['file_name']." coudn't be uploaded due to database error.";
                            Flash::addMessage($msg, Flash::DANGER);
                        }

                    }

                }

                $this->redirect('/admin/upload-files');

            }else {
                // Error
                Flash::addMessage("Please select a file to upload.", Flash::DANGER);
                $this->redirect('/admin/upload-files');

            }

            // Count total files
            /*$count_files = count($_FILES['file']['name']);

            // Looping all files
            for($i=0;$i<$count_files;$i++){
                $filename = $_FILES['file']['name'][$i];

                // Upload file
                move_uploaded_file($_FILES['file']['tmp_name'][$i],'../public/uploads/'.$filename);

            }*/
        }


    }

}
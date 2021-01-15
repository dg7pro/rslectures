<?php


namespace App\Controllers;


use App\Models\Content;
use App\Models\Subject;
use Core\Controller;
use Core\View;

/**
 * Class Lesson
 * @package App\Controllers
 */
class Lesson extends Controller
{

    /**
     * Show Lesson
     */
    public function indexAction(){

        $content_id = $_GET['cid'];
        $content = Content::fetch($content_id);

        $subject = Subject::fetch($content['subject_id']);
        $lessons = Content::fetchAll($subject['id']);

        View::renderBlade('lesson.index_sb2',['content'=>$content,'subject'=>$subject,'lessons'=>$lessons]);

    }

    /**
     * Show Lesson
     */
    public function fileAction(){

        $pdf_id = $_GET['pdf'];
        $content = Content::fetch($pdf_id);

        $subject = Subject::fetch($content['subject_id']);
        $lessons = Content::fetchAll($subject['id']);

        View::renderBlade('lesson.index_sb2',['content'=>$content,'subject'=>$subject,'lessons'=>$lessons]);

    }

    public function displayAction(){

        $pdf = $_GET['pdf'];
        //$pdf = "demo_lesson_1.pdf";
        //$pdf = "New_Horizons.pdf";

        View::renderBlade('lesson.htmlpdf',['pdf'=>$pdf]);
        // https://wpscholar.com/blog/prevent-directory-browsing-with-htaccess/

    }




}
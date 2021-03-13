<?php


namespace App\Controllers;


use App\Models\Content;
use Core\Controller;
use Core\View;

/**
 * Class Lesson
 * @package App\Controllers
 */
class Lesson extends Authenticated
{

    /**
     * Render text content
     *
     * @return void
     */
    public function indexAction(){

        $content_id = $_GET['cid'];
        if(empty($content_id)){
            $this->redirect('/home/page-not-found');
        }
        $content = Content::fetch($content_id);
        View::renderBlade('lesson.index',['content'=>$content]);

    }

    /**
     * Render pdf file
     *
     * @return void
     */
    public function fileAction(){

        $pdf = $_GET['pdf'];
        if(empty($pdf)){
            $this->redirect('/home/page-not-found');
        }
        View::renderBlade('lesson.file',['pdf'=>$pdf]);

    }

}
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

    /**
     * Show catalog page
     *
     * @return void
     */
    public function catalogAction(){

        $notes = Group::fetchAllVisible();
        View::renderBlade('home/catalog',['eNotes'=>$notes]);
    }

    /**
     * Show catalog page
     *
     * @return void
     */
    public function paytmQRAction(){

        View::renderBlade('home/paytm_qr');
    }

}

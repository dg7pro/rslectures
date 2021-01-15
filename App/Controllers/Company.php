<?php


namespace App\Controllers;


use Core\Controller;
use Core\View;

/**
 * Class Company
 * @package App\Controllers
 */
class Company extends Controller
{

    /**
     * About Us
     */
    public function aboutUsAction(){
        View::renderBlade('company.about_us');
    }

    /**
     * Contact us
     */
    public function contactUsAction(){
        View::renderBlade('company.contact_us');
    }

    /**
     * Disclaimer
     */
    public function disclaimerAction(){
        View::renderBlade('company.disclaimer');
    }

    /**
     * Privacy Policy
     */
    public function privacyPolicyAction(){
        View::renderBlade('company.privacy_policy');
    }

    /**
     * Read more
     */
    public function readMoreAction(){
        View::renderBlade('company.read_more');
    }

    /**
     * Refund Policy
     */
    public function refundPolicyAction(){
        View::renderBlade('company.refund_policy');
    }

    /**
     * Terms and Conditions
     */
    public function tncAction(){
        View::renderBlade('company.tnc');
    }

}
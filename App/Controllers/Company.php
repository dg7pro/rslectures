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
     * Contact Us
     */
    public function contactUsAction(){
        View::renderBlade('company.contact_us');
    }

    /**
     * Career
     */
    public function careerAction(){
        View::renderBlade('company.career');
    }

    /**
     * Support
     */
    public function supportAction(){
        View::renderBlade('company.support');
    }

    /**
     * Privacy Policy
     */
    public function privacyPolicyAction(){
        View::renderBlade('company.privacy_policy');
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
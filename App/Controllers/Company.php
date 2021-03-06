<?php


namespace App\Controllers;


use App\Flash;
use App\Mail;
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
        View::renderBlade('company.contact_us');
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

    public function submitContactAction(){

        if(isset($_POST['query']) && $_POST['query']==='submit'){
            $name = filter_var($_POST['c_name'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['c_email'],FILTER_SANITIZE_EMAIL);
            $query = $_POST['c_type'];
            $subject = filter_var($_POST['c_subject'], FILTER_SANITIZE_STRING);
            $message =  filter_var($_POST['c_message'], FILTER_SANITIZE_STRING);

            $text = View::getTemplate('company/contact_us_email.txt', ['name' => $name, 'email' => $email, 'subject'=>$subject, 'message'=>$message ]);
            $html = View::getTemplate('company/contact_us_email.html', ['name' => $name, 'email' => $email, 'subject'=>$subject, 'message'=>$message ]);

            Mail::sendContact($email, $query, $text, $html);

            Flash::addMessage('Message submitted successfully, we will contact you soon',Flash::SUCCESS);

//            $this->redirect('/payment/new');
            //$this->redirect('/Account/welcome');
            $this->redirect('/company/contact-us');
        }
    }

}
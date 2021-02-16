<?php


namespace App\Controllers;


use App\Auth;
//use App\Config;
use App\Models\Order;
use App\Models\User;
use App\Models\UserGroup;
use App\Paytm;
use Core\Controller;
use Core\View;

/**
 * Class Payment - Checked but not commented
 * @package App\Controllers
 */
class Payment extends Controller
{
    /**
     * Shows new payment page
     */
    public function newAction(){

        //$amount = 200;
//        View::renderBlade('payment/new',['amount'=>$amount]);

        $course = UserGroup::getFirstCourse($_SESSION['user_id']);
        View::renderBlade('/payment/make-subscription',['course'=>$course]);
    }


    /**
     *
     */
    public static function redirectPaymentAction(){

        //var_dump($_POST);
        //exit();

        if($_POST['ORDER_ID'] && $_POST['TXN_AMOUNT']) {

            $orderNo = $_POST['ORDER_ID'];
            $userId = $_SESSION['user_id'];
            $userCode = $_POST['CUST_ID'];
            $courseId = $_POST['COURSE_ID'];
            $course = $_POST['COURSE'];
            $amount  = $_POST['TXN_AMOUNT'];

            /*$nOrder[]='';
            $nOrder['order_no'] = $_POST['ORDER_ID'];
            $nOrder['user_id'] = $_SESSION['user_id'];
            $nOrder['user_code'] = $_POST['CUST_ID'];
            $nOrder['course_id'] = $_POST['COURSE_ID'];
            $nOrder['course'] = $_POST['COURSE'];
            $nOrder['amount'] = $_POST['TXN_AMOUNT'];*/

            $result = Order::save($orderNo,$userId,$userCode,$courseId,$course,$amount);

            /*if(!$result){
                header('Location:/Payment/new');
                exit();
            }*/

            $checkSum = "";
            $paramList = array();

            $ORDER_ID = $_POST["ORDER_ID"];
            $CUST_ID = $_POST["CUST_ID"];
            $INDUSTRY_TYPE_ID = $_POST["INDUSTRY_TYPE_ID"];
            $CHANNEL_ID = $_POST["CHANNEL_ID"];
            $TXN_AMOUNT = $_POST["TXN_AMOUNT"];

            // Create an array having all required parameters for creating checksum.
            $paramList["MID"] = "JdmvXd39200695834227";
            $paramList["ORDER_ID"] = $ORDER_ID;
            $paramList["CUST_ID"] = $CUST_ID;
            $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
            $paramList["CHANNEL_ID"] = $CHANNEL_ID;
            $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
            $paramList["WEBSITE"] = 'DEFAULT';

            /*$MSISDN = '9453351473';
            $EMAIL = 'dgkashi@gmail.com';*/

            $MSISDN = Auth::getUser()->mobile;
            $EMAIL = Auth::getUser()->email;

            $paramList["CALLBACK_URL"] = 'http://' . $_SERVER['HTTP_HOST'] . '/payment/response-payment';
            $paramList["MSISDN"] = $MSISDN; //Mobile number of customer
            $paramList["EMAIL"] = $EMAIL; //Email ID of customer
            $paramList["VERIFIED_BY"] = "EMAIL"; //
            $paramList["IS_USER_VERIFIED"] = "YES"; //


            //Here checksum string will return by getChecksumFromArray() function.
            $checkSum = Paytm::getChecksumFromArray($paramList, $_ENV['PAYTM_MERCHANT_KEY']);

            View::renderBlade('payment/redirect-page', ['paramList' => $paramList, 'checkSum' => $checkSum, 'paytmTxnUrl' => $_ENV['PAYTM_TXN_URL'] ]);

        }
    }


    /**
     *
     */
    public function responsePaymentAction(){

        /*Helpers::dnd($_POST);
        exit();*/

        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";

        $paramList = $_POST;
        $paytmChecksum = $_POST["CHECKSUMHASH"] ?? ""; //Sent by Paytm pg

        //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
        $isValidChecksum = Paytm::verifychecksum_e($paramList,  $_ENV['PAYTM_MERCHANT_KEY'], $paytmChecksum); //will return TRUE or FALSE string.


        if($isValidChecksum == "TRUE") {

            //echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
            if ($_POST["STATUS"] == "TXN_SUCCESS") {

                $result = Order::updateOrderStatus($_POST);

                $currentOrder = Order::findByOrderId($_POST['ORDERID']);

                $arr = array();
                $arr['course_id']=$currentOrder->course_id;
                $arr['user_id']=$currentOrder->user_id;
                $ug = new UserGroup($arr);
                $ug->firstSubscription();

                /*if($result){
                    User::updateUserPaidStatus(Auth::getUser()->id);
                }
                Notification::save('payment_successful',$_SESSION['user_id']);*/

                //$this->redirect('/payment/success');

                $color = 'success';
                $amount = $_POST['TXNAMOUNT'];
                $orderId = $_POST['ORDERID'];
                $message = 'Transaction vide order id: '. $orderId .' is successful';

                View::renderBlade('payment/status',['message'=>$message,'color'=>$color,'amount'=>$amount,'orderId'=>$orderId]);

            }
            else {

                /*var_dump($_POST);
                exit();*/

                Order::updateOrderStatus($_POST);

                $color = 'danger';
                $amount = $_POST['TXNAMOUNT'];
                $orderId = $_POST['ORDERID'];
                $message = 'Transaction vide order id: '. $orderId .' failed';

                View::renderBlade('payment/status',['message'=>$message,'color'=>$color,'amount'=>$amount,'orderId'=>$orderId]);

            }

        }
        else {
            echo "<b>Checksum mismatched.</b>";
            //Process transaction as suspicious.
        }

    }

    /*public static function success(){



    }

    public static function failure(){

        $color = 'danger';
        //$amount = $_POST['TXNAMOUNT'];
        $amount = 1800;
        //$orderId = $_POST['ORDERID'];
        $orderId = 'ABC1234';
        $message = 'Transaction vide order id: '. $orderId .' failed';

        View::renderBlade('payment/status',['message'=>$message,'color'=>$color,'amount'=>$amount,'orderId'=>$orderId]);

    }*/

}
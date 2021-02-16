<?php


namespace App\Controllers;


use App\Auth;
use App\Models\Order;
use App\Models\UserGroup;
use App\Paytm;
use Core\Controller;
use Core\View;

/**
 * Class Payment
 * @package App\Controllers
 */
class Payment extends Controller
{

    /**
     * Redirects to the PayTM
     * payment gateway
     */
    public function redirectPaymentAction(){

        // This page requires login
        $this->requireLogin();

        if($_POST['ORDER_ID'] && $_POST['TXN_AMOUNT']) {

            Order::save($_SESSION['user_id'],$_POST);

            $paramList = array();

            // Create an array having all required parameters for creating checksum.
            $paramList["MID"] = "JdmvXd39200695834227";
            $paramList["ORDER_ID"] = $_POST["ORDER_ID"];
            $paramList["CUST_ID"] = $_POST["CUST_ID"];
            $paramList["INDUSTRY_TYPE_ID"] = $_POST["INDUSTRY_TYPE_ID"];
            $paramList["CHANNEL_ID"] = $_POST["CHANNEL_ID"];
            $paramList["TXN_AMOUNT"] = $_POST["TXN_AMOUNT"];
            $paramList["WEBSITE"] = 'DEFAULT';

            $paramList["CALLBACK_URL"] = 'https://' . $_SERVER['HTTP_HOST'] . '/payment/response-payment';
            $paramList["MSISDN"] = Auth::getUser()->mobile; //Mobile number of customer
            $paramList["EMAIL"] = Auth::getUser()->email; //Email ID of customer
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

        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = FALSE;

        $paramList = $_POST;
        $paytmChecksum = $_POST["CHECKSUMHASH"] ?? ""; //Sent by Paytm pg

        //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application’s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
        $isValidChecksum = Paytm::verifychecksum_e($paramList,  $_ENV['PAYTM_MERCHANT_KEY'], $paytmChecksum); //will return TRUE or FALSE string.


        if($isValidChecksum == TRUE) {

            if ($_POST["STATUS"] == "TXN_SUCCESS") {

                Order::updateOrderStatus($_POST);

                $currentOrder = Order::findByOrderId($_POST['ORDERID']);

                $arr = array();
                $arr['course_id']=$currentOrder->course_id;
                $arr['user_id']=$currentOrder->user_id;
                $ug = new UserGroup($arr);
                $ug->firstSubscription();

                $color = 'success';
                $amount = $_POST['TXNAMOUNT'];
                $orderId = $_POST['ORDERID'];
                $message = 'Transaction vide order id: '. $orderId .' is successful';

            }
            else {

                Order::updateOrderStatus($_POST);

                $color = 'danger';
                $amount = $_POST['TXNAMOUNT'];
                $orderId = $_POST['ORDERID'];
                $message = 'Transaction vide order id: '. $orderId .' failed';

            }
            View::renderBlade('payment/status',['message'=>$message,'color'=>$color,'amount'=>$amount,'orderId'=>$orderId]);

        }
        else {
            echo "<b>Checksum mismatched.</b>";
            //Process transaction as suspicious.
        }

    }

}
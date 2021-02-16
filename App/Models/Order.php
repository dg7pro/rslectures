<?php


namespace App\Models;


use App\Auth;
use Core\Model;
use PDO;

class Order extends Model
{

    /**
     * @param $oid
     * @return mixed
     */
    public static function findByOrderId($oid){

        $sql = "SELECT * FROM orders WHERE order_id= :oid";
        $db = static::getDB();

        $stmt=$db->prepare($sql);
        $stmt->bindParam(':oid',$oid,PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }


    public static function save($userId,$arr){

        $orderId = $arr['ORDER_ID'];
        $userCode = $arr['CUST_ID'];
        $courseId = $arr['COURSE_ID'];
        $course = $arr['COURSE'];
        $amount  = $arr['TXN_AMOUNT'];

        $sql = 'INSERT INTO orders (order_id,user_id,user_code,course_id,course,amount) values(?,?,?,?,?,?)';
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$orderId,$userId,$userCode,$courseId,$course,$amount]);

    }

    /**
     * @param $data
     * @return bool
     */
    public static function updateOrderStatus($data){

        $oid = $data['ORDERID'];
        $tid = $data['TXNID'];
        $sus = $data['STATUS'];
        $rco = $data['RESPCODE'];
        $rms = $data['RESPMSG'];
        $gnm = $data['GATEWAYNAME'] ?? '';
        $bnm = $data['BANKNAME'] ?? '';
        $pmo = $data['PAYMENTMODE'] ?? '';

        //Process your transaction here as success transaction.
        $sql="UPDATE orders SET 
                  txn_id=?, 
                  status=?, 
                  resp_code=?, 
                  resp_msg=?,                 
                  gateway_name=?,
                  bank_name=?,
                  payment_mode=?
                  WHERE order_id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$tid,$sus,$rco,$rms,$gnm,$bnm,$pmo,$oid]);

    }

    public static function liveSearch($start, $limit){

        $query = "SELECT * FROM orders";

        if($_POST['query'] != ''){
            $query .= '
            WHERE id LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR order_id LIKE "%'.str_replace('', '%', $_POST['query']).'%"
            OR user_id LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            ';
        }

        $query .= ' ORDER BY id DESC ';

        $filter_query = $query . 'LIMIT '.$start.','.$limit.'';


        $pdo=Model::getDB();
        $stmt=$pdo->prepare($filter_query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);


    }

    public static function liveSearchCount(){

        $query = "SELECT * FROM orders";

        if($_POST['query'] != ''){
            $query .= '
            WHERE id LIKE "%'.str_replace('', '%', $_POST['query']).'%" 
            OR order_id LIKE "%'.str_replace('', '%', $_POST['query']).'%"
            OR user_id LIKE "%'.str_replace('', '%', $_POST['query']).'%" ';
        }

        $pdo=Model::getDB();
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();


    }

}
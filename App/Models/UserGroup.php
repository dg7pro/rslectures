<?php


namespace App\Models;


use Core\Model;
use PDO;

class UserGroup extends Model
{

    public function __construct($data=[])
    {
        foreach ($data as $key => $value){
            $this->$key=$value;
        }
    }

    public function firstSubscription(){

        $sql = 'INSERT INTO user_group (group_id,user_id)
                    VALUES (:gid, :uid)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':gid', $this->course_id, PDO::PARAM_INT);
        $stmt->bindValue(':uid', $this->user_id, PDO::PARAM_INT);

        $stmt->execute();

    }

    public static function getFirstCourse($user_id){

        $sql = "SELECT ug.group_id, gr.id, gr.name, gr.descr,gr.price  FROM user_group AS ug
                JOIN groups AS gr
                ON ug.group_id = gr.id
                WHERE user_id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




    public static function isLinked($group_id, $user_id){

        $sql = "SELECT * FROM user_group WHERE group_id=? AND user_id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$group_id,$user_id]);
        if($stmt->fetch(PDO::FETCH_ASSOC)){
            return true;
        }
        return false;

    }

    public static function subscription(){

        if(isset($_SESSION['user_id'])) {

            $user_id = $_SESSION['user_id'];
            $sql = "SELECT ug.group_id as gid, groups.name FROM user_group AS ug
            JOIN groups ON ug.group_id=groups.id
            WHERE user_id=?";
            $pdo = Model::getDB();
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);

        }

    }





}
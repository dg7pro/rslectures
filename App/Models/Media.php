<?php


namespace App\Models;


use Core\Model;
use PDO;

class Media extends Model
{

    public static function insert($arr): bool
    {

        var_dump($arr);

        $file_name = $arr['file']['name'];
        $file_type = $arr['file']['type'];
        $file_size = $arr['file']['size'];
        $file_date = date("Y-m-d");


        $pdo=Model::getDB();
        $stmt = $pdo->prepare("insert into media values(null, :name, :type, :size, :on_date)");

        $stmt->bindParam(':name',$file_name);
        $stmt->bindParam(':type',$file_type);
        $stmt->bindParam(':size',$file_size);
        $stmt->bindParam(':on_date',$file_date);

        return $stmt->execute();
    }


    public static function getAll(){

        $sql = "SELECT * FROM media";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
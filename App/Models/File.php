<?php


namespace App\Models;


use Core\Model;
use PDO;

class File extends Model
{

    public static function getFileWithContent($content_id){

        $sql = "SELECT * FROM files WHERE content_id = ?";
        $pdo=Model::getDB();

        $stmt=$pdo->prepare($sql);
        $stmt->execute([$content_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function upload($arr){

        //var_dump($arr);

        $file_name = $arr['file_name'];
        $file_type = $arr['file_type'];
        $file_size = $arr['file_size'];
        $file_date = date("Y-m-d");
        $linked = 0;
        $content_id = null;


        $pdo=Model::getDB();
        $stmt = $pdo->prepare("insert into files values( null, :name, :type, :size, :on_date, :linked, :content_id)");

        $stmt->bindParam(':name',$file_name);
        $stmt->bindParam(':type',$file_type);
        $stmt->bindParam(':size',$file_size);
        $stmt->bindParam(':on_date',$file_date);
        $stmt->bindParam(':linked',$linked);
        $stmt->bindParam(':content_id',$content_id);

        return $stmt->execute();
    }

    public static function fetchAllUnattached(){

        $sql = "SELECT * FROM files WHERE linked=0";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteRecord($id){

        $file =Self::getFileName($id);
        $fn = $file['name'];

        $sql = "DELETE FROM files WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $result = $stmt->execute([$id]);
        if($result){
            Self::deleteFilePhysically($fn);
        }

        return $result;

    }

    public static function deleteFilePhysically($fn){

        return unlink('../public/uploads/'.$fn);
    }

    public static function getFileName($id){
        $sql = "SELECT name FROM files WHERE id = ?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public static function getUnattachedFiles(){

        $sql = "SELECT * FROM files WHERE content_id IS NULL";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function attachContentToFile($arr){

        $file_id = $arr['file_id'];
        $content_id = $arr['content_id'];
        $linked = 1;

        $sql = "UPDATE files SET content_id=?, linked=? WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$content_id,$linked,$file_id]);
    }

    public static function detachContentFromFile($arr){

        $file_id = $arr['file_id'];
        $content_id = null;
        $linked = 0;

        $sql = "UPDATE files SET content_id=?, linked=? WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$content_id,$linked,$file_id]);
    }

}
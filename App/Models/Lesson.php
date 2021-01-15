<?php


namespace App\Models;


use Core\Model;
use PDO;

class Lesson extends Model
{

    public static function fetchTitle($id){

        $sql = "SELECT id,subject_id,title,unit FROM lessons WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function updateTitle($arr){

        $cid = $arr['id'];
        $title = $arr['title'];
        $unit = $arr['unit'];

        $sql = "UPDATE lessons SET title=?,unit=? WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$title,$unit,$cid]);

    }

    public static function fetchAll($subjectId){

        $sql = "SELECT id,subject_id,title FROM lessons WHERE subject_id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$subjectId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetchAllWithUnit($subjectId){

        $sql = "SELECT lessons.unit,id,subject_id,title,pdf,unit FROM lessons WHERE subject_id=? ORDER BY unit";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$subjectId]);
        $results = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

        $arr = array();
        $newKey = 0;
        foreach ($results as $k=>$v){
            //echo $k;
            if(!in_array($k,$arr)){
                $newKey++;
                $arr[$newKey]['no']=$k;
                $arr[$newKey]['pdfs']=$v;
            }
        }
        return $arr;
    }

    public static function insert($arr){

        $sid = $arr['sid'];
        $title = $arr['title'];
        $unit = $arr['unit'];

        $sql = "INSERT INTO lessons(subject_id,title,unit) VALUES (?,?,?)";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$sid,$title,$unit]);

    }

   /* public static function deleteRecord($id){

        $sql = "DELETE FROM lessons WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$id]);

    }*/

}
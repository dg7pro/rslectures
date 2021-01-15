<?php


namespace App\Models;


use Core\Model;
use PDO;

class Subject extends Model
{

    public static function insert($arr){

        $gid = $arr['gid'];
        $units = $arr['units'];
        $name = $arr['name'];
        $descr = $arr['descr'];

        $sql = "INSERT INTO subjects(group_id,units,name,descr) VALUES (?,?,?,?)";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$gid,$units,$name,$descr]);

    }

    public static function first($id){

        $sql = "SELECT * FROM subjects WHERE group_id=? LIMIT 1";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    public static function fetch($id){

        $sql = "SELECT * FROM subjects WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function fetchAll($groupId){

        $sql = "SELECT * FROM subjects WHERE group_id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$groupId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update($arr){

        $name = $arr['name'];
        $descr = $arr['descr'];
        $units = $arr['units'];
        $id = $arr['id'];

        $sql = "UPDATE subjects SET name=?, descr=?, units=? WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$name,$descr,$units,$id]);
    }

    public static function deleteRecord($id){

        $sql = "DELETE FROM subjects WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$id]);

    }


}
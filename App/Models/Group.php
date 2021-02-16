<?php


namespace App\Models;


use Core\Model;
use PDO;

class Group extends Model
{
    public static function fetch($gid){

        $sql = "SELECT * FROM groups WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$gid]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function fetchAll(): array
    {
        $sql = "SELECT * FROM groups";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetchAllActive(): array
    {
        $sql = "SELECT * FROM groups";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update($arr){

        $name = $arr['name'];
        $descr = $arr['descr'];
        $price = $arr['price'];
        $colour = $arr['color'];
        $open = $arr['open'];
        $id = $arr['id'];

        $sql = "UPDATE groups SET name=?, descr=?, price=?, color=?, open=? WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$name,$descr,$price,$colour,$open,$id]);

    }


    public static function insert($arr){

        $name = $arr['name'];
        $descr = $arr['descr'];
        $price = $arr['price'];
        $color = $arr['color'];
        $open = $arr['open'];


        $sql = "INSERT INTO groups(name,descr,price,color,open) VALUES (?,?,?,?,?)";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$name,$descr,$price,$color,$open]);

    }

    public static function deleteRecord($id){

        $sql = "DELETE FROM groups WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$id]);

    }

}
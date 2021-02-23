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
        $sql = "SELECT * FROM groups ORDER BY sno";
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

    public static function fetchGroupWithSubDetails($id)
    {
        $sql = "SELECT t1.name AS grp, t2.name, t2.name AS subj, t3.title FROM groups AS t1 
                JOIN subjects AS t2 ON t2.group_id=t1.id
                LEFT JOIN contents AS t3 ON t3.subject_id=t2.id
                WHERE t1.id = ?
                ";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

        // TODO :: checking is required very important 3 level deep fetch record
    }

    public static function update($arr){

        $name = $arr['name'];
        $descr = $arr['descr'];
        $price = $arr['price'];
        $duration = $arr['duration'];
        $colour = $arr['color'];
        $open = $arr['open'];
        $deactive = $arr['deactive'];
        $id = $arr['id'];

        $sql = "UPDATE groups SET name=?, descr=?, price=?, duration=?, color=?, open=?, deactive=? WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$name,$descr,$price,$duration,$colour,$open,$deactive,$id]);

    }

    public static function updateOrder($sno,$id){

        $sql = "UPDATE groups SET sno=? WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$sno,$id]);

    }


    public static function insert($arr){

        $name = $arr['name'];
        $descr = $arr['descr'];
        $price = $arr['price'];
        $duration = $arr['duration'];
        $color = $arr['color'];
        $open = $arr['open'];
        $deactive = $arr['deactive'];


        $sql = "INSERT INTO groups(name,descr,price,duration,color,open,deactive) VALUES (?,?,?,?,?,?,?)";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$name,$descr,$price,$duration,$color,$open,$deactive]);

    }

    public static function deleteRecord($id){

        $sql = "DELETE FROM groups WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$id]);

    }

}
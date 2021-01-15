<?php


namespace App\Models;


use App\Lib\Helpers;
use Core\Model;
use PDO;

class Content extends Model
{

    public static function fetch($id){

        $sql = "SELECT * FROM contents WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function fetchTitle($id){

        $sql = "SELECT id,subject_id,title,unit FROM contents WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public static function fetchAll($subjectId){

        $sql = "SELECT id,subject_id,title FROM contents WHERE subject_id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$subjectId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getLessons($subjectId){

        $sql = "SELECT * FROM contents WHERE subject_id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$subjectId]);
        /*$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($result);*/

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }



    public static function fetchAllWithUnit($subjectId){

        $sql = "SELECT contents.unit,id,subject_id,title,unit,sno FROM contents WHERE subject_id=? ORDER BY sno";
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
                $arr[$newKey]['lessons']=$v;
            }

        }

        return $arr;

    }

    public static function updateOrder($sno,$id){

        $sql = "UPDATE contents SET sno=? WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$sno,$id]);

    }

    public static function updateTitle($arr){

        $cid = $arr['id'];
        $unit = $arr['unit'];
        $title = $arr['title'];

        $sql = "UPDATE contents SET title=?,unit=? WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$title,$unit,$cid]);

    }


    public static function update($arr){

        $cid = $arr['content_id'];
        $matter = $arr['matter'];

        $sql = "UPDATE contents SET matter=? WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$matter,$cid]);

    }

    public static function insertEditorContent($arr){

        $sid = $arr['sid'];
        $title = $arr['title'];
        $matter = $arr['matter'];
        $unit = $arr['unit'];
        $type = "editor";

        $sql = "INSERT INTO contents(type,subject_id,title,matter,unit) VALUES (?,?,?,?,?)";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$type,$sid,$title,$matter,$unit]);

    }

    public static function insertFileContent($arr){

        $sid = $arr['sid'];
        $title = $arr['title'];
        $unit = $arr['unit'];
        $type = "pdf";

        $sql = "INSERT INTO contents(type,subject_id,title,unit) VALUES (?,?,?,?)";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$type,$sid,$title,$unit]);

    }

    public static function deleteRecord($id){

        $sql = "DELETE FROM contents WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$id]);

    }

    public static function publishContent($arr){

        $cid = $arr['id'];
        $pub=1;

        $sql = "UPDATE contents SET publish=? WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$pub,$cid]);

    }

    public static function unpublishContent($arr){

        $cid = $arr['id'];
        $pub=0;

        $sql = "UPDATE contents SET publish=? WHERE id=?";
        $pdo=Model::getDB();
        $stmt=$pdo->prepare($sql);
        return $stmt->execute([$pub,$cid]);

    }

    public static function fetchFileContentWithUnitForOrder($subjectId){

        $sql = "SELECT c.unit,c.id,c.type,c.subject_id,c.title,c.unit,c.publish,c.sno,p.name,p.id AS fid
                FROM contents AS c
                LEFT JOIN files AS p ON  p.content_id = c.id
                WHERE subject_id=? ORDER BY sno";
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
                $arr[$newKey]['lessons']=$v;
            }

        }

        return $arr;

    }

    public static function fetchEditorContentWithUnit($subjectId){

        $sql = "SELECT contents.unit,id,subject_id,title,unit,sno FROM contents 
                WHERE subject_id=? AND type='editor' ORDER BY sno";
        $pdo = Model::getDB();
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
                $arr[$newKey]['lessons']=$v;
            }

        }

        return $arr;

    }


    /**
     * Gives all PDF File Contents
     * to the Admin
     *
     * @param $subjectId
     * @return array
     */
    public static function fetchFileContentWithUnit($subjectId){

        $sql = "SELECT c.unit,c.id,c.type,c.subject_id,c.title,c.unit,c.publish,c.sno,p.name,p.id AS fid
                FROM contents AS c
                LEFT JOIN files AS p ON  p.content_id = c.id
                WHERE subject_id=? && c.type='pdf' ORDER BY unit,id";

        $pdo = Model::getDB();
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
                $arr[$newKey]['lessons']=$v;
            }

        }

        return $arr;

    }

}
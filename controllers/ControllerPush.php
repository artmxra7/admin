<?php
 
class ControllerPush
{ 
    private $db;
    private $pdo;
    function __construct() 
    {
        // connecting to database
        $this->db = new DB_Connect();
        $this->pdo = $this->db->connect();
    }
 
    function __destruct() { }
 

    public function deletePush($push_id, $is_deleted) {
        $stmt = $this->pdo->prepare('UPDATE tbl_storefinder_push SET is_deleted = :is_deleted WHERE push_id = :push_id');
        $result = $stmt->execute( array('is_deleted' => $is_deleted, 'push_id' => $push_id) );
        return $result ? true : false;
    }

    public function insertPush($itm) {
        $stmt = $this->pdo->prepare('INSERT INTO tbl_storefinder_push( 
                                            push_msg,
                                            push_url,
                                            created_at,
                                            updated_at,
                                            push_title,
                                            is_deleted) 
                                        VALUES( 
                                            :push_msg,
                                            :push_url,
                                            :created_at,
                                            :updated_at,
                                            :push_title,
                                            0 )');
        
        $result = $stmt->execute(
                            array('push_msg' => $itm->push_msg,
                                    'push_url' => $itm->push_url,
                                    'created_at' => $itm->created_at,
                                    'updated_at' => $itm->updated_at,
                                    'push_title' => $itm->push_title) );
        
        return $result ? true : false;
    }
 
    public function getPushByPushId($push_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_push WHERE is_deleted = 0 AND push_id = :push_id');
        $stmt->execute( array('push_id' => $push_id) );        
        foreach ($stmt as $row) {
            $itm = $this->formatData($row);
            return $itm;
        }
        return null;
    }

    public function getPush() {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_push WHERE is_deleted = 0 ORDER BY push_id DESC');
        $stmt->execute();
        return $this->formatPush($stmt);
    }

    public function getPushBySearching($search) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_push WHERE is_deleted = 0 AND push_msg LIKE :search ORDER BY push_msg ASC');
        $stmt->execute( array('search' => '%'.$search.'%'));
        return $this->formatPush($stmt);
    }


    public function getPushAtRange($begin, $end) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_push WHERE is_deleted = 0 ORDER BY push_id ASC LIMIT :beg, :end');
        $stmt->execute( array('beg' => $begin, 'end' => $end) );
        return $this->formatPush($stmt);
    }

    public function formatPush($stmt) {
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            $itm = $this->formatData($row);
            $array[$ind] = $itm;
            $ind++;
        }
        return $array;
    }

    public function formatData($row) {
        $itm = new Push();
        $itm->push_id = $row['push_id'];
        $itm->push_msg = $row['push_msg'];
        $itm->push_url = $row['push_url'];
        $itm->created_at = $row['created_at'];
        $itm->updated_at = $row['updated_at'];
        $itm->is_deleted = $row['is_deleted'];
        $itm->push_title = $row['push_title'];
        return $itm;
    }

    public function getTokens() {
        $stmt = $this->pdo->prepare('SELECT device_token FROM tbl_storefinder_tokens WHERE is_deleted = 0');
        $stmt->execute( );
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            $array[$ind] = $row['device_token'];
            $ind++;
        }
        return $array;
    }


}
 
?>
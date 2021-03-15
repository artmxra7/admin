<?php
 
class ControllerToken
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

    public function insertToken($itm) {
        $stmt = $this->pdo->prepare('INSERT INTO tbl_storefinder_tokens( 
                                            device_token,
                                            created_at,
                                            updated_at,
                                            is_deleted ) 
                                        VALUES( 
                                            :device_token,
                                            :created_at,
                                            :updated_at,
                                            0 )');
        
        $result = $stmt->execute(
                            array('device_token' => $itm->device_token,
                                    'created_at' => $itm->created_at,
                                    'updated_at' => $itm->updated_at ) );
        
        return $result ? true : false;
    }

    public function formatRow($row) {
        $itm = new Token();
        $itm->token_id = $row['token_id'];
        $itm->device_token = $row['device_token'];
        $itm->created_at = $row['created_at'];
        $itm->updated_at = $row['updated_at'];
        $itm->is_deleted = $row['is_deleted'];
        return $itm;
    }
 
    public function getTokenByDeviceToken($device_token) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_tokens WHERE device_token = :device_token');
        $stmt->execute( array('device_token' => $device_token));
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            // do something with $row
            $itm = $this->formatRow($row);
            return $itm;
        }
        return null;
    }
}
 
?>
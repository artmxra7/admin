<?php

class ControllerStore
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
 
    public function updateStore($itm) {
        $stmt = $this->pdo->prepare('UPDATE tbl_storefinder_stores

                                        SET store_name = :store_name, 
                                            store_address = :store_address, 
                                            store_desc = :store_desc, 
                                            lat = :lat, 
                                            lon = :lon, 
                                            sms_no = :sms_no, 
                                            phone_no = :phone_no, 
                                            email = :email, 
                                            website = :website, 
                                            category_id = :category_id, 
                                            created_at = :created_at, 
                                            updated_at = :updated_at, 
                                            featured = :featured, 

                                            mon_open = :mon_open, 
                                            mon_close = :mon_close, 
                                            tue_open = :tue_open, 
                                            tue_close = :tue_close, 
                                            wed_open = :wed_open, 
                                            wed_close = :wed_close, 
                                            thu_open = :thu_open, 
                                            thu_close = :thu_close, 
                                            fri_open = :fri_open, 
                                            fri_close = :fri_close, 
                                            sat_open = :sat_open, 
                                            sat_close = :sat_close, 
                                            sun_open = :sun_open, 
                                            sun_close = :sun_close, 
                                            user_id = :user_id, 

                                            is_deleted = :is_deleted 

                                        WHERE store_id = :store_id');

        $result = $stmt->execute(
                            array('store_name' => $itm->store_name,
                                    'store_address' => $itm->store_address,  
                                    'store_desc' => $itm->store_desc,
                                    'lat' => $itm->lat,
                                    'lon' => $itm->lon,
                                    'sms_no' => $itm->sms_no,
                                    'phone_no' => $itm->phone_no,
                                    'email' => $itm->email,
                                    'website' => $itm->website,
                                    'category_id' => $itm->category_id,
                                    'created_at' => $itm->created_at,
                                    'updated_at' => $itm->updated_at,
                                    'featured' => $itm->featured,
                                    'is_deleted' => $itm->is_deleted,

                                    'mon_open' => $itm->mon_open,
                                    'mon_close' => $itm->mon_close,
                                    'tue_open' => $itm->tue_open,
                                    'tue_close' => $itm->tue_close,
                                    'wed_open' => $itm->wed_open,
                                    'wed_close' => $itm->wed_close,
                                    'thu_open' => $itm->thu_open,
                                    'thu_close' => $itm->thu_close,
                                    'fri_open' => $itm->fri_open,
                                    'fri_close' => $itm->fri_close,
                                    'sat_open' => $itm->sat_open,
                                    'sat_close' => $itm->sat_close,
                                    'sun_open' => $itm->sun_open,
                                    'sun_close' => $itm->sun_close,
                                    'user_id' => $itm->user_id,

                                    'store_id' => $itm->store_id ) );
        
        return $result ? true : false;

    }


    public function deleteStore($store_id, $is_deleted) {
        $stmt = $this->pdo->prepare('UPDATE tbl_storefinder_stores SET is_deleted = :is_deleted WHERE store_id = :store_id ');
        $result = $stmt->execute( array('store_id' => $store_id, 'is_deleted' => $is_deleted) );
        return $result ? true : false;
    }

    public function updateStoreFeatured($itm) {
        $stmt = $this->pdo->prepare('UPDATE tbl_storefinder_stores SET featured = :featured WHERE store_id = :store_id ');
        $result = $stmt->execute( array('store_id' => $itm->store_id, 'featured' => $itm->featured) );
        return $result ? true : false;
    }


    public function insertStore($itm) {
        $stmt = $this->pdo->prepare('INSERT INTO tbl_storefinder_stores( 
                                        store_name, 
                                        store_address, 
                                        store_desc, 
                                        lat, 
                                        lon, 
                                        sms_no, 
                                        phone_no, 
                                        email, 
                                        website, 
                                        category_id, 
                                        created_at, 
                                        updated_at, 
                                        featured,

                                        mon_open,
                                        mon_close,
                                        tue_open,
                                        tue_close,
                                        wed_open,
                                        wed_close,
                                        thu_open,
                                        thu_close,
                                        fri_open,
                                        fri_close,
                                        sat_open,
                                        sat_close,
                                        sun_open,
                                        sun_close,
                                        user_id,

                                        is_deleted ) 

                                    VALUES(
                                        :store_name, 
                                        :store_address, 
                                        :store_desc, 
                                        :lat, 
                                        :lon, 
                                        :sms_no, 
                                        :phone_no, 
                                        :email, 
                                        :website, 
                                        :category_id, 
                                        :created_at, 
                                        :updated_at, 
                                        :featured,

                                        :mon_open,
                                        :mon_close,
                                        :tue_open,
                                        :tue_close,
                                        :wed_open,
                                        :wed_close,
                                        :thu_open,
                                        :thu_close,
                                        :fri_open,
                                        :fri_close,
                                        :sat_open,
                                        :sat_close,
                                        :sun_open,
                                        :sun_close,
                                        :user_id,

                                        :is_deleted )');
        
        $result = $stmt->execute(
                            array('store_name' => $itm->store_name,
                                    'store_address' => $itm->store_address,  
                                    'store_desc' => $itm->store_desc,
                                    'lat' => $itm->lat,
                                    'lon' => $itm->lon,
                                    'sms_no' => $itm->sms_no,
                                    'phone_no' => $itm->phone_no,
                                    'email' => $itm->email,
                                    'website' => $itm->website,
                                    'category_id' => $itm->category_id,
                                    'created_at' => $itm->created_at,
                                    'updated_at' => $itm->updated_at,
                                    'featured' => $itm->featured,

                                    'mon_open' => $itm->mon_open,
                                    'mon_close' => $itm->mon_close,
                                    'tue_open' => $itm->tue_open,
                                    'tue_close' => $itm->tue_close,
                                    'wed_open' => $itm->wed_open,
                                    'wed_close' => $itm->wed_close,
                                    'thu_open' => $itm->thu_open,
                                    'thu_close' => $itm->thu_close,
                                    'fri_open' => $itm->fri_open,
                                    'fri_close' => $itm->fri_close,
                                    'sat_open' => $itm->sat_open,
                                    'sat_close' => $itm->sat_close,
                                    'sun_open' => $itm->sun_open,
                                    'sun_close' => $itm->sun_close,
                                    'user_id' => $itm->user_id,

                                    'is_deleted' => 0 ) );
        
        return $result ? true : false;
    }
 
    public function getStoresByUserId($user_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_stores WHERE is_deleted = 0 AND user_id = :user_id ORDER BY store_name ASC');
        $stmt->execute( array('user_id' => $user_id) );
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            $itm = $this->formatStore($row);
            $array[$ind] = $itm;
            $ind++;
        } 
        return $array;
    }

    public function getStores() {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_stores WHERE is_deleted = 0 ORDER BY store_name ASC');
        $stmt->execute();
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            $itm = $this->formatStore($row);
            $array[$ind] = $itm;
            $ind++;
        } 
        return $array;
    }

    public function getStoresBySearching($search) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_stores WHERE is_deleted = 0 AND store_name LIKE :search ORDER BY store_name ASC');
        $stmt->execute( array('search' => '%'.$search.'%'));
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            $itm = $this->formatStore($row);
            $array[$ind] = $itm;
            $ind++;
        } 
        return $array;
    }


    public function getStoreByStoreId($store_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_stores WHERE store_id = :store_id');
        $stmt->execute( array('store_id' => $store_id));
        foreach ($stmt as $row) {
            $itm = $this->formatStore($row);
            return $itm;
        } 
        return null;
    }


    public function getStoreFeatured() {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_stores WHERE featured = 1 AND is_deleted = 0 ORDER BY store_name ASC');
        $stmt->execute();
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            $itm = $this->formatStore($row);
            $array[$ind] = $itm;
            $ind++;
        } 
        return $array;
    }

    public function getLastInsertedId() {
        return $this->pdo->lastInsertId(); 
    }

    public function getFeaturedStoresAtRange($begin, $end) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_stores WHERE is_deleted = 0 AND featured = 1 ORDER BY store_name ASC LIMIT :beg, :end');
        $stmt->execute( array('beg' => $begin, 'end' => $end) );
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            $itm = $this->formatStore($row);
            $array[$ind] = $itm;
            $ind++;
        } 
        return $array;
    }

    public function getStoresAtRange($begin, $end) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_stores WHERE is_deleted = 0 ORDER BY store_id ASC LIMIT :beg, :end');
        $stmt->execute( array('beg' => $begin, 'end' => $end) );
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            $itm = $this->formatStore($row);
            $array[$ind] = $itm;
            $ind++;
        } 
        return $array;
    }

    public function getStoresByCategoryIdAtRange($category_id, $begin, $end) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_stores WHERE category_id = :category_id AND is_deleted = 0 ORDER BY store_name ASC LIMIT :beg, :end');
        $stmt->execute( array('category_id' => $category_id, 'beg' => $begin, 'end' => $end) );
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            $itm = $this->formatStore($row);
            $array[$ind] = $itm;
            $ind++;
        } 
        return $array;
    }

    public function getStoreFeaturedAtMax($max) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_stores WHERE featured = 1 AND is_deleted = 0 ORDER BY store_name ASC LIMIT 0, :max');
        $stmt->execute( array('max' => $max) );
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            $itm = $this->formatStore($row);
            $array[$ind] = $itm;
            $ind++;
        } 
        return $array;
    }

    public function getStoresByCategoryId($category_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_stores WHERE category_id = :category_id AND is_deleted = 0 ORDER BY store_name ASC');
        $stmt->execute( array('category_id' => $category_id) );
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            $itm = $this->formatStore($row);
            $array[$ind] = $itm;
            $ind++;
        } 
        return $array;
    }

    public function formatStore($row) {
        $itm = new Store();
        $itm->store_id = $row['store_id'];
        $itm->store_name = $row['store_name'];
        $itm->store_address = $row['store_address'];
        $itm->store_desc = $row['store_desc'];
        $itm->lat = $row['lat'];
        $itm->lon = $row['lon'];
        $itm->sms_no = $row['sms_no'];
        $itm->phone_no = $row['phone_no'];
        $itm->email = $row['email'];
        $itm->website = $row['website'];
        $itm->category_id = $row['category_id'];
        $itm->created_at = $row['created_at'];
        $itm->updated_at = $row['updated_at'];
        $itm->featured = $row['featured'];
        $itm->is_deleted = $row['is_deleted'];

        $itm->mon_open = $row['mon_open'];
        $itm->mon_close = $row['mon_close'];
        $itm->tue_open = $row['tue_open'];
        $itm->tue_close = $row['tue_close'];
        $itm->wed_open = $row['wed_open'];
        $itm->wed_close = $row['wed_close'];
        $itm->thu_open = $row['thu_open'];
        $itm->thu_close = $row['thu_close'];
        $itm->fri_open = $row['fri_open'];
        $itm->fri_close = $row['fri_close'];
        $itm->sat_open = $row['sat_open'];
        $itm->sat_close = $row['sat_close'];
        $itm->sun_open = $row['sun_open'];
        $itm->sun_close = $row['sun_close'];
        $itm->user_id = $row['user_id'];
        return $itm;
    }

    public function getStoreSearchAtRange($begin, $end, $keywords) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_stores WHERE is_deleted = 0 AND (store_name LIKE :keyword1 OR store_address LIKE :keyword2 OR store_desc LIKE :keyword3) ORDER BY store_name ASC LIMIT :beg, :end');
        $stmt->execute( array(
                'keyword1' => '%'.$keywords.'%', 
                'keyword2' => '%'.$keywords.'%', 
                'keyword3' => '%'.$keywords.'%', 
                'beg' => $begin, 
                'end' => $end) );
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            $itm = $this->formatStore($row);
            $array[$ind] = $itm;
            $ind++;
        } 
        return $array;
    }

    public function getStoreSearch($keywords) {
        $stmt = $this->pdo->prepare('SELECT * FROM tbl_storefinder_stores WHERE is_deleted = 0 AND (store_name LIKE :keyword1 OR store_address LIKE :keyword2 OR store_desc LIKE :keyword3) ORDER BY store_name ASC');
        $stmt->execute( array(
                'keyword1' => '%'.$keywords.'%', 
                'keyword2' => '%'.$keywords.'%', 
                'keyword3' => '%'.$keywords.'%'));
        $array = array();
        $ind = 0;
        foreach ($stmt as $row) {
            $itm = $this->formatStore($row);
            $array[$ind] = $itm;
            $ind++;
        } 
        return $array;
    }
}
 
?>
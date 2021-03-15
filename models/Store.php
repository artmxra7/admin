<?php
 
class Store
{
    public $store_id;
    public $store_name;
    public $store_address;
    public $store_desc;
    public $lat;
    public $lon;
    public $sms_no;
    public $phone_no;
    public $email;
    public $website;
    public $category_id;
    public $icon_id;
    public $created_at;
    public $updated_at;
    public $featured;
    public $is_deleted;
    public $user_id;

    public $mon_open;
    public $mon_close;
    public $tue_open;
    public $tue_close;
    public $wed_open;
    public $wed_close;
    public $thu_open;
    public $thu_close ;
    public $fri_open;
    public $fri_close;
    public $sat_open;
    public $sat_close;
    public $sun_open;
    public $sun_close;

    // constructor
    function __construct() 
    {

    }
 
    // destructor
    function __destruct() 
    {
         
    }
}
 
?>
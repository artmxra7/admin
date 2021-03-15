<?php
 
class User
{
	public $user_id;
    public $full_name;
    public $username;
    public $password;
    public $login_hash;
    public $facebook_id;
    public $twitter_id;
    public $email;
    public $dealer_id;
    public $seller_id;
    public $deny_access;
    public $apple_id;

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
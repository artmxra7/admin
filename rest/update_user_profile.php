<?php

    require '../header_rest.php';
    $controllerRest = new ControllerRest();
    $controllerUser = new ControllerUser();
    $extras = new Extras();

    $password = "";
    if( !empty($_POST['password']) )
        $password = md5($_POST['password']);

    $full_name = "";
    if( !empty($_POST['full_name']) )
        $full_name = $_POST['full_name'];

    $email = "";
    if( !empty($_POST['email']) )
      $email = $_POST['email'];

    $user_id ="";
    if( !empty($_POST['user_id']) )
        $user_id = $_POST['user_id'];

    $login_hash ="";
    if( !empty($_POST['login_hash']) )
        $login_hash = $_POST['login_hash'];

    $api_key = "";
    if(!empty($_POST['api_key']))
        $api_key = $_POST['api_key'];

    $thumb_url ="";
    if(!empty($_POST['thumb_url']))
        $thumb_url = $_POST['thumb_url'];
      
    if( !empty($_FILES["thumb_file"]["name"]) ) {
        $thumb_url = $extras->uploadFile("thumb_file", 'profile_');
    }

    if( empty($api_key) ) {
        $arr = array();
        $arr['status'] = formatStatus('3', 'Invalid Access.');
        echo json_encode($arr);
        return;
    }

    if($controllerUser->isUserIdExistAndHash($user_id, $login_hash)) {
        $arr = array();
        $arr['status'] = formatStatus('3', 'Invalid Access.');
        echo json_encode($arr);
        return;
    }
    
    $itm = $controllerUser->getUserByUserId($user_id);
    $itm->full_name = $full_name;
    
    if(strlen($password) > 0)
        $itm->password = $password;
    
    $itm->thumb_url = $thumb_url;
    $controllerUser->updateUserProfile($itm);

    $user = $controllerUser->getUserByUserId($user_id);
    $userData = translateJSON($user);
    echo json_encode($userData);

    function translateJSON($itm) {
        $arr = array();
        $arr['user_id'] = $itm->user_id;
        $arr['username'] = $itm->username;
        $arr['login_hash'] = $itm->login_hash;
        $arr['facebook_id'] = $itm->facebook_id;
        $arr['twitter_id'] = $itm->twitter_id;
        $arr['full_name'] = $itm->full_name;
        $arr['thumb_url'] = $itm->thumb_url;
        $arr['photo_url'] = $itm->photo_url;
        $arr['email'] = $itm->email;
        $arr['apple_id'] = $itm->apple_id;

        $arrStatus = array();
        $arrStatus['status_code'] = "-1";
        $arrStatus['status_text'] = "Success.";

        $arrJSON = array();
        $arrJSON['user'] = $arr;
        $arrJSON['status'] = $arrStatus;

        return $arrJSON;
    }

    function formatStatus($status_code, $status_text) {
        $arr = array( 'status_code' => ''.$status_code.'', 'status_text' => ''.$status_text.'' );
        return $arr;
    }


?>
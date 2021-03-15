<?php

  require_once '../header_rest.php';

  $controllerUser = new ControllerUser();
  $extras = new Extras();

  if( !empty($_POST['username']) )
      $username = $_POST['username'];

  if( !empty($_POST['password']) )
      $password = md5($_POST['password']);

  $full_name = "";
  if( !empty($_POST['full_name']) )
      $full_name = $_POST['full_name'];

  $email = "";
  if( !empty($_POST['email']) )
      $email = $_POST['email'];

  if( !empty($_POST['facebook_id']) )
      $facebook_id = $_POST['facebook_id'];

  if( !empty($_POST['twitter_id']) )
      $twitter_id = $_POST['twitter_id'];

  $thumb_url = "";
  if( !empty($_POST['thumb_url']) )
    $thumb_url = $_POST['thumb_url'];

  $api_key = "";
  if(!empty($_POST['api_key']))
      $api_key = $_POST['api_key'];


  if( !empty($_FILES["thumb_file"]["name"]) ) {
      $thumb_url = $extras->uploadFile("thumb_file", 'profile_');
  }

  if( empty($api_key) ) {
      $arr = array();
      $arr['status'] = formatStatus('3', 'Invalid Access.');
      echo json_encode($arr);
      return;
  }

  if( !empty($username) && !empty($password) && !empty($full_name) && !empty($email) ) {

      if($controllerUser->isUserExist($username)) {
          $arr = array();
          $arr['status'] = formatStatus('2', 'Username Exist.');
          echo json_encode($arr);
          return;
      }

      if($controllerUser->isEmailExist($email)) {
          $arr = array();
          $arr['status'] = formatStatus('2', 'Email already registered.');
          echo json_encode($arr);
          return;
      }

      $itm = new User();
      $itm->username = $username;
      $itm->password = $password;
      $itm->full_name = $full_name;
      $itm->email = $email;
      $itm->facebook_id = '';
      $itm->apple_id = '';
      $itm->twitter_id = '';
      $itm->thumb_url = $thumb_url;
      $itm->photo_url = '';

      $controllerUser->registerUser($itm);
      $user = $controllerUser->loginUser($username, $itm->password);
      if($user != null) {
          // update the hash
          $controllerUser->updateUserHash($user);
          $userData = translateJSON($user);
          echo json_encode($userData);
      }
  }

  else if( !empty($facebook_id) ) {  
      if(!$controllerUser->isFacebookIdExist($facebook_id)) {
            $itm = new User();
            $itm->username = '';
            $itm->password = '';
            $itm->full_name = $full_name;
            $itm->email = $email;
            $itm->facebook_id = $facebook_id;
            $itm->apple_id = '';
            $itm->twitter_id = '';
            $itm->thumb_url = $thumb_url;
            $itm->photo_url = '';
            $controllerUser->registerUser($itm);
              
            $user = $controllerUser->loginFacebook($facebook_id);
            $controllerUser->updateUserHash($user);
            $userData = translateJSON($user);
            echo json_encode($userData);
      }
      else {
          $user = $controllerUser->loginFacebook($facebook_id);
          if($user == null) {
              // update the hash
              $arr = array();
              $arr['status'] = formatStatus('2', 'Facebook account invalid.');
              echo json_encode($arr);
              return;
          }
          $controllerUser->updateUserHash($user);
          $userData = translateJSON($user);
          echo json_encode($userData);
      }
  }
  else if( !empty($twitter_id) ) {
      if(!$controllerUser->isTwitterIdExist($twitter_id)) {
          $itm = new User();
          $itm->username = '';
          $itm->password = '';
          $itm->full_name = $full_name;
          $itm->apple_id = '';
          $itm->email = $email;
          $itm->facebook_id = '';
          $itm->twitter_id = $twitter_id;
          $itm->thumb_url = $thumb_url;
          $itm->photo_url = '';
          $controllerUser->registerUser($itm);

          $controllerUser->updateUserHash($user);
          $userData = translateJSON($user);
          echo json_encode($userData);
      }
      else {
          $user = $controllerUser->loginTwitter($twitter_id);
          if($user == null) {
              // update the hash
              $arr = array();
              $arr['status'] = formatStatus('2', 'Twitter account invalid.');
              echo json_encode($arr);
              return;
          }
          $controllerUser->updateUserHash($user);
          $userData = translateJSON($user);
          echo json_encode($userData);
      }
  }
  else {
      $arr = array();
      $arr['status'] = formatStatus('2', 'Invalid Access.');
      echo json_encode($arr);
      return;
  }


  function translateJSON($itm) {
      $arr = array();
      $arr['user_id'] = "".$itm->user_id."";
      $arr['username'] = "".$itm->username."";
      $arr['login_hash'] = "".$itm->login_hash."";
      $arr['facebook_id'] = "".$itm->facebook_id."";
      $arr['twitter_id'] = "".$itm->twitter_id."";
      $arr['full_name'] = "".$itm->full_name."";
      $arr['thumb_url'] = "".$itm->thumb_url."";
      $arr['photo_url'] = "".$itm->photo_url."";
      $arr['email'] = "".$itm->email."";
      $arr['apple_id'] = "".$itm->apple_id."";

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
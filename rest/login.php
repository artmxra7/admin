<?php

  require_once '../header_rest.php';
  $controllerUser = new ControllerUser();

  $username = "";
  if( !empty($_POST['username']) )
    $username = $_POST['username'];

  $password = "";
  if( !empty($_POST['password']) )
    $password = md5($_POST['password']);

  $facebook_id = "";
  if( !empty($_POST['facebook_id']) )
    $facebook_id = $_POST['facebook_id'];

  $twitter_id = "";
  if( !empty($_POST['twitter_id']) )
    $twitter_id = $_POST['twitter_id'];

  $apple_id = "";
  if( !empty($_POST['apple_id']) )
    $apple_id = $_POST['apple_id'];

  $api_key = "";
  if(!empty($_POST['api_key']))
      $api_key = $_POST['api_key'];

    

  if( empty($api_key) || empty($username) || empty($password) ) {
      $arr = array();
      $arr['status'] = formatStatus('3', 'Invalid Access.');
      echo json_encode($arr);
      return;
  }

  if( !empty($username) && !empty($password) ) {
      $user = $controllerUser->loginUser($username, $password);
      if($user != null) {
          // update the hash
          $controllerUser->updateUserHash($user);
          $userData = translateJSON($user);
          echo json_encode($userData);
      }
      else {
          $arr = array();
          $arr['status'] = formatStatus('2', 'Invalid Login.');
          echo json_encode($arr);
      }
  }
  else if( !empty($facebook_id) ) {
      $user = $controllerUser->loginFacebook($facebook_id);
      if($user != null) {
          // update the hash
          $controllerUser->updateUserHash($user);
          $userData = translateJSON($user);
          echo json_encode($userData);
      }
      else {
          $arr = array();
          $arr['status'] = formatStatus('2', 'Invalid Login.');
          echo json_encode($arr);
      }
  }
  else if( !empty($twitter_id) ) {
      $user = $controllerUser->loginTwitter($twitter_id);
      if($user != null) {
          // update the hash
          $controllerUser->updateUserHash($user);
          $userData = translateJSON($user);
          echo json_encode($userData);
      }
      else {
          $arr = array();
          $arr['status'] = formatStatus('2', 'Invalid Login.');
          echo json_encode($arr);
      }
  }
  else {
      $arr = array();
      $arr['status'] = formatStatus('3', 'Invalid Access.');
      echo json_encode($arr);
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
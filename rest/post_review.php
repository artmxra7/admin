<?php

  require '../header_rest.php';
  $controllerRest = new ControllerRest();
  $controllerUser = new ControllerUser();
  $controllerReview = new ControllerReview();

  $user_id = 0;
  if(!empty($_POST['user_id']) )
    $user_id = $_POST['user_id'];

  $store_id = 0;
  if(!empty($_POST['store_id']) )
    $store_id = $_POST['store_id'];

  $login_hash = 0;
  if(!empty($_POST['login_hash']) )
    $login_hash = $_POST['login_hash'];

  $review = "";
  if(!empty($_POST['review']) )
    $review = $_POST['review'];

  $api_key = "";
  if(!empty($_POST['api_key']))
      $api_key = $_POST['api_key'];

  if( empty($api_key) || $user_id <= 0 || $store_id <= 0 || empty($login_hash) || empty($review)) {
      $arr = array();
      $arr['status'] = formatStatus('3', 'Invalid Access.');
      echo json_encode($arr);
      return;
  }

  if(!$controllerUser->isUserIdExistAndHash($user_id, $login_hash)) {
      $arr = array();
      $arr['status'] = formatStatus('3', 'Invalid Access.');
      echo json_encode($arr);
      return;
  }

  $itm = new Review();
  $itm->review = $review;
  $itm->store_id = $store_id; 
  $itm->user_id = $user_id;
  $itm->created_at = time();
  $itm->updated_at = time();
  $controllerReview->insertReview($itm);

  $arr = array();
  $arr['status'] = formatStatus('-1', 'Success.');
  echo json_encode($arr);

  function formatStatus($status_code, $status_text) {
      $arr = array( 'status_code' => ''.$status_code.'', 'status_text' => ''.$status_text.'' );
      return $arr;
  }
?>
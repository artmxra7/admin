<?php

  require '../header_rest.php';
  $controllerRest = new ControllerRest();
  $controllerUser = new ControllerUser();
  $controllerRating = new ControllerRating();

  $user_id = 0;
  if(!empty($_POST['user_id']) )
    $user_id = $_POST['user_id'];

  $store_id = 0;
  if(!empty($_POST['store_id']) )
    $store_id = $_POST['store_id'];

  $login_hash = "";
  if(!empty($_POST['login_hash']) )
    $login_hash = $_POST['login_hash'];

  $rating = 0;
  if(!empty($_POST['rating']) )
    $rating = $_POST['rating'];

  $api_key = "";
  if(!empty($_POST['api_key']))
      $api_key = $_POST['api_key'];

  if( empty($api_key) || $user_id <= 0 || $store_id <= 0 || empty($login_hash) || $rating <= 0) {
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

  $itm = new Rating();
  $itm->rating = $rating;
  $itm->store_id = $store_id; 
  $itm->user_id = $user_id;
  $itm->created_at = time();
  $itm->updated_at = time();
  $controllerRating->insertRating($itm);

  // $results = $controllerRest->getResultStoresRating($store_id);
  // $arrayObj = array();
  // foreach ($results as $row) {
  //     foreach ($row as $columnName => $field) {
  //         if(!is_numeric($columnName)) {
  //             $arrayObj[$columnName] = $field;
  //         }
  //     }
  // }

  $arr = array();
  $arr['status'] = formatStatus('-1', 'Success.');
  echo json_encode($arr);


  function formatStatus($status_code, $status_text) {
      $arr = array( "status_code" => $status_code, "status_text" => $status_text );
      return $arr;
  }

?>
<?php

  require '../header_rest.php';
  $controllerToken = new ControllerToken();

  $player_id ="";
  if(!empty($_POST['player_id']) )
    $player_id = $_POST['player_id'];

  $api_key = "";
  if(!empty($_POST['api_key']))
      $api_key = $_POST['api_key'];

  if( empty($api_key) || empty($player_id) ) {
      $arr = array();
      $arr['status'] = formatStatus('3', 'Invalid Access.');
      echo json_encode($arr);
      return;
  }

  $token = $controllerToken->getTokenByDeviceToken($player_id);
  if($token != null) {
    $arr = array();
    $arr['status'] = formatStatus('-1', 'Success.');
    echo json_encode($arr);
    return;
  }

  $itm = new Token();
  $itm->device_token = $player_id;
  $itm->created_at = time();
  $itm->updated_at = time();
  $controllerToken->insertToken($itm);

  $arr = array();
  $arr['status'] = formatStatus('-1', 'Success.');
  echo json_encode($arr);

  function formatStatus($status_code, $status_text) {
      $arr = array( 'status_code' => ''.$status_code.'', 'status_text' => ''.$status_text.'' );
      return $arr;
  }
?>
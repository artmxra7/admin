<?php

  require '../header_rest.php';
  $controllerUser = new ControllerUser();
  $controllerStore = new ControllerStore();


  $user_id = sanitize('user_id');
  $login_hash = sanitize('login_hash');
  $api_key = sanitize('api_key');
  $store_id = sanitize('store_id');

  if( empty($api_key) || empty($user_id) || empty($login_hash) || $store_id <= 0 ) {
      $arr = array();
      $arr['status'] = formatStatus('3', 'Invalid Access.');
      echo json_encode($arr);
      return;
  }

  if(!$controllerUser->isUserIdExistAndHash($user_id, $login_hash)) {
      $arr = array();
      $arr['status'] = formatStatus('3', 'Invalid Access. Please relogin.');
      echo json_encode($arr);
      return;
  }

  $controllerStore->deleteStore($store_id, 1);

  $arr = array();
  $arr['status'] = formatStatus('-1', 'Success.');
  echo json_encode($arr);

  function formatStatus($status_code, $status_text) {
      $arr = array( 'status_code' => ''.$status_code.'', 'status_text' => ''.$status_text.'' );
      return $arr;
  }

  function sanitize($key) {
      $val = "";
      if( !empty($_POST[$key]) )
        $val = $_POST[$key];

      return $val;
  }
?>
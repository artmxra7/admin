<?php

    require '../header_rest.php';
    $controllerRest = new ControllerRest();
    $controllerUser = new ControllerUser();
    $controllerRating = new ControllerRating();


    $api_key = "";
    if(!empty($_POST['api_key']))
        $api_key = $_POST['api_key'];

    $user_id = 0;
    if(!empty($_POST['user_id']) )
      $user_id = $_POST['user_id'];

    $store_id = 0;
    if(!empty($_POST['store_id']) )
      $store_id = $_POST['store_id'];

    $login_hash = 0;
    if(!empty($_POST['login_hash']) )
      $login_hash = $_POST['login_hash'];

    if( empty($api_key) || $user_id <= 0 || $store_id <= 0 || empty($login_hash)) {
        $arr = array();
        $arr['status'] = formatStatus('3', 'Invalid Access.');
        echo json_encode($arr);
        return;
    }

    $itm = $controllerRating->checkUserCanRate($store_id, $user_id);
    $canRate = $itm != null ? 0 : 1;

    $arr = array();
    $arr['status'] = formatStatus('-1', 'Success.');
    $arr['store_rating'] = array('store_id' => $store_id, 'can_rate' => $canRate);
    echo json_encode($arr);

    function formatStatus($status_code, $status_text) {
        $arr = array( 'status_code' => ''.$status_code.'', 'status_text' => ''.$status_text.'' );
        return $arr;
    }
?>
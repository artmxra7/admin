<?php

  require_once '../header_rest.php';

  $controllerUser = new ControllerUser();
  $controllerStore = new ControllerStore();
  $controllerPhoto = new ControllerPhoto();
  $extras = new Extras();

  $store_id = sanitize('store_id');
  $store_name = sanitize('store_name');
  $store_address = sanitize('store_address');
  $store_desc = base64_encode(sanitize('store_desc'));
  $lat = sanitize('lat');
  $lon = sanitize('lon');
  $sms_no = sanitize('sms_no');
  $phone_no = sanitize('phone_no');
  $email = sanitize('email');
  $website = sanitize('website');
  $category_id = sanitize('category_id');
  $mon_open = sanitize('mon_open');
  $mon_close = sanitize('mon_close');
  $tue_open = sanitize('tue_open');
  $tue_close = sanitize('tue_close');
  
  $wed_open = sanitize('wed_open');
  $wed_close = sanitize('wed_close');
  $thu_open = sanitize('thu_open');
  $thu_close = sanitize('thu_close');
  $fri_open = sanitize('fri_open');
  $fri_close = sanitize('fri_close');
  $sat_open = sanitize('sat_open');
  $sat_close = sanitize('sat_close');
  $sun_open = sanitize('sun_open');
  $sun_close = sanitize('sun_close');
  $user_id = sanitize('user_id');
  $login_hash = sanitize('login_hash');
  $api_key = sanitize('api_key');
  $max_photos_count = sanitize('max_photos_count');

  $photo_ids_deleted = sanitize('photo_ids_deleted');

  $arrPhotos = array();

  $ind = 0;
  for($x = 0; $x < $max_photos_count; $x++) {
      $file_name = "thumb_file_" .$x;
      if( !empty($_FILES[$file_name]["name"]) ) {
          $arrPhotos[$ind] = $extras->uploadFile($file_name, 'photo_');
          $ind += 1;
      }
  }

  if( empty($api_key) ) {
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

  $itm = new Store();
  $itm->store_id = intval($store_id);
  $itm->store_name = $store_name;
  $itm->store_address = $store_address;
  $itm->store_desc = $store_desc;
  $itm->lat = $lat;
  $itm->lon = $lon;
  $itm->sms_no = $sms_no;
  $itm->phone_no = $phone_no;
  $itm->email = $email;
  $itm->website = $website;
  $itm->category_id = intval($category_id);
  $itm->mon_open = $mon_open;
  $itm->mon_close = $mon_close;
  $itm->tue_open = $tue_open;
  $itm->tue_close = $tue_close;
  $itm->wed_open = $wed_open;
  $itm->wed_close = $wed_close;
  $itm->thu_open = $thu_open;
  $itm->thu_close = $thu_close;
  $itm->fri_open = $fri_open;
  $itm->fri_close = $fri_close;
  $itm->sat_open = $sat_open;
  $itm->sat_close = $sat_close;
  $itm->sun_open = $sun_open;
  $itm->sun_close = $sun_close;
  $itm->created_at = time();
  $itm->updated_at = time();
  $itm->featured = 0;
  $itm->user_id = intval($user_id);
  $itm->is_deleted = 0;

  if($store_id > 0) {
      $controllerStore->updateStore($itm);
  }
  else {
      $controllerStore->insertStore($itm);
      $store_id = $controllerStore->getLastInsertedId();
  }

  if(count($arrPhotos) > 0) {
      for($ind = 0; $ind < count($arrPhotos); $ind++) {
          $photo = new Photo();
          $photo->thumb_url = $arrPhotos[$ind];
          $photo->photo_url = $arrPhotos[$ind];
          $photo->store_id = $store_id;
          $photo->created_at = time();
          $photo->updated_at = time();
          $photo->is_deleted = 0;
          $controllerPhoto->insertPhoto($photo);
      }
  }

  $arrPhotoIds = explode(",", $photo_ids_deleted);
  if( count($arrPhotoIds) > 0 ) {
      for($ind = 0; $ind < count($arrPhotoIds); $ind++) {
          $controllerPhoto->deletePhoto($arrPhotoIds[$x], 1);
      }
  }

  $arr = array();
  $arr['status'] = formatStatus('-1', 'Success.');
  echo json_encode($arr);

  function sanitize($key) {
      $val = "";
      if( !empty($_POST[$key]) )
        $val = $_POST[$key];

      return $val;
  }

  function formatStatus($status_code, $status_text) {
      $arr = array( 'status_code' => ''.$status_code.'', 'status_text' => ''.$status_text.'' );
      return $arr;
  }

?>
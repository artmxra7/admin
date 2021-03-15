<?php

    require '../header_rest.php';
    $controllerRest = new ControllerRest();

    $api_key = "";
    if(!empty($_POST['api_key']))
        $api_key = $_POST['api_key'];

    $lat = 0;
    if(!empty($_POST['lat']))
        $lat = str_replace(",", ".", $_POST['lat']);

    $lon = 0;
    if(!empty($_POST['lon']))
        $lon = str_replace(",", ".", $_POST['lon']);

    $min = 0;
    if(!empty($_POST['min']))
        $min = $_POST['min'];

    $max = 0;
    if(!empty($_POST['max']))
        $max = $_POST['max'];

    $search_str = "";
    if(!empty($_POST['search_str']))
        $search_str = $_POST['search_str'];

    if( empty($api_key) ) {
        $arr = array();
        $arr['status'] = formatStatus('3', 'Invalid Access.');
        echo json_encode($arr);
        return;
    }
    
    if($lat == 0 || $lon == 0 ) {
        $arr = array();
        $arr['status'] = formatStatus('3', 'Invalid Access.');
        echo json_encode($arr);
        return;
    }

    $results = $controllerRest->getResultStoresSearch($lat, $lon, $min, $max, $search_str);

    $arrayJSON = array();
    $arrayJSON['stores'] = getArrayObjsStores($results, $controllerRest);
    $arrayJSON['lat'] = $lat;
    $arrayJSON['lon'] = $lon;
    $arrayJSON['api_key'] = $api_key;
    $arrayJSON['search_str'] = $search_str;
    $arrayJSON['max'] = $max;
    $arrayJSON['min'] = $min;
    echo json_encode($arrayJSON);

    function formatStatus($status_code, $status_text) {
        $arr = array( 'status_code' => ''.$status_code.'', 'status_text' => ''.$status_text.'' );
        return $arr;
    }

    function getObj($results) {
        $arrayObj = array();
        foreach ($results as $row) {
            foreach ($row as $columnName => $field) {
                if(!is_numeric($columnName)) {
                    $arrayObj[$columnName] = $field;
                }
            }
        }
        return $arrayObj;
    }

    function getArrayObjs($results) {
        $ind = 0;
        $arrayObjs = array();
        foreach ($results as $row) {
            $arrayObj = array();
            foreach ($row as $columnName => $field) {
                if(!is_numeric($columnName)) {
                    $val = preg_replace('~[\r\n]+~', '', $field);
                    $val = htmlspecialchars(trim(strip_tags($val)));
                    $arrayObj[$columnName] = $val;
                }
            }
            $arrayObjs[$ind] = $arrayObj;
            $ind += 1;
        }
        return $arrayObjs;
    }

    function getArrayObjsStores($results, $controllerRest) {
        $ind = 0;
        $arrayObjs = array();
        foreach ($results as $row) {
            $arrayObj = array();
            foreach ($row as $columnName => $field) {
                if(!is_numeric($columnName)) {
                    $val = preg_replace('~[\r\n]+~', '', $field);
                    $val = htmlspecialchars(trim(strip_tags($val)));
                    $arrayObj[$columnName] = $val;
                }
            }

            $arrayObj['photos'] = array();
            $store_id = $arrayObj['store_id'];
            if( !empty($store_id) ) {
                $resultPhotos = $controllerRest->getResultPhotosByStoreId($store_id);
                $arrayObj['photos'] = getArrayObjs($resultPhotos);
            }

            $arrayObjs[$ind] = $arrayObj;
            $ind += 1;
        }
        return $arrayObjs;
    }

?>
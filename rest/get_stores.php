<?php

    require '../header_rest.php';
    $controllerRest = new ControllerRest();

    $api_key = "";
    if(!empty($_GET['api_key']))
        $api_key = $_GET['api_key'];

    $lat = 0;
    if(!empty($_GET['lat']))
        $lat = str_replace(",", ".", $_GET['lat']);

    $lon = 0;
    if(!empty($_GET['lon']))
        $lon = str_replace(",", ".", $_GET['lon']);

    $radius = 0;
    if(!empty($_GET['radius']))
        $radius = $_GET['radius'];

    $category_id = 0;
    if(!empty($_GET['category_id']))
        $category_id = $_GET['category_id'];

    if( empty($api_key) ) {
        $arr = array();
        $arr['status'] = formatStatus('3', 'Invalid Access.');
        echo json_encode($arr);
        return;
    }
    
    if($lat == 0 || $lon == 0 || $radius == 0) {
        $arr = array();
        $arr['status'] = formatStatus('3', 'Invalid Access.');
        echo json_encode($arr);
        return;
    }

    if($category_id > 0) {
        $results = $controllerRest->getResultCategoryStoresNearby($lat, $lon, $radius, $category_id);
    }
    else {
        $results = $controllerRest->getResultStoresNearby1($lat, $lon, $radius);
    }

    $arrayJSON = array();
    $arrayJSON['stores'] = getArrayObjsStores($results, $controllerRest);
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
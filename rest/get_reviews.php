<?php

    require '../header_rest.php';
    $controllerRest = new ControllerRest();
    $controllerUser = new ControllerUser();


    $store_id = 0;
    if(!empty($_GET['store_id']) )
        $store_id = $_GET['store_id'];

    $min = 0;
    if(!empty($_GET['min']) )
        $min = $_GET['min'];

    $max = 0;
    if(!empty($_GET['max']) )
        $max = $_GET['max'];

    $api_key = "";
    if(!empty($_GET['api_key']) )
        $api_key = $_GET['api_key'];

    if( empty($_GET['store_id']) || empty($_GET['api_key'])) {
        $arr = array();
        $arr['status'] = formatStatus('3', 'Invalid Access.');
        echo json_encode($arr);
    }

    $resultReviews = $controllerRest->getResultReviewsMinMax($min, $max, $store_id);
    $no_of_rows = $resultReviews->rowCount();
    $total_row_count = $controllerRest->getResultReviewsTotalCount($store_id);    

    $arrayJSON = array();
    $arrayJSON['min'] = $min;
    $arrayJSON['max'] = $max;
    $arrayJSON['total_row_count'] = $total_row_count;
    $arrayJSON['reviews'] = getArrayObjs($resultReviews);
    echo json_encode($arrayJSON);

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

    function formatStatus($status_code, $status_text) {
        $arr = array( 'status_code' => ''.$status_code.'', 'status_text' => ''.$status_text.'' );
        return $arr;
    }

?>
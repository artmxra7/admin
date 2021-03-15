<?php

class Extras
{
 
    function __construct()  { }
 
    function __destruct() { }
 
    function encryptQuery1($keySalt, $qry, $val, $landing_page){
         //making query string
        $qryStr = "$qry=".$val; 
        $query = $this->customEncode($qryStr);
        $link = "$landing_page?".$query;
        return $link;
    }

    function decryptQuery1($keySalt, $qryStr){
        //this line of code decrypt the query string
        $queryString = $this->customDecode($qryStr);
        $val = explode('=', $queryString);
        $count = count($val);
        if($count == 2)
            return $val[1];

        return null;
    }

    function encryptQuery2($keySalt, $qry1, $val1, $qry2, $val2, $landing_page){
        //making query string
        $qryStr = "$qry1=".$val1."&$qry2=".$val2;  
        $query = $this->customEncode($qryStr);
        $link = "$landing_page?".$query;
        return $link;
    }

    function decryptQuery2($keySalt, $qryStr){
        //this line of code decrypt the query string
        $queryString = $this->customDecode($qryStr);
        $amp = explode('&', $queryString);
        $ampCount = count($amp);
        if($ampCount == 2) {
            $equal1 = explode('=', $amp[0]);
            $equal2 = explode('=', $amp[1]);
            $equalCount1 = count($equal1);
            $equalCount2 = count($equal2);
            if($equalCount1 == 2 && $equalCount2 == 2) {
                $val = array();
                $val[0] = $equal1[1];
                $val[1] = $equal2[1];

                return $val;
            }
        }
        return null;
    }

    function removeHttp($str) {
        $prefix = 'http://';
        if (substr($str, 0, strlen($prefix)) == $prefix) {
            $str = substr($str, strlen($prefix));
        }
        $prefix = 'https://';
        if (substr($str, 0, strlen($prefix)) == $prefix) {
            $str = substr($str, strlen($prefix));
        }
        return $str;
    }

    function uploadFile($key, $prefix) {

        $desired_dir = Constants::IMAGE_UPLOAD_DIR;
        $errors= array();
        $file_name = $_FILES[$key]['name'];
        $file_size = $_FILES[$key]['size'];
        $file_tmp = $_FILES[$key]['tmp_name'];
        $file_type= $_FILES[$key]['type'];
        // if($file_size > 2097152){
        //     $errors[]='File size must be less than 2 MB';
        // }    

        $timestamp =  uniqid();
        $temp = explode(".", $_FILES[$key]["name"]);
        $extension = end($temp);

        $extension = "";
        $image_info = getimagesize($_FILES[$key]["tmp_name"]);
        switch ($image_info['mime']) {
            case 'image/gif':
                $extension = 'gif';
                break;
            case 'image/jpeg':
                $extension = 'jpg';
                break;
            case 'image/png':
                $extension = 'png';
                break;
            default:
                return "";
                break;
        }

        $new_file_name = $desired_dir."/".$prefix.$timestamp.".".$extension;
        $new_file_name_dir = "./".$new_file_name;
        if(empty($errors)==true) {
            if(is_dir($desired_dir)==false) {
                // Create directory if it does not exist
                mkdir("$desired_dir", 0700);        
            }
            if(is_dir($file_name)==false) {
                // rename the file if another one exist
                move_uploaded_file($file_tmp, $new_file_name_dir);
            }
            else {                                   
                $new_dir = $new_file_name.time();
                rename($file_tmp, $new_dir) ;               
            }
            return Constants::ROOT_URL.$new_file_name;
        }
        else {
            return "";
        }
    }

    function customEncode($string){
        $base_encryption_array = array(
        '0'=>'B76',
        '1'=>'D75',
        '2'=>'F74',
        '3'=>'H73',
        '4'=>'J72',
        '5'=>'L71',
        '6'=>'N70',
        '7'=>'P69',
        '8'=>'R68',
        '9'=>'T67',
        'a'=>'V66',
        'b'=>'X65',
        'c'=>'Z64',
        'd'=>'A63',
        'e'=>'D62',
        'f'=>'E61',
        'g'=>'H60',
        'h'=>'I59',
        'i'=>'J58',
        'j'=>'G57',
        'k'=>'F56',
        'l'=>'C55',
        'm'=>'B54',
        'n'=>'Y53',
        'o'=>'W52',
        'p'=>'U51',
        'q'=>'S50',
        'r'=>'Q49',
        's'=>'O48',
        't'=>'M47',
        'u'=>'K46',
        'v'=>'I45',
        'w'=>'G44',
        'x'=>'E43',
        'y'=>'C42',
        'z'=>'A41',
        '&'=>'Q41',
        '='=>'X40',
        '_'=>'C39'
        );

        $string = (string)$string;
        $length = strlen($string);
        $hash = '';
            for ($i=0; $i<$length; $i++) {
                if(isset($string[$i])){
                    $hash .= $base_encryption_array[$string[$i]];
                }
            }
        return $hash;
    }


    function customDecode($hash){
        $base_encryption_array = array(
        '0'=>'B76',
        '1'=>'D75',
        '2'=>'F74',
        '3'=>'H73',
        '4'=>'J72',
        '5'=>'L71',
        '6'=>'N70',
        '7'=>'P69',
        '8'=>'R68',
        '9'=>'T67',
        'a'=>'V66',
        'b'=>'X65',
        'c'=>'Z64',
        'd'=>'A63',
        'e'=>'D62',
        'f'=>'E61',
        'g'=>'H60',
        'h'=>'I59',
        'i'=>'J58',
        'j'=>'G57',
        'k'=>'F56',
        'l'=>'C55',
        'm'=>'B54',
        'n'=>'Y53',
        'o'=>'W52',
        'p'=>'U51',
        'q'=>'S50',
        'r'=>'Q49',
        's'=>'O48',
        't'=>'M47',
        'u'=>'K46',
        'v'=>'I45',
        'w'=>'G44',
        'x'=>'E43',
        'y'=>'C42',
        'z'=>'A41',
        '&'=>'Q41',
        '='=>'X40',
        '_'=>'C39'
        );

        /* this makes keys as values and values as keys */
        $base_encryption_array = array_flip($base_encryption_array);

        $hash = (string)$hash;
        $length = strlen($hash);
        $string = '';
            for ($i=0; $i<$length; $i=$i+3) {
                if(isset($hash[$i]) && isset($hash[$i+1]) && isset($hash[$i+2]) && isset($base_encryption_array[$hash[$i].$hash[$i+1].$hash[$i+2]])){
                    $string .= $base_encryption_array[$hash[$i].$hash[$i+1].$hash[$i+2]];
                }
            }
        return $string;
    }

    function is_base64($s) {
          return (bool) preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
    }

    function encryptParams($keySalt, $objs, $landing_page){
        $count = count($objs);
        $qryStr = "";
        for($x = 0; $x < $count; $x++) {
            $arrObj = $objs[$x];
            $qryStr .= $arrObj[0]."=".$arrObj[1];
            if($x < $count - 1)
                $qryStr .= "&";
        }
        $query = $this->customEncode($qryStr);
        $link = "$landing_page?".$query;
        return $link;
    }


    function decryptParams($keySalt, $qryStr){
        //this line of code decrypt the query string
        $queryString = $this->customDecode($qryStr);
        $amp = explode('&', $queryString);
        $count = count($amp);
        $objs = array();

        for($x = 0; $x < $count; $x++) {
            $params = explode('=', $amp[$x]);
            $equalCount1 = count($params);
            if($equalCount1 == 2) {
                $objs[$params[0]] = $params[1];
            }
        }
        return $objs;
    }

    function toUL(array $array, $indent) {
        $html = '' . PHP_EOL;
        $indent++;
        foreach ($array as $value) {
          $html .= '<option value=' . $value['category_id']. '>' . str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $indent) . $value['category'];
          if (!empty($value['children'])) {
                $html .= $this->toUL($value['children'], $indent);
          }
          $html .= '</option>' . PHP_EOL;
        }
        $html .= '' . PHP_EOL;
      return $html;
    }

    function toUL1(array $array, $indent, $pid, $category_id) {
        $html = '' . PHP_EOL;
        $indent++;
        foreach ($array as $value) {
            $selected = "";
            if($value['category_id'] == $pid)
              $selected = "selected";

            $disabled = "";
            if($value['category_id'] == $category_id)
              $disabled = "disabled";

            $html .= '<option value=' . $value['category_id']. ' '.$selected. ' '.$disabled . '>' . str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $indent) . $value['category'];
            if (!empty($value['children'])) {
                $html .= $this->toUL1($value['children'], $indent, $pid, $category_id);
            }
            $html .= '</option>' . PHP_EOL;
        }
        $html .= '' . PHP_EOL;
        return $html;
    }

}
 
?>
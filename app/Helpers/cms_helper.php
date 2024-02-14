<?php

if (!function_exists('checkActiveMenu')) {
    function checkActiveMenu($crnt_controller, $controller_name, $crnt_function, $function_name = "index")
    {

        if (trim($crnt_function) == "") {
            $crnt_function = "index";
        }

        if (strtolower($function_name) == "") {
            $function_name = "index";
        }

        if (in_array(strtolower($crnt_function), array('add', 'edit', 'delete')) && strtolower($function_name) != "recycle") {
            $function_name = "index";
            $crnt_function = "index";
        }

        if (trim(strtolower($crnt_controller)) == trim(strtolower($controller_name)) && strtolower($crnt_function) == strtolower($function_name)) {
            return "active";
        } else {
            return "";
        }
    } //end checkActiveMenu function
} //end check checkActiveMenu function exist

//encrypt_decrypt function is used for encrypt & decrypt data
if (!function_exists('encrypt_decrypt')) {
    function encrypt_decrypt($action, $string, $secret_key = 'D3B361F1F159649CCE369D4B1351Ahd269P05BF9B650F409DAD9E246D')
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_iv = '159649CCE369D4djkvun51Ahd2694084C7';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } elseif ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    } //end encrypt_decrypt function
} //end if not exist

//encrypt_decrypt function is used for encrypt & decrypt data
if (!function_exists('client_encypt_decrypt')) {
    function client_encrypt_decrypt($action = "decrypt", $string = "", $secret_key = "")
    {
        $output = '';

        if (trim($string) != "") {

            $iv = 'e9f8db49806ee2823d03d5f1fc40b180'; //32 hex key
            $key = '4ae66fe0af898766d52147883331e79348c3d4957d8ece1f947be3072afe7363'; //64 hex key
            if (trim($secret_key) != "") {
                $key = hash('sha256', $secret_key);
            }

            $ivBytes = hex2bin($iv);
            $keyBytes = hex2bin($key);
            $ctBytes = base64_decode($string);

            if ($action == "encrypt") {
                $output = openssl_encrypt($string, 'aes-256-cbc', $keyBytes, 0, $ivBytes);
            } else {
                $output = openssl_decrypt($ctBytes, "aes-256-cbc", $keyBytes, OPENSSL_RAW_DATA, $ivBytes);
            }
        }

        return $output;
    } //end client_encypt_decrypt function
} //end if not exist


if (!function_exists('mysql_escape_mimic')) {
    function mysql_escape_mimic($inp)
    {
        if (is_array($inp)) {
            return array_map(__METHOD__, $inp);
        }

        if (!empty($inp) && is_string($inp)) {
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
        }

        return $inp;
    } //end escape function
} //end

if (!function_exists('checkaddslashes')) {
    function checkaddslashes($str)
    {
        if (strpos(str_replace("\'", "", " $str"), "'") != false) {
            return addslashes($str);
        } else {
            return $str;
        }
    }
} //end

if (!function_exists('stripslashes2')) {
    function stripslashes2($string)
    {
        $string = str_replace("\\\"", "\"", $string);
        $string = str_replace("\\'", "'", $string);
        $string = str_replace("\\\\", "\\", $string);
        return $string;
    } //If you want to deal with slashes in double-byte encodings

    //Mysql Injection Function
} //end

if (!function_exists('cleanQuery')) {
    function cleanQuery($string)
    {
        if (get_magic_quotes_gpc()) {  // prevents duplicate backslashes
            $string = stripslashes2($string);
        }
        if (phpversion() >= '4.3.0') {
            $string = mysql_escape_mimic($string);
        } else {
            $string = mysql_escape_mimic($string);
        }
        return $string;
    }
} //end

if (!function_exists('seoUrl')) {
    function seoUrl($string)
    {
        //Lower case everything
        $string = strtolower($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    } //end seoUrl function
} //end seoUrl function exists

if (!function_exists('randomUniqueId')) {
    function randomUniqueId($length = 5)
    {
        $random = "";
        $random = srand((float)microtime() * 1000000);
        $data = time();
        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }
        return $random;
    } //end randomUniqueId
}

if (!function_exists('getHash')) {
    function getHash()
    {
        $_SESSION['request_token'] = md5(uniqid() . time());
        return $_SESSION['request_token'];
    } //end getHash function
} //end check getHash function exist

if (!function_exists('passwordGenerator')) {
    function passwordGenerator($PassSpecial = "")
    {

        $special     = "";
        $length      = 6;
        $alpha          = generateRandomString(2, "abcdefghijkmnpqrstuvwxyz");
        $alpha_upper = generateRandomString(2, strtoupper($alpha));
        $numeric      = generateRandomString(2, "23456789");
        if (trim($PassSpecial) != "") {
            $special = generateRandomString(1, $PassSpecial);
        }

        $chars          = "";
        $chars = $alpha . $alpha_upper . $numeric . $special;

        $pw = '';
        $pw = str_shuffle($chars);

        return $pw;
    } //end passwordGenerator function
} //end check passwordGenerator function exist

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 4, $characters = '0123456789abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ')
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    } //end generateRandomString
} //end check generateRandomString

if (!function_exists('toTimestamp')) {
    function toTimestamp($milliseconds = 0)
    {
        //Date time statmp with milliseconds
        $milliseconds = ($milliseconds == 0) ? date('U') : $milliseconds;
        $seconds = $milliseconds / 1000;
        $remainder = round($seconds - ($seconds >> 0), 3) * 1000;

        return date('YmdHis') . $remainder;
    } //end toTimestamp function
} //end check toTimestamp

if (!function_exists('date_convert')) {
    function date_convert($date, $format = "Y-m-d")
    {
        if (trim($date) != "" && $date != null) {
            return date($format, strtotime($date));
        } else {
            return null;
        }
    }
} //end check date_convert function

if (!function_exists('get_date')) {
    function get_date($originalDate = "", $format = "d-m-Y")
    {
        $newDate = "";
        if (trim($originalDate) != "" && trim($originalDate) != null && $originalDate != "0000-00-00" && $originalDate != "0000-00-00 00:00:00") {
            $newDate = date($format, strtotime($originalDate));
        }
        return $newDate;
    }
} //end check get_date

if (!function_exists('escape')) {
    function escape($data)
    {
        // Fix &entity\n;
        $data = trim($data);
        $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = @html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do {
            // Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);

        // we are done...
        //return $data;

        if (get_magic_quotes_gpc()) {
            $clean = mysql_escape_mimic(stripslashes2($data));
        } else {
            $clean = mysql_escape_mimic($data);
        }

        //$clean1 = escapeshellcmd($clean);

        return htmlspecialchars($clean, ENT_QUOTES, 'UTF-8');
    } //escape fucntion
} //end check escape function exist

if (!function_exists('getChildNode')) {
    function getChildNode($list = array(), $parent_id = null, $parent_id_name = "parent_id", $id_name = "id")
    {
        $result = "";
        if ($parent_id != null) {
            foreach ($list as $cat) {
                if ($cat[$parent_id_name] == $parent_id) {
                    $current_id = $cat[$id_name];
                    $result .= "," . $current_id;
                    $result .= getChildNode($list, $current_id, $parent_id_name, $id_name);
                } //end check parent_id is equal
            } //end foreach
        } //end check parent_id is not null
        return $result;
    } //end getChildNode function

} //end check exist getChildNode

if (!function_exists('checkLanguage')) {

    function checkLanguage($lang = "")
    {
        $ci = get_instance();

        if ($ci->session->has_userdata('site_lang') == true && $ci->session->userdata('site_lang') == strtolower($lang)) {
            return true;
        } else {
            return false;
        }
    } //end checkLanguage function

} //end check checkLanguage function exist



/**
 * function getDateTimeDiff
 *
 * @param undefined $currentDateTimeObj
 * @param undefined $NewDateTime
 *
 * @return $dateConvertObj or empty strig
 *
 *  echo $dateConvertObj->days.' days total<br>                       ';
 *  echo $dateConvertObj->y.' years<br>                       ';
 *  echo $dateConvertObj->m.' months<br>                       ';
 *  echo $dateConvertObj->d.' days<br>                       ';
 *  echo $dateConvertObj->h.' hours<br>                       ';
 *  echo $dateConvertObj->i.' minutes<br>                       ';
 *  echo $dateConvertObj->s.' seconds<br>                       ';
 *
 */

if (!function_exists('diff')) {

    function diff($date1, $date2, $format = false)
    {
        $diff = date_diff(date_create($date1), date_create($date2));
        if ($format) {
            return $diff->format($format);
        }

        return array(
            'y' => $diff->y,
            'm' => $diff->m,
            'd' => $diff->d,
            'h' => $diff->h,
            'i' => $diff->i,
            's' => $diff->s
        );
    }
} //end check diff function exist

if (!function_exists('getFileInfo')) {
    function getFileInfo($filename = "")
    {
        if (trim($filename) != "") {
            $file = basename($filename);
            $file = preg_replace('/\s+/', '', $file); //remove space between words
            $filename_array = explode('.', $file);
            $ext = end($filename_array);
            $file = substr($file, 0, - (strlen($ext) + 1));
            return array('filename' => $file, 'extension' => $ext);
        }
        return array('filename' => '', 'extension' => '');
    }
} //end getFileInfo

if (!function_exists('getModifierName')) {
    function getModifierName($added_name = "", $edited_name = "")
    {
        if (trim($edited_name) != "" && $edited_name != null) {
            return ucwords($edited_name);
        }
        return ucwords($added_name);
    }
} //end getModifierName

if (!function_exists('getModifiedDate')) {
    function getModifiedDate($added_date = "", $edited_date = "")
    {
        $edited_date = get_date(html_escape($edited_date));

        if ($edited_date != "") {
            return $edited_date;
        }
        return get_date(html_escape($added_date));
    }
} //end getModifiedDate

if (!function_exists('putVisitorCountImg')) {
    function putVisitorCountImg($count_visit = 0, $color = "black", $dir = 'assets/img/counter/')
    {

        $number = $count_visit; // Storing the counter value in another variable
        $divisor = 10; // setting the divisor value to 10
        $digitarray = array(); // creating an array

        do {
            $digit = ($number % $divisor); // looping through the till all digits are taken
            $number = ($number / $divisor); // getting the digits from right side
            array_push($digitarray, $digit); // storing them in the array
        } while ($number >= 1); // condition of do loop

        // array is to be reversed as digits are in reverse order
        $digitarray = array_reverse($digitarray);

        while (list($key, $val) = each($digitarray)) { // looping through the array
            echo img(array('src' => base_url($dir . $color . '/' . $val . '.gif'), 'alt' => $val));
        } // end of the loop

    } //end function putVisitorCountImg
} //end exist putVisitorCountImg

if (!function_exists('getHashKey')) {
    function getHashKey()
    {
        $key = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
        return $key;
    } //end getHash function
} //end check getHashKey function exist

if (!function_exists('is_home')) {
    function is_home()
    {
        $CI = &get_instance();
        return (!$CI->uri->segment(1)) ? true : false;
    }
}

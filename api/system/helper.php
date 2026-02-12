<?php

defined('INDEX') or error('Access denied',403);
function error($m, $code=500): void {
    header("Content-type: application/json; charset=utf-8");
    header($_SERVER['SERVER_PROTOCOL'] . " $code error", true, $code);

    if (is_array($m)) {
        die(json_encode($m, JSON_UNESCAPED_UNICODE));
    } else {
        die(json_encode(['error' => $m], JSON_UNESCAPED_UNICODE));
    }
}

function res($m = [], $f =  JSON_UNESCAPED_UNICODE, $null = false): void
{
    if (!headers_sent()) {
        header('Content-Type: application/json;');
    }
    if ($null) {
        foreach ($m as $i => $v) {
            $m[$i] = array_filter($v, function($value) {
                return !is_null($value);
            });
        }
    }
    $jsonData = json_encode($m, $f);
    if ($jsonData === false) {
        $error = [
            'status' => 'error',
            'message' => 'Failed to encode JSON response',
            'error' => json_last_error_msg()
        ];
        $jsonData = json_encode($error, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        header('Content-Length: ' . strlen($jsonData)); // Set content-length for error response
        die($jsonData);  // Return error response and terminate script
    }
    try{ob_start('ob_gzhandler'); }catch (Exception $e){ }
    die($jsonData);
}
function getFixedPath($dir, $file = 'index.php'): string
{
    if ($dir === false) {
        return _API_DIR_ . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . $file;
    }

    return _API_DIR_ . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $file;
}
function Excel(){
    require_once _API_DIR_ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'SimpleXLSXGen.php';
    return new SimpleXLSXGen();
}
function openExcel($file){
    require_once _API_DIR_ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'SimpleXLSX.php';
    $xlsx = SimpleXLSX::parse($file);
    return $xlsx;
}
function raw(){
    return _API_DIR_ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'SimpleXLSXGen.php';
}
function boolInt($v): int
{
    return ($v === true || $v === 1 || $v === "1") ? 1 : 0;
}
function rawData($data){
    require_once _API_DIR_ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'SimpleXLSXGen.php';
    return SimpleXLSXGen::rawArray($data);
}
function loadRoute($dir, $file = 'index.php') {

    $path = getFixedPath($dir, $file);
    if (!file_exists($path)) {
        return false;
    }

    return require_once $path;
};
function ok(){die("");};
function logs($table,$data){
    global $db;
    $db->insert('logs',["table"=>$table,"data"=>json_encode($data)]);
}
function user(){
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    global $db;
    $token =  @$_COOKIE['sessions'];

    if(!$token) return false;
    $user_id = $db->get('sessions','user_id',['token'=>$token]);

    if($user_id){
        $user = $db->get('users','*',['id'=>$user_id]);
        unset($user['pass']);
        return $user;
    }

    return false;
}
function send_email($to, $body, $subject = 'sapCard', $from = "sapcard@nikora.app") {
    $to = filter_var($to, FILTER_VALIDATE_EMAIL);
    if (!$to)  return false;
    $subject = trim(strip_tags($subject));
    $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
    $headers = [];
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-Type: text/html; charset=UTF-8";
    $headers[] = "From: =?UTF-8?B?" . base64_encode("SapCard") . "?= <{$from}>";
    $headers[] = "X-Mailer: PHP/" . phpversion();
    $headers[] = "Date: " . date('r');
    // თუ გინდა plain text ვერსიაც (რეკომენდებულია)
    // $headers[] = "Content-Type: text/plain; charset=UTF-8";
    // დამატებითი პარამეტრები -sendmail-ისთვის (Linux სერვერებზე ძალიან სასარგებლოა)
    $additional_parameters = "-f{$from}"; // Return-Path და Envelope-From

    // წერილის გაგზავნა
    $result = mail(
        $to,
        $subject,
        $body,
        implode("\r\n", $headers),
        $additional_parameters
    );

    return $result; // true ან false
}
function fetchPaginatedData($db, $tableName, $fields, $p) {
    $pageSize = $p['params']['pageSize'] ?? 12;
    $page     = $p['params']['page'] ?? 1;
    $search   = $p['params']['search'] ?? '';
    $equals   = $p['params']['equals'] ?? [];
    $filter   = $p['params']['filter'] ?? [];
    $sortKey  = $p['params']['sortKey'] ?? null;
    $sortDesc = $p['params']['sortDesc'] ?? false;
    $params = [];
    $colls = [];
    foreach ($fields as $key => $field) {
        if(is_int($key)) {
            if($search)  $params['OR'][] = "`$field` LIKE '%$search%'";
            if(isset($filter[$field]))$params['AND'][] = "`$field` LIKE '%$filter[$field]%'";
            if(isset($equals[$field]))$params['AND'][] = "`$field` = '$equals[$field]'";
            $colls[] = $field;
            if($sortKey==$field) $params['ORDER'] = " `$field`".($sortDesc ? ' DESC' : '');
        }
        else {
            if ($search)  $params['OR'][]=("$field LIKE '%$search%'");
            if(isset($filter[$key])) $params['AND'][] = "$field LIKE '%$filter[$key]%'";
            if(isset($equals[$key])) $params['AND'][] = "$field = '$equals[$key]'";
            $colls[$key]=$db::raw($field);
            if($sortKey==$key) $params['ORDER'] = " `$key`".($sortDesc ? ' DESC' : '');
        }
    }

    if($params['OR']) {
        $params['AND'][] = "(".implode(' OR ', $params['OR']) .")";
        unset($params['OR']);
    }
    $paramsString = "";
    if($params['AND']){
        $paramsString = " WHERE ";
        $paramsString.= implode(' AND ', $params['AND']);
    }
    $count = $db->count($tableName,  $db::raw($paramsString));
    if($params['ORDER']) $paramsString.= " ORDER BY ". $params['ORDER'];
    if ($pageSize !== 'total') {
        $offset = ($page - 1) * $pageSize;
        $paramsString.= " LIMIT $pageSize OFFSET $offset";
    }
    //die($paramsString);


    $items = $db->select($tableName, $colls , $db::raw($paramsString));
    //die($db->last());

    return [
        "items" => $items,
        "totalCount" => $count,
    ];
}

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
    if (!is_string($token) || !preg_match('/^[a-f0-9]{128}$/', $token)) return false;
    $user_id = $db->get('sessions','user_id',['token'=>$token]);

    if($user_id){
        $user = $db->get('users','*',['id'=>$user_id]);
        if (!$user) return false;
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
    $page = (int)($p['params']['page'] ?? 1);
    $search = (string)($p['params']['search'] ?? '');
    $equals = $p['params']['equals'] ?? [];
    $filter = $p['params']['filter'] ?? [];
    $sortKey = $p['params']['sortKey'] ?? null;
    $sortDescRaw = $p['params']['sortDesc'] ?? false;
    $sortDesc = ($sortDescRaw === true || $sortDescRaw === 1 || $sortDescRaw === '1' || $sortDescRaw === 'true');

    if ($page < 1) {
        $page = 1;
    }

    $colls = [];
    $allowedSort = [];
    $orConditions = [];
    $andConditions = [];
    $map = [];
    $paramIndex = 0;

    foreach ($fields as $key => $field) {
        if (is_int($key)) {
            $column = $field;
            $colls[] = $column;
            $allowedSort[] = $column;

            if ($search !== '') {
                $k = ':search_' . $paramIndex++;
                $orConditions[] = "`{$column}` LIKE {$k}";
                $map[$k] = '%' . $search . '%';
            }
            if (isset($filter[$column])) {
                $k = ':filter_' . $paramIndex++;
                $andConditions[] = "`{$column}` LIKE {$k}";
                $map[$k] = '%' . $filter[$column] . '%';
            }
            if (isset($equals[$column])) {
                $k = ':equals_' . $paramIndex++;
                $andConditions[] = "`{$column}` = {$k}";
                $map[$k] = (string)$equals[$column];
            }
        } else {
            $alias = $key;
            $expression = $field;
            $colls[$alias] = $db::raw($expression);
            $allowedSort[] = $alias;

            if ($search !== '') {
                $k = ':search_' . $paramIndex++;
                $orConditions[] = "({$expression}) LIKE {$k}";
                $map[$k] = '%' . $search . '%';
            }
            if (isset($filter[$alias])) {
                $k = ':filter_' . $paramIndex++;
                $andConditions[] = "({$expression}) LIKE {$k}";
                $map[$k] = '%' . $filter[$alias] . '%';
            }
            if (isset($equals[$alias])) {
                $k = ':equals_' . $paramIndex++;
                $andConditions[] = "({$expression}) = {$k}";
                $map[$k] = (string)$equals[$alias];
            }
        }
    }

    if (!empty($orConditions)) {
        $andConditions[] = '(' . implode(' OR ', $orConditions) . ')';
    }

    $paramsString = '';
    if (!empty($andConditions)) {
        $paramsString = ' WHERE ' . implode(' AND ', $andConditions);
    }

    $count = $db->count($tableName, $db::raw($paramsString, $map));

    if ($sortKey && in_array($sortKey, $allowedSort, true)) {
        $safeSort = preg_replace('/[^a-zA-Z0-9_]/', '', (string)$sortKey);
        if ($safeSort !== '') {
            $paramsString .= " ORDER BY `{$safeSort}`" . ($sortDesc ? ' DESC' : '');
        }
    }

    if ($pageSize !== 'total') {
        $pageSize = max(1, (int)$pageSize);
        $offset = ($page - 1) * $pageSize;
        $paramsString .= " LIMIT {$pageSize} OFFSET {$offset}";
    }

    $items = $db->select($tableName, $colls, $db::raw($paramsString, $map));

    return [
        "items" => $items,
        "totalCount" => $count,
    ];
}

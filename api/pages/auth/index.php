<?php
defined('INDEX') or exit('No direct access allowed');

return function () {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    global $db ,$p;
    $key = "oop";
    $pass = md5($key.$p['pass']);
    $id = $db->get("users","id",['user'=>$p['user'],'pass'=>$pass]);
    $token =  bin2hex(random_bytes(64));
    if($id){
        $db->insert("sessions",['token'=>$token,  "ip"=>$_SERVER['REMOTE_ADDR'],'user_id'=>$id]);
        setcookie('sessions', $token, time() + (10 * 365 * 24 * 60 * 60), '/');
        ok();
    }else{
        error(["message"=>"no access", 'pass'=>$pass]);
    }
};

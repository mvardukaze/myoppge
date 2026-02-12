<?php
defined('INDEX') or exit('No direct access allowed');

return function () {
    global  $router;
    $router->get('/', function () {
        global $db,$user;
        $res = $db->get("about","code", ["user_id"=>$user['id'], "ORDER"=>["id"=>"DESC"]]);
        res([
            "code"=>$res
        ]);
    });
    $router->post('/', function () {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        global $db,$p,$user;

        $data = [
            "code"=>$p["code"],
            "user_id"=>$user['id']
        ];
        $db->insert('about',$data);

        res([]);
    });

};

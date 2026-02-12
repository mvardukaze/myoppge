<?php
defined('INDEX') or exit('No direct access allowed');

return function () {
    global  $router;
    $router->get('/', function () {
        global $db,$user;
        $res = $db->get("main","code", ["user_id"=>$user['id'], "ORDER"=>["id"=>"DESC"]]);
        res([
            "code"=>$res
        ]);
    });
    $router->post('/', function () {
        global $db,$p,$user;

        $data = [
            "code"=>$p["code"],
            "user_id"=>$user['id']
        ];
        $db->insert('main',$data);

        res([]);
    });

};

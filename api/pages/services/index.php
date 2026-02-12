<?php
defined('INDEX') or exit('No direct access allowed');

return function () {
    global  $router;
    $router->get('/', function () {
        global $db,$user;
        $res = $db->select("services","*", ["user_id"=>$user['id']]);
        res([
            "items"=>$res
        ]);
    });
    $router->post('/', function () {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        global $db,$p,$user;

        $data = [
            "icon"=>$p["icon"],
            "title"=>$p["title"],
            "short"=>$p["short"],
            "detail"=>$p["detail"],
            "user_id"=>$user['id']
        ];
        if($p['id']>0){
            $db->update('services',$data,["id"=>$p['id']]);
        }else{
            $db->insert('services',$data);
        }


        res([]);
    });

};

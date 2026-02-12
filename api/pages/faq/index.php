<?php
defined('INDEX') or exit('No direct access allowed');

return function () {
    global  $router;
    $router->get('/', function () {
        global $db,$user;
        $res = $db->select("faq","*", ["user_id"=>$user['id']]);
        res([
            "items"=>$res
        ]);
    });
    $router->post('/', function () {
        global $db,$p,$user;

        $data = [

            "title"=>$p["title"],

            "active"=>$p["active"],
            "detail"=>$p["detail"],
            "user_id"=>$user['id']
        ];
        if($p['id']>0){
            $db->update('faq',$data,["id"=>$p['id']]);
        }else{
            $db->insert('faq',$data);
        }


        ok();
    });

};

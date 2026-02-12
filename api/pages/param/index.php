<?php
defined('INDEX') or exit('No direct access allowed');

return function () {
    global $router;
    $router->post('/', function () {
        global  $user, $p,$db;
        $data = [
            "logo" => $p['logo'],
            "name" => $p['name'],
            "phone" => $p['phone'],
            "email" => $p['email'],
            "address" => $p['address'],
            "fb" => $p['fb'],
            "instagram" => $p['instagram'],
            "backgroundColor" => $p['backgroundColor'],
            "textColor" => $p['textColor'],
            "headerColor" => $p['headerColor'],
            "footerColor" => $p['footerColor'],
            "primaryColor" => $p['primaryColor'],
            "buttonColor" => $p['buttonColor'],
            "user_id" => $user['id']
        ];
        $db->insert('options',$data);
        ok();

    });
    $router->get('/', function () {
        global  $user,$db;
        $options = $db->get('params','*',['user_id'=> $user['id'], "ORDER"=>["id"=>"DESC"]]);
        res([
            "status"=>"ok",
            "user"=>$user,
            "options"=>$options
        ]);
    });


};

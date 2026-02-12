<?php
defined('INDEX') or exit('No direct access allowed');
date_default_timezone_set("Asia/Tbilisi");
$router = new Router();
global $user;
$user = user();

if($user){
    $router->get('/init', function(){
        global $db,$user;

        $params = $db->get('params','*',['user_id'=> $user['id'], "ORDER"=>["id"=>"DESC"]]);
        res([
            "status"=>"ok",
            "user"=>$user,
            "params"=>$params
        ]);
    });
    $router->mount('/main', loadRoute('main'));
    $router->mount('/param', loadRoute('param'));
    $router->mount('/projects', loadRoute('projects'));
    $router->mount('/services', loadRoute('services'));
    $router->mount('/upload', loadRoute('upload'));
    $router->mount('/faq', loadRoute('faq'));
    $router->mount('/about', loadRoute('about'));
}else{
    $router->post('/auth', loadRoute('auth'));
}
$router->run();
error(['404']);

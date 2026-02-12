<?php
defined('INDEX') or error('Access denied',403);
require_once "Db_class.php";

global $db, $options, $services, $projects,$faq;

$user_id = 1;
$db = new Db_class\Db_classs([
    'database_type' => 'mysql',
    'database_name' => 'oopge_main',
    'server' => 'localhost',
    'username' => 'oopge_main',
    'password' => 'KCweHO5Cwu-l2584',
    'charset' => 'utf8mb4'
]);
$params = $db->get('params',['logo','name','phone','email','address','fb','instagram','user_id','backgroundColor','textColor','headerColor','footerColor','primaryColor','buttonColor','enable'],['user_id'=> $user_id, "ORDER"=>["id"=>"DESC"]]);
$about = $db->get('about','code',['user_id'=> $user_id, "ORDER"=>["id"=>"DESC"]]);
$home = $db->get('main','code',['user_id'=> $user_id, "ORDER"=>["id"=>"DESC"]]);
$faq = $db->select('faq',['title','detail'],['user_id'=> $user_id, "ORDER"=>["id"=>"DESC"]]);
$services = $db->select('services','*',['user_id'=> $user_id, "ORDER"=>["id"=>"DESC"]]);
$projects = $db->select('projects','*',['user_id'=> $user_id, "ORDER"=>["id"=>"DESC"]]);

foreach($projects as &$p){
    $p['photos'] = $db->select('project_photos','path',['project_id'=> $p['id'], "ORDER"=>["id"=>"DESC"]]);
}


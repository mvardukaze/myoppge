<?php
defined('INDEX') or exit('No direct access allowed');

return function () {
   global  $router;

   $router->get('/', function () {
        global $db,$user;
        $res = $db->select("projects","*", ["user_id"=>$user['id']]);

        foreach($res as &$r){
           $r['photos']=$db->select("project_photos","*",["project_id"=>$r['id'], "ORDER"=>'order']);

        }
        res([
            "items"=>$res
        ]);
   });
    $router->post('/', function () {

        global $db,$p,$user;
        $id = $p['id'];
        $data = [
            "title"=>$p["title"],
            "subtitle"=>$p["subtitle"],
            "status"=>$p["status"],
            "desc"=>$p["desc"],
            "location"=>$p["location"],
            "date"=>$p["date"],
            "active"=>$p["active"],
            "user_id"=>$user['id']
        ];
        if($p['id']>0){
            $db->update('projects',$data,["id"=>$id]);
        }else{
            $db->insert('projects',$data);
            $id = $db->id();
        }
        $db->delete("project_photos",["project_id"=>$id]);
        foreach($p['photos'] as $img){
            $dd = [
                "path"=>$img["path"] ?? $img["url"],
                "order"=>$img["order"],
                "name"=>$img["name"],
                "project_id"=>$id,
            ];
            $db->insert("project_photos",$dd);
        }
        res([]);
    });

};

<?php
defined('INDEX') or exit('No direct access allowed');

return function () {
    global  $router;
    $router->get('/', function () {

    });
    $router->post('/', function () {
        global $user;
        $page = $user['page'];

        $uploadDir = _API_DIR_ . "/../pages/$page/uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }
        $uploadDir = realPath($uploadDir);
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $safeName = uniqid("photo_") . '.' . strtolower($ext);

        $relativePath = "/uploads/$safeName";
        $fullPath = "$uploadDir/$safeName";

        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $fullPath)) {
            fail('ფაილის შენახვა ვერ მოხერხდა');       }


        res([
            "url"=>$relativePath,
            "name"=>$safeName
        ]);
    });

};

<?php
defined('INDEX') or exit('No direct access allowed');

return function () {
    global  $router;
    $router->get('/', function () {

    });
    $router->post('/', function () {
        global $user;

        if (!isset($_FILES['photo'])) {
            error(['error' => 'ფაილი ვერ მოიძებნა'], 400);
        }

        $file = $_FILES['photo'];
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            error(['error' => 'ფაილის ატვირთვა ვერ მოხერხდა'], 400);
        }

        $maxSize = 5 * 1024 * 1024;
        if (($file['size'] ?? 0) <= 0 || $file['size'] > $maxSize) {
            error(['error' => 'ფაილის ზომა არასწორია'], 400);
        }

        $allowedMime = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
        ];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo === false) {
            error(['error' => 'ფაილის ტიპის შემოწმება ვერ მოხერხდა'], 500);
        }

        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!is_string($mime) || !isset($allowedMime[$mime])) {
            error(['error' => 'ფაილის ტიპი არასწორია'], 400);
        }

        $allowedPages = ['smartelectricsolution', 'elevatorcity'];
        $page = (string)($user['page'] ?? '');
        if (!in_array($page, $allowedPages, true)) {
            error(['error' => 'არასწორი გვერდი'], 403);
        }

        $uploadDir = _API_DIR_ . "/../pages/$page/uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }

        $uploadDir = realPath($uploadDir);
        if ($uploadDir === false) {
            error(['error' => 'ფაილის დირექტორია ვერ მოიძებნა'], 500);
        }

        $safeName = uniqid('photo_', true) . '.' . $allowedMime[$mime];

        $relativePath = "/uploads/$safeName";
        $fullPath = "$uploadDir/$safeName";

        if (!move_uploaded_file($file['tmp_name'], $fullPath)) {
            error(['error' => 'ფაილის შენახვა ვერ მოხერხდა'], 500);
        }

        res([
            "url"=>$relativePath,
            "name"=>$safeName
        ]);
    });

};

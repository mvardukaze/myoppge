<?php
defined('INDEX') or exit('No direct access allowed');

return function () {
    global $db ,$p;

    $password = (string)($p['pass'] ?? '');
    $login = (string)($p['user'] ?? '');
    $user = $db->get("users", ['id', 'pass'], ['user' => $login]);
    $token =  bin2hex(random_bytes(64));

    $isValid = false;
    $id = 0;

    if ($user && isset($user['id'], $user['pass'])) {
        $id = (int)$user['id'];
        $storedHash = (string)$user['pass'];

        if (password_verify($password, $storedHash)) {
            $isValid = true;
        } else {
            // Backward compatibility for legacy md5 hashes; migrate on successful login.
            $legacyHash = md5("oop" . $password);
            if (hash_equals($storedHash, $legacyHash)) {
                $isValid = true;
                $db->update('users', ['pass' => password_hash($password, PASSWORD_DEFAULT)], ['id' => $id]);
            }
        }
    }

    if($isValid){
        $db->insert("sessions",['token'=>$token,  "ip"=>$_SERVER['REMOTE_ADDR'],'user_id'=>$id]);

        $forwardedProtoRaw = (string)($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '');
        $forwardedProto = strtolower(trim(explode(',', $forwardedProtoRaw)[0] ?? ''));
        $isHttps = (
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
            (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443) ||
            $forwardedProto === 'https'
        );

        setcookie('sessions', $token, [
            'expires' => time() + (30 * 24 * 60 * 60),
            'path' => '/',
            'secure' => $isHttps,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        ok();
    }else{
        error(["message"=>"no access", 'pass'=>null]);
    }
};

<?php
defined('INDEX') or error('Access denied',403);

global $db,$user,$p;
$tmp = json_decode(file_get_contents('php://input'), true);
$p = array_replace($_POST ?? [], is_array($tmp) ? $tmp : []);
require_once __DIR__.'/helper.php';

require_once __DIR__.'/config.php';

require_once __DIR__.'/Router.php';



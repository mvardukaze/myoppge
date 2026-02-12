<?php
const INDEX = true;
require_once "system/config.php";
global $params;
if($params['enabled'] || $_GET['show']=='yes'){
    require_once "main.php";
}else{
    require_once "disabled.php";
}


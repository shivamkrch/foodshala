<?php
include_once $_SERVER['DOCUMENT_ROOT']."/config/db.php";

$email = $_COOKIE['user-email'];
$type = $_COOKIE['user-type'];


$db = new DB();
$db->query("SELECT * FROM ".($type=='rest'?'restaurants':'customers')." WHERE email=:email");

include_once $_SERVER['DOCUMENT_ROOT']."/templates/partials/profile-header.php";
include_once $_SERVER['DOCUMENT_ROOT']."/templates/pages/customers/orders.php";

$db->terminate();
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/footer.html'; ?>


<?php
include_once $_SERVER['DOCUMENT_ROOT']."/config/db.php";

$email = $_COOKIE['user-email'];
$type = $_COOKIE['user-type'];

$db = new DB();

$db->query("SELECT * FROM ".($type=='rest'?'restaurants':'customers')." WHERE email=:email");
$db->bind(':email', $email);
$res = $db->single();

include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/header.php';
include_once $_SERVER['DOCUMENT_ROOT']."/templates/partials/profile-header.php";
if($type == 'cust'){
    include_once $_SERVER['DOCUMENT_ROOT']."/templates/pages/customers/orders.php";
}else{
    include_once $_SERVER['DOCUMENT_ROOT']."/templates/pages/restaurants/orders.php";
}

$db->terminate();
echo "<title>Orders | {$res['name']} | FoodShala</title>";
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/footer.html'; ?>


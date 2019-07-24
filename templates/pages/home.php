<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/config/auth.php';

if(isAuthenticated()){
    $db = new DB();
    $db->query("SELECT name FROM ".($_COOKIE['user-type']=='rest'?'restaurants':'customers').
    " WHERE email=:email");
    $db->bind(':email', $_COOKIE['user-email']);
    $res = $db->single();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/header.php';
?>
<div class="container-fluid p-0">
    <div class="slider w-100 bg-danger px-0">
        <div class="heading w-100 h-100 py-5">
            <h1 class="user-name text-center text-white display-3 pt-5">Welcome to 
                <span style="color: #00da32">FoodShala</span></h1>
            <p class="text-center text-white h3">The fastest food delivery</p>
        </div>
    </div>
<?php require_once __DIR__."/partials/restaurants.php"; ?>
    <div class="features p-3 bg-warning text-white" id="features">
        <div class="row mx-auto text-center px-4 py-3">
            <div class="col-md-4 mt-sm-3 mt-3">
                <i class="fas fa-thumbs-up fa-4x"></i>
                <h4 class="mt-4 feat-head">No Minimum Order</h4>
                <p>Order in for yourself or for the group, with no restrictions on order value</p>
            </div>
            <div class="col-md-4 mt-sm-3 mt-3">
                <i class="fas fa-map-marked-alt fa-4x"></i>
                <h4 class="mt-4 feat-head">Live Order Tracking</h4>
                <p>Know where your order is at all times, from the restaurant to your doorstep</p>
            </div>
            <div class="col-md-4 mt-sm-3 mt-3">
                <i class="fas fa-motorcycle fa-4x"></i>
                <h4 class="mt-4 feat-head">Lightning-Fast Delivery</h4>
                <p>Experience FoodShala's superfast delivery for food delivered fresh & on time</p>
            </div>
        </div>
    </div>
</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/footer.html'; ?>

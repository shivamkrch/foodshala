<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/config/db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/config/auth.php';

if(isAuthenticated()){
    // If user is logged in, get his details
    $db = new DB();
    $db->query("SELECT name, id FROM ".($_COOKIE['user-type']=='rest'?'restaurants':'customers').
    " WHERE email=:email");
    $db->bind(':email', $_COOKIE['user-email']);
    $res = $db->single();
    // If no user found go to login page by logging out the user and clearing cookies
    if($res == ''){
        header('location: /logout');
    }
    if($_COOKIE['user-type']=='rest'){
        $rest_id = $res['id'];
    }
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/header.php';
?>
<div class="container-fluid p-0">
    <!-- Slider at the home page -->
    <div class="slider w-100 bg-danger px-0">
        <div class="heading w-100 h-100 py-5">
            <h1 class="user-name text-center text-white display-3 pt-5">Welcome to 
                <span style="color: #00da32">FoodShala</span></h1>
            <p class="text-center text-white h3">The fastest food delivery</p>
        </div>
    </div>
<?php 
if(!(isAuthenticated() && $_COOKIE['user-type']=='rest')){
    // Show restaurants by default
    require_once $_SERVER['DOCUMENT_ROOT']."/templates/partials/restaurants.php";
}else{
    // Show orders of the restaurant if logged in user is a restaurant
    require_once $_SERVER['DOCUMENT_ROOT']."/templates/pages/restaurants/orders.php";
}
?>
    <!-- Features Section -->
    <div class="features p-3 bg-warning text-white mt-4" id="features">
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
<?php
$db->terminate();
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/footer.html'; ?>

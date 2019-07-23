<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/header.php'; ?>
<div class="container-fluid p-0">
    <div class="slider w-100 bg-danger px-2 px-md-5">
        <form autocomplete="off" class="align-middle-vertical mx-md-5">
            <div class="input-group mb-3">
                <input type="text" class="form-control form-control-lg" placeholder="Search for food and restaurants" id="searchField">
                <div class="input-group-append">
                    <button class="btn btn-success btn-lg" id="searchBtn">Search</button>
                </div>
            </div>
        </form>
    </div>
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

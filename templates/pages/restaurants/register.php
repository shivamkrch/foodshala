<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/header.php'; ?>

<div class="container p-3 my-5 pb-5">
    <h1 class="display-4 text-center">Restaurant's Registration</h1>
    <p class="text-center">Register to serve the awesome FoodShala family</p>
    <center>
        <div class="alert alert-danger text-center col-md-6" role="alert" id="regError" style="display: none">
        </div>
    </center>
    <form id="restRegForm" class="mt-5 col-md-6 mx-auto">
        <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-user-alt"></i>
                </span>
            </div>
            <input type="text" class="form-control form-control-lg" placeholder="Full Name"
             name="name" required>
        </div>
        <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">@</span>
            </div>
            <input type="email" class="form-control form-control-lg" placeholder="Email"
             name="email" required>
        </div>
        <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-map-marker-alt"></i>
                </span>
            </div>
            <input type="text" class="form-control form-control-lg" placeholder="Location"
             name="location" required>
        </div>
        <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-lock"></i>
                </span>
            </div>
            <input type="password" class="form-control form-control-lg" placeholder="Password"
             name="password" id="pwdField" minlength="6" required>
            <div class="input-group-append">
                <button type="button" class="btn btn-light" id="showPwdBtn">
                    <i class="fa fa-eye" id="showPwdIcon"></i>
                </button>
            </div>
        </div>
        <input type="submit" value="Register" class="btn btn-success btn-block btn-lg mt-4">
    </form>
    <p class="text-center mb-1 mt-4">Already registered?<a href="/login" class="ml-2">Login</a></p>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/footer.html'; ?>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/header.php'; ?>

<div class="container p-3 my-5 pb-5">
    <h1 class="display-4 text-center">Customer's Registration</h1>
    <p class="text-center">Register to become a precious member of the awesome FoodShala family</p>
    <center>
        <div class="alert alert-danger text-center col-md-6" role="alert"
         id="regError" style="display: none">
        </div>
    </center>
    
    <form id="custRegForm" class="mt-5 col-md-6 mx-auto">
        <!-- Customer's name field -->
        <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-user-alt"></i>
                </span>
            </div>
            <input type="text" class="form-control form-control-lg" placeholder="Full Name"
             name="name" required>
        </div>
        <!-- Customer's email field -->
        <div class="input-group input-group-lg mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">@</span>
            </div>
            <input type="email" class="form-control form-control-lg" placeholder="Email"
             name="email" required>
        </div>
        <!-- Customer's password field -->
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
        <!-- Customer's preference field -->
        <h5>Preference:</h5>
        <div class="row text-center">
            <div class="col-6">
                <div class="custom-control custom-radio">
                    <input type="radio" id="vegOpt" name="veg" class="custom-control-input"
                     value="1" required>
                    <label class="custom-control-label" for="vegOpt">Veg</label>
                </div>
            </div>
            <div class="col-6">
                <div class="custom-control custom-radio">
                    <input type="radio" id="nonVegOpt" name="veg" class="custom-control-input" 
                    value="0" required>
                    <label class="custom-control-label" for="nonVegOpt">Non-Veg</label>
                </div>
            </div>
        </div>
        <input type="submit" value="Register" class="btn btn-success btn-block btn-lg mt-4">
    </form>
    <p class="text-center mb-1 mt-4">Already registered?<a href="/login" class="ml-2">Login</a></p>
</div>
<script>
    document.title = "Customer's Registration | FoodShala";
</script>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/footer.html'; ?>

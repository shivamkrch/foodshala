<?php
include_once $_SERVER['DOCUMENT_ROOT']."/config/db.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config/auth.php";

if(isAuthenticated()){
    $type = $_COOKIE['user-type'];
    $email = $_COOKIE['user-email'];
    // Get the logged in user details
    $db = new DB();
    $db->query("SELECT * FROM ".($type=='rest'?'restaurants':'customers')." WHERE email=:email");
    $db->bind(':email', $email);
    $res = $db->single();
    if($res == ''){
        // If no user found go to login page by logging out the user and clearing cookies
        header('location: /logout');
    }
    if($type == 'cust'){
        // Set the veg preference of the customer
        $custVeg = $res['veg'];
    }
    $db->terminate();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/header.php';

$rest_id = $_GET['menu_rest_id'];
$type = "rest";

$db = new DB();
// Get restaurant by id
$db->query("SELECT * FROM restaurants WHERE id=:id");
$db->bind(':id', $rest_id);
$res = $db->single();
// If no restaurant found, go to home page
if($res == ''){
    header('location: /');
}
$db->terminate();

include_once $_SERVER['DOCUMENT_ROOT']."/templates/partials/profile-header.php";
unset($type);
$db = new DB();
$foodQuery = "SELECT * FROM food_items WHERE rest_id=:id";
if(isset($custVeg) && $custVeg == 1){
    // If the customer is vegetarian then show the veg food items first
    $foodQuery = "SELECT * FROM food_items WHERE rest_id=:id ORDER BY veg DESC";
}
$db->query($foodQuery);
$db->bind(":id", $rest_id);
$menu = $db->resultset();
?>
<div class="container px-3 py-5">
    <h2 class="ml-2 mb-4">Menu
    <?php if(isset($_COOKIE['user-type']) && $_COOKIE['user-type'] == 'rest'){ ?>
        <!-- Show add menu button if the user is the restaurant -->
        <button type="button" class="btn btn-success float-right"
        data-toggle="modal" data-target="#addMenuModal" data-restid="<?=$rest_id ?>">
            <i class="fas fa-plus mr-1"></i> Add Menu
        </button>
        <!-- Show the add menu modal on add menu button click -->
    <?php include_once $_SERVER['DOCUMENT_ROOT']."/templates/partials/add-menu-modal.html";
 } ?>
    </h2>
    
    <?php
    echo (count($menu)==0 ? '<p class=" h4 text-center text-danger">No menu.</p>' 
    : "");
    foreach ($menu as $menuItem) {
        ?>
        <div class="card text-left shadow-sm mt-4 mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                            <h5 class="card-title"><?=$menuItem['name'] ?>
                            <?php if($menuItem['veg']=='1'){ ?>
                                <!-- Show veg icon if the food item is veg -->
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Indian-vegetarian-mark.svg/155px-Indian-vegetarian-mark.svg.png"
                             alt="Veg mark" style="height: 1.1rem;" class="mr-2">
                        <?php }else{ ?>
                            <!-- Show the non-veg icon if the food item is non-veg -->
                            <img src="https://img.icons8.com/color/48/000000/non-vegetarian-food-symbol.png"
                             style="height: 1.4rem;" class="mr-2">
                        <?php } ?>
                        </h5>
                            <p class="card-text"><?=$menuItem['ingredients'] ?></p>
                    </div>
                    <div class="col-3">
                        <p class="card-text h3 text-success float-right">₹ <?=$menuItem['cost'] ?></p>
                        <?php if(!isset($_COOKIE['user-type']) || $_COOKIE['user-type'] != 'rest') { ?>
                            <!-- Show Order button if the user is a customer -->
                        <button type="button" class="btn btn-info mt-2 float-right btn-block orderBtn"
                        data-menuid="<?=$menuItem['id'] ?>" data-restid="<?=$rest_id ?>">Order</button>
                        <?php }else{ ?>
                            <!-- Show the remove menu button if the user is a restaurant -->
                        <button type="button" class="btn btn-danger mt-2 float-right btn-block removeMenu"
                        id="<?=$menuItem['id'] ?>">Remove</button>
                        <?php } ?>
                    </div>
                </div> 
            </div>
        </div>
    <?php } ?>
</div>
<script>
    document.title = "<?=$res['name'] ?> | Menu | FoodShala";
</script>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/footer.html'; ?>


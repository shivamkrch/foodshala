<?php
include_once $_SERVER['DOCUMENT_ROOT']."/config/db.php";
include_once $_SERVER['DOCUMENT_ROOT']."/config/auth.php";

if(isAuthenticated()){
    $type = $_COOKIE['user-type'];
    $email = $_COOKIE['user-email'];

    $db = new DB();
    $db->query("SELECT * FROM ".($type=='rest'?'restaurants':'customers')." WHERE email=:email");
    $db->bind(':email', $email);
    $res = $db->single();
    $db->terminate();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/header.php';

$rest_id = $_GET['menu_rest_id'];
$type="rest";

$db = new DB();
$db->query("SELECT * FROM restaurants WHERE id=:id");
$db->bind(':id', $rest_id);
$res = $db->single();
$db->terminate();

include_once $_SERVER['DOCUMENT_ROOT']."/templates/partials/profile-header.php";
unset($type);
$db = new DB();
$db->query("SELECT * FROM food_items WHERE rest_id=:id");
$db->bind(":id", $rest_id);
$menu = $db->resultset();
?>
<div class="container px-3 py-5">
    <h2 class="ml-2 mb-4">Menu
    <?php if(isset($_COOKIE['user-type']) && $_COOKIE['user-type'] == 'rest'){ ?>
        <button type="button" class="btn btn-success float-right"
        data-toggle="modal" data-target="#addMenuModal" data-restid="<?=$rest_id ?>">
            <i class="fas fa-plus mr-1"></i> Add Menu
        </button>
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
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Indian-vegetarian-mark.svg/155px-Indian-vegetarian-mark.svg.png"
                             alt="Veg mark" style="height: 1.1rem;" class="mr-2">
                        <?php }else{ ?>
                            <img src="https://img.icons8.com/color/48/000000/non-vegetarian-food-symbol.png"
                             style="height: 1.4rem;" class="mr-2">
                        <?php } ?>
                        </h5>
                            <p class="card-text"><?=$menuItem['ingredients'] ?></p>
                    </div>
                    <div class="col-3">
                        <p class="card-text h3 text-success float-right">₹ <?=$menuItem['cost'] ?></p>
                        <?php if(!isset($_COOKIE['user-type']) || $_COOKIE['user-type'] != 'rest') { ?>
                        <button type="button" class="btn btn-info mt-2 float-right btn-block"
                        data-id="<?=$menuItem['id'] ?>">Order</button>
                        <?php }else{ ?>
                        <button type="button" class="btn btn-danger mt-2 float-right btn-block removeMenu"
                        id="<?=$menuItem['id'] ?>">Remove</button>
                        <?php } ?>
                    </div>
                </div> 
            </div>
        </div>
    <?php } ?>
</div>
<div class="toast removeMenuErr">
  <div class="toast-body text-danger">
    Unable to remove item!
  </div>
</div>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/footer.html'; ?>


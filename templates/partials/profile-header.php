<?php
$db->bind(':email', $email);
$res = $db->single();
include_once $_SERVER['DOCUMENT_ROOT'] . '/templates/partials/header.php';
?>
<div class="slider w-100 bg-danger px-0" style="height: 40vh">
    <div class="text-center p-3 heading w-100 h-100">
        <div class="mt-5">

            <h1 class="user-name text-white">
                <?php if($type=='cust'){ ?>
                    <i class="fas fa-user"></i>
                <?php }else{ ?>
                    <i class="fas fa-hotel"></i>
                <?php } ?>
                <?=$res['name'] ?></h1>
                <p class="h4 text-white"><i class="fa fa-envelope mr-2"></i><?=$res['email'] ?></p>
                <?php if($type=='rest'){ ?>
                    <p class="h4 text-white"><i class="fa fa-map-marker-alt"></i><?=$res['location'] ?></p>
                <?php }else{ ?>
                    <p class="h4 text-white">
                        <?php if($res['veg']=='1'){ ?>
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Indian-vegetarian-mark.svg/155px-Indian-vegetarian-mark.svg.png"
                             alt="Veg mark" style="height: 1.6rem;" class="mr-2"> Vegetarian
                        <?php }else{ ?>
                            <img src="https://img.icons8.com/color/48/000000/non-vegetarian-food-symbol.png " style="height: 1.6rem;" class="mr-2"> Vegetarian
                        <?php } ?>
                    </p>
                <?php } ?>
        </div>
    </div>      
</div>
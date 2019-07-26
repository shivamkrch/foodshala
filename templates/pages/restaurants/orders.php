<?php
// Get all orders with recent orders first for the restaurant
$db->query("SELECT * FROM orders WHERE rest_id=:id ORDER BY `date` DESC");
$db->bind(':id',$res['id']);
$orders = $db->resultset();
?>
<div class="container px-3 py-5">
    <h2 class="ml-2 mb-4">Orders</h2>
    <?php
    echo (count($orders)==0 ? '<p class=" h4 text-center text-danger">No orders.</p>' 
    : "");
    $count = 0;
    foreach ($orders as $order) { 
        // Find user's name of the order
        $count++;
        $db->query("SELECT name FROM customers WHERE id={$order['cust_id']}");
        $custName = $db->single()['name'];
        // Find the name of the food item
        $db->query("SELECT name, cost, veg FROM food_items WHERE id={$order['food_id']}");
        $foodItem = $db->single();
        ?>
        <div class="card text-left shadow-sm mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                            <h5 class="card-title"><?=$foodItem['name'] ?>
                            <?php if($foodItem['veg']=='1'){ ?>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Indian-vegetarian-mark.svg/155px-Indian-vegetarian-mark.svg.png"
                                alt="Veg mark" style="height: 1.1rem;" class="mr-2">
                            <?php }else{ ?>
                                <img src="https://img.icons8.com/color/48/000000/non-vegetarian-food-symbol.png"
                                style="height: 1.4rem;" class="mr-2">
                            <?php } ?>
                            </h5>
                            <p class="card-text"><?=$custName ?></p>
                            <!-- Show on Smaller Screens -->
                            <p class="card-text d-md-none"><i class="fas fa-clock mr-1"></i> 
                            <?=date("j M, Y h:i A", strtotime($order['date'])) ?></p>
                    </div>
                    <div class="col-4 text-right">
                        <p class="card-text h3 text-success">₹ <?=$foodItem['cost'] ?></p>
                        <!-- Show on Larger Screens -->                    
                        <p class="card-text d-none d-md-block"><i class="fas fa-clock mr-1"></i> 
                        <?=date("j M, Y h:i A", strtotime($order['date'])) ?></p>
                    </div>
                </div> 
            </div>
        </div>
    <?php // To show only 5 recent orders on home page
     if($_SERVER['REQUEST_URI']=='/' && $count==5){ ?>
    <center>
        <a href="/orders" class="btn btn-info mt-5">Show All</a>
    </center>
        <?php
            break;
         }
     } ?>

    
    
</div>
<?php

$db->query("SELECT * FROM orders WHERE rest_id=:id");
$db->bind(':id',$res['id']);
$orders = $db->resultset();
?>
<div class="container px-3 py-5">
    <h2 class="ml-2 mb-4">Orders</h2>
    <?php
    echo (count($orders)==0 ? '<p class=" h4 text-center text-danger">No orders.</p>' 
    : "");
    foreach ($orders as $order) { 
        // Find user's name of the order
        $db->query("SELECT name FROM customers WHERE id={$order['cust_id']}");
        $custName = $db->single()['name'];
        // Find the name of the food item
        $db->query("SELECT name, cost FROM food_items WHERE id={$order['food_id']}");
        $foodItem = $db->single();
        ?>
        <div class="card text-left shadow-sm mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                            <h5 class="card-title"><?=$foodItem['name'] ?></h5>
                            <p class="card-text"><?=$custName ?></p>
                    </div>
                    <div class="col-3">
                        <p class="card-text h3 text-success float-right">₹ <?=$foodItem['cost'] ?></p>
                    </div>
                </div> 
            </div>
        </div>
    <?php } ?>

    
    
</div>
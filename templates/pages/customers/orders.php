<?php
$orderQuery = "SELECT orders.*, restaurants.id, restaurants.name FROM orders INNER JOIN restaurants".
        "ON orders.rest_id=restaurants.id WHERE cust_id={$res['id']}";

$db->query($orderQuery);
$db->bind(':id', $res['id']);
$orders = $db->resultset();
?>
<div class="container px-3 py-5">
    <h2 class="">Recent Orders</h2>
    <?php
    echo (count($orders)==0 ? '<p class=" h4 text-center text-danger">No orders.</p>' 
    : "");
    ?>

    <div class="card text-left">
      <div class="card-body">
          <div class="row">
              <div class="col-9">
                    <h5 class="card-title">Item name</h5>
                    <p class="card-text">Restaurant name</p>
              </div>
              <div class="col-3">
                  <p class="card-text h3 text-success float-right">₹23</p>
              </div>
          </div> 
      </div>
    </div>
    
</div>
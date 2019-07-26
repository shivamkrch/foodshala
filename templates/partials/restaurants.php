<!-- Show restaurants section -->
<div class="container mt-3 p-3 mb-5">
    <h3>Restaurants</h3>
    <?php
        // Get all the restaurants
        $db = new DB();
        $db->query("SELECT * FROM restaurants");
        $restaurants = $db->resultset();
        foreach($restaurants as $restaurant){
    ?>
    <div class="card mt-3">
        <div class="card-body shadow-sm">
            <div class="row">
                <div class="col-md-9">
                    <h4 class="card-title"><?=$restaurant['name'] ?></h4>
                    <p class="card-text">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        <?=$restaurant['location'] ?></p>
                </div>
                <div class="col-md-3">
                    <a href="/restaurant/<?=$restaurant['id'] ?>" 
                    class="btn btn-info btn-block float-right mt-3">Show Menu</a>
                </div>
            </div>
        </div>
    </div>
        <?php } ?>
</div>
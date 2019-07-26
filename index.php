<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config/db.php';
require_once __DIR__.'/config/auth.php';

// Initializing router
$router = new Klein\Klein();

// Home page route
$router->respond('GET', '/', function($req, $res, $service){
    $service->render(__DIR__.'/templates/pages/home.php');
});

// Login page route
$router->respond('GET', '/login', function($req, $res, $service){
    if(isAuthenticated()){
        header('location: /');
    }
    $service->render(__DIR__.'/templates/pages/login.php');
});

// Logout page route
$router->respond('GET', '/logout', function($req, $res, $service){
    // Remove both saved cookies
    setcookie('user-email', null, time()-1, '/');
    setcookie('user-type', null, time()-1, '/');
    $res->redirect('/login');
});

// Orders page route
$router->respond('/orders', function($req, $res, $service){
    if(!isAuthenticated()){
        header('location: /login');
    }
    $service->render(__DIR__.'/templates/pages/orders.php');
});

// Menu page route, only for restaurants
$router->respond('/menu', function($req, $res, $service){
    if(!isAuthenticated()){
        header('location: /login');
    }elseif(isAuthenticated() && $_COOKIE['user-type'] == 'cust'){
        header('location: /');
    }
    $db = new DB();
    $db->query("SELECT id from restaurants WHERE email=:email");
    $db->bind(':email', $_COOKIE['user-email']);
    $_GET['menu_rest_id'] = $db->single()['id'];
    $db->terminate();
    $service->render(__DIR__.'/templates/pages/restaurants/menu.php');
});

// Routes for rstaurants
// Routes starting with /restaurant
$router->with('/restaurant', function() use ($router){

    // Restaurants registration page route
    $router->respond('/register', function($req, $res, $service){
        if(isAuthenticated()){
            header('location: /orders');
        }
        $service->render(__DIR__.'/templates/pages/restaurants/register.php');
    });

    // Restaurants menu page route
    $router->respond('/[i:id]', function($req, $res, $service){
        if(isAuthenticated() && $_COOKIE['user-type'] == 'rest'){
            header('location: /menu');
        }
        $_GET['menu_rest_id'] = $req->id;
        $service->render(__DIR__.'/templates/pages/restaurants/menu.php');
    });
});

// Routes starting with /customer
$router->with('/customer', function() use ($router){

    // Customer registration route
    $router->respond('/register', function($req, $res, $service){
        if(isAuthenticated()){
            header('location: /');
        }
        $service->render(__DIR__.'/templates/pages/customers/register.php');
    });
});

// API routes, starting with /api
$router->with('/api', function() use ($router){

    // Routes starting with /api/customer
    $router->with('/customer', function() use ($router){

        // Route /api/customer/register
        // Register new customer
        $router->respond('POST','/register', function($req, $res, $service){
            if(isset($req->name) && isset($req->email) && isset($req->password) && isset($req->veg)){
                $db = new DB();
                $db->query("SELECT email FROM `customers` WHERE email=:email");
                $db->bind(':email', $req->email);
                $resCust = $db->resultset();
                $db->query("SELECT email FROM `restaurants` WHERE email=:email");
                $db->bind(':email', $req->email);
                $resRest = $db->resultset();
                if (count($resCust) != 0 || count($resRest) != 0) {
                    $result['email'] = "Email already exists. Please try another.";
                    return json_encode($result);
                }else{
                    $db->bind(':name', $req->name);
                    $pwd = md5($req->password);
                    $db->query("INSERT INTO `customers` (name, email, pwd, veg) 
                    VALUES(:name, :email, :pwd, :veg)");
                    $db->bind(':name', $req->name);
                    $db->bind(':email', $req->email);
                    $db->bind(':pwd', $pwd);
                    $db->bind(':veg', $req->veg);
                    $result = $db->execute();
                    if (!is_null($db->queryError())) {
                        return json_encode('false');
                    }
                    return json_encode($result);
                }
                $db->terminate();
            }else{
                return "Invalid request";
            }
        });

        
    });

    // Routes starting with /api/restaurant
    $router->with('/restaurant', function() use ($router){

        // Route /api/restaurant/register
        // Register new restaurant
        $router->respond('POST','/register', function($req, $res, $service){
            if(isset($req->name) && isset($req->email) && isset($req->password) && isset($req->location)){
                $db = new DB();
                $db->query("SELECT email FROM `customers` WHERE email=:email");
                $db->bind(':email', $req->email);
                $resCust = $db->resultset();
                $db->query("SELECT email FROM `restaurants` WHERE email=:email");
                $db->bind(':email', $req->email);
                $resRest = $db->resultset();
                if (count($resCust) != 0 || count($resRest) != 0) {
                    $result['email'] = "Email already exists. Please try another.";
                    return json_encode($result);
                }else{
                    $db->bind(':name', $req->name);
                    $pwd = md5($req->password);
                    $db->query("INSERT INTO `restaurants` (name, email, pwd, location) 
                    VALUES(:name, :email, :pwd, :loc)");
                    $db->bind(':name', $req->name);
                    $db->bind(':email', $req->email);
                    $db->bind(':pwd', $pwd);
                    $db->bind(':loc', $req->location);
                    $result = $db->execute();
                    if ($db->queryError()) {
                        return json_encode('false');
                    }
                    return json_encode($result);
                }
                $db->terminate();
            }else{
                return "Invalid request";
            }
        });

        // Route /api/restaurant/menu
        // Add new menu item to restaurant
        $router->respond('POST', '/menu', function($req, $res, $service){
            if(isAuthenticated()){
                $db = new DB();
                $db->query("INSERT INTO `food_items` (name, ingredients, veg, rest_id, cost) 
                VALUES(:name, :ingreds, :veg, :restid, :cost)");
                $db->bind(':name', $req->itemName);
                $db->bind(':ingreds', $req->itemIngreds);
                $db->bind(':veg', $req->veg);
                $db->bind(':restid', $req->itemRestId);
                $db->bind(':cost', $req->itemCost);
                $result = $db->execute();
                if ($db->queryError()) {
                    return json_encode(FALSE);
                }
                return json_encode(TRUE);
                $db->terminate();
            }else{
                return json_encode(FALSE);
            }
        });

        // Route /api/restaurant/menu/{id}
        // Delete a menu item by id
        $router->respond('DELETE', '/menu/[i:id]', function($req, $res, $service){
            if(isAuthenticated()){
                $db = new DB();
                $db->query("DELETE FROM `food_items` WHERE id=:id");
                $db->bind(':id', $req->id);
                $result = $db->execute();
                if ($db->queryError()) {
                    return json_encode(FALSE);
                }
                return json_encode(TRUE);
                $db->terminate();
            }else{
                return json_encode(FALSE);
            }
        });
    });

    // Route /api/login
    // User login route
    $router->respond('POST', '/login', function($req, $res, $service) use($router){
        if(isset($req->email) && isset($req->password)){
            $db = new DB();
            // Select from both restaurant and customer tables
            $db->query("SELECT pwd FROM `customers` WHERE email=:email");
            $db->bind(':email', $req->email);
            $resCust = $db->single();
            $db->query("SELECT pwd FROM `restaurants` WHERE email=:email");
            $db->bind(':email', $req->email);
            $resRest = $db->single();
            $pwd = md5($req->password);
            // Check for same password for customer if exists
            if($pwd == $resCust['pwd']){
                // Set cookie with key 'user-email' to matched customer's email
                setcookie('user-email', $req->email, time()+3600*24*20, '/');
                // Set cookie with key 'user-type' to 'cust' representing customers
                setcookie('user-type', 'cust', time()+3600*24*20, '/');
                return json_encode(TRUE);
            // Check for same password for customer if exists
            }elseif($pwd == $resRest['pwd']){
                // Set cookie with key 'user-email' to matched customer's email
                setcookie('user-email', $req->email, time()+3600*24*20, '/');
                // Set cookie with key 'user-type' to 'rest' representing restaurants
                setcookie('user-type', 'rest', time()+3600*24*20, '/');
                return json_encode(TRUE);
            }else{
                return json_encode(FALSE);
            }
            $db->terminate();
        }else{
            return "Invalid request";
        }
    });

    // Route /api/order/{restId}/{menuId}
    // Route to add a new order with restaurant id and menu id
    $router->respond('POST', '/order/[i:restId]/[i:menuId]', function($req, $res){
        if(isAuthenticated() && $_COOKIE['user-type'] == 'cust'){
            if(isset($req->restId) && isset($req->menuId)){
                $db = new DB();
                $db->query("SELECT id FROM customers WHERE email=:email");
                $db->bind(':email', $_COOKIE['user-email']);
                $custId = $db->single()['id'];
                if(!$db->queryError()){
                    $db->query("INSERT INTO orders (rest_id, cust_id, food_id) VALUES(:rest, :cust, :food)");
                    $db->bind(':rest', $req->restId);
                    $db->bind(':cust', $custId);
                    $db->bind(':food', $req->menuId);
                    $db->execute();
                    if(!$db->queryError()){
                        return json_encode(TRUE);
                    }else{
                        return json_encode(FALSE);
                    }
                }else{
                    return json_encode(FALSE);
                }
            }else{
                return json_encode(FALSE);
            }
            $db->terminate();
        }else{
            return json_encode(FALSE);
        }
    });
    
});

$router->dispatch();
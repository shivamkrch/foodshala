<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config/db.php';
require_once __DIR__.'/config/auth.php';

$router = new Klein\Klein();

$router->respond('GET','/', function($req, $res, $service){
    $service->render(__DIR__.'/templates/pages/home.php');
});

$router->respond('/login', function($req, $res, $service){
    if(isAuthenticated()){
        header('location: /orders');
    }
    $service->render(__DIR__.'/templates/pages/login.php');
});

$router->respond('/orders', function($req, $res, $service){
    if(!isAuthenticated()){
        header('location: /login');
    }
    $service->render(__DIR__.'/templates/pages/orders.php');
});

$router->with('/restaurant', function() use ($router){
    $router->respond('/register', function($req, $res, $service){
        if(isAuthenticated()){
            header('location: /orders');
        }
        $service->render(__DIR__.'/templates/pages/restaurants/register.php');
    });
});

$router->with('/customer', function() use ($router){
    $router->respond('/register', function($req, $res, $service){
        if(isAuthenticated()){
            header('location: /orders');
        }
        $service->render(__DIR__.'/templates/pages/customers/register.php');
    });
});

$router->with('/api', function() use ($router){
    $router->with('/customer', function() use ($router){
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

    $router->with('/restaurant', function() use ($router){
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

    $router->respond('POST', '/login', function($req, $res, $service) use($router){
        if(isset($req->email) && isset($req->password)){
            $db = new DB();
            $db->query("SELECT pwd FROM `customers` WHERE email=:email");
            $db->bind(':email', $req->email);
            $resCust = $db->single();
            $db->query("SELECT pwd FROM `restaurants` WHERE email=:email");
            $db->bind(':email', $req->email);
            $resRest = $db->single();
            $pwd = md5($req->password);
            if($pwd == $resCust['pwd']){
                setcookie('user-email', $req->email, time()+3600*24*20, '/');
                setcookie('user-type', 'cust', time()+3600*24*20, '/');
                return json_encode(TRUE);
            }elseif($pwd == $resRest['pwd']){
                setcookie('user-email', $req->email, time()+3600*24*20, '/');
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
    
});

$router->dispatch();
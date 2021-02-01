<?
// rate limit
require_once('rate_limit.php');

// роутинг
require_once('route.php');

// модель работы с бд
require_once('order.php');


$client_ip = $_SERVER['REMOTE_ADDR'];


$rate_limit = new RateLimit(10, $client_ip);  
$route  = new Route();
$db = new Order();

// адрес отправителя
$sender = array ('Ул. Ленина', 'Дом 7', 'кв. 14');

// отправка всех заказов
$route->get('/allorders/', function() use ($rate_limit, $db){
   
    header('Content-type: application/json; charset=utf-8"');
    echo json_encode($db->getOrders());
   
});

// отправка заказа по id
$route->get('/getorder/:id', function($id) use ($rate_limit, $db){
   
    header('Content-type: application/json; charset=utf-8"');
    echo json_encode($db->getOrderById($id)); 
    
});


// расчёт стоимости
$route->post('/calculate/', function() use ($rate_limit){
        if($rate_limit->check()){
            $address = $_POST['address'];
            $house = $_POST['house'];
            $apartment = $_POST['apartment'];
            header('Content-type: application/json; charset=utf-8"');
            echo json_encode(array(
                'cost' => rand(),
                'address' => array(
                    'address' => $address,
                    'house' => $house,
                    'apartment' => $apartment
                )
            ));
        }else{
            header('HTTP/1.1 429 Too Many Requests');
            header('Content-Type: text/html');
            header('Retry-After: 3600');
            echo json_encode('To many requests');
        }
});

// добавление нового заказа
$route->post('/neworder/', function() use ($rate_limit, $db, $sender){
    if($rate_limit->check()){
        $address = $_POST['address'] ? $_POST['address'] : "kek";
        $house = $_POST['house'];
        $apartment = $_POST['apartment'];
        $cost = $_POST['cost'];

        $db->newOrder($address, $house, $apartment, $cost);

       
        header('Content-type: application/json; charset=utf-8"');
        echo json_encode(array(
            'orderAddress' => array('address' => $address, 'house' => $house, 'apartment' => $apartment, 'cost' => $cost),
            'senderAddress' => $sender
        ));
    }else{
        header('HTTP/1.1 429 Too Many Requests');
        header('Content-Type: text/html');
        header('Retry-After: 3600');
        echo json_encode('To many requests');
    }
});
    








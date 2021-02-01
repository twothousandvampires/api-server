<?
$curl = curl_init();
$host = 'http://api-server/';
$show = 'form';

// TRUE для возврата результата передачи в качестве строки из curl_exec() вместо прямого вывода в браузер

curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    if($_POST['action'] == 'calculate'){

        // Расчёт стоимости доставки

        $str = sprintf("address=%s&house=%s&apartment=%s", $_POST['address'], $_POST['house'], $_POST['apartment']);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $str);  
        curl_setopt($curl, CURLOPT_URL, $host.'calculate');
        curl_setopt($curl, CURLOPT_POST, 1);

        // Получение ответа

        $result = json_decode(curl_exec($curl), true);
        if($result === "To many requests"){
            $show = 'many_requests';
        }
        else{
            $cost = $result['cost'];
            $orderInfo = $result['address'];
            $show = 'order';
        }
       
    }
    else if($_POST['action'] == 'order'){     
        
        // Оформление заказа

        $str = sprintf("address=%s&house=%s&apartment=%s&cost=%s", $_POST['address'], $_POST['house'], $_POST['apartment'], $_POST['cost']);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $str);    
        curl_setopt($curl, CURLOPT_URL, $host.'neworder');
        curl_setopt($curl, CURLOPT_POST, 1);

        // Получение ответа

        $result = json_decode(curl_exec($curl), true);
        if($result === "To many requests"){
            $show = 'many_requests';
        }
        else{
            $show = 'order_info';
        }     
    }  
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@200&family=Roboto+Slab&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body style='font-family: Roboto Slab, serif;'>
    <div class = 'container' style='height:100vh'>
       
            <div >
                <a  class = 'text-decoration-none' href="admin.php">Админ панель</a>
                <a  class = 'text-decoration-none' href="courier.php">Курьер панель</a>
            </div>
            <div >             
                <? switch($show){
                case 'form':
                    require_once('templates/order_form.php');
                break;
                case 'order':
                    require_once('templates/accept_form.php');
                break;
                case 'order_info' :
                    require_once('templates/order_info.php');
                break;
                case 'many_requests' :
                    require_once('templates/many_requests.php');
                break;
                }
                ?>
            </div>
        
    </div>
    
   

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/css/suggestions.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@20.3.0/dist/js/jquery.suggestions.min.js"></script>

<script>
    $("#address").suggestions({
        token: "58738833347af9f1b0fab4c7ab2811bf31eccb11",
        type: "ADDRESS",
        constraints: {
      // Ограничиваем поиск Петрозаводском
        locations: {
        region: "Карелия",
        city: "Петрозаводск"
      },
    },
    // В списке подсказок не показываем область и город
    restrict_value: true,
    });

</script>
</body>
</html>
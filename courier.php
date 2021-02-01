<?
$curl = curl_init();
$host = 'http://api-server/';
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@200&family=Roboto+Slab&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Document</title>
</head>
<body style = 'height:100vh;font-family: Roboto Slab, serif;'>
        <a href="client.php">Назад</a>
        <div class = 'd-flex justify-content-center align-items-center h-75'>
        
        <?if(isset($_GET['id'])){?>

        <?
            curl_setopt($curl, CURLOPT_URL, $host."getorder/{$_GET['id']}");
            $result = json_decode(curl_exec($curl), true);
            if(is_array($result)){
            ?>  
                <!-- Вывод заказа -->
                <div  class = 'd-flex flex-column border m-5 p-5 bg-gradient-light bg-info rounded'> 
                    <p>Адрес : <?=$result['address'] ." ". $result['house'] ." ". $result['apartment']?></p>
                    <p>Стоимость : <?=$result['cost']?></p>
                    <p>Время заказа : <?=date('Y-m-d', $result['datetime'])?></p>
                    <p><a class = 'text-success text-decoration-none' href="<?=$_SERVER['PHP_SELF']?>">Назад
                    </a></p>
                </div>
                
            <?}else{?>
                <!-- Заказ не найден-->
                <div class='d-flex flex-column align-items-center'>
                    <p>Заказа с таким номером не существует</p>
                    <p><a class = 'text-success text-decoration-none' href="<?=$_SERVER['PHP_SELF']?>">Назад
                    </a></p>
                </div>
            <?}?>
        <?}
        else
        {?>
            <form action="<?=$_SERVER['PHP_SELF']?>" method = 'GET'>
                <p> Введите номер заказа : </p>
                <input type="text" name = 'id'>
                <button class="btn btn-success">найти заказ</button>
            </form>  
        <?}
        ?> 
        </div>
            
</body>
</html>
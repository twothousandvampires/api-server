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
    <title>Admin panel</title>
</head>
<body style='font-family: Roboto Slab, serif;'>
    <a href="client.php">Назад</a>
    <!-- Если выбран заказ -->

    <?if(isset($_GET['id'])){?>

    <?
    curl_setopt($curl, CURLOPT_URL, $host."getorder/{$_GET['id']}");
    $result = json_decode(curl_exec($curl), true);
    if(is_array($result)){
    ?>  
        <div  class = 'd-flex flex-column border m-5 p-5 bg-gradient-light bg-info rounded'> 
            <p>Адрес : <?=$result['address'] ." ". $result['house'] ." ". $result['apartment']?></p>
            <p>Стоимость : <?=$result['cost']?></p>
            <p>Время заказа : <?=date('Y-m-d', $result['datetime'])?></p>
            <p><a class = 'text-success text-decoration-none' href="<?=$_SERVER['PHP_SELF']?>">Назад
            </a></p>
        </div>
        
    <?}else{?>
        <p><?=$result?></p>
    <?}?>
    <?}

    else

    {?>
    <!-- Вывод всех заказов -->
    <?
    curl_setopt($curl, CURLOPT_URL, $host.'allorders');
    $result = json_decode(curl_exec($curl), true);
    if(is_array($result)){
    ?>

    <?foreach($result as $item){?>
        <div class = 'd-flex flex-column border m-5 p-5 bg-gradient-light bg-info rounded'>
            <p>Номер заказ : <?=$item['id']?></p>
            <p>Адрес : <?=$item['address']?></p>
            <p><a class = 'text-success text-decoration-none' href="<?=$_SERVER['PHP_SELF']?>?id=<?=$item['id']?>">Подробнее
            </a></p>
        </div>       
    <?}}
    else{?>
        <p><?=$result?></p>
    <?}?>

    <?}?>

</body>
</html>




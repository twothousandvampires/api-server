<div  style = 'margin:25% 0 0 0' class = 'd-flex flex-column align-items-center'>
        <p>Спасибо за заказ!<?=$cost?></p>
                <p>Адрес : <?=$result['orderAddress']['address'] . " " .$result['orderAddress']['house'] . " " .$result['orderAddress']['apartments']?></p>
                <p>Стоимость : <?=$result['orderAddress']['cost']?></p>
                <p>Адрес отправителя : <?=$result['senderAddress'][0] . " " .$result['senderAddress'][1] . " " .$result['senderAddress'][2]?></p>
        <a href="client.php">Назад</a>
</div>


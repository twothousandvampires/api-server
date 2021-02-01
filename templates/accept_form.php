<div style = 'margin:25% 0 0 0' class = 'd-flex flex-column align-items-center'>
    <p>Стоимость доставки: <?=$cost?></p>
                <form action="<?=$_SERVER['PHP_SELF']?>"  method = "POST">
                    <input name="action" type="hidden" value = 'order'/>
                    <input type="hidden" name = 'address' value= '<?=$orderInfo['address']?>'>
                    <input type="hidden" name = 'house' value= '<?=$orderInfo['house']?>'>
                    <input type="hidden" name = 'apartment' value= '<?=$orderInfo['apartment']?>'>
                    <input type="hidden" name = 'cost' value= '<?=$cost?>'>
                    <button type = 'submit'class="btn btn-success" >Сделать заказ</button>
                </form>
    <a href="client.php">Назад</a>
</div>
    

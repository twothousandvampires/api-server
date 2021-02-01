
                <p class = 'text-secondary text-center'>Расчёт стоимости доставки:</p>
                <form action="<?=$_SERVER['PHP_SELF']?>" method = 'POST' class ='d-flex flex-column '>
                        <input name="action" type="hidden" value = 'calculate'/>
                        <div>
                                <label style='width:70px;margin-left:30%;margin-right:10px' for="address">Улица</label>
                                <input class='w-25 mt-2 'id="address" name="address" required type="text">
                        </div>
                       
                        <div >
                                <label style='width:70px;margin-left:30%;margin-right:10px' for="name">Дом</label>
                                <input class='w-25 mt-2' type="text"  required name = 'house'>
                        </div>
                        <div>
                                <label style='width:70px;margin-left:30%;margin-right:10px' for="name">Квартира</label>       
                                <input class='w-25 mt-2' type="text"  required name = 'apartment'>  
                        </div>
                        
                        <div style='margin:0 auto;margin-top:20px'>                        
                                <button class="btn btn-success" style='width:80px;' id= 'go' type = 'submit'>go</button>
                        </div>                       
                </form>


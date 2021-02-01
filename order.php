<?

class Order{

    private $db;

    const DB_NAME = 'orders.db';

    public function __construct(){

        // создание бд или подключение к существующей

        if(is_file(self::DB_NAME)){
            $this->db = new SQLite3(self::DB_NAME);
        }
        else{
            $this->db = new SQLite3(self::DB_NAME);
            $sql = "CREATE TABLE orders(
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                address TEXT,
                house TEXT,
                apartment TEXT,
                cost TEXT,
                datetime TEXT
            )";
            $this->db->exec($sql) or $this->db->lastErrorMsg();
        }
    }

    // создание нового заказа
    public function newOrder($address, $house, $apartment, $cost){
        $time = time();
        $sql = "INSERT INTO orders(address, house, apartment, cost, datetime)
                           VALUES('$address', '$house', '$apartment', '$cost', '$time')";

        $this->db->exec($sql);
    }

     // получение всех заказов
    public function getOrders(){

        $sql = "SELECT id, address, house, apartment, cost, datetime FROM orders";
        $result = $this->db->query($sql);             
        return $this->db2Arr($result) ;

    }

    // получение заказа по id
    public function getOrderById($id){

        $sql = "SELECT id, address, house, apartment, cost, datetime FROM orders WHERE id = $id";
        $result = $this->db->query($sql);             
        return $this->db2Arr($result)[0] ;

    }

    // конверт ответа бд в массив
    protected function db2Arr(SQLite3Result $data){
        $arr = [];
        while($row = $data->fetchArray(SQLITE3_ASSOC))
          $arr[] = $row;
        return $arr;
    }

}
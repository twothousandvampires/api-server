<?

class RateLimit{
    
    private $db;

    const DB_NAME = 'limit.db';
    // ограничение по времени
    private $per = 60;
    
    public function __construct($rate , $ip){
        // ограничение подключений
        $this->rate = $rate;
        
        // время подключения
        $this->time = time();
        $this->ip = $ip;

        // возможность ответа
        $this->response = false;

        // создание бд или подключение к существующей
        if(is_file(self::DB_NAME)){
            $this->db = new SQLite3(self::DB_NAME);
           
        }
        else{
            $this->db = new SQLite3(self::DB_NAME);
            $sql = "CREATE TABLE connection(
                                    num INTEGER,
                                    time INTEGER,
                                    ip VARCHAR
                                )";
            $this->db->exec($sql) or $this->db->lastErrorMsg();
            $this->response = true;	     
        }
        
        // получение количечтва подключений для данного ip

        $sql = "SELECT num, time
        FROM connection
        WHERE ip = '$this->ip'";

 
        $result = $this->db->query($sql);
        $result = $this->db2Arr($result);
        
        if($result){
            $num = $result[0]['num'];
            $time = $result[0]['time'];
            if($time + $this->per > time()){


                // если последнее подключение было менее минуты назад

                if($num < $this->rate){
                    $this->response = true;

                    $sql = "UPDATE connection
                    SET num = $num + 1
                    WHERE ip ='$this->ip'";
                    $this->db->exec($sql);

                }
                               
            }
            else{

                // если последнее подключение было больше минуты назад

                $this->response = true;  
                $time = time();
                $sql = "UPDATE connection
                SET num = 0, time = $time
                WHERE ip ='$this->ip'";
                $this->db->exec($sql);

            }
            
        }

        else{

            $sql = "INSERT INTO connection(num, time, ip)
            VALUES(0, $this->time, '$ip')";
            $this->db->exec($sql) or $this->db->lastErrorMsg();   
            
        }
       
    }

    protected function db2Arr(SQLite3Result $data){
        $arr = [];
        while($row = $data->fetchArray(SQLITE3_ASSOC))
          $arr[] = $row;
        return $arr;
    }

    public function check(){
        
        return $this->response;
    }
}
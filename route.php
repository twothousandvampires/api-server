<?

class Route{

    public $params = [];
    public $route_string = '/';

    public function __construct(){

        $this->uri = $_SERVER['REQUEST_URI']. '/';

        $this->method = $_SERVER['REQUEST_METHOD'];
        
        $this->params_name = explode('/',trim($this->uri,'/'));

    }


    public function get($path_string, $func){
    
        $mass = explode('/',trim($path_string,'/'));
        if($this->method === 'GET'){
            
            for($i = 0; $i < count($mass); $i++){
                if($mass[$i][0] != ":"){
                    $this->route_string .= $mass[$i] . '/';
                }
                else{
                    if(isset($this->params_name[$i])){
                        $this->params[] = $this->params_name[$i];
                        $this->route_string .= $this->params_name[$i] . '/';  
                    }                            
                }
            }
           
        }
       if($this->uri === $this->route_string){           
         call_user_func($func,...$this->params);       
       }
       else{
        $this->params = [];
        $this->route_string = '/';
       }
          
    }  
    
    public function post($path_string, $func){
        if($this->uri === $path_string){
            call_user_func($func);
        }
    }
}
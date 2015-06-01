<?php
//"Main" class
error_reporting(E_ALL);
ini_set('display_errors', 1);
class Main {

  
    function __construct() {
        
             $url = isset($_GET['url']) ? $_GET['url'] : null;
             $url = $this->trimURL($url);
             $url = $this->explodeURl($url);
             
             if (empty($url[0])) {
			require 'controllers/index.php';
			$controller = new Index();
			$controller->index();
			return false;
		}
             
             $file =   $this->getFilePath($url[0]);
             if(file_exists($file))
             {
                 require $file;   
             }
             else{
                 $this->error();
                 return false;
             }  
             
             //instanciate controller and model 
             
             $controller = new $url[0];
             $controller->loadModel($url[0]);
             
           // calling methods
		if(isset($url[3]) && isset($url[2]))
                {
          
                    if (method_exists($controller, $url[1])) { //check if method exit 
				
                                if(isset($url[2]) && $url[3]){
                                    $controller->{$url[1]}($url[2], $url[3]); //run the method
                                }else{
                                    header('location: '.URL.$url[0]);
                                }
			}
                        else {
				header('location: '.URL.$url[0]);
			}
                }
                else if (isset($url[2])) //check method with input is set 
                { 
                    $one = 1;
                    //check if method should have 2 param
                    $method = new ReflectionMethod($controller, $url[1]);
                    $methodParamCount = $method->getNumberOfRequiredParameters();
                    
                    if($methodParamCount > $one){
                        header('location: '.URL.$url[0]);
                    }else{
                            if (method_exists($controller, $url[1])) { //check if method exit 
                                if(isset($url[2])){
                                    $controller->{$url[1]}($url[2]); //run the method
                                }else{
                                    header('location: '.URL.$url[0]);
                                }

                            } 
                            else {
                                    header('location: '.URL.$url[0]);
                            }
                    }
		} 
                else {  //if method with put does not exist
              
			if (isset($url[1])) { //check if method is set
				if (method_exists($controller, $url[1])) 
                                { //check if methos exist in class
                                        if($this->isMethodwithParam($url[0], $url[1])){
                                            $controller->{$url[1]}();//run method 
                                        }else{
                                            header('location: '.URL.$url[0]);
                                        }
					     
				} else {
					header('location: '.URL.$url[0]); //else just run the default index
				}
			} else {
				$controller->index(); //if method is not set, run default index
			}
		}
             
    }
    
    private function isMethodwithParam($class, $method){
        $r = new ReflectionMethod($class, $method);
         $params = $r->getParameters();      
         if(count($params) === ZERO){
             return true;
         }else{
             false;
         }
    }
    
    
    private function trimURL($url)
    {
        return rtrim($url, '/');
    }
   private function explodeURl($url)
    {
        return explode('/', $url);
    }
    private function getFilePath($url)
    {
        return Controller.''.$url.'.php';
    }
  
    private function error(){
            $url[0] = "";
            $url[0] = "Error";
            
            $file = $this->getFilePath($url[0]);
            
            require $file;
            $controller = new $url[0];
            $controller->index();
            $controller->loadModel($url[0]);
            return false;
        
        }

    
}

<?php


namespace Source\Support;


class Auth {
    
   private $data;
    
    public function __construct() {
        
        $data = $this->data;
       
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
        $this->create();
    }
    
    public function create():void {
        
        $this->data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
        
        if($this->data){
         var_dump($this->data);   
        }
        
        
        
    }
    
}

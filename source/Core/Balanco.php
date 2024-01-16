<?php


namespace Source\Core;


class Balanco {
    
    public function __construct() {
        
    }
    
    public function entradas() {
        
        if(!empty($_SESSION['carteira'])){
            
                                    
            $entradas = new \Source\Models\Read();
            $entradas->ExeRead("app_faturas", "WHERE user_id = :id AND modo = :m AND status = :s AND carteira_id = :c", "id={$_SESSION['user_id']}&m=entrada&s=paid&c={$_SESSION['carteira']}");
            $entradas->getResult();
            $entradageral = 0;
            
           
            foreach ($entradas->getResult() as $value) {
                $entradageral =+ $value['valor'];
            }
            
            return $entradageral;
            
        }else{
            
             $entradas = new \Source\Models\Read();
            $entradas->ExeRead("app_faturas", "WHERE user_id = :id AND modo = :m AND status = :s", "id={$_SESSION['user_id']}&m=entrada&s=paid");
            $entradas->getResult();
            $entradageral = 0;

            foreach ($entradas->getResult() as $value) {
                $entradageral =+ $value['valor'];
            }
            
            return $entradageral;
 
        }

        
    }
    
    
    public function saidas() {
        
    }
    
    
    
    
    
}

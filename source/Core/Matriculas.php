<?php



namespace Source\Core;


class Matriculas {
    
    public function __construct() {
        
        $this->matricula();
    }
    
    public function matricula() {
        $read = new \Source\Models\Read();
        $read->ExeRead("app_planos", "WHERE id = :id ", "id={$_SESSION["nivel"]}");
        $read->getResult();
        if($read->getResult()){
       echo $read->getResult()[0]["name"];
        }else{
            echo "FREE";
        }
       
    }
}

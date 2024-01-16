<?php


namespace Source\Core;


class Agenda {
    
    private $filtro;
    
    public function __construct() {
        
        $filtro = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
        
        $this->filtro = $filtro;
        
    }
    
    public function cadastra() {
        
        if(!empty($this->filtro["cadastra"])){
          
            $valor = $this->filtro["title"];
            $valor = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($valor)));
            
            if(!empty($_SESSION["pedido_id"])){
                $pedido_id = $_SESSION["pedido_id"];
               
            }else{
                $pedido_id = null;
                
            }
            
            $Dados = [
                "title" => $valor,
                "start" => $this->filtro["start_dia"] . " " .trim($this->filtro["start_horas"]) . ":" . $this->filtro["start_minutos"] . ":00", 
                "end" => $this->filtro["end_dia"] . " " .trim($this->filtro["end_horas"]) . ":" . $this->filtro["end_minutos"] . ":00" ,
                "color" => $this->filtro["color"],
                "user_id" => $_SESSION["user_id"],
                "os" => $pedido_id
            ];
            
           // var_dump($Dados);
            
            $cadastra = new \Source\Models\Create();
            $cadastra->ExeCreate("eventos", $Dados);
            $cadastra->getResult();
            if($cadastra->getResult()){
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
                <h5>Evento Cadastrado com Sucesso </h5>  </div>";
            }else{
                echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
                <h5>Erro ao cadastrar </h5>  </div>";
            }
            
           // var_dump($this->filtro , $Dados);
        }
        
    }
    
    public function buscar() {
        if(!empty($this->filtro["search"])){
            var_dump($this->filtro);
        }
        
    }
}

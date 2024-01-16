<?php

namespace Source\Core;

class Contratos {

    private $filtro;

    public function __construct() {
        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->filtro = $filtro;
    }

    public function cadastra() {

        if ($this->filtro) {

            
            $cad = new \Source\Models\Create();
            $cad->ExeCreate("contracts", $this->filtro);
            $cad->getResult();
            if($cad->getResult()){
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
                <h5>Contrato cadastrado com sucesso  </h5>  </div>";
            }else{
                echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
                <h5>Erro ao cadastrar Contrato </h5>  </div>";
            }
            
           // var_dump($this->filtro , $Dados);
        }
    }
    
    public function editar() {
        
        if($this->filtro){

            $update = new \Source\Models\Update();
            $update->ExeUpdate("contracts", $this->filtro, "WHERE id = :id", "id={$_GET["update"]}");
            $update->getResult();
            if($update->getResult()){
                 echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
                <h5>Contrato editado com sucesso  </h5>  </div>";
            }else{
                 echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
                <h5>Erro ao atualizar contrato  </h5>  </div>";
            }

        }
        
    }
    
    public function delete() {
        if(!empty($_GET["delete"])){
            
            $delete = new \Source\Models\Delete();
            $delete->ExeDelete("contracts", "WHERE id = :id", "id={$_GET["delete"]}");
            $delete->getResult();
            if($delete->getResult()){
                 echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
                <h5>Contrato deletado com sucesso  </h5>  </div>";
            }else{
                 echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
                <h5>Erro ao deletar contrato  </h5>  </div>";
            }
        }
    }

}

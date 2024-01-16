<?php

namespace Source\Core;

class CategoriaEstoque {

    private $filtro;

    public function __construct() {
        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->filtro = $filtro;
    }

    public function cadastra() {
        if (!empty($this->filtro)) {
            //var_dump($this->filtro);
            $Dados = [
                "user_id" => $_SESSION["user_id"],
                "categoria" => $this->filtro["estoque"]
            ];

            $cad = new \Source\Models\Create();
            $cad->ExeCreate("app_categ_estoque", $Dados);
            $cad->getResult();
            if ($cad->getResult()) {
                
            } else {
                
            }
        }
    }

    public function editar() {
        if(!empty($this->filtro)){
            
            $Dados = [
                "categoria" => $this->filtro["estoque"]
                
                ];
            
            $up = new \Source\Models\Update();
            $up->ExeUpdate("app_categ_estoque", $Dados, "WHERE id = :a", "a={$this->filtro["id"]}");
            $up->getResult();
            if($up->getResult()){
               echo "<div class='alert alert-success'> Categoria Editada com Sucesso </div>"; 
            }else{
                echo "<div class='alert alert-danger'> Erro ao editar categoria </div>";  
            }
            
        }
    }

    public function deletar() {
        
        $del = new \Source\Models\Delete();
        $del->ExeDelete("app_categ_estoque", "WHERE id = :a", "a={$_GET["deletar"]}");
        $del->getResult();
        if($del->getResult()){
           echo "<div class='alert alert-success'>Categoria excluida com Sucesso </div>"; 
        }else{
          echo "<div class='alert alert-danger'>Erro ao deletar categoria </div>";   
        }
    }

}

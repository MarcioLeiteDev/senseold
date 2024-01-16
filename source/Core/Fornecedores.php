<?php



namespace Source\Core;


class Fornecedores {
    private $filtro;
    
    public function __construct() {
        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->filtro = $filtro;
    }
    
    public function cadastra() {
        
        if(!empty($this->filtro)){
            
         $this->filtro["user_id"] = $_SESSION["user_id"]; 
         unset($this->filtro["files"]);
         
         $Dados = [
             "user_id" => $_SESSION["user_id"],
             "empresa" => $this->filtro["empresa"],
             "cnpj" => $this->filtro["cnpj"],
             "telefone" => $this->filtro["telefone"],
             "email" => $this->filtro["email"],
             "site" => $this->filtro["site"],
             "cep" => $this->filtro["cep"],
             "logradouro" => $this->filtro["logradouro"],
             "numero" => $this->filtro["numero"],
             "complemento" => $this->filtro["complemento"],
             "bairro" => $this->filtro["bairro"],
             "cidade" => $this->filtro["cidade"],
             "uf" => $this->filtro["uf"],
             "obs" => $this->filtro["obs"]
         ];
         
         $cad = new \Source\Models\Create();
         $cad->ExeCreate("app_fornecedor", $Dados);
         $cad->getResult();
         if($cad->getResult()){
            echo "<div class='alert alert-success'>  Fornecedor cadastrado com sucesso</div>"; 
         }else{
            echo "<div class='alert alert-danger'>  Erro ao cadastrar </div>";   
         }
            
           // var_dump($this->filtro , $Dados);
        }
        
    }
    
    public function editar() {
        
        if(!empty($_GET["editar"])){
             $Dados = [
             "user_id" => $_SESSION["user_id"],
             "empresa" => $this->filtro["empresa"],
             "cnpj" => $this->filtro["cnpj"],
             "telefone" => $this->filtro["telefone"],
             "email" => $this->filtro["email"],
             "site" => $this->filtro["site"],
             "cep" => $this->filtro["cep"],
             "logradouro" => $this->filtro["logradouro"],
             "numero" => $this->filtro["numero"],
             "complemento" => $this->filtro["complemento"],
             "bairro" => $this->filtro["bairro"],
             "cidade" => $this->filtro["cidade"],
             "uf" => $this->filtro["uf"],
             "obs" => $this->filtro["obs"]
         ];
             
             $update = new \Source\Models\Update();
             $update->ExeUpdate("app_fornecedor", $Dados, "WHERE id = :a", "a={$_GET["editar"]}");
             $update->getResult();
             if($update->getResult()){
                echo "<div class='alert alert-success'> Fornecedor atualizado com sucesso </div>"; 
             }else{
                 echo "<div class='alert alert-danger'> Erro ao atualizar fornecedor </div>";  
             }
           // var_dump($this->filtro);
        }
        
    }
    
    public function deletar() {
        if(!empty($_GET["deletar"])){
            $del = new \Source\Models\Delete();
            $del->ExeDelete("app_fornecedor", "WHERE id = :a", "a={$_GET["deletar"]}");
            $del->getResult();
            if($del->getResult()){
               echo "<div class='alert alert-success'>Fornecedor Deletado com Sucesso </div>"; 
            }else{
             echo "<div class='alert alert-danger'>Erro ao deletar Fornecedor  </div>";    
            }
        }
        
    }
}

<?php



namespace Source\Core;


class Servicos {
    
    private $filtro;
    
    public function __construct() {
        
        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
       
        $this->filtro = $filtro;
       
    }
    
    public function Arquivos() {
        
         if (!empty($_FILES["archive"])) {
             
             $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
             
                $Image = $_FILES["archive"];
                
                $upload = new \Source\Support\Upload("./uploads/");
                $upload->File($Image);
                $upload->getResult();
                
                $arquivo = $upload->getResult();
                
                $Dados = [
                   "user_id" => $filtro["user_id"],
                    "employer" => $filtro["employer"],
                    "service_id" => $filtro["service_id"],
                    "archive" => $arquivo,
                    "budget" => $filtro["budget"],
                    "status" => 1
                    
                ];
                
                $cad = new \Source\Models\Create();
                $cad->ExeCreate("archives", $Dados);
                $cad->getResult();
                if($cad->getResult()){
                    echo "<p class='alert alert-success'> Arquivo cadastrado com sucesso</p>";
                    /**
                     * Notifica por e-mail envio do arquivo
                     */
                     //cria template do e-mail
                $view = new \Source\Models\View(__DIR__ . "/../../themes/views/email");
                $message = $view->render("notificacao", [
                    "servico" => $filtro["service_id"]
                  
                ]);

                $email = new \Source\Support\Email();
                $email->bootstrap(
                        "Notificação de envio de arquivos Serviço {$filtro["service_id"]} ",
                        $message,
                        "bruno@sensetranslate.com",
                        "Sense Translate"
                )->send();

                    
                }else{
                   echo "<p class='alert alert-danger'> Erro </p>";  
                }
     

         }
        
    }
    
    public function cadastra(){
        
        if(!empty($this->filtro)){
            
            $this->filtro["employer"] = $_SESSION["user_id"];
            $this->filtro["data"] = date("Y-m-d");
            $this->filtro["status"] = 1 ;
            $this->filtro["budget"] = 0 ;
            
            $cad = new \Source\Models\Create();
            $cad->ExeCreate("services", $this->filtro);
            $cad->getResult();
            if($cad->getResult()){
              echo "<div class='alert alert-success'>Serviço cadastrado com sucesso </div>";  
            }else{
              echo "<div class='alert alert-danger'>Error </div>";     
            }
            
           // var_dump($this->filtro);
        }
        
    }
    
    public function update(){
        
        if(!empty($this->filtro)){
            
            $update = new \Source\Models\Update();
            $update->ExeUpdate("services", $this->filtro , "WHERE id = :a", "a={$_GET["update"]}");
            $update->getResult();
            if($update->getResult()){
                echo "<div class='alert alert-success'> Atualizado com sucesso</div>";
            }else{
               echo "<div class='alert alert-danger'> Error</div>"; 
            }
            
            // var_dump($this->filtro);
        }
        
    }
    
    public function AlteraContrato() {
        
        if($this->filtro){
            $Dados = [
                "contract" => $this->filtro["contract"]
            ];
            $update = new \Source\Models\Update();
            $update->ExeUpdate("services", $Dados, "WHERE id = :a", "a={$this->filtro["id"]}");
            $update->getResult();
            if($update->getResult()){
               echo "<p class='alert alert-success'>Contrato atualizado com Sucesso</p>"; 
            }else{
               echo "<p class='alert alert-danger'>Erro ao atualizar.</p>"; 
            }
            //var_dump($this->filtro);
        }
        
    }
    
    public function destroy() {
        
        $delete = new \Source\Models\Delete();
        $delete->ExeDelete("services", "WHERE id = :a", "a={$_GET["id"]}");
        $delete->getResult();
        if($delete->getResult()){
             echo "<p class='alert alert-success'>Serviço Deletado com sucesso</p>"; 
           echo "<meta http-equiv=\"refresh\" content=\"3; URL='index.php?p=servico'\"/>"; 
        }else{
           echo "<p class='alert alert-danger'>ERROR</p>";  
        }
        
    }
}

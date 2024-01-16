<?php

namespace Source\Core;

class Orcamento {

    private $filtro;

    public function __construct() {

        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->filtro = $filtro;
    }

    public function cadastra() {

        if (!empty($this->filtro["phone"])) {

            $this->filtro["phone"] = str_replace("(", "", $this->filtro["phone"]);
            $this->filtro["phone"] = str_replace(")", "", $this->filtro["phone"]);
            $this->filtro["phone"] = str_replace("-", "", $this->filtro["phone"]);

            $this->filtro["price"] = str_replace(".", "", $this->filtro["price"]);
            $this->filtro["price"] = str_replace(",", "", $this->filtro["price"]);

            $data = date("Y-m-d");
            
            if(isset($this->filtro["user_id"])){
                $user_id = $this->filtro["user_id"];
                
            }else{
                
                $user_id = $_SESSION["user_id"];
            }

            $Dados = [
                "user_id" => $user_id,
                "name" => $this->filtro["name"],
                "email" => $this->filtro["email"],
                "phone" => $this->filtro["phone"],
                "content" => $this->filtro["content"],
                "status" => '1',
                "price" => $this->filtro["price"],
                "payment_method" => $this->filtro["payment_method"],
                "data" => $data
            ];

            //var_dump($Dados);

            $cad = new \Source\Models\Create();
            $cad->ExeCreate("budget", $Dados);
            $cad->getResult();
            if ($cad->getResult()) {
                echo "<div class='alert alert-success'>Orçamento cadastrado com sucesso </div>";
            } else {
                echo "<div class='alert alert-danger'>Erro ao cadastrar Orçamento </div>";
            }

            //var_dump($this->filtro , $Dados);
        }
    }

    public function delete() {

        $filtro = filter_input(INPUT_GET, "delete", FILTER_DEFAULT);

        if (!empty(($filtro))) {
            $delete = new \Source\Models\Delete();
            $delete->ExeDelete("budget", "WHERE id = :a", "a={$filtro}");
            $delete->getResult();
            if ($delete->getResult()) {
                echo "<p class='alert alert-success'> Orçamento excluido com sucesso</p>";
                // sleep(5);

                echo "<meta http-equiv=\"refresh\" content=\"2; URL='index.php?p=orcamento'\"/>
";
            } else {
                echo "<p class='alert alert-danger'>Erro ao deletar Orçamento. </p>";
            }
        }
    }

    public function enviarEmail() {

        $data = filter_input_array(INPUT_GET, FILTER_DEFAULT);

        if (!empty($data["content"])) {



            $Dados = [
                "status" => 2
            ];

            $updateStatus = new \Source\Models\Update();
            $updateStatus->ExeUpdate("budget", $Dados, "WHERE id = :a", "a={$data["content"]}");



            $view = new \Source\Models\View(__DIR__ . "/../../themes/views/email");
            $message = $view->render("mail", [
                "nome" => $data['name'],
                "email" => $data['email'],
                "telefone" => $data['phone'],
                "content" => $data["content"]
            ]);

            $email = new \Source\Support\Email();
            $email->bootstrap(
                    "Orçamento Sense Translate",
                    $message,
                    "{$data['email']}",
                    "{$data['name']}"
            )->send();


            if ($email->send()) {
                echo $message = "<div class=\"alert alert-success\" role=\"alert\">
                Orçamento enviado com sucesso para email  {$data['email']} . </div>";
            } else {
                echo $message = "<div class=\"alert alert-danger\" role=\"alert\">
                Erro ao cadastrar usuário</div>";
            }
        }
    }

    public function editar() {

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);


        if (!empty($data["content"])) {
            $update = new \Source\Models\Update();
            $update->ExeUpdate("budget", $data, "WHERE id = :a", "a={$data["id"]}");
            $update->getResult();

            if ($update->getResult()) {
                echo "<p class='alert alert-success'>Orçamento editado com sucesso</p>";

                if ($data["status"] == 3) {

                    $bytes = openssl_random_pseudo_bytes(4);
                    $senha = bin2hex($bytes);
                   // echo "Senha ". $senha;
                    
                    $pass = password_hash($senha, CONF_PASSWD_ALGO);

                    $Dados = [
                        "name" => $data["name"],
                        "email" => $data["email"],
                        "level" => 1,
                        "password" => $pass,
                        "user_id" => $_SESSION["user_id"]
                    ];
                    
                    //var_dump($Dados);
                    //Cria o usuario
                    $cad = new \Source\Models\Create();
                    $cad->ExeCreate("users", $Dados);
                    $cad->getResult();
                    if($cad->getResult()){
                       echo "<p class='alert alert-success'>Usuario cadastrado com sucesso</p>"; 
                    }else{
                       echo "<p class='alert alert-danger'>Erro cadastrar cliente</p>";  
                    }
                    
                    //verifica id do cliente
                    $verid = new \Source\Models\Read();
                    $verid->ExeRead("users", "WHERE email = :a", "a={$data["email"]}");
                    
                    $id = $verid->getResult()[0]["id"];
                    
//                    //Cria o Serviço
                   $Services = [
                        "user_id" => $id,
                       "budget" => $data["id"],
                       "employer" => $_SESSION['user_id'],
                       "name" => $data["name"],
                       "method_payment" => $data["payment_method"],
                       "price" => $data["price"],
                       "data" => date("Y-m-d")
                       
                   ];
                   
                   $cadServ = new \Source\Models\Create();
                   $cadServ->ExeCreate("services", $Services);
                    
                    
                     //Envia o E-mail de Notificação
                $view = new \Source\Models\View(__DIR__ . "/../../themes/views/email");
                $message = $view->render("confirm", [
                    "first_name" => $data['name'],
                    "email" => $data['email'],
                    "password" => $senha,
                    "confirm_link" => CONF_URL_BASE . "/obrigado&email={$data['email']}&token=" . base64_encode($data['email'])
                ]);

                $email = new \Source\Support\Email();
                $email->bootstrap(
                        "Seja bem vindo a Sense Translate",
                        $message,
                        "{$data['email']}",
                        "{$data['name']}"
                )->send();


                if ($email->send()) {
                    echo $message = "<div class=\"alert alert-success\" role=\"alert\">
               E-mail de notificação enviado com sucesso para {$data['email']}  </div>";
                } else {
                    echo $message = "<div class=\"alert alert-danger\" role=\"alert\">
                Erro ao cadastrar usuário</div>";
                }


                  //  var_dump($Dados);
                }
            } else {
                echo "<p class='alert alert-danger'>Erro ao editar orçamento</p>";
            }
            // var_dump($data);
        }
    }

}

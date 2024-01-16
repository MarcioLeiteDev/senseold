<?php

namespace Source\Core;

class Clientes {

    private $filtro;

    public function __construct() {

        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->filtro = $filtro;
    }

    public function cadastra() {


        if ($this->filtro) {

            $bytes = openssl_random_pseudo_bytes(4);
            $senha = bin2hex($bytes);

            //transforma a senha em uma hash
            $pass = password_hash($senha, CONF_PASSWD_ALGO);


            $Dados = [
                "user_id" => intval($_SESSION["user_id"]),
                "name" => $this->filtro["name"],
                "email" => $this->filtro["email"],
                "password" => $pass,
                "phone" => $this->filtro["phone"],
                "cep" => $this->filtro["cep"],
                "logradouro" => $this->filtro["endereco"],
                "numero" => $this->filtro["numero"],
                "complemento" => $this->filtro["complemento"],
                "bairro" => $this->filtro["bairro"],
                "cidade" => $this->filtro["cidade"],
                "uf" => $this->filtro["uf"],
                "level" => 1,
            ];

        

            $cadastra = new \Source\Models\Create();
            $cadastra->ExeCreate("users", $Dados);
            $cadastra->getResult();
            
            if($cadastra->getResult()){
                 echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
               <h5> Cliente cadastrado com sucesso </h5>  </div>";
                 
                //cria template do e-mail
                $view = new \Source\Models\View(__DIR__ . "/../../themes/views/email");
                $message = $view->render("confirm", [
                    "first_name" => $this->filtro['name'],
                    "email" => $this->filtro['email'],
                    "password" => $senha,
                    "confirm_link" => CONF_URL_BASE . "/obrigado&email={$this->filtro['email']}&token=" . base64_encode($this->filtro['email'])
                ]);

                $email = new \Source\Support\Email();
                $email->bootstrap(
                        "Seja bem vindo a Sense Translate",
                        $message,
                        "{$this->filtro['email']}",
                        "{$this->filtro['name']}"
                )->send();


                if ($email->send()) {
                    echo $message = "<div class=\"alert alert-success\" role=\"alert\">
                Usuário cadastrado com sucesso, acesse seu e-mail {$this->filtro['email']} e confirme seu cadastro </div>";
                } else {
                    echo $message = "<div class=\"alert alert-danger\" role=\"alert\">
                Erro ao cadastrar usuário</div>";
                }
            }else{
                echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
               <h5> Erro  </h5>  </div>";
            }
        }
    }

    public function atualiza() {

        unset($this->filtro["editar"]);

        if ($this->filtro) {


            $this->filtro["logradouro"] =  $this->filtro["endereco"];
            
            unset($this->filtro["endereco"]);
            
            $update = new \Source\Models\Update();
            $update->ExeUpdate("users", $this->filtro, "WHERE id = :id",
                    "id={$_GET["id"]}");
            $update->getResult();
            if ($update->getResult()) {
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
               <h5> Sucesso atualizar cliente  </h5>  </div>";
               
            } else {
                echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
               <h5> Erro atualziar cliente </h5>  </div>";
            }
           
        }
    }

    public function atualizaEndereco() {

        if ($this->filtro) {
            $update = new \Source\Models\Update();
            $update->ExeUpdate("app_enderecos", $this->filtro, "WHERE id = :id", "id={$this->filtro["id"]}");
            $update->getResult();
            if ($update->getResult()) {
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
               <h5> Atualizado com sucesso  </h5>  </div>";
            } else {
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
               <h5> Erro ao atualizar  </h5>  </div>";
            }
            // var_dump($this->filtro);
        }
    }

    public function sessaoCliente() {
        //cria a sessão cliente
        $cli = new \Source\Models\Read();
        $cli->ExeRead("app_clientes", "WHERE user_id = :id ORDER BY id DESC", "id={$_SESSION["user_id"]}");
        $cli->getResult();

        if ($cli->getResult()) {
            $id = $cli->getResult()[0]["cliente_id"];
        } else {
            $id = 0;
        }

        return $_SESSION["cliente_id"] = $id + 1;

        //  var_dump($_SESSION["cliente_id"]);
    }

    public function endereco() {

        if ($this->filtro) {

            $Dados = [
                "user_id" => intval($this->filtro["user_id"]),
                "cliente_id" => intval($this->filtro["cliente_id"]),
                "cep" => $this->filtro["cep"],
                "logradouro" => $this->filtro["logradouro"],
                "cliente_id" => $this->filtro["cliente_id"],
                "complemento" => $this->filtro["complemento"],
                "bairro" => $this->filtro["bairro"],
                "cidade" => $this->filtro["cidade"],
                "uf" => $this->filtro["uf"],
                "tipo" => intval($this->filtro["tipo"]),
            ];

            $registra = new \Source\Models\Create();
            $registra->ExeCreate("app_enderecos", $Dados);
            $registra->getResult();
            if ($registra->getResult()) {
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
               <h5> Endereço Cadastrado com sucesso  </h5>  </div>";
            } else {
                echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
               <h5> Erro ao cadastrar  </h5>  </div>";
            }


            // var_dump( $Dados);
        }
    }

    public function contatos() {

        if ($this->filtro) {
            $this->filtro["user_id"] = $_SESSION["user_id"];
            $this->filtro["cliente_id"] = $_SESSION["cliente_id"];

            $reg = new \Source\Models\Create();
            $reg->ExeCreate("app_contatos", $this->filtro);
            $reg->getResult();
            if ($reg->getResult()) {
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
               <h5> <b>{$this->filtro["tipo"]}</b> Cadastrado com sucesso  </h5>  </div>";
            } else {
                echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
               <h5> Erro ao cadastrar  </h5>  </div>";
            }

            //  var_dump($this->filtro);
        }
    }
    
    public function destroy() {
        
        //$valor = $_GET["delete"];
        $delete = new \Source\Models\Delete();
        $delete->ExeDelete("users", "WHERE id = :a", "a={$_GET["delete"]}");
        $delete->getResult();
        if($delete->getResult()){
            echo "<div class='alert alert-success'>Cliente deletado com sucesso</div>";
            
            echo "<meta http-equiv=\"refresh\" content=\"3; URL='index.php?p=cliente'\"/>";

        }else{
            echo "<div class='alert alert-danger'>Erro deletar cliente</div>";
        }
        
    }

}

<?php

namespace Source\Core;

class Usuarios {

    private $data;

    public function __construct() {

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->data = $data;

        // var_dump($data);
    }

    public function cadastra() {

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $message = "<div class=\"alert alert-info\" role=\"alert\">
                Cadastre-se Grátis </div>";

        //se existir envio de formulario
        if (!empty($data)) {
            //se formulario estiver vasio
            if ($data["name"] == null) {
                echo $message = "<div class=\"alert alert-warning\" role=\"alert\">
                Você precisa enviar os dados via formulário; </div>";
            }

            //verifica se o email é valido
            $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
            if ($email == false) {
                echo $message = "<div class=\"alert alert-warning\" role=\"alert\">
                Você precisa informar um e-mail válido; </div>";
            }

            //verifica se já não existe um usuario na base
            $verifica = new \Source\Models\Read();
            $verifica->ExeRead("users", "WHERE email = :email", "email={$data['email']}");
            $verifica->getResult();

            if ($verifica->getResult()) {
                echo $message = "<div class=\"alert alert-warning\" role=\"alert\">
                Já existe um usuário com email <b>{$data['email']}</b> cadastrado no sistema; </div>";
            }
            //verifica se senha esta de acordo com a regra
            // echo "Aqui a senha" . $data["password"];
            if ($data["password"] < 4) {
                echo $message = "<div class=\"alert alert-warning\" role=\"alert\">
                A senha precisa ter mais de 4 caracteres</div>";
            }

            $senha = $data['password'];

            //transforma a senha em uma hash
            $pass = password_hash($data['password'], CONF_PASSWD_ALGO);

            //cadastra usuario no banco
            $cad = new \Source\Models\Create();

            $data["password"] = $pass;
            unset($data["register"]);

            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');

            $cad->ExeCreate("users", $data);
            $cad->getResult();
            if ($cad->getResult()) {
                //envia e-mail de boas vindas
                //cria template do e-mail
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
                Usuário cadastrado com sucesso, acesse seu e-mail {$data['email']} e confirme seu cadastro </div>";
                } else {
                    echo $message = "<div class=\"alert alert-danger\" role=\"alert\">
                Erro ao cadastrar usuário</div>";
                }
            }
        }
    }

    public function recuperar() {

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);


        if (!empty($data)) {

            //verifica se usuario existe
            $read = new \Source\Models\Read();
            $read->ExeRead("users", "WHERE email = :e", "e={$data['email']}");
            $read->getResult();

            if (empty($read->getResult())) {
                echo $message = "<div class=\"alert alert-warning\" role=\"alert\">
                E-mail não encotrado no sistema; </div>";
            }

            $view = new \Source\Models\View(__DIR__ . "/../../themes/views/email");
            $message = $view->render("forget", [
                "first_name" => $read->getResult()[0]['name'],
                "forget_link" => CONF_URL_BASE . "/recuperar-senha&email={$read->getResult()[0]['email']}&token=" . base64_encode($read->getResult()[0]['email'])
            ]);

            $email = new \Source\Support\Email();
            $email->bootstrap(
                    "Recuperação de senha Sense Translate",
                    $message,
                    "{$read->getResult()[0]['email']}",
                    "{$read->getResult()[0]['name']}"
            )->send();

            if ($email->send()) {
                echo $message = "<div class=\"alert alert-success\" role=\"alert\">
                E-mail de recuperação enviado com sucesso para {$data['email']} </div>";
            }
        }
    }

    public function alterar() {

        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
        $message = "";

        if (!empty($data)) {

            $ref = filter_input_array(INPUT_GET, FILTER_DEFAULT);
            if (!empty($ref['email'])) {
                $email = $ref['email'];
                $token = $ref['token'];
            }

            $email = $data['email'];
            $token = $data['token'];

            if ($data['password'] != $data['repassword']) {
                echo $message = "<div class=\"alert alert-danger\" role=\"alert\">
                Senha são diferentes </div>";
            }

            $pass = password_hash($data['password'], CONF_PASSWD_ALGO);

            $update = new \Source\Models\Update();
            $Dados = [
                "password" => $pass
            ];
            $update->ExeUpdate("users", $Dados, "WHERE email = :email", "email={$data['email']}");
            $update->getResult();

            if ($update->getResult()) {
                echo $message = "<div class=\"alert alert-success\" role=\"alert\">
                Senha alterada com sucesso  </div>";
            } else {
                echo $message = "<div class=\"alert alert-danger\" role=\"alert\">
               Erro ao cadastrar </div>";
            }
        }
    }

    public function deletar() {

        $data = filter_input(INPUT_GET, "delete", FILTER_DEFAULT);

        if (!empty($data)) {
            $delete = new \Source\Models\Delete();
            $delete->ExeDelete("users", "WHERE id = :a", "a={$data}");
            $delete->getResult();
            if ($delete->getConn()) {
                echo "<div class='alert alert-success'> Usuario deletado com sucesso </div>";
            } else {
                echo "<div class='alert alert-danger'> Erro ao deletar Usuario </div>";
            }
        }


        //var_dump($data);
    }

    public function editar() {

        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);

        if (!empty($data)) {
            
            $pass = password_hash($data['password'], CONF_PASSWD_ALGO);
            
            $data["password"] = $pass;

            $update = new \Source\Models\Update();
            $update->ExeUpdate("users", $data, "WHERE id = :a", "a={$_GET["id"]}");
            $update->getResult();

            if ($update->getResult()) {
                echo "<div class='alert alert-success'> Atualizado com sucesso </div>";
            } else {
                echo "<div class='alert alert-danger'> Erro ao atualizar </div>";
            }

            // var_dump($data);
        }
    }

}

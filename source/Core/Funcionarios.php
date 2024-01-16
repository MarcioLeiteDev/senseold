<?php



namespace Source\Core;


class Funcionarios {

    private $filtro;

    public function __construct() {
        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->filtro = $filtro;
    }

    public function cadastra() {

        if (!empty($this->filtro)) {
            $this->filtro["user_id"] = $_SESSION["user_id"];
            $this->filtro["salario"] = str_replace(",", "", $this->filtro["salario"]);
            $this->filtro["salario"] = str_replace(".", "", $this->filtro["salario"]);
            $this->filtro["vale_transporte"] = str_replace(",", "", $this->filtro["vale_transporte"]);
            $this->filtro["vale_transporte"] = str_replace(".", "", $this->filtro["vale_transporte"]);
            $this->filtro["vale_refeicao"] = str_replace(",", "", $this->filtro["vale_refeicao"]);
            $this->filtro["vale_refeicao"] = str_replace(".", "", $this->filtro["vale_refeicao"]);
            $this->filtro["data_nascimento"] = date("Y-m-d", strtotime($this->filtro["data_nascimento"]));
            $this->filtro["cadastrado"] = date("Y-m-d");
            // var_dump($this->filtro);

            $Dados = [
                "user_id" => $_SESSION["user_id"],
                "nome" => $this->filtro["nome"],
                "cpf" => $this->filtro["cpf"],
                "rg" => $this->filtro["rg"],
                "data_nascimento" => $this->filtro["data_nascimento"],
                "cep" => $this->filtro["cep"],
                "logradouro" => $this->filtro["logradouro"],
                "numero" => $this->filtro["numero"],
                "complemento" => $this->filtro["complemento"],
                "bairro" => $this->filtro["bairro"],
                "cidade" => $this->filtro["cidade"],
                "uf" => $this->filtro["uf"],
                "tipo" => $this->filtro["tipo"],
                "salario" => $this->filtro["salario"],
                "dia_salario" => $this->filtro["dia_salario"],
                "comissao" => $this->filtro["comissao"],
                "dia_comissao" => $this->filtro["dia_comissao"],
                "vale_transporte" => $this->filtro["vale_transporte"],
                "dia_transporte" => $this->filtro["dia_transporte"],
                "vale_refeicao" => $this->filtro["vale_refeicao"],
                "dia_refeicao" => $this->filtro["dia_refeicao"],
                "telefone" => $this->filtro["telefone"],
                "status" => $this->filtro["status"],
                "funcao" => $this->filtro["funcao"],
                "cadastrado" => date("Y-m-d")
            ];

            $cad = new \Source\Models\Create();
            $cad->ExeCreate("app_funcionarios", $Dados);
            $cad->getResult();
            if ($cad->getResult()) {
                echo "<div class='alert alert-success'>Funcionario cadastrado com sucesso </div>";
            } else {
                echo "<div class='alert alert-danger'>Erro ao cadastrar funcionario </div>";
            }
        }
    }

    public function deletar() {

        $delete = new \Source\Models\Delete();
        $delete->ExeDelete("app_funcionarios", "WHERE id = :a", "a={$_GET["deletar"]}");
        $delete->getResult();
        if ($delete->getResult()) {
            echo "<div class='alert alert-success'> Funcionario Excluido com SUcesso </div>";
        } else {
            echo "<div class='alert alert-danger'> Erro ao deletar Funcionario </div>";
        }
    }

    public function editar() {
        if (!empty($this->filtro)) {

            $this->filtro["user_id"] = $_SESSION["user_id"];
            $this->filtro["salario"] = str_replace(",", "", $this->filtro["salario"]);
            $this->filtro["salario"] = str_replace(".", "", $this->filtro["salario"]);
            $this->filtro["vale_transporte"] = str_replace(",", "", $this->filtro["vale_transporte"]);
            $this->filtro["vale_transporte"] = str_replace(".", "", $this->filtro["vale_transporte"]);
            $this->filtro["vale_refeicao"] = str_replace(",", "", $this->filtro["vale_refeicao"]);
            $this->filtro["vale_refeicao"] = str_replace(".", "", $this->filtro["vale_refeicao"]);
            $this->filtro["data_nascimento"] = date("Y-m-d", strtotime($this->filtro["data_nascimento"]));

            $update = new \Source\Models\Update();
            $update->ExeUpdate("app_funcionarios", $this->filtro, "WHERE id = :a", "a={$_GET["editar"]}");
            $update->getResult();
            if ($update->getResult()) {
                echo "<div class='alert alert-success'> Funcionário editado com Sucesso </div>";
            } else {
                echo "<div class='alert alert-danger'> Erro ao editar funcionario </div>";
            }
        }
    }

}


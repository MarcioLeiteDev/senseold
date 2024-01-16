<?php

namespace Source\Core;

class Planos {

    private $filtro;

    public function __construct() {
        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->filtro = $filtro;
    }

    public function cadastra() {

        if ($this->filtro["metodo"] == "cadastrar") {

            $this->filtro["valor"] = str_replace(".", "", $this->filtro["valor"]);
            $this->filtro["valor"] = str_replace(",", "", $this->filtro["valor"]);

            $Dados = [
                "user_id" => $_SESSION["user_id"],
                "plano" => $this->filtro["plano"],
                "descricao" => $this->filtro["descricao"],
                "valor" => $this->filtro["valor"],
                "periodo" => $this->filtro["periodo"]
            ];

            $cad = new \Source\Models\Create();
            $cad->ExeCreate("app_planos_user", $Dados);
            $cad->getResult();
            if ($cad->getResult()) {
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
                <h5>Plano cadastrado com sucesso  </h5>  </div>";
            } else {
                echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
                <h5>Erro ao cadastrar Plano </h5>  </div>";
            }
            // var_dump($this->filtro , $Dados);
        }
    }

    public function editar() {

        if ($this->filtro["metodo"] == "editar") {

            $this->filtro["valor"] = str_replace(".", "", $this->filtro["valor"]);
            $this->filtro["valor"] = str_replace(",", "", $this->filtro["valor"]);

            $Dados = [
                "user_id" => $_SESSION["user_id"],
                "plano" => $this->filtro["plano"],
                "descricao" => $this->filtro["descricao"],
                "valor" => $this->filtro["valor"],
                "periodo" => $this->filtro["periodo"]
            ];

            // var_dump($Dados);
            $update = new \Source\Models\Update();
            $update->ExeUpdate("app_planos_user", $Dados, "WHERE id = :id", "id={$this->filtro["id"]}");
            $update->getResult();
            if ($update->getResult()) {
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
                <h5>Plano editado com sucesso  </h5>  </div>";
            } else {
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
                <h5>Erro ao atualizar Plano  </h5>  </div>";
            }
        }
    }

    public function delete() {
        if (!empty($_GET["deletar"])) {

            $delete = new \Source\Models\Delete();
            $delete->ExeDelete("app_planos_user", "WHERE id = :id", "id={$_GET["deletar"]}");
            $delete->getResult();
            if ($delete->getResult()) {
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
                <h5>Plano deletado com sucesso  </h5>  </div>";
            } else {
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
                <h5>Erro ao deletar Plano  </h5>  </div>";
            }
        }
    }

}

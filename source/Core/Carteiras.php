<?php

namespace Source\Core;

class Carteiras {

    public $filtro;

    public function __construct() {
        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->filtro = $filtro;
    }

    public function carteiras() {

        $carteira = new \Source\Models\Read();
        $carteira->ExeRead("app_carterias", "WHERE user_id = :id", "id={$_SESSION["user_id"]}");
        $carteira->getResult();

        return $carteira->getResult();
    }

    public function buscar() {


       
    }

    public function entradas(){

            $m = date("m");
            $y = date("y");

            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :c  AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :a",
                    "c={$_SESSION["user_id"]}&m={$m}&y={$y}&a=entrada");
            $read->getResult();
            $total = 0;
            foreach ($read->getResult() as $value) {
                $total += $value["valor"];
            }

            return $total;
        
    }

    public function saidas() {

        if (!empty($this->filtro["periodo"])) {


            $p = $this->filtro["periodo"];
            if ($this->filtro["periodo"] == "todas") {
                
            } else {
                $trata = explode("/", $p);

                $m = $trata['0'];
                $y = $trata['1'];
            }

            $carteira = $this->filtro["carteira"];

            //  echo $m . $y . $carteira;

            if ($this->filtro["carteira"] == "geral") {

                if ($this->filtro["periodo"] == "todas") {
                    $read = new \Source\Models\Read();
                    $read->ExeRead("app_faturas", "WHERE user_id = :id  AND modo = :a",
                            "a=saida&id={$_SESSION["user_id"]}");
                } else {

                    $read = new \Source\Models\Read();
                    $read->ExeRead("app_faturas", "WHERE user_id = :id AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :a",
                            "m={$m}&y={$y}&a=saida&id={$_SESSION["user_id"]}");
                }
            } else {

                $carteira = $this->filtro["carteira"];
                if ($this->filtro["periodo"] == "todas") {
                    $read = new \Source\Models\Read();
                    $read->ExeRead("app_faturas", "WHERE carteira_id = :c  AND modo = :a",
                            "c={$carteira}&a=saida");
                } else {
                    $trata = explode("/", $p);

                    $m = $trata['0'];
                    $y = $trata['1'];

                    $read = new \Source\Models\Read();
                    $read->ExeRead("app_faturas", "WHERE carteira_id = :c AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :a",
                            "c={$carteira}&m={$m}&y={$y}&a=saida");
                }
            }
            $read->getResult();
            $total = 0;
            foreach ($read->getResult() as $value) {
                $total += $value["valor"];
            }

            return $total;
        } else {

            $m = date("m");
            $y = date("y");

            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :c AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :a",
                    "c={$_SESSION["user_id"]}&m={$m}&y={$y}&a=saida");
            $read->getResult();
            $total = 0;
            foreach ($read->getResult() as $value) {
                $total += $value["valor"];
            }

            return $total;
        }
    }

    public function balanco() {
        return $this->entradas() - $this->saidas();
    }

    public function cadastrar() {

        if (!empty($this->filtro["cadastra"])) {

            
            unset($this->filtro["cadastra"]);
            unset($this->filtro["periodo"]);
            unset($this->filtro["carteira"]);
            $this->filtro["free"] = 0;
            $create = new \Source\Models\Create();
            $create->ExeCreate("app_carterias", $this->filtro);
            $create->getResult();

            if ($create->getResult()) {
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
                <h5>Carteira Cadastrada com sucesso  </h5>  </div>";
            } else {
                echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
                <h5>Erro ao cadastrar carteira  </h5>  </div>";
            }
        }
    }
    
    public function deletar() {
        $filter = filter_input_array(INPUT_GET, FILTER_DEFAULT);
        
        if(!empty($filter["del"])){
            echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
                <h5>Você esta a ponto de deletar a carteria {$filter["del"]} , essa ação é irreversivel e apagará todos os dados de entrada e saida dessa carteira, tem certeza que deseja prosseguir, <a href='./?p=carteira&del={$filter["del"]}&confirm=yes'>clique aqui para deletar</a> </h5>  </div>";
          //var_dump($filter);  
        }
         if(!empty($filter["confirm"])){
             
             $deleta = new \Source\Models\Delete();
             $deleta->ExeDelete("app_carterias", "WHERE id = :id", "id={$filter["del"]}");
             $deleta->getResult();
             
             if($deleta->getResult()){
             
            echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
                <h5>Carteira deletada com suceeso </h5>  </div>";
             }else{
               echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
                <h5>Erro ao deletar carteira </h5>  </div>";   
             }
          
        }
        
        
        
        
    }

}

<?php

namespace Source\Core;

class SessaoCarteiras {

    public function __construct() {
        if (!session_id()) {
            session_start();
        }
    }

    public function sessaoCarteira() {
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

       // var_dump($data);

        if (!empty($data['carteira'])) {

            if ($data['carteira'] == "geral") {
                $_SESSION['carteira'] = "geral";
                $_SESSION['nome_carteira'] = "Geral";
            } else {
                
                if(!empty($data["carteira"])){
                    $_SESSION['carteira'] = $data["carteira"];
                    $_SESSION['nome_carteira'] = $data["carteira"];
                }else{

                //$_SESSION['carteira'] = $data['carteira'];
                $nome = new \Source\Models\Read();
                $nome->ExeRead("app_carterias", "WHERE id = :id", "id={$data['carteira']}");
                $nome->getResult();
                $_SESSION['nome_carteira'] = $nome->getResult()[0]['wallet'];
                $_SESSION['carteira'] = $nome->getResult()[0]['wallet'];
                }
            }
        }
    }

}

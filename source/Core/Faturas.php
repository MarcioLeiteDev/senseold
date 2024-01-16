<?php

namespace Source\Core;

class Faturas {

    public function __construct() {
        
    }

    public function registra() {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
       //var_dump($data);

        if (!empty($data)) {


            //fatura Unica
            if (isset($data['tipo']) && $data['tipo'] == "Unica") {

                //retura pontos e acentos do valor
                $data["valor"] = str_replace(".", "", $data["valor"]);
                $data["valor"] = str_replace(",", "", $data["valor"]);

                //cria a usuario
                $data["user_id"] = $_SESSION['user_id'];
                $data["moeda"] = "BRL";
                $data["periodo"] = "unico";

                $data["repetir_em"] = $data["vencimento_em"];

                $agora = date("Y-m-d");

                if ($data["vencimento_em"] <= $agora) {
                    $data["status"] = "paid";
                }
                if ($data["vencimento_em"] > $agora) {
                    $data["status"] = "unpaid";
                }


                unset($data['js_fixa']);
                unset($data['js_parcelas']);
                unset($data['submit']);

                $cad = new \Source\Models\Create();
                $cad->ExeCreate("app_faturas", $data);
                $cad->getResult();

                if ($cad->getResult()) {
                    $_SESSION['retorno'] = "<div class=\"alert alert-success\" role=\"alert\">
               <h5>Fatura de {$data['modo']}  cadastrada com sucesso</h5>  </div>";
                } else {
                    $_SESSION['retorno'] = "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
                <h5>Erro ao cadastrar Fatura de {$data['modo']} </h5>  </div>";
                }
            }

            //se tipo PArcela
            if (isset($data['tipo']) && $data['tipo'] == "Parcela") {


                $agora = date("Y-m-d");
                for ($i = 0; $i < $data['js_parcelas']; $i++) {

                    $vencimento = date('Y-m-d', strtotime("+{$i} month", strtotime($data["vencimento_em"])));


////                //retura pontos e acentos do valor
                    $data["valor"] = str_replace(".", "", $data["valor"]);
                    $data["valor"] = str_replace(",", "", $data["valor"]);
////
                    $agora = date("Y-m-d");

                    if ($vencimento <= $agora) {
                        $data["status"] = "paid";
                    } else {

                        $data["status"] = "unpaid";
                    }


                    $Dados = [
                        "modo" => $data["modo"],
                        "descricao" => $data["descricao"],
                        "vencimento_em" => $vencimento,
                        "valor" => $data["valor"],
                        "carteira_id" => $data["carteira_id"],
                        "categoria_id" => $data["categoria_id"],
                        "tipo" => $data["tipo"],
                        "js_parcelas" => $i,
                        "user_id" => $_SESSION["user_id"],
                        "status" => $data["status"],
                        "repetir_em" => date('Y-m-d', strtotime("+1 month", strtotime($vencimento)))
                    ];

                    // var_dump($Dados);

                    $cadastra = new \Source\Models\Create();
                    $cadastra->ExeCreate("app_faturas", $Dados);
                    $cadastra->getResult();

                    if ($cadastra->getResult()) {

                        $_SESSION['retorno'] = "<div class=\"alert alert-success\" role=\"alert\">
               <h5> Faturas cadastrada com sucesso</h5> </div>";
                    } else {
                        $_SESSION['retorno'] = "<div class=\"alert alert-danger\" role=\"alert\">
               <h5>  Erro ao cadastrar Faturas</h5> </div>";
                    }
                }
            }

            //se tipo for fixa
            if (isset($data['tipo']) && $data['tipo'] == "Fixa") {

               

                if ($data["js_fixa"] == "mensal") {

                      $agora = date("Y-m-d");
                    
                    //$date_begin = new DateTime($data["vencimento_em"]);
                    $date_begin = new \DateTime($data["vencimento_em"]);
                    $date_end = new \DateTime($agora);
                    // Definimos o intervalo de 1 mes
                    $interval = new \DateInterval('P1M');
                    // Resgatamos datas de cada ano entre data de início e fim
                    $period = new \DatePeriod($date_begin, $interval, $date_end);
                    
                  
                    $vencimento = $data["vencimento_em"];
                    
                    if ($vencimento <= $agora) {
                        $data["status"] = "paid";
                    } else {

                        $data["status"] = "unpaid";
                    }
                    
                    $data["vencimento_em"] = $data["vencimento_em"];
                    /////retura pontos e acentos do valor
                    $data["valor"] = str_replace(".", "", $data["valor"]);
                    $data["valor"] = str_replace(",", "", $data["valor"]);
                    $data["loja"] = $_SESSION["carteira"];
                    $data["carteira_id"] = $_SESSION["carteira"];

                    $data["repetir_em"] = date('Y-m-d', strtotime("+1 month", strtotime("{$data["vencimento_em"]}")));
                    $data["user_id"] = $_SESSION["user_id"];
                    $data["status"] = "paid";
                    unset($data["submit"]);

                   // var_dump($data);

                    $cadastra = new \Source\Models\Create();
                    $cadastra->ExeCreate("app_faturas", $data);
                    $cadastra->getResult();

                    if ($cadastra->getResult()) {
                        echo "<div class=\"alert alert-success\" role=\"alert\">
               <h5>  Cadastro realizado com sucesso</h5> </div>";
                    } else {
                        echo  "<div class=\"alert alert-danger\" role=\"alert\">
               <h5>  Erro ao cadastrar</h5> </div>";
                    }
                    
                   //  var_dump($data);
                }

                if ($data["js_fixa"] == "anual") {

                    //$date_begin = new DateTime($data["vencimento_em"]);
                    $date_begin = new \DateTime($data["vencimento_em"]);
                    $date_end = new \DateTime($agora);
                    // Definimos o intervalo de 1 ano
                    $interval = new \DateInterval('P1Y');
                    // Resgatamos datas de cada ano entre data de início e fim
                    $period = new \DatePeriod($date_begin, $interval, $date_end);
                    
                                        $data["vencimento_em"] = $date->format("Y-m-d");
                    /////retura pontos e acentos do valor
                    $data["valor"] = str_replace(".", "", $data["valor"]);
                    $data["valor"] = str_replace(",", "", $data["valor"]);

                    $data["repetir_em"] = date('Y-m-d', strtotime("+1 {$ref}", strtotime("{$data["vencimento_em"]}")));
                    $data["user_id"] = $_SESSION["user_id"];
                    $data["status"] = "paid";
                    unset($data["submit"]);

                    // var_dump($data);

                    $cadastra = new \Source\Models\Create();
                    $cadastra->ExeCreate("app_faturas", $data);
                    $cadastra->getResult();

                    if ($cadastra->getResult()) {
                        $_SESSION['retorno'] = "<div class=\"alert alert-success\" role=\"alert\">
               <h5>  Cadastro realizado com sucesso</h5> </div>";
                    } else {
                        $_SESSION['retorno'] = "<div class=\"alert alert-danger\" role=\"alert\">
               <h5>  Erro ao cadastrar</h5> </div>";
                    }
                }

                if ($data["js_fixa"] == "anual") {
                    $ref = "year";
                } else {
                    $ref = "month";
                }


            }


            //tipo = entrada
            if (isset($data['tipo']) && $data['tipo'] == "entrada") {




                $tipo = $data["tipo_b"];

                $DadosUp = [
                    "status" => "paid"
                ];

                //atualiza a fatura para status paid
                $atualiza = new \Source\Models\Update();
                $atualiza->ExeUpdate("app_faturas", $DadosUp, "WHERE id = :id", "id={$data['id']}");
                $atualiza->getResult();

                if ($atualiza->getResult()) {
                    $_SESSION['retorno'] = "<div class=\"alert alert-success\" role=\"alert\">
               <h5> Fatura  Atualizada com sucesso </h5> </div>";
                }
//            
//var_dump($Dados , $data , $DadosUp);

                if ($data["tipo_b"] == "Fixa") {

                    $DadosUp = [
                        "js_fixa" => "1"
                    ];

                    //atualiza a fatura para status paid
                    $atualiza = new \Source\Models\Update();
                    $atualiza->ExeUpdate("app_faturas", $DadosUp, "WHERE id = :id", "id={$data['id']}");
                    $atualiza->getResult();

                    if ($atualiza->getResult()) {
                        $_SESSION['retorno'] = "<div class=\"alert alert-success\" role=\"alert\">
               <h5> Fatura  Atualizada com sucesso </h5> </div>";
                    }


                    $Dados = [
                        "user_id" => $data["user_id"],
                        "carteira_id" => $data["carteira_id"],
                        "categoria_id" => $data["categoria_id"],
                        "valor" => $data["valor"],
                        "descricao" => $data["descricao"],
                        "vencimento_em" => $data["vencimento_em"],
                        "modo" => $data["modo"],
                        "periodo" => $data["periodo"],
                        "moeda" => $data["moeda"],
                        "tipo" => "Fixa",
                        "js_parcelas" => $data["js_parcelas"],
                        "js_fixa" => "0",
                        "status" => "paid",
                        "tipo" => $data["tipo_b"],
                        "repetir_em" => date('Y-m-d', strtotime("+1 month", strtotime($data["vencimento_em"])))
                    ];

                    $cad = new \Source\Models\Create();
                    $cad->ExeCreate("app_faturas", $Dados);
                    $cad->getResult();
                    if ($cad->getResult()) {
                        $_SESSION['retorno'] = "<div class=\"alert alert-success\" role=\"alert\">
               <h5> Nova Fatura Registrada </h5> </div>";
                    } else {
                        $_SESSION['retorno'] = "<div class=\"alert alert-danger\" role=\"alert\">
               <h5> erro ao registrar fatura </h5> </div>";
                    }
                }
            }
        }
    }
    
    public function registraService() {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
       //var_dump($data);

        if (!empty($data)) {


            //fatura Unica
            if (isset($data['tipo']) && $data['tipo'] == "Unica") {

                //retura pontos e acentos do valor
                $data["valor"] = str_replace(".", "", $data["valor"]);
                $data["valor"] = str_replace(",", "", $data["valor"]);

                //cria a usuario
                $data["user_id"] = $_SESSION['user_id'];
                $data["moeda"] = "BRL";
                $data["periodo"] = "unico";

                $data["repetir_em"] = $data["vencimento_em"];

                $agora = date("Y-m-d");

                if ($data["vencimento_em"] <= $agora) {
                    $data["status"] = "paid";
                }
                if ($data["vencimento_em"] > $agora) {
                    $data["status"] = "unpaid";
                }


                unset($data['js_fixa']);
                unset($data['js_parcelas']);
                unset($data['submit']);

                $cad = new \Source\Models\Create();
                $cad->ExeCreate("app_faturas", $data);
                $cad->getResult();

                if ($cad->getResult()) {
                    $_SESSION['retorno'] = "<div class=\"alert alert-success\" role=\"alert\">
               <h5>Fatura de {$data['modo']}  cadastrada com sucesso</h5>  </div>";
                } else {
                    $_SESSION['retorno'] = "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
                <h5>Erro ao cadastrar Fatura de {$data['modo']} </h5>  </div>";
                }
            }

            //se tipo PArcela
            if (isset($data['tipo']) && $data['tipo'] == "Parcela") {


                $agora = date("Y-m-d");
                for ($i = 0; $i < $data['js_parcelas']; $i++) {

                    $vencimento = date('Y-m-d', strtotime("+{$i} month", strtotime($data["vencimento_em"])));


////                //retura pontos e acentos do valor
                    $data["valor"] = str_replace(".", "", $data["valor"]);
                    $data["valor"] = str_replace(",", "", $data["valor"]);
////
                    $agora = date("Y-m-d");

                    if ($vencimento <= $agora) {
                        $data["status"] = "paid";
                    } else {

                        $data["status"] = "unpaid";
                    }


                    $Dados = [
                        "modo" => $data["modo"],
                        "descricao" => $data["descricao"],
                        "vencimento_em" => $vencimento,
                        "valor" => $data["valor"],
                        "carteira_id" => $data["carteira_id"],
                        "categoria_id" => $data["categoria_id"],
                        "tipo" => $data["tipo"],
                        "js_parcelas" => $i,
                        "user_id" => $_SESSION["user_id"],
                        "status" => $data["status"],
                        "repetir_em" => date('Y-m-d', strtotime("+1 month", strtotime($vencimento)))
                    ];

                    // var_dump($Dados);

                    $cadastra = new \Source\Models\Create();
                    $cadastra->ExeCreate("app_faturas", $Dados);
                    $cadastra->getResult();

                    if ($cadastra->getResult()) {

                        $_SESSION['retorno'] = "<div class=\"alert alert-success\" role=\"alert\">
               <h5> Faturas cadastrada com sucesso</h5> </div>";
                    } else {
                        $_SESSION['retorno'] = "<div class=\"alert alert-danger\" role=\"alert\">
               <h5>  Erro ao cadastrar Faturas</h5> </div>";
                    }
                }
            }

            //se tipo for fixa
   


            //tipo = entrada
            if (isset($data['tipo']) && $data['tipo'] == "entrada") {




                $tipo = $data["tipo_b"];

                $DadosUp = [
                    "status" => "paid"
                ];

                //atualiza a fatura para status paid
                $atualiza = new \Source\Models\Update();
                $atualiza->ExeUpdate("app_faturas", $DadosUp, "WHERE id = :id", "id={$data['id']}");
                $atualiza->getResult();

                if ($atualiza->getResult()) {
                    $_SESSION['retorno'] = "<div class=\"alert alert-success\" role=\"alert\">
               <h5> Fatura  Atualizada com sucesso </h5> </div>";
                }
//            
//var_dump($Dados , $data , $DadosUp);

                if ($data["tipo_b"] == "Fixa") {

                    $DadosUp = [
                        "js_fixa" => "1"
                    ];

                    //atualiza a fatura para status paid
                    $atualiza = new \Source\Models\Update();
                    $atualiza->ExeUpdate("app_faturas", $DadosUp, "WHERE id = :id", "id={$data['id']}");
                    $atualiza->getResult();

                    if ($atualiza->getResult()) {
                        $_SESSION['retorno'] = "<div class=\"alert alert-success\" role=\"alert\">
               <h5> Fatura  Atualizada com sucesso </h5> </div>";
                    }


                    $Dados = [
                        "user_id" => $data["user_id"],
                        "carteira_id" => $data["carteira_id"],
                        "categoria_id" => $data["categoria_id"],
                        "valor" => $data["valor"],
                        "descricao" => $data["descricao"],
                        "vencimento_em" => $data["vencimento_em"],
                        "modo" => $data["modo"],
                        "periodo" => $data["periodo"],
                        "moeda" => $data["moeda"],
                        "tipo" => "Fixa",
                        "js_parcelas" => $data["js_parcelas"],
                        "js_fixa" => "0",
                        "status" => "paid",
                        "tipo" => $data["tipo_b"],
                        "repetir_em" => date('Y-m-d', strtotime("+1 month", strtotime($data["vencimento_em"])))
                    ];

                    $cad = new \Source\Models\Create();
                    $cad->ExeCreate("app_faturas", $Dados);
                    $cad->getResult();
                    if ($cad->getResult()) {
                        $_SESSION['retorno'] = "<div class=\"alert alert-success\" role=\"alert\">
               <h5> Nova Fatura Registrada </h5> </div>";
                    } else {
                        $_SESSION['retorno'] = "<div class=\"alert alert-danger\" role=\"alert\">
               <h5> erro ao registrar fatura </h5> </div>";
                    }
                }
            }
        }
    }

    public function proxPagto() {

        if (!empty($_SESSION["carteira"])) {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND carteira_id = :c AND status = :s  AND modo = :m AND vencimento_em BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 MONTH)",
                    "id={$_SESSION["user_id"]}&m=saida&s=unpaid&c={$_SESSION["carteira"]}");
            $read->getResult();

            return $read->getResult();
        }
        $read = new \Source\Models\Read();
        $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s  AND modo = :m AND vencimento_em BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 MONTH)", "id={$_SESSION["user_id"]}&m=saida&s=unpaid");
        $read->getResult();

        return $read->getResult();
    }

    public function proxPagtoFixa() {

        if (!empty($_SESSION["carteira"] == "geral")) {

            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND  status = :s AND js_fixa = :j AND modo = :m AND repetir_em BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 MONTH)", "id={$_SESSION["user_id"]}&m=saida&s=paid&j=0");
            $read->getResult();

            return $read->getResult();
        } else {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND js_fixa = :j AND status = :s AND carteira_id = :c AND modo = :m AND repetir_em BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 MONTH)", "id={$_SESSION["user_id"]}&s=paid&c={$_SESSION['carteira']}&m=saida&j=0");
            $read->getResult();

            return $read->getResult();
        }
        // var_dump($read);
    }

    public function proxReceita() {

        if (!empty($_SESSION["carteira"])) {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND carteira_id = :c AND status = :s  AND modo = :m  AND vencimento_em BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 MONTH)",
                    "id={$_SESSION["user_id"]}&m=entrada&s=unpaid&c={$_SESSION["carteira"]}");
            return $read->getResult();
        }

        $read = new \Source\Models\Read();
        $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s  AND modo = :m  AND vencimento_em BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 MONTH)", "id={$_SESSION["user_id"]}&m=entrada&s=unpaid");
        return $read->getResult();
    }

    public function proxReceitaFixa() {


        $read = new \Source\Models\Read();
        $read->ExeRead("app_faturas", "WHERE user_id = :id  AND modo = :m  AND repetir_em BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 MONTH)", "id={$_SESSION["user_id"]}&m=entrada");
        return $read->getResult();
    }

    public function Fixas() {

        $read = new \Source\Models\Read();
        $read->ExeRead("app_faturas", "WHERE user_id = :id AND js_fixa = :j AND tipo = :t AND repetir_em BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 MONTH) ",
                "id={$_SESSION["user_id"]}&t=Fixa&j=0");
        $read->getResult();

        foreach ($read->getResult() as $value) {

            $cadastrar = [
                "user_id" => $value["user_id"],
                "carteira_id" => $value["carteira_id"],
                "categoria_id" => $value["categoria_id"],
                "fatura_de" => $value["fatura_de"],
                "modo" => $value["modo"],
                "descricao" => $value["descricao"],
                "tipo" => $value["tipo"],
                "valor" => $value["valor"],
                "moeda" => $value["moeda"],
                "vencimento_em" => date('Y-m-d', strtotime("+1 month", strtotime("{$value["vencimento_em"]}"))),
                "repetir_em" => date('Y-m-d', strtotime("+1 month", strtotime("{$value["repetir_em"]}"))),
                "periodo" => $value["periodo"],
                "js_parcelas" => $value["js_parcelas"],
                "js_fixa" => "0",
                "status" => "unpaid"
            ];
            //faz cadastro

            $cad = new \Source\Models\Create();
            $cad->ExeCreate("app_faturas", $cadastrar);
            $cad->getResult();


            $up = [
                "js_fixa" => "1"
            ];
//                
            $update = new \Source\Models\Update();
            $update->ExeUpdate("app_faturas", $up, "WHERE id = :id ", "id={$value["id"]}");
        }
    }

}

<?php

namespace Source\Core;

class Carrinho {

    private $filtro;

    public function __construct() {
        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->filtro = $filtro;
    }

    public function carrinho() {

        //var_dump($_GET);

        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = array();
        } //adiciona produto 

        if (isset($_GET['acao'])) {
            //ADICIONAR CARRINHO 
            if ($_GET['acao'] == 'add') {

                $id = intval($_GET['id']);
                if (!isset($_SESSION['carrinho'][$id])) {
                    $_SESSION['carrinho'][$id] = 1;
                } else {
                    $_SESSION['carrinho'][$id] += 1;
                }
            } //REMOVER CARRINHO 

            if ($_GET['acao'] == 'del') {
                $id = intval($_GET['id']);
                if (isset($_SESSION['carrinho'][$id])) {
                    unset($_SESSION['carrinho'][$id]);
                }
            } //ALTERAR QUANTIDADE 
            if ($_GET['acao'] == 'up') {
                if (is_array($_POST['prod'])) {
                    foreach ($_POST['prod'] as $id => $qtd) {
                        $id = intval($id);
                        $qtd = intval($qtd);
                        if (!empty($qtd) || $qtd <> 0) {
                            $_SESSION['carrinho'][$id] = $qtd;
                        } else {
                            unset($_SESSION['carrinho'][$id]);
                        }
                    }
                }
            }

            // var_dump($_SESSION["carrinho"]);
        }
    }

    public function pedido() {
        if ($this->filtro) {

            $total = 0;
            foreach ($_SESSION['carrinho'] as $id => $qtd) {

                $ler = new \Source\Models\Read();
                $ler->ExeRead("app_prod_var", "WHERE id = :a", "a={$id}");
                $ler->getResult();

                $nomeProd = new \Source\Models\Read();
                $nomeProd->ExeRead("app_prod", "WHERE id = :a", "a={$ler->getResult()[0]["produto_id"]}");
                $nomeProd->getResult();

                $nome = $nomeProd->getResult()[0]["produto"];
                $preco = number_format($ler->getResult()[0]["valor"] / 100, 2, ',', '.');
                $sub = number_format($ler->getResult()[0]["valor"] / 100 * $qtd, 2, ',', '.');
                $total += $ler->getResult()[0]["valor"] * $qtd;

                //$_SESSION["totalPedido"] = $total;
            }
            $total = number_format($total / 100, 2, ',', '.');





            $verifica = new \Source\Models\Read();
            $verifica->ExeRead("app_pedidos", "ORDER BY id DESC ");
            $verifica->getResult();


            if ($verifica->getResult()) {
                $id = $verifica->getResult()[0]["pedido_id"];
            } else {
                $id = 0;
            }

            $_SESSION["pedido_id"] = $id + 1;


            $cad = [
                "user_id" => intval($_SESSION["user_id"]),
                "cliente_id" => intval($_SESSION["user_id"]),
                "pedido_id" => intval($_SESSION["pedido_id"]),
                "status" => intval("1"),
                "data" => date("Y-m-d H:i:s"),
                "valor" => $total
            ];

            $cadastra = new \Source\Models\Create();
            $cadastra->ExeCreate("app_pedidos", $cad);
            $cadastra->getResult();


            if ($cadastra->getResult()) {
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
               <h5>Pedido Iniciado</h5>  </div>";

                $total = 0;
                foreach ($_SESSION['carrinho'] as $id => $qtd) {

                    $ler = new \Source\Models\Read();
                    $ler->ExeRead("app_prod_var", "WHERE id = :a", "a={$id}");
                    $ler->getResult();

                    $nomeProd = new \Source\Models\Read();
                    $nomeProd->ExeRead("app_prod", "WHERE id = :a", "a={$ler->getResult()[0]["produto_id"]}");
                    $nomeProd->getResult();

                    $nome = $nomeProd->getResult()[0]["produto"];
                    $preco = number_format($ler->getResult()[0]["valor"] / 100, 2, ',', '.');
                    $sub = number_format($ler->getResult()[0]["valor"] / 100 * $qtd, 2, ',', '.');
                    $total += $ler->getResult()[0]["valor"] * $qtd;

                    //cadastra itens no banco
                    $DadosItens = [
                        "pedido_id" => $_SESSION["pedido_id"],
                        "produto_id" => $id,
                        "produto_qtd" => $qtd,
                        "valor" => $ler->getResult()[0]["valor"]
                    ];



                    //atualiza estoque
                    $estoque = new \Source\Models\Read();
                    $estoque->ExeRead("app_prod_var", "WHERE id = :a", "a={$id}");
                    $estoque->getResult();

                    $estoqueAtual = $estoque->getResult()[0]["qtd"];

                    $totalestoque = $estoqueAtual - $qtd;
                    $at = [
                        "qtd" => $totalestoque
                    ];

                    $atestoque = new \Source\Models\Update();
                    $atestoque->ExeUpdate("app_prod_var", $at, "WHERE id = :a", "a={$id}");
                    $atestoque->getResult();
//                     if($atestoque->getResult()){
//                         echo "atualizado";
//                     }else{
//                         echo "erro";
//                     }
                    // var_dump($at);

                    $item = new \Source\Models\Create();
                    $item->ExeCreate("app_pedidos_itens", $DadosItens);
                    $item->getResult();
                    if ($item->getResult()) {
                        $_SESSION["pagamento"] = true;
                    } else {
                        null;
                    }

                    // var_dump($DadosItens);
                }
                $total = number_format($total / 100, 2, ',', '.');
            } else {
                echo "<div class=\"alert alert-danger\" role=\"alert\">
               <h5>Erro ao iniciar pedido</h5>  </div>";
            }
        }

       // var_dump($_SESSION);
    }

    public function pedidoWeb() {
        

        $total = 0;
        foreach ($_SESSION['carrinho'] as $id => $qtd) {

            $ler = new \Source\Models\Read();
            $ler->ExeRead("app_prod_var", "WHERE produto_id = :a", "a={$id}");
            $ler->getResult();

            $nomeProd = new \Source\Models\Read();
            $nomeProd->ExeRead("app_prod", "WHERE id = :a", "a={$id}");
            $nomeProd->getResult();

            //  var_dump($ler);

            $nome = $nomeProd->getResult()[0]["produto"];
            $preco = number_format($ler->getResult()[0]["valor"] / 100, 2, ',', '.');
            $sub = number_format($ler->getResult()[0]["valor"] / 100 * $qtd, 2, ',', '.');
            $total += $ler->getResult()[0]["valor"] * $qtd;

            //$_SESSION["totalPedido"] = $total;
        }
       // $total = number_format($total / 100, 2, ',', '.');

        $verifica = new \Source\Models\Read();
        $verifica->ExeRead("app_pedidos", "ORDER BY id DESC ");
        $verifica->getResult();


        if ($verifica->getResult()) {
            $id = $verifica->getResult()[0]["pedido_id"];
        } else {
            $id = 0;
        }

        $_SESSION["pedido_id"] = $id + 1;


        $cad = [
            "user_id" => intval($_SESSION["user_id"]),
            "cliente_id" => intval($_SESSION["user_id"]),
            "pedido_id" => intval($_SESSION["pedido_id"]),
            "frete" => $_SESSION["freteTipo"],
            "frete_valor" => $_SESSION["frete"],
            "status" => intval("1"),
            "data" => date("Y-m-d H:i:s"),
            "valor" => $_SESSION["totalPedido"],
            "origem" => "WEB"
        ];
        
        //var_dump($_SESSION);

        $cadastra = new \Source\Models\Create();
        $cadastra->ExeCreate("app_pedidos", $cad);
        $cadastra->getResult();


        if ($cadastra->getResult()) {
            echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
               <h5>Pedido Iniciado</h5>  </div>";

            $total = 0;
            foreach ($_SESSION['carrinho'] as $id => $qtd) {

                $ler = new \Source\Models\Read();
                $ler->ExeRead("app_prod_var", "WHERE produto_id = :a", "a={$id}");
                $ler->getResult();

                $nomeProd = new \Source\Models\Read();
                $nomeProd->ExeRead("app_prod", "WHERE id = :a", "a={$id}");
                $nomeProd->getResult();

                $nome = $nomeProd->getResult()[0]["produto"];
                $preco = number_format($ler->getResult()[0]["valor"] / 100, 2, ',', '.');
                $sub = number_format($ler->getResult()[0]["valor"] / 100 * $qtd, 2, ',', '.');
                $total += $ler->getResult()[0]["valor"] * $qtd;

                //cadastra itens no banco
                $DadosItens = [
                    "pedido_id" => $_SESSION["pedido_id"],
                    "produto_id" => $id,
                    "produto_qtd" => $qtd,
                    "valor" => $ler->getResult()[0]["valor"]
                ];
                
           
                


                //atualiza estoque
                $estoque = new \Source\Models\Read();
                $estoque->ExeRead("app_prod_var", "WHERE produto_id = :a", "a={$id}");
                $estoque->getResult();

                $estoqueAtual = $estoque->getResult()[0]["qtd"];

                $totalestoque = $estoqueAtual - $qtd;
                $at = [
                    "qtd" => $totalestoque
                ];

                $atestoque = new \Source\Models\Update();
                $atestoque->ExeUpdate("app_prod_var", $at, "WHERE id = :a", "a={$id}");
                $atestoque->getResult();
//                     if($atestoque->getResult()){
//                         echo "atualizado";
//                     }else{
//                         echo "erro";
//                     }
                // var_dump($at);

                $item = new \Source\Models\Create();
                $item->ExeCreate("app_pedidos_itens", $DadosItens);
                $item->getResult();
                if ($item->getResult()) {
                    $_SESSION["pagamento"] = true;
                    
                    echo " <meta http-equiv=\"refresh\" content=\"0; URL='".CONF_URL_BASE."/frete'\"/>";
                   // header("location:./frete");
                } else {
                    null;
                }

                // var_dump($DadosItens);
            }
            $total = number_format($total / 100, 2, ',', '.');
            
            $boot = new \Source\Models\Read();
            $boot->ExeRead("usuarios", "WHERE id = :id", "id={$_SESSION["user_id"]}");
            $boot->getResult();
            
            $view = new \Source\Models\View(__DIR__ . "/../../themes/views/email");
            $message = $view->render("pedido", [
                 "nome" => $boot->getResult()[0]["first_name"] . " " . $boot->getResult()[0]["first_name"]
            ]);
            
             $email = new \Source\Support\Email();
                 $email->bootstrap(
                         "Pedido" . CONF_SITE_NAME, 
                         $message, 
                         $boot->getResult()[0]["email"], 
                         $boot->getResult()[0]["first_name"])->send();
            
            
        } else {
            echo "<div class=\"alert alert-danger\" role=\"alert\">
               <h5>Erro ao iniciar pedido</h5>  </div>";
        }


       // var_dump($_SESSION);
    }
    
    

    public function finalizar() {
        if (!empty($this->filtro["forma_pagamento"])) {

            $data["valor"] = str_replace(".", "", $_SESSION["totalpedido"]);
            $data["valor"] = str_replace(",", "", $_SESSION["totalpedido"]);

            $Dados = [
                "user_id" => $_SESSION["user_id"],
                "carteira_id" => $_SESSION["carteira"],
                "categoria_id" => "17",
                "pedido_id" => $_SESSION["pedido_id"],
                "forma_pagamento" => $this->filtro["forma_pagamento"],
                "modo" => "entrada",
                "descricao" => "venda balcão",
                "tipo" => "Unica",
                "valor" => str_replace(".", "", $_SESSION["totalpedido"]),
                "moeda" => "BRL",
                "vencimento_em" => date("Y-m-d"),
                "repetir_em" => date("Y-m-d"),
                "periodo" => "unico",
                "status" => "paid"
            ];

            $fatura = new \Source\Models\Create();
            $fatura->ExeCreate("app_faturas", $Dados);
            $fatura->getResult();
            if ($fatura->getResult()) {
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
               <h5>Pedido Finalizado</h5>  </div>";
                unset($_SESSION["pagamento"]);
                unset($_SESSION["totalpedido"]);
                unset($_SESSION["carrinho"]);
                unset($_SESSION["pedido_id"]);
                unset($_SESSION["total"]);
                //sleep(3);
                // header("location:./caixa");
            } else {
                echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
               <h5>Erro ao Finalizar</h5>  </div>";
            }

            // var_dump($_SESSION  );
        }
    }
    
    public function frete() {
        
        if($this->filtro){
            
            $this->filtro["cliente_id"] = $_SESSION["user_id"];
            
            $cad = new \Source\Models\Create();
            $cad->ExeCreate("app_enderecos", $this->filtro);
            $cad->getResult();
            if($cad->getResult()){
                 echo " <meta http-equiv=\"refresh\" content=\"0; URL='".CONF_URL_BASE."/pagamento'\"/>";
                //header("location:./pagamento");
            }else{
                echo "<div class='alert alert-danger'>Erro ao cadastrar endereço </div>";
            }
           //var_dump($this->filtro);
        }
        
    }

}

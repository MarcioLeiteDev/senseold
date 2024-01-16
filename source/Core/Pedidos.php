<?php

namespace Source\Core;

use Source\Core\Agenda;

class Pedidos {

    private $filtro;

    public function __construct() {
        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);


        $this->filtro = $filtro;
    }

    public function pedido() {

        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $verifica = new \Source\Models\Read();
        $verifica->ExeRead("app_pedidos", "ORDER BY id DESC ");
        $verifica->getResult();


        if ($verifica->getResult()) {
            $id = $verifica->getResult()[0]["pedido_id"];
        } else {
            $id = 0;
        }

        $_SESSION["pedido_id"] = $id + 1;
        $_SESSION["totalPedido"] = 0;

        $cad = [
            "user_id" => intval($_SESSION["user_id"]),
            "cliente_id" => $filtro["cliente_id"],
            "pedido_id" => intval($_SESSION["pedido_id"]),
            "valor" => $_SESSION["totalPedido"],
            "status" => intval("1"),
            "data" => date("Y-m-d H:i:s")
        ];


        $cadastra = new \Source\Models\Create();
        $cadastra->ExeCreate("app_pedidos", $cad);
        $cadastra->getResult();


        if ($cadastra->getResult()) {
            echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
               <h5>Pedido Iniciado</h5>  </div>";
            $_SESSION["etapa"] = "1";
            //$this->veiculos();
            echo "<meta http-equiv=\"refresh\" content=\"2; URL='./?p=pedido_veiculos'\"/>";
            //header("location:./pedido/veiculos");
        } else {
            echo "<div class=\"alert alert-danger\" role=\"alert\">
               <h5>Erro ao iniciar pedido</h5>  </div>";
            var_dump($_SESSION, $this->filtro);
        }
    }

    public function veiculos() {

        if (!empty($this->filtro["veiculo"])) {
            //$_SESSION["etapa"] = $_SESSION["etapa"] + 1;

            $marca = explode("|", $this->filtro["marca1"]);
            $marca = $marca[0];

            $modelo = explode("|", $this->filtro["modelo1"]);
            $modelo = $modelo["3"];

            $ano = explode("|", $this->filtro["ano1"]);
            $ano = $ano["4"];

            $Dados = [
                "user_id" => $_SESSION["user_id"],
                "cliente_id" => $_SESSION["cliente_id"],
                "pedido_id" => $_SESSION["pedido_id"],
                "tipo" => $this->filtro['veiculo'],
                "marca" => $marca,
                "modelo" => $modelo,
                "ano" => $ano,
                "cor" => $this->filtro["cor"],
                "placa" => $this->filtro["placa"],
                "chassi" => $this->filtro["chassi"],
                "renavam" => $this->filtro["renavam"],
                "fipe" => $this->filtro["fipe"],
                "valor" => $this->filtro["valor"]
            ];

            $cad = new \Source\Models\Create();
            $cad->ExeCreate("app_veiculos", $Dados);
            $cad->getResult();
            if ($cad->getResult()) {
                echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
               <h5>Veiculo Cadastrado com Sucesso</h5>  </div>";
            } else {
                echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
               <h5>Erro ao cadastrar</h5>  </div>";
            }

            // var_dump($this->filtro , $_SESSION , $Dados);
        }
        //var_dump($this->filtro , $_SESSION);
        if (!empty($this->filtro["pular"])) {
            $_SESSION["etapa"] = $_SESSION["etapa"] + 1;
            echo "<meta http-equiv=\"refresh\" content=\"2; URL='./?p=pedido_planos'\"/>";
            // header("location:./planos");
            //var_dump($this->filtro , $_SESSION);
        }
    }

    public function planos() {
        if ($this->filtro) {
            $Dados = [
                "user_id" => $_SESSION["user_id"],
                "cliente_id" => $_SESSION["cliente_id"],
                "pedido_id" => $_SESSION["pedido_id"],
                "plano" => $this->filtro["planos"]
            ];
            $cad = new \Source\Models\Create();
            $cad->ExeCreate("app_plano_pedido", $Dados);
            $cad->getResult();
            if ($cad->getResult()) {
                $_SESSION["etapa"] = $_SESSION["etapa"] + 1;
                echo "<meta http-equiv=\"refresh\" content=\"2; URL='./?p=pedido_itens'\"/>";
                // header("location:./itens");
                //echo "cadatrado";  
            } else {
                null;
            }
            // var_dump($this->filtro , $_SESSION , $Dados);
        }
    }

    public function itens() {


        if (!empty($_GET["deletar"])) {

            if (!empty($_GET["tipo"] && $_GET["tipo"] == "estoque")) {

                //atualiza o estoque
                $verifica = new \Source\Models\Read();
                $verifica->ExeRead("app_itens", "WHERE id = :a", "a={$_GET["deletar"]}");
                $verifica->getResult();

                $ver = new \Source\Models\Read();
                $ver->ExeRead("app_estoque", "WHERE produto = :a ", "a={$verifica->getResult()[0]["descricao"]}");
                $ver->getResult();

                $valor = $verifica->getResult()[0]["qtd"] + $ver->getResult()[0]["qtd"];

                $Dados = [
                    "qtd" => $valor
                ];

                $up = new \Source\Models\Update();
                $up->ExeUpdate("app_estoque", $Dados, "WHEre id = :a", "a={$ver->getResult()[0]["id"]}");
                $up->getResult();
                if ($up->getResult()) {
                    echo "<div class='alert alert-success'>Arquivo retirado da lista e estqoue atualizado </div>";
                }
            } else {
                null;
            }

            $del = new \Source\Models\Delete();
            $del->ExeDelete("app_itens", "WHERE id = :a", "a={$_GET["deletar"]}");
            $del->getResult();
            if ($del->getResult()) {
                echo "<div class='alert alert-success'> Deletado com sucesso</div>";
            } else {
                echo "<div class='alert alert-danger'> Erro ao deletar item</div>";
            }
        }

        if (!empty($this->filtro)) {
            if (!empty($this->filtro["tipo"] && $this->filtro["tipo"] == "estoque")) {

                //

                $this->filtro["valor_unit"] = str_replace(".", "", $this->filtro["valor_unit"]);
                $this->filtro["valor_unit"] = str_replace(",", "", $this->filtro["valor_unit"]);

                $Dados = [
                    "user_id" => $_SESSION["user_id"],
                    "pedido_id" => $_SESSION["pedido_id"],
                    "qtd" => $this->filtro["qtd"],
                    "descricao" => $this->filtro["descricao"],
                    "valor_unit" => $this->filtro["valor_unit"],
                    "tipo" => $this->filtro["tipo"]
                ];

                $cad = new \Source\Models\Create();
                $cad->ExeCreate("app_itens", $Dados);
                $cad->getResult();
                if ($cad->getResult()) {
                    echo "cadastrado";
                    //aqui atualiza o estoque

                    echo $this->filtro["id"];
                    //atualiza a tabela

                    $veres = new \Source\Models\Read();
                    $veres->ExeRead("app_estoque", "WHERE id = :a", "a={$this->filtro["id"]}");
                    $veres->getResult();

                    $resultado = $veres->getResult()[0]["qtd"] - $this->filtro["qtd"];

                    $Dados = [
                        "qtd" => $resultado
                    ];

                    $up = new \Source\Models\Update();
                    $up->ExeUpdate("app_estoque", $Dados, "WHERE id = :a", "a={$this->filtro["id"]}");
                    $up->getResult();
                    if ($up->getResult()) {
                        echo "<p class='alert alert-success'>Estoque atualizado com sucesso</p>";
                    } else {
                        echo "Erro";
                    }
                }

                // echo "é aqui mesmo carai";
            }
        }
        if (!empty($this->filtro)) {
            if (!empty($this->filtro["tipo"] && $this->filtro["tipo"] == "servico")) {

                $this->filtro["valor_unit"] = str_replace(".", "", $this->filtro["valor_unit"]);
                $this->filtro["valor_unit"] = str_replace(",", "", $this->filtro["valor_unit"]);

                $Dados = [
                    "user_id" => $_SESSION["user_id"],
                    "pedido_id" => $_SESSION["pedido_id"],
                    "qtd" => $this->filtro["qtd"],
                    "descricao" => $this->filtro["descricao"],
                    "valor_unit" => $this->filtro["valor_unit"],
                    "tipo" => $this->filtro["tipo"]
                ];

                $cad = new \Source\Models\Create();
                $cad->ExeCreate("app_itens", $Dados);
                $cad->getResult();
                if ($cad->getResult()) {
                    echo "cadastrado";
                }
                // var_dump($this->filtro , $_SESSION , $Dados); 
            }
        }

        if (!empty($this->filtro["pular"])) {
            $_SESSION["etapa"] = $_SESSION["etapa"] + 1;
            echo "<meta http-equiv=\"refresh\" content=\"2; URL='./?p=pedido_detalhes'\"/>";
            //header("location:./detalhes"); 
        }

        // var_dump($this->filtro , $_SESSION , $Dados); 
    }

    public function detalhes() {
        if ($this->filtro) {
            $Dados = [
                "detalhes" => $this->filtro["detalhes"],
                "pedido_id" => $_SESSION["pedido_id"],
                "user_id" => $_SESSION["user_id"]
            ];
            $cad = new \Source\Models\Create();
            $cad->ExeCreate("app_detalhes_pedido", $Dados);
            $cad->getResult();
            if ($cad->getResult()) {
                $_SESSION["etapa"] = $_SESSION["etapa"] + 1;
                echo "<meta http-equiv=\"refresh\" content=\"2; URL='./?p=pedido_local'\"/>";
                //header("location:./local"); 
            } else {
                echo "deu merda ai";
            }
        }
    }

    public function local() {
        if ($this->filtro) {
            $Dados = [
                "local" => $this->filtro["local"],
                "pedido_id" => $_SESSION["pedido_id"]
            ];
            $cad = new \Source\Models\Create();
            $cad->ExeCreate("app_local_data", $Dados);
            $cad->getResult();
            if ($cad->getResult()) {
                $_SESSION["etapa"] = $_SESSION["etapa"] + 1;
                echo "<meta http-equiv=\"refresh\" content=\"2; URL='./?p=pedido_agendar'\"/>";
                // header("location:./agendar");  
            } else {
                null;
            }
        }
    }

    public function agendar() {
        if ($this->filtro) {

            $agenda = new Agenda();
            $agenda->cadastra();
            $_SESSION["etapa"] = $_SESSION["etapa"] + 1;
            echo "<meta http-equiv=\"refresh\" content=\"2; URL='./?p=pedido_recibo'\"/>";
            // header("location:./recibo");  
            // var_dump($this->filtro , $_SESSION );    
        }
    }

    public function recibo() {
        if ($this->filtro) {

            $this->filtro["valor"] = str_replace(".", "", $this->filtro["valor"]);
            $this->filtro["valor"] = str_replace(",", "", $this->filtro["valor"]);

            $Dados = [
                "pedido_id" => $_SESSION["pedido_id"],
                "valor" => $this->filtro["valor"],
                "de" => $this->filtro["de"],
                "descricao" => $this->filtro["descricao"],
                "forma_pagamento" => $this->filtro["forma_pagamento"]
            ];

            $cad = new \Source\Models\Create();
            $cad->ExeCreate("app_recibo", $Dados);
            $cad->getResult();
            if ($cad->getResult()) {
                $_SESSION["etapa"] = $_SESSION["etapa"] + 1;

                // header("location:../cliente");  
            }

            //aqui cria a fatura

            $valor = str_replace(".", "", $this->filtro["valor"]);
            $valor = str_replace(",", "", $this->filtro["valor"]);

            if ($this->filtro["pagamento"] == "pago") {
                $status = "paid";
            }
            if ($this->filtro["pagamento"] == "avencer") {
                $status = "unpaid";
            }

            $DadosFatura = [
                "user_id" => $_SESSION["user_id"],
                "loja" => $_SESSION["nome_carteira"],
                "categoria" => "servicos",
                "carteira_id" => $_SESSION["carteira"],
                "pedido_id" => $_SESSION["pedido_id"],
                "forma_pagamento" => $this->filtro["forma_pagamento"],
                "modo" => "entrada",
                "descricao" => $this->filtro["descricao"],
                "valor" => $valor,
                "moeda" => "BRL",
                "vencimento_em" => $this->filtro["data_pagamento"],
                "repetir_em" => $this->filtro["data_pagamento"],
                "periodo" => "unico",
                "status" => $status
            ];

            $fatura = new \Source\Models\Create();
            $fatura->ExeCreate("app_faturas", $DadosFatura);
            $fatura->getResult();
            if ($fatura->getResult()) {
                echo "<div class='alert alert-success'> Fatura cadastreada com sucesso</div>";
            } else {
                echo "<div class='alert alert-danger'> Erro cadastrar fatura</div>";
            }
            echo "<meta http-equiv=\"refresh\" content=\"2; URL='./?p=cliente'\"/>";
            // var_dump($this->filtro , $_SESSION , $DadosFatura ); 
        }
    }

}

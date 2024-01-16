<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Source\Core;

class CarrinhoOrcamento {

    private $filtro;

    public function __construct() {
        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->filtro = $filtro;
    }

    public function carrinho() {


        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = array();
        }

        //ação deletar item da OS e atualizar estoque
        if (isset($_GET['deletar'])) {
            
            //ver o produto
            $ver = new \Source\Models\Read();
            $ver->ExeRead("app_orcamento_itens", "WHERE id = :a", "a={$_GET['deletar']}");
            $ver->getResult();
            
            $qtd = $ver->getResult()[0]["qtd"];
            $busca = explode("/", $ver->getResult()[0]["item"]);
           // echo "Produto" . $busca[1] ;
            
            $verpro = new \Source\Models\Read();
            $verpro->ExeRead("app_estoque", "WHERE produto = :a", "a={$busca[1]}");
            $verpro->getResult();
            
            $DadosAtualiza = [
                "qtd" => $verpro->getResult()[0]["qtd"] + $qtd
            ];
            
            $atualiza = new \Source\Models\Update();
            $atualiza->ExeUpdate("app_estoque", $DadosAtualiza, "WHERE id = :a", "a={$verpro->getResult()[0]["id"]}");
            $atualiza->getResult();
            if($atualiza->getResult()){
                echo "<div class='alert alert-success'> Estoque atualizado com sucesso</div>";
                 echo "<meta http-equiv=\"refresh\" content=\"1; URL='painel&p=servicos-itens'\"/>";
            }else{
               echo "<div class='alert alert-danger'> Erro ao atualizar estoque</div>"; 
            }

            $del = new \Source\Models\Delete();
            $del->ExeDelete("app_orcamento_itens", "WHERE id = :a", "a={$_GET['deletar']}");
            $del->getResult();
            if($del->getResult()){
                echo "<div class='alert alert-success'> Item removido com sucesso</div>";
            }else{
               echo "<div class='alert alert-danger'>Erro ao remover item</div>"; 
            }
        }
//adiciona produto 
        if (isset($_POST['acao'])) {
            //ADICIONAR CARRINHO 
            if ($_POST['acao'] == 'add') {
                //var_dump($_POST);
                //verifica o produto
                $ver = new \Source\Models\Read();
                $ver->ExeRead("app_estoque", "WHERE id = :a", "a={$_POST["id"]}");
                $ver->getResult();



                //cadastra item na OS
                $DadosItens = [
                    "user_id" => $_SESSION["user_id"],
                    "loja" => $_SESSION["carteira"],
                    "orcamento_id" => $_SESSION["orcamento"],
                    "item" => $ver->getResult()[0]["categoria"] . "/" . $ver->getResult()[0]["produto"],
                    "qtd" => $_POST["qtd"],
                    "valor_unit" => $ver->getResult()[0]["preco_venda"],
                    "valor_total" => $ver->getResult()[0]["preco_venda"] * $_POST["qtd"],
                    "origem" => "estoque"
                ];

              // var_dump($_SESSION , $DadosItens);
                $cad = new \Source\Models\Create();
                $cad->ExeCreate("app_orcamento_itens", $DadosItens);
                $cad->getResult();
                if ($cad->getResult()) {
                    echo "<div class='alert alert-success'>Item cadastrado com sucesso </div>";
                } else {
                    echo "<div class='alert alert-danger'>Erro ao cadastrar Item </div>";
                }

                $id = intval($_POST['id']);
                $qtd = intval($_POST['qtd']);
                if (!isset($_SESSION['carrinho'][$id])) {
                    $_SESSION['carrinho'][$id] = $qtd;
                } else {
                    $_SESSION['carrinho'][$id] += 1;
                }
            }

            //cadastro evento manual
            if ($_POST["acao"] == "manual") {

                $this->filtro["valor_unit"] = str_replace(".", "", $this->filtro["valor_unit"]);
                $this->filtro["valor_unit"] = str_replace(",", "", $this->filtro["valor_unit"]);
                $this->filtro["valor_unit"] = str_replace("R", "", $this->filtro["valor_unit"]);
                $this->filtro["valor_unit"] = str_replace("$", "", $this->filtro["valor_unit"]);

                $this->filtro["valor_total"] = str_replace(".", "", $this->filtro["valor_total"]);
                $this->filtro["valor_total"] = str_replace(",", "", $this->filtro["valor_total"]);
                $this->filtro["valor_total"] = str_replace("R", "", $this->filtro["valor_total"]);
                $this->filtro["valor_total"] = str_replace("$", "", $this->filtro["valor_total"]);

                $Dados = [
                    "user_id" => $_SESSION["user_id"],
                    "orcamento_id" => $_SESSION["orcamento"],
                    "loja" => $_SESSION["carteira"],
                    "item" => $this->filtro["item"],
                    "qtd" => $this->filtro["qtd"],
                    "valor_unit" => $this->filtro["valor_unit"],
                    "valor_total" => $this->filtro["valor_total"],
                    "origem" => "manual"
                ];
                $cad = new \Source\Models\Create();
                $cad->ExeCreate("app_orcamento_itens", $Dados);
                $cad->getResult();
                if ($cad->getResult()) {
                    echo "<div class='alert alert-success'> Item cadastrado com Sucesso </div>";
                } else {
                    echo "<div class='alert alert-danger'> Erro ao cadastrar item </div>";
                }
                // var_dump($this->filtro , $Dados);
            }




//REMOVER CARRINHO 

            if ($_POST['acao'] == 'del') {
                $id = intval($_GET['id']);
                if (isset($_SESSION['carrinho'][$id])) {
                    unset($_SESSION['carrinho'][$id]);
                }
            } //ALTERAR QUANTIDADE 
            if ($_POST['acao'] == 'up') {
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

}

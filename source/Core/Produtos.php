<?php

namespace Source\Core;

class Produtos {

    private $filtro;

    public function __construct() {

        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->filtro = $filtro;
    }

    public function categoria() {

        if ($this->filtro) {

            //cadastra
            if ($this->filtro["acao"] == "cadastrar") {
                if ($_FILES["image"]) {
                    $Image = $_FILES["image"];

                    $upload = new \Source\Support\Upload("./uploads/");
                    $upload->Image($Image);
                    $upload->getResult();
                    //$image = $upload->getResult();

                    if ($upload->getResult()) {
                        $foto = $upload->getResult();
                    } else {

                        $ver = new \Source\Models\Read();
                        $ver->ExeRead("app_post_categ", "WHERE id = :a", "a={$_GET["editar"]}");
                        $ver->getResult();

                        $foto = $ver->getResult()[0]["imagem"];
                    }

                    $this->filtro["slug"] = \Source\Support\Check::Name($this->filtro["categoria"]);

                    $Dados = [
                        "categoria" => $this->filtro["categoria"],
                        "slug" => $this->filtro["slug"],
                        "titulo" => $this->filtro["titulo"],
                        "descricao" => $this->filtro["descricao"],
                        "conteudo" => $this->filtro["conteud"],
                        "imagem" => $foto,
                        "data" => date("Y-m-d H:i:s")
                    ];

                    $cad = new \Source\Models\Create();
                    $cad->ExeCreate("app_prod_categ", $Dados);
                    $cad->getResult();
                    if ($cad->getResult()) {
                        echo "<div class='alert alert-success col-md-12'> Categoria Cadastrado com Sucesso </div>";
                    } else {
                        echo "<div class='alert alert-danger col-md-12'> Erro ao cadastrar categoria </div>";
                    }
                }
            }

            //edita
            //atualiza
            if ($this->filtro["acao"] == "editar") {

                if (!empty($_FILES["image"])) {
                    $Image = $_FILES["image"];

                    $upload = new \Source\Support\Upload("./uploads/");
                    $upload->Image($Image);
                    $upload->getResult();

                    if ($upload->getResult()) {
                        $foto = $upload->getResult();
                    } else {

                        $ver = new \Source\Models\Read();
                        $ver->ExeRead("app_prod_categ", "WHERE id = :a", "a={$_GET["editar"]}");
                        $ver->getResult();

                        $foto = $ver->getResult()[0]["imagem"];
                    }

                    $this->filtro["slug"] = Check::Name($this->filtro["categoria"]);

                    $Dados = [
                        "categoria" => $this->filtro["categoria"],
                        "slug" => $this->filtro["slug"],
                        "titulo" => $this->filtro["titulo"],
                        "descricao" => $this->filtro["descricao"],
                        "conteudo" => $this->filtro["conteud"],
                        "imagem" => $foto
                    ];
                } else {

                    $this->filtro["slug"] = Check::Name($this->filtro["categoria"]);


                    $Dados = [
                        "categoria" => $this->filtro["categoria"],
                        "slug" => $this->filtro["slug"],
                        "titulo" => $this->filtro["titulo"],
                        "descricao" => $this->filtro["descricao"],
                        "conteudo" => $this->filtro["conteud"],
                        "imagem" => $foto
                    ];
                }

                $update = new \Source\Models\Update();
                $update->ExeUpdate("app_prod_categ", $Dados, "WHERE id = :a", "a={$this->filtro["id"]}");
                $update->getResult();

                if ($update->getResult()) {
                    echo "<div class='alert alert-success col-md-12'> Categoria Atualizada com Sucesso </div>";
                } else {
                    echo "<div class='alert alert-danger col-md-12'> Erro ao atualziar categoria </div>";
                }

                //   var_dump($Dados);
            }

            //excluir
            //deletar

            if (!empty($_GET["deletar"])) {
                echo "deleta o barato";
                $deleta = new \Source\Models\Delete();
                $deleta->ExeDelete("app_post_categ", "WHERE id = :a", "a={$_GET["deletar"]}");
                $deleta->getResult();
                if ($deleta->getResult()) {
                    echo "<div class='alert alert-success col-md-12'> Categoria Deletada com Sucesso </div>";
                } else {
                    echo "<div class='alert alert-danger col-md-12'> Erro ao deletar </div>";
                }
            }
            // var_dump($this->filtro , $Dados);
        }
    }

    public function produtos() {

        if ($this->filtro) {

            //cadastrar
            if ($this->filtro["acao"] == "cadastrar") {

                $Dados = [
                    "categoria" => $this->filtro["categoria"],
                    "produto" => $this->filtro["produto"],
                    "slug" => \Source\Support\Check::Name($this->filtro["produto"]),
                    "titulo" => $this->filtro["titulo"],
                    "descricao" => $this->filtro["descricao"],
                    "conteudo" => $this->filtro["conteudo"],
                    "detalhes" => $this->filtro["detalhes"],
                    "tipo" => $this->filtro["tipo"],
                    "data" => date("Y-m-d H:i:s")
                ];

                $cad = new \Source\Models\Create();
                $cad->ExeCreate("app_prod", $Dados);
                $cad->getResult();
                if ($cad->getResult()) {
                    echo "<div class='alert alert-success col-md-12'> Produto cadastrado com sucesso </div>";

                    $ver = new \Source\Models\Read();
                    $ver->ExeRead("app_prod", "ORDER BY id DESC");
                    $ver->getResult();

                    $_SESSION["produto"] = $ver->getResult()[0]["id"];

                    header("location:./produtos/variacao");
                } else {
                    echo "<div class='alert alert-danger col-md-12'> Erro ao cadastrar produto </div>";
                }


                var_dump($this->filtro, $Dados);
            }
            //editar
            if ($this->filtro["acao"] == "editar") {
                
                $Dados = [
                    "categoria" => $this->filtro["categoria"],
                    "produto" => $this->filtro["produto"],
                    "slug" => \Source\Support\Check::Name($this->filtro["produto"]),
                    "titulo" => $this->filtro["titulo"],
                    "descricao" => trim($this->filtro["descricao"]),
                    "conteudo" => trim($this->filtro["conteudo"]) ,
                    "detalhes" => trim($this->filtro["detalhes"]) ,
                    "tipo" => $this->filtro["tipo"]
                ];
                
                $update = new \Source\Models\Update();
                $update->ExeUpdate("app_prod", $Dados, "WHERE id = :a", "a={$this->filtro["id"]}");
                $update->getResult();
                if($update->getResult()){
                     echo "<div class='alert alert-success col-md-12'> Produto atualizado com sucesso </div>";

                    $_SESSION["produto"] = $this->filtro["id"];

                    header("location:./produtos/variacao");
                }else{
                     echo "<div class='alert alert-danger col-md-12'> Erro ao atualizar produto </div>";
                }
                
                
                var_dump($this->filtro , $Dados);
            }
 
        }
        
                   //excluir
            
            if(!empty($_GET["deletar"])){
                $deleta = new \Source\Models\Delete();
                $deleta->ExeDelete("app_prod", "WHERE id = :a", "a={$_GET["deletar"]}");
                $deleta->getResult();
                if($deleta->getResult()){
                    echo "<div class='alert alert-success col-md-12'> Produto deletado com sucesso </div>"; 
                }else{
                    echo "<div class='alert alert-danger col-md-12'> Produto deletado com sucesso </div>"; 
                }
            }
    }

    public function variacao() {
        if ($this->filtro) {
            //cadastrar
            //retura pontos e acentos do valor

            if (!empty($_FILES["image"])) {
                $Image = $_FILES["image"];

                $upload = new \Source\Support\Upload("./uploads/");
                $upload->Image($Image);
                $upload->getResult();

                if ($upload->getResult()) {
                    $foto = $upload->getResult();
                } else {


                    $foto = null;
                }
            }

            $this->filtro["valor"] = str_replace(".", "", $this->filtro["valor"]);
            $this->filtro["valor"] = str_replace(",", "", $this->filtro["valor"]);

            if ($this->filtro["acao"] == "cadastrar") {
                $Dados = [
                    "produto_id" => $_SESSION["produto"],
                    "cor" => $this->filtro["cor"],
                    "tamanho" => $this->filtro["tamanho"],
                    "qtd" => $this->filtro["qtd"],
                    "valor" => $this->filtro["valor"],
                    "imagem" => $foto,
                    "data" => date("Y-m-d H:i:s")
                ];
                
                $cad = new \Source\Models\Create();
                $cad->ExeCreate("app_prod_var", $Dados);
                $cad->getResult();
                if($cad->getResult()){
                  echo "<div class='alert alert-success col-md-12'> Variação de Produto cadastrado com sucesso </div>";  
                }else{
                  echo "<div class='alert alert-danger col-md-12'> Erro cadastrar variação </div>";    
                }
                
               // var_dump($this->filtro, $Dados);
            }
            

        }
        
                    //excluri
            if(!empty($_GET["deletar"])){
                $deleta = new \Source\Models\Delete();
                $deleta->ExeDelete("app_prod_var", "WHERE id = :a", "a={$_GET["deletar"]}");
                $deleta->getResult();
                if($deleta->getResult()){
                   echo "<div class='alert alert-success col-md-12'> Variação de Produto <b>Deletada </b> com sucesso </div>";   
                }else{
                echo "<div class='alert alert-danger col-md-12'> erro ao deletar </div>";       
                }
            }
    }

}

<?php

namespace Source\Core;

/**
 * Description of Arvore
 *
 * @author Marcio
 */
class Arvore {

    private $filtro;

    public function __construct() {
        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->filtro = $filtro;
    }

    public function cadastra() {

        if (!empty($this->filtro)) {

            $create = new \Source\Models\Create();
            $create->ExeCreate("genealogy_tree", $this->filtro);
            if ($create->getResult()) {
                echo "<p class='alert alert-success'>Usuario cadastrado com sucesso na arvore</p>";
            } else {
                echo "<p class='alert alert-danger'>Erro</p>";
            }
            // var_dump($this->filtro);
        }
    }

    public function delete() {

        $del = new \Source\Models\Delete();
        $del->ExeDelete("genealogy_tree", "WHERE id = :a", "a={$_GET["delete"]}");
        $del->getResult();
        if ($del->getResult()) {
            echo "<p class='alert alert-success'> Cadastro removido com sucesso</p>";
            
            echo "<meta http-equiv=\"refresh\" content=\"3; URL='index.php?p=arvore&servico={$_GET["servico"]}'\"/>"  ;      
        } else {
            echo "<p class='alert alert-danger'> Erro ao remover</p>";
        }
    }

    public function update() {

        if(!empty($this->filtro)) {

            $update = new \Source\Models\Update();
            $update->ExeUpdate("genealogy_tree", $this->filtro, "WHERE id = :a", "a={$_GET["update"]}");
            $update->getResult();
            if ($update->getResult()) {
                echo "<p class='alert alert-success'> Cadastro editado com sucesso</p>";
                echo "<meta http-equiv=\"refresh\" content=\"3; URL='index.php?p=arvore&servico={$_GET["servico"]}'\"/>
";
                
            } else {
                echo "<p class='alert alert-danger'> Erro ao remover</p>";
            }
        }
    }

}

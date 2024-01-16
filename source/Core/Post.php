<?php

namespace Source\Core;

use Source\Support\Check;

class Post {

    private $filtro;

    public function __construct() {

        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->filtro = $filtro;
    }

    public function categoria() {

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

                $this->filtro["slug"] = Check::Name($this->filtro["categoria"]);

                $Dados = [
                    "data" => date("Y-m-d H:i:s"),
                    "categoria" => $this->filtro["categoria"],
                    "title" => $this->filtro["title"],
                    "description" => $this->filtro["description"],
                    "slug" => $this->filtro["slug"],
                    "content" => $this->filtro["content"],
                    "imagem" => $foto
                ];

                //echo "aqui carai";
            } else {

                $this->filtro["slug"] = Check::Name($this->filtro["categoria"]);

                $Dados = [
                    "data" => date("Y-m-d H:i:s"),
                    "categoria" => $this->filtro["categoria"],
                    "title" => $this->filtro["title"],
                    "description" => $this->filtro["description"],
                    "slug" => $this->filtro["slug"],
                    "content" => $this->filtro["content"]
                ];
            }

            $cad = new \Source\Models\Create();
            $cad->ExeCreate("app_post_categ", $Dados);
            $cad->getResult();
            if ($cad->getResult()) {
                echo "<div class='alert alert-success col-md-12'> Categoria Cadastrada com Sucesso </div>";
            } else {
                echo "<div class='alert alert-danger col-md-12'> Erro ao cadastrar categoria </div>";
            }


            // var_dump($Dados);
        }

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
                    $ver->ExeRead("app_post_categ", "WHERE id = :a", "a={$_GET["editar"]}");
                    $ver->getResult();

                    $foto = $ver->getResult()[0]["imagem"];
                }

                $this->filtro["slug"] = Check::Name($this->filtro["categoria"]);

                $Dados = [
                    "data" => date("Y-m-d H:i:s"),
                    "categoria" => trim($this->filtro["categoria"]),
                    "title" => trim($this->filtro["title"]),
                    "description" => trim($this->filtro["description"]),
                    "slug" => $this->filtro["slug"],
                    "content" => trim($this->filtro["content"]),
                    "imagem" => $foto
                ];
            } else {

                $this->filtro["slug"] = Check::Name($this->filtro["categoria"]);

                $Dados = [
                    "data" => date("Y-m-d H:i:s"),
                    "categoria" => trim($this->filtro["categoria"]),
                    "title" => trim($this->filtro["title"]),
                    "description" => trim($this->filtro["description"]),
                    "slug" => $this->filtro["slug"],
                    "content" => trim($this->filtro["content"])
                ];
            }

            $update = new \Source\Models\Update();
            $update->ExeUpdate("app_post_categ", $Dados, "WHERE id = :a", "a={$this->filtro["id"]}");
            $update->getResult();

            if ($update->getResult()) {
                echo "<div class='alert alert-success col-md-12'> Categoria Atualizada com Sucesso </div>";
            } else {
                echo "<div class='alert alert-danger col-md-12'> Erro ao atualziar categoria </div>";
            }

            //   var_dump($Dados);
        }

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
    }

    /**
     *
     */
    public function post() {

        $this->sitemap();
        //cadastra
        if (!empty($this->filtro)) {
            if ($this->filtro["acao"] == "cadastrar") {

                if ($_FILES["image"]) {
                    $Image = $_FILES["image"];

                    $upload = new \Source\Support\Upload("./uploads/");
                    $upload->Image($Image);
                    $upload->getResult();
                    $image = $upload->getResult();

                    $this->filtro["slug"] = Check::Name($this->filtro["pagina"]);

                    $Dados = [
                        "data" => date("Y-m-d H:i:s"),
                        "categoria" => $this->filtro["categoria"],
                        "pagina" => $this->filtro["pagina"],
                        "title" => $this->filtro["title"],
                        "description" => $this->filtro["description"],
                        "slug" => $this->filtro["slug"],
                        "content" => $this->filtro["content"],
                        "imagem" => $image
                    ];
                } else {

                    $this->filtro["slug"] = Check::Name($this->filtro["pagina"]);

                    $Dados = [
                        "data" => date("Y-m-d H:i:s"),
                        "categoria" => $this->filtro["categoria"],
                        "pagina" => $this->filtro["pagina"],
                        "title" => $this->filtro["title"],
                        "description" => $this->filtro["description"],
                        "slug" => $this->filtro["slug"],
                        "content" => $this->filtro["content"],
                        "imagem" => $image
                    ];
                }

                $cad = new \Source\Models\Create();
                $cad->ExeCreate("app_post", $Dados);
                $cad->getResult();
                if ($cad->getResult()) {
                    echo "<div class='alert alert-success col-md-12'> Post Cadastrado com Sucesso </div>";
                } else {
                    echo "<div class='alert alert-danger col-md-12'> Erro ao cadastrar Post </div>";
                    // var_dump($Dados);
                }


               // var_dump($Dados);
            }
        }

        //atualiza
        if (!empty($this->filtro)) {
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
                        $ver->ExeRead("app_post", "WHERE id = :a", "a={$_GET["editar"]}");
                        $ver->getResult();

                        $foto = $ver->getResult()[0]["imagem"];
                    }

                    $this->filtro["slug"] = Check::Name($this->filtro["categoria"]);

                    $Dados = [
                        "data" => date("Y-m-d H:i:s"),
                        "categoria" => trim($this->filtro["categoria"]),
                        "pagina" => trim($this->filtro["pagina"]),
                        "title" => trim($this->filtro["title"]),
                        "description" => trim($this->filtro["description"]),
                        "slug" => $this->filtro["slug"],
                        "content" => trim($this->filtro["content"]),
                        "imagem" => $foto
                    ];
                } else {

                    $this->filtro["slug"] = Check::Name($this->filtro["categoria"]);

                    $Dados = [
                        "data" => date("Y-m-d H:i:s"),
                        "categoria" => trim($this->filtro["categoria"]),
                        "pagina" => trim($this->filtro["pagina"]),
                        "title" => trim($this->filtro["title"]),
                        "description" => trim($this->filtro["description"]),
                        "slug" => $this->filtro["slug"],
                        "content" => trim($this->filtro["content"])
                    ];
                }

                $update = new \Source\Models\Update();
                $update->ExeUpdate("app_post", $Dados, "WHERE id = :a", "a={$this->filtro["id"]}");
                $update->getResult();

                if ($update->getResult()) {
                    echo "<div class='alert alert-success col-md-12'> Categoria Atualizada com Sucesso </div>";
                } else {
                    echo "<div class='alert alert-danger col-md-12'> Erro ao atualziar categoria </div>";
                }

                // var_dump($Dados);
            }
        }

        //deletar

        if (!empty($_GET["deletar"])) {
            echo "deleta o barato";
            $deleta = new \Source\Models\Delete();
            $deleta->ExeDelete("app_post", "WHERE id = :a", "a={$_GET["deletar"]}");
            $deleta->getResult();
            if ($deleta->getResult()) {
                echo "<div class='alert alert-success col-md-12'> Post Deletado com Sucesso </div>";
            } else {
                echo "<div class='alert alert-danger col-md-12'> Erro ao deletar Post </div>";
            }
        }
    }

    public function postHome() {
        if ($this->filtro) {
            $Dados = [
                "title" => trim($this->filtro["title"]),
                "description" => trim($this->filtro["description"]),
                "content" => trim($this->filtro["content"]),
                "video" => trim($this->filtro["video"])
            ];
            $update = new \Source\Models\Update();
            $update->ExeUpdate("app_post_home", $Dados, "WHERE id = :a", "a=1");
            $update->getResult();
            if ($update->getResult()) {
                echo "<div class='alert alert-success col-md-12'> Atualizado com Sucesso</div>";
            } else {
                echo "<div class='alert alert-danger col-md-12'> Erro ao atualizar</div>";
            }
            //  var_dump($this->filtro , $Dados);
        }
    }

    public function sitemap() {

        //Abre o diretorio raiz
        $handle = @opendir(".");
// abre ou cria o arquivo xml
        $xml = fopen("./../sitemap.xml", "w+");
//Gravamos os dados iniciais do xml
        fwrite($xml, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n\n");

//Abre url
        $conteudo = '  <url>' . "\n";
//pega o Dominio e o nome do arquivo
        $conteudo .= '     <loc>' . CONF_URL_BASE . '/</loc>' . "\n";
//pega a data atual e informa no xml
        $conteudo .= '     <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
//informa a frequencia de atualização da pagina
        $conteudo .= '     <changefreq>daily</changefreq>' . "\n";
//informa a prioridade da pagina
        $conteudo .= '     <priority>1.0</priority>' . "\n";
//Fecha url
        $conteudo .= '  </url>' . "\n";
        fwrite($xml, $conteudo);

        $readxml = new \Source\Models\Read();
        $readxml->ExeRead('app_post');
        $readxml->getResult();

        foreach ($readxml->getResult() as $xmlreq):

            //Abre url
            $conteudo = '  <url>' . "\n";
//pega o Dominio e o nome do arquivo
//        if($xmlreq['post_category'] == "pagina"):
//            $conteudo .="     <loc>".CONF_URL_BASE."/". $xmlreq['post_name']. "</loc>"."\n";
//            else:
            $conteudo .= "     <loc>" . CONF_URL_BASE . "/" . $xmlreq['slug'] . "</loc>" . "\n";
//        endif;
//pega a data atual e informa no xml
            $conteudo .= '     <lastmod>' . date('Y-m-d', strtotime($xmlreq['data'])) . '</lastmod>' . "\n";
//informa a frequencia de atualização da pagina
            $conteudo .= '     <changefreq>monthly</changefreq>' . "\n";
//informa a prioridade da pagina
            $conteudo .= '     <priority>0.9</priority>' . "\n";
//Fecha url
            $conteudo .= '  </url>' . "\n";


            fwrite($xml, $conteudo);
        endforeach;
        closedir($handle);
//Fechamos a estrutura do xml
        fwrite($xml, "\n</urlset>");
//Fecha o arquivo aberto (para liberar memoria do servidor)
        fclose($xml);
    }

}

<?php

use Source\Models\Controller;

namespace Source\App;

class Web extends \Source\Models\Controller {

    public function __construct() {
        parent::__construct(__DIR__ . "/../../themes/default/");
    }
    
        /**
     * Classe responsavel por renderizar o blog
     * @return void
     */
    public function single(): void {
      
        $rota = $_GET["route"];
        
        $rota = str_replace("/", "", $rota);

        $content = new \Source\Models\Read();
        $content->ExeRead("app_post", "WHERE slug = :a", "a={$rota}");
        $content->getResult();
        
        $conteudo = $content->getResult()[0]["content"];
        
        $imagem = $content->getResult()[0]["imagem"];

          $head = $this->seo->render(
                  $content->getResult()[0]['title'] , 
                  $content->getResult()[0]['description'], 
                  CONF_SITE_DOMAIN, 
                  "<img src='".CONF_URL_BASE."/uploads/{$content->getResult()[0]["imagem"]}' />");

        
        echo $this->view->render("single", [
            "head" => $head,
            "conteudo" => $conteudo,
            "imagem" => $imagem
        ]);
    }

    /**
     * 
     * @return void
     */
    public function affiliate(): void {
        
        $data = filter_input_array(INPUT_GET, FILTER_DEFAULT);

        $aff = explode("/", $data['route']);
         $aff = $aff[2];

            setcookie('affiliateDflix', "{$aff}", (time() + (90 * 24 * 3600)));

            var_dump($_COOKIE);

      // sleep(5);

      header("location:" . CONF_URL_BASE);


        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("affiliate", [
            "head" => $head
        ]);
    }

    /**
     * 
     * @return void
     */
    public function home(): void {
        
        var_dump($_SESSION);
       
        //cria o cookie do usuario
        if(!empty($_GET['aff'])){
           setcookie('affDflix', "{$_GET['aff']}", (time() + (365 * 24 * 3600))); 
        }
        
        $content = new \Source\Models\Read();
        $content->ExeRead("app_post_home", "WHERE id = :a", "a=1");
        $content->getResult();
        
        $readBlog = new \Source\Models\Read();
        $readBlog->ExeRead("app_post", "ORDER BY id DESC");
        $blog = $readBlog->getResult();
        
        $readProd = new \Source\Models\Read();
        $readProd->ExeRead("app_prod", "ORDER BY id DESC LIMIT 6");
        $produto = $readProd->getResult();

        $head = $this->seo->render(
                $content->getResult()[0]["title"], 
                $content->getResult()[0]["description"], 
                CONF_SITE_DOMAIN, "./assets/image/footer-bg.jpg");


        echo $this->view->render("home", [
            "head" => $head,
            "conteudo" => $content->getResult()[0]["content"],
            "blog" => $blog,
            "produto" => $produto
        ]);
    }
    /**
     * 
     * @return void
     */
    public function products(): void {
        
       


        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "./assets/image/footer-bg.jpg");


        echo $this->view->render("products", [
            "head" => $head
        ]);
    }
   
    /**
     * 
     * @return void
     */
    public function singleProducts(): void {
        
       $trata = explode("/", $_GET["route"]);
       // var_dump($trata);
        
        $read= new \Source\Models\Read();
        $read->ExeRead("app_prod", "WHERE slug = :a", "a={$trata['2']}");
        $read->getResult();
        
        $id = $read->getResult()[0]["id"];
        $titulo = $read->getResult()[0]["titulo"];
        $descricao =  $read->getResult()[0]["descricao"];
        $produto =  $read->getResult()[0]["produto"];
        $conteudo =  $read->getResult()[0]["conteudo"];
        $detalhes =  $read->getResult()[0]["detalhes"];
        
        $imagem = new \Source\Models\Read();
        $imagem->ExeRead("app_prod_var", "WHERE produto_id = :a","a={$read->getResult()[0]["id"]}");
        $imagem->getResult();
        
        $img = $imagem->getResult()[0]["imagem"];
        $preco = number_format($imagem->getResult()[0]["valor"] / 100, 2,".", ",") ;

        $head = $this->seo->render($titulo, $descricao, CONF_SITE_DOMAIN, "./assets/image/footer-bg.jpg");


        echo $this->view->render("single-products", [
            "head" => $head,
            "produto" => $produto,
            "imagem" => $img,
            "preco" => $preco,
            "conteudo" => $conteudo,
            "detalhes" => $detalhes,
            "descricao" => $descricao,
            "id" => $id
        ]);
    }

    /**
     * 
     * @return void
     */
    public function about(): void {
        $head = $this->seo->render("Sobre -" . CONF_SITE_NAME, "Sobre -" . CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("about", [
            "head" => $head
        ]);
    }

    /**
     * 
     * @return void
     */
    public function card(): void {
        $head = $this->seo->render("Sobre -" . CONF_SITE_NAME, "Sobre -" . CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("card", [
            "head" => $head
        ]);
    }

    /**
     * 
     * @return void
     */
    public function payment(): void {
        $head = $this->seo->render("Sobre -" . CONF_SITE_NAME, "Sobre -" . CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("payment", [
            "head" => $head
        ]);
    }

    /**
     * 
     * @return void
     */
    public function users(): void {
        $head = $this->seo->render("Sobre -" . CONF_SITE_NAME, "Sobre -" . CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("user", [
            "head" => $head
        ]);
    }

    /**
     * 
     * @return void
     */
    public function price(): void {
        $head = $this->seo->render("Planos" . CONF_SITE_NAME, "Sobre -" . CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("price", [
            "head" => $head
        ]);
    }

    /**
     * 
     * @return void
     */
    public function login(?array $data): void {

        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $message = "";

        if (!empty($data)) {

            $verusu = new \Source\Models\Read();
            $verusu->ExeRead("usuarios", "WHERE email = :email", "email={$data['email']}");
            $verusu->getResult();

            $pass = $verusu->getResult()['0']['password'];

            if (empty($verusu->getResult())) {
                $message = "<div class=\"alert alert-danger\" role=\"alert\">
                E-mail não encontrado </div>";
            }

            $verifica = password_verify($data['password'], $pass);

            if ($verifica == false) {
                $message = "<div class=\"alert alert-danger\" role=\"alert\">
                Senha não confere </div>";
            }

            if ($verifica == true) {
                //cria a sessão do usuario e redireciona
                $sessao = new \Source\Core\SessionUser();
                $sessao->start($verusu->getResult()[0]['id']);

                $message = "<div class=\"alert alert-success\" role=\"alert\">
                Login efetuado com suceeso aguarde redirecionamento </div>";
                
                sleep(5);
                
                if($verusu->getResult()[0]["nivel"] == "1"){
                header("location:" . CONF_URL_BASE . "/cliente");
                }else{
                header("location:" . CONF_URL_BASE . "/app");    
                }
            }
        }


        $head = $this->seo->render("Login" . CONF_SITE_NAME, "Sobre -" . CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("login", [
            "head" => $head,
            "message" => $message
        ]);
    }

    /**
     * Classe responsavel por registrar o usuario no sistema
     * @param array $data
     * @return void
     */
    public function register(?array $data): void {


        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $message = "<div class=\"alert alert-info\" role=\"alert\">
                Cadastre-se Grátis </div>";

        //se existir envio de formulario
        if (!empty($data)) {
            //se formulario estiver vasio
            if ($data["first_name"] == null) {
                $message = "<div class=\"alert alert-warning\" role=\"alert\">
                Você precisa enviar os dados via formulário; </div>";
            }

            //verifica se o email é valido
            $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
            if ($email == false) {
                $message = "<div class=\"alert alert-warning\" role=\"alert\">
                Você precisa informar um e-mail válido; </div>";
            }

            //verifica se já não existe um usuario na base
            $verifica = new \Source\Models\Read();
            $verifica->ExeRead("usuarios", "WHERE email = :email", "email={$data['email']}");
            $verifica->getResult();

            if ($verifica->getResult()) {
                $message = "<div class=\"alert alert-warning\" role=\"alert\">
                Já existe um usuário com email <b>{$data['email']}</b> cadastrado no sistema; </div>";
            }
            //verifica se senha esta de acordo com a regra
            // echo "Aqui a senha" . $data["password"];
            if ($data["password"] < 4) {
                $message = "<div class=\"alert alert-warning\" role=\"alert\">
                A senha precisa ter mais de 4 caracteres</div>";
            }

            //transforma a senha em uma hash
            $pass = password_hash($data['password'], CONF_PASSWD_ALGO);

            //cadastra usuario no banco
            $cad = new \Source\Models\Create();

            $data["password"] = $pass;
            unset($data["register"]);

            $cad->ExeCreate("usuarios", $data);
            $cad->getResult();
            if ($cad->getResult()) {
                //envia e-mail de boas vindas
                //cria template do e-mail
                $view = new \Source\Models\View(__DIR__ . "/../../themes/views/email");
                $message = $view->render("confirm", [
                    "first_name" => $data['first_name'],
                    "confirm_link" => CONF_URL_BASE . "/obrigado&email={$data['email']}&token=" . base64_encode($data['email'])
                ]);

                $email = new \Source\Support\Email();
                $email->bootstrap(
                        "Seja bem vindo a Dflix Control",
                        $message,
                        "{$data['email']}",
                        "{$data['first_name']}"
                )->send();


                if ($email->send()) {
                    $message = "<div class=\"alert alert-success\" role=\"alert\">
                Usuário cadastrado com sucesso, acesse seu e-mail {$data['email']} e confirme seu cadastro </div>";
                } else {
                    $message = "<div class=\"alert alert-danger\" role=\"alert\">
                Erro ao cadastrar usuário</div>";
                }
            }
        }

        $head = $this->seo->render("Cadastre-se" . CONF_SITE_NAME, "Sobre -" . CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("register", [
            "head" => $head,
            "message" => $message
        ]);
    }

    /**
     * 
     * @param array $data
     * @return void
     */
    public function confirm(?array $data): void {

        $data = filter_input_array(INPUT_GET, FILTER_DEFAULT);

        $update = new \Source\Models\Update();
        $Dados = [
            "status" => "confirmed"
        ];
        $update->ExeUpdate("usuarios", $Dados, "WHERE email = :email", "email={$data['email']}");
        $update->getResult();

        if ($update->getResult()) {
            $titulo = "Cadastro Ativo com Sucesso";
            $descricao = "Use todas as ferramentas disponiveis em seu plano";
        }
        
        $verDados = new \Source\Models\Read();
        $verDados->ExeRead("usuarios", "WHERE email = :email", "email={$data['email']}");
        $verDados->getResult();
        
        $Cad = [
            "user_id" => $verDados->getResult()[0]["id"],
            "wallet" => "Carteira Free",
            "free" => "1"
        ];
        
        $carteira = new \Source\Models\Create();
        $carteira->ExeCreate("app_carterias", $Cad);


        $head = $this->seo->render("Obrigado" . CONF_SITE_NAME, "Sobre -" . CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("confirm", [
            "head" => $head,
            "titulo" => $titulo,
            "descricao" => $descricao
        ]);
    }
    
    /**
     * 
     * @param array $data
     * @return void
     */
    public function forget(?array $data):void 
    {
       $message = "";
       
       $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
       
       //verifica se usuario existe
       $read = new \Source\Models\Read();
       $read->ExeRead("usuarios", "WHERE email = :e", "e={$data['email']}");
       $read->getResult();
       
       if(empty($read->getResult())){
            $message = "<div class=\"alert alert-warning\" role=\"alert\">
                E-mail não encotrado no sistema; </div>";
       }
       
       $view = new \Source\Models\View(__DIR__ . "/../../themes/views/email");
                $message = $view->render("forget", [
                    "first_name" => $read->getResult()[0]['first_name'],
                    "forget_link" => CONF_URL_BASE . "/recuperar-senha&email={$read->getResult()[0]['email']}&token=" . base64_encode($read->getResult()[0]['email'])
                ]);

                $email = new \Source\Support\Email();
                $email->bootstrap(
                        "Recuperação de senha Dflix Control",
                        $message,
                        "{$read->getResult()[0]['email']}",
                        "{$read->getResult()[0]['first_name']}"
                )->send();
       
                if($email->send()){
                     $message = "<div class=\"alert alert-success\" role=\"alert\">
                E-mail de recuperação enviado com sucesso para {$data['email']} </div>";
                }        
       
       //var_dump($data);
        
        $head = $this->seo->render("Esqueceu a Senha " . CONF_SITE_NAME, "Sobre -" . CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("forget", [
            "head" => $head,
            "message" => $message
           
        ]); 
    }
    
    /**
     * 
     * @param array $data
     * @return void
     */
    public function rePass(?array $data):void
    
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
        $message = "";
        
        $ref = filter_input_array(INPUT_GET, FILTER_DEFAULT);
        if(!empty($ref['email'])){
            $email = $ref['email'];
             $token = $ref['token'];  
        }
        
            $email = $data['email'];
            $token = $data['token'];

        if($data['password'] != $data['repassword'] ){
            $message = "<div class=\"alert alert-danger\" role=\"alert\">
                Senha são diferentes </div>"; 
        }
        
         $pass = password_hash($data['password'], CONF_PASSWD_ALGO); 
        
        $update = new \Source\Models\Update();
        $Dados = [
           "password" => $pass
        ];
        $update->ExeUpdate("usuarios", $Dados, "WHERE email = :email", "email={$data['email']}");
        $update->getResult();
        
        if($update->getResult()){
            $message = "<div class=\"alert alert-success\" role=\"alert\">
                Senha alterada com sucesso  </div>"; 
        }
       // var_dump($data );
        
         $head = $this->seo->render("Recuperar Senha " . CONF_SITE_NAME, "Sobre -" . CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("repass", [
            "head" => $head,
            "message" => $message,
            "email" => $email,
            "token" => $token
           
        ]); 
    }

    /**
     * Classe responsavel por renderizar o blog
     * @return void
     */
    public function blog(): void {
        $head = $this->seo->render("Blog " . CONF_SITE_NAME, "Sobre -" . CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("blog", [
            "head" => $head
        ]);
    }

    /**
     * Classe responsavel por renderizar o blog
     * @return void
     */
    public function perfil(): void {
        $head = $this->seo->render("Perfil " . CONF_SITE_NAME, "Sobre -" . CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("perfil", [
            "head" => $head
        ]);
    }

    /**
     * Classe responsavel por renderizar  frete
     * @return void
     */
    public function freight(): void {
        $head = $this->seo->render("Frete " . CONF_SITE_NAME, "Sobre -" . CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("freight", [
            "head" => $head
        ]);
    }

    /**
     * Classe responsavel por renderizar  frete
     * @return void
     */
    public function pedidos(): void {
        $head = $this->seo->render("Pedidos " . CONF_SITE_NAME, "Sobre -" . CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("pedidos", [
            "head" => $head
        ]);
    }

}

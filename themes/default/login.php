<?php 
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // var_dump($data);
        
     // var_dump($_SESSION);

        $message = "";

        if (!empty($data)) {

            $verusu = new \Source\Models\Read();
            $verusu->ExeRead("users", "WHERE email = :email", "email={$data['email']}");
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
                
               // sleep(5);
                
                if($verusu->getResult()[0]["level"] == "1"){
                    echo "<meta http-equiv=\"refresh\" content=\"0; URL=".CONF_URL_BASE."/pedidos\"/>";
              //  header("location:" . CONF_URL_BASE . "/pedidos");
                }else{
                     echo "<meta http-equiv=\"refresh\" content=\"0; URL=".CONF_URL_BASE."/office\"/>";
               // header("location:" . CONF_URL_BASE . "/app");    
                }
            }
        }


?>
<div class="container-fluid">
    <div class="row no-gutter">
        <!-- The image half -->
        <div class="col-md-6 d-none d-md-flex bg-image"></div>


        <!-- The content half -->
        <div class="col-md-6 bg-light">
            <div class="login d-flex align-items-center py-5">

                <!-- Demo content-->
                <div class="container">
                    <div class="row">
                        <div class="col-lg-10 col-xl-7 mx-auto">
                            <h3 class="display-4">Entrar</h3>
                            

 <?= $message; ?>
 <form action="<?= CONF_URL_BASE ?>/entrar" id="cadastro" name="form" method="post">
                                <div class="form-group mb-3">
                                    <input id="inputEmail" type="email" name="email" placeholder="Seu E-mail" required="" autofocus="" class="form-control rounded-pill border-0 shadow-sm px-4">
                                </div>
                                <div class="form-group mb-3">
                                    <input id="inputPassword" type="password" name="password" placeholder="Senha" required="" class="form-control rounded-pill border-0 shadow-sm px-4 text-primary">
                                </div>
                                <div class="custom-control custom-checkbox mb-3">
                                    <input id="customCheck1" type="checkbox" checked class="custom-control-input">
                                    <label for="customCheck1" class="custom-control-label">Lembrar senha</label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm">Entrar</button>
                    
                                </br>
                                 <p class="text-muted mb-4"><A href="<?=CONF_URL_BASE ?>/esqueceu-senha">Esqueceu a senha</a>.</p>
                            </form>
                        </div>
                    </div>
                </div><!-- End -->

            </div>
        </div><!-- End -->

    </div>
</div>


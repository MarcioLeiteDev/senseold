
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
                            <h5 >Esqueceu a Senha !?</h5>
                            <p>Receba em seu e-mail a recuperação de senha</p>
                            <?php 
                            $recupera = new \Source\Core\Usuarios();
                            $recupera->recuperar();
                            ?>
                           <form action="<?=  CONF_URL_BASE ?>/esqueceu-senha" id="repasswd" method="post">
                                <div class="form-group mb-3">
                                    <input id="inputEmail" type="email" name="email" placeholder="Seu E-mail" required="" autofocus="" class="form-control rounded-pill border-0 shadow-sm px-4">
                                </div>

                                <button type="submit" class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm">Recuperar Senha</button>
                    
                                </br>
                                
                            </form>
                        </div>
                    </div>
                </div><!-- End -->

            </div>
        </div><!-- End -->

    </div>
</div>


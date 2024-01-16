

<div class="container backwhite">
    <div class="row py-5 mt-4 align-items-center">
        <!-- For Demo Purpose -->
        <div class="col-md-5 pr-lg-5 mb-5 mb-md-0">
            <img src="https://res.cloudinary.com/mhmd/image/upload/v1569543678/form_d9sh6m.svg" alt="" class="img-fluid mb-3 d-none d-md-block">
            <h1>Redefenir sua Senha</h1>
            <p> Crie sua conta e comece controlar agora, é grátis </p>
        </div>

        <!-- Registeration Form -->
        <div class="col-md-7 col-lg-6 ml-auto">
            <div class="info"> <?php 
            $usuario = new \Source\Core\Usuarios();
            $usuario->alterar();
            ?></div>
            <form action="" id="cadastro" method="post">
                <div class="row">





                    <!-- Password -->
                    <div class="input-group col-lg-12 mb-0">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-lock text-muted"></i>
                            </span>
                        </div>
                        <input id="password" type="password" name="password" placeholder="Nova Senha" class="form-control bg-white border-left-0 border-md">
                    </div>

                    <div class="input-group col-lg-12 mb-0">.</div>

                    <!-- Password -->
                    <div class="input-group col-lg-12 mb-0">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white px-4 border-md border-right-0">
                                <i class="fa fa-lock text-muted"></i>
                            </span>
                        </div>
                        <input id="password" type="password" name="repassword" placeholder="Repetir Senha" class="form-control bg-white border-left-0 border-md">
                    </div>

                    <input type="hidden" name="email" value="<?= $_GET["email"] ?>" />
                    <input type="hidden" name="token" value="<?= $_GET["token"] ?>" />

                    <!-- Submit Button -->
                    <div class="form-group col-lg-12 mx-auto mb-0">
                        <input type="submit"  <a href="<?= CONF_URL_BASE ?>/recuperar-senha" class="btn btn-primary btn-block py-2" value="cadastrar">
                            <span class="font-weight-bold">Criar sua conta</span>
                        </a>
                    </div>
                    
                    <hr>

                    <div class="text-center w-100">
                        <p class="text-muted font-weight-bold">Fazer Login? <a href="<?= CONF_URL_BASE ?>/entrar" class="text-primary ml-2">Login</a></p>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>


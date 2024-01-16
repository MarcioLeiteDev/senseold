

<div class="container py-5 backwhite">
    <header class="text-center">
        <h1 class="display-4">Blog</h1>
        <p class="font-italic mb-0">Dflix Control.</p>
        <form method="post" id="form-pesquisa" action=""> 
            <label>Pesquisa </label>
            <input type="text" class="form-control" id="pesquisa" name="pesquisa" placeholder="Digite sua busca" />
        </form>

        <div class="resultado">  </div>


        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>

        <script type="text/javascript">

            $(function () {
                $("#pesquisa").keyup(function () {
                    //Recuperar o valor do campo
                    var pesquisa = $(this).val();

                    $("#blog").hide();
                    //Verificar se há algo digitado
                    if (pesquisa != '') {
                        var dados = {
                            palavra: pesquisa
                        }
                        $.post("<?= CONF_URL_BASE ?>/process/buscaPost.php", dados, function (retorna) {
                            //Mostra dentro da ul os resultado obtidos 
                            $(".resultado").html(retorna);
                        });
                    }
                });
            });

        </script>

    </header>

    <div class="row">
        <div class="col-lg-11 mx-auto" id="blog">
            <!-- FIRST EXAMPLE ===================================-->
            <div class="row py-5">
                <?php
                $atual = filter_input(INPUT_GET, 'atual', FILTER_VALIDATE_INT);
                $pager = new \Source\Support\Pager("./blog&atual=", "Primeiro", "Ultimo", "1");
                $pager->ExePager($atual, 9);

                $resultado = new \Source\Models\Read();
                $resultado->ExeRead("app_post", "LIMIT :limit OFFSET :offset",
                        "limit={$pager->getLimit()}&offset={$pager->getOffset()}"
                        );
                $resultado->getResult();
                foreach ($resultado->getResult() as $value) {
                    ?>
                    <div class="col-lg-4">
                        <figure class="rounded p-3 bg-white shadow-sm">
                            <img src="<?= CONF_URL_BASE ?>/admin/uploads/<?= $value["imagem"] ?>" alt="" class="w-100 card-img-top">
                            <figcaption class="p-4 card-img-bottom">
                                <h2 class="h5 font-weight-bold mb-2 font-italic"><?= $value["pagina"] ?></h2>
                                <p class="mb-0 text-small text-muted font-italic"><?= $value["description"] ?></p>
                                <button class="btn btn-info"><a href="<?= CONF_URL_BASE ?>/<?= $value["slug"] ?>" style="text-decoration: none; color:#fff;"> Saiba Mais ... </a> </button>

                            </figcaption>
                        </figure>
                    </div>
<?php } ?>



                <div class="separator my-3"></div>
                <div class="col-md-12"> 
                
                                <?php
                    $pager->ExePaginator("app_post");
                    echo $pager->getPaginator();
                    ?>
</div>

            </div>
        </div>
    </div>
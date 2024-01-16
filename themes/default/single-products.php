

<header class="container backwhite"> 
    <?php 
    
     $url = $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
     
     $tratar = explode("/", $url);
     
    // var_dump($tratar);
    
    $var = new \Source\Models\Read();
    $var->ExeRead("app_prod", "WHERE slug = :a", "a={$tratar['3']}");
    $var->getResult();
    
  //  var_dump($var);
    
    $dados = new Source\Models\Read();
    $dados->ExeRead("app_prod_var", "WHERE produto_id = :a", "a={$var->getResult()[0]["id"]}");
    $dados->getResult();
    
            ?>

    <h1><?= $var->getResult()[0]["produto"]; ?>  </h1>

<div class="container">
    <div class="row">
        <div class="resposta"> </div>
        <!-- Image -->
        <div class="col-12 col-lg-6" id="imagem">
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <a href="" data-toggle="modal" data-target="#productModal">
                        <!--<img class="img-fluid" src="https://dummyimage.com/800x800/55595c/fff" />-->
                        <img class="img-fluid" src="<?=CONF_URL_BASE ?>/uploads/<?= $dados->getResult()[0]["imagem"] ?>" style="width:100%;" />
                        <p class="text-center">Zoom</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Add to cart -->
        <div class="col-12 col-lg-6 add_to_cart_block">
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <p class="price">R$ <?= number_format( $dados->getResult()[0]["valor"] / 100,2, ",", "."); ?></p>
<!--                    <p class="price_discounted">149.90 $</p>-->
                    <form method="get" action="<?=CONF_URL_BASE ?>/carrinho&id=<?= $dados->getResult()[0]["produto_id"] ?>">
                       <?php 
                       if(!empty( $var->getResult()[0]["cor"])){
                       ?>
                        <div class="form-group">
                            <label for="cor">Color</label>
                            <select class="custom-select" name="cor" id="colors">
                                <option selected>Selecione</option>
                                <?php 
                                foreach ($var->getResult() as $cor) {

                                ?>
                                <option value="<?=$cor["id"] ?>"><?=$cor["cor"] ?></option>
                       <?php } ?>
                               
                            </select>
                        </div>
                       <?php } ?>
                        
                        
                        <div class="form-group">
                            <label>Quantidade :</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button type="button" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control"  id="quantity" name="quantity" min="1" max="100" value="1">
                                <div class="input-group-append">
                                    <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <a href="<?=CONF_URL_BASE ?>/carrinho&acao=add&id=<?= $dados->getResult()[0]["produto_id"] ?>" class="btn btn-success btn-lg btn-block text-uppercase">
                            <i class="fa fa-shopping-cart"></i> Adiconar CArrinho
                        </a>
                    </form>
                    
                    <div class="form-group"> 
                        </br>
                        <h5 class="border-bottom">Detalhes</h5>
                        <?= $var->getResult()[0]["descricao"]; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Description -->
        <div class="col-12">
            <div class="card border-light mb-3">
                <div class="card-header bg-info text-white text-uppercase"><i class="fa fa-align-justify"></i> Descrição</div>
                <div class="card-body">
                    <p class="card-text">
                        <?= $var->getResult()[0]["conteudo"]; ?>
                    </p>
                   
                </div>
            </div>
        </div>
        <!-- Description -->
        <div class="col-12">
            <div class="card border-light mb-3">
                <div class="card-header bg-info text-white text-uppercase"><i class="fa fa-align-justify"></i> Detalhes</div>
                <div class="card-body">
                    <p class="card-text">
                        <?= $var->getResult()[0]["detalhes"]; ?>
                    </p>
                   
                </div>
            </div>
        </div>

    </div>
</div>



<!-- Modal image -->
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Product title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <img class="img-fluid" src="<?=CONF_URL_BASE ?>/uploads/<?=$imagem ?>" style="width:100%;" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <script>



        $(function () {
            
        $('select[name=cor]').change(function(){
            $('#imagem').hide(),
        $.post("<?=CONF_URL_BASE ?>/process/var.php",
                    {veiculo: $(this).val()},
            function(veiculo) {
                
                $('.resposta').html(veiculo)

            })
    });


    });       

     
        
        
     
    </script>

<style>
.bloc_left_price {
    color: #c01508;
    text-align: center;
    font-weight: bold;
    font-size: 150%;
}
.category_block li:hover {
    background-color: #007bff;
}
.category_block li:hover a {
    color: #ffffff;
}
.category_block li a {
    color: #343a40;
}
.add_to_cart_block .price {
    color: #c01508;
    text-align: center;
    font-weight: bold;
    font-size: 200%;
    margin-bottom: 0;
}
.add_to_cart_block .price_discounted {
    color: #343a40;
    text-align: center;
    text-decoration: line-through;
    font-size: 140%;
}
.product_rassurance {
    padding: 10px;
    margin-top: 15px;
    background: #ffffff;
    border: 1px solid #6c757d;
    color: #6c757d;
}
.product_rassurance .list-inline {
    margin-bottom: 0;
    text-transform: uppercase;
    text-align: center;
}
.product_rassurance .list-inline li:hover {
    color: #343a40;
}
.reviews_product .fa-star {
    color: gold;
}
.pagination {
    margin-top: 20px;
}
footer {
    background: #343a40;
    padding: 40px;
}
footer a {
    color: #f8f9fa!important
}

</style>

<script> 
    $(document).ready(function(){
        var quantity = 1;

        $('.quantity-right-plus').click(function(e){
            e.preventDefault();
            var quantity = parseInt($('#quantity').val());
            $('#quantity').val(quantity + 1);
        });

        $('.quantity-left-minus').click(function(e){
            e.preventDefault();
            var quantity = parseInt($('#quantity').val());
            if(quantity > 1){
                $('#quantity').val(quantity - 1);
            }
        });

    });
</script>
    
    
</header>
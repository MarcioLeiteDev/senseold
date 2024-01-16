<div class="container-fluid"> 
    <h3>Ordem de Serviços </h3>
    <?php
    session_start();
    include '../../vendor/autoload.php';
    
    $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//var_dump($filtro);

$_SESSION["busca"] = $filtro["palavra"];

echo "<p>Sua busca por <b>" . $filtro["palavra"]  . "</b> Retornou os seguintes resultados." ;
    
    $os = new Source\Functions\Os();
    $os->cadastra();

    $atualiza = new \Source\Functions\AtualizaStatus();
    $atualiza->atualiza();



    ?>



<table class="table"> 
    <thead> 
        <tr> 
            <th> Data </th>
            <th> OS Numero </th>
            <th> Placa </th>
            <th> Veiculo </th>
            <th> Cor </th>
            <th> Funcionario</th>
            <th> Serviço </th>
            <th> Impressos </th>
            <th> Status </th>
            <th> Editar </th>

        </tr>
    </thead>
    <tbody>
        <?php
        $atual = filter_input(INPUT_GET, 'atual', FILTER_VALIDATE_INT);
        $pager = new Source\Support\Pager("painel&p=servicos&atual=", "Primeiro", "Ultimo", "1");
        $pager->ExePager($atual, 10);

        $ler = new Source\Models\Read();
        $ler->ExeRead("app_os", "WHERE user_id = :a AND placa LIKE '%' :b '%' OR os LIKE '%' :b '%' ORDER BY os DESC LIMIT :limit OFFSET :offset", "a={$_SESSION["user_id"]}&b={$_SESSION["busca"]}&limit={$pager->getLimit()}&offset={$pager->getOffset()}");
        $ler->getResult();
        foreach ($ler->getResult() as $vler) {
            ?>
            <tr> 
                <td style="font-size: 0.8em;"> <?= date("d/m/Y H:i:s", strtotime($vler["data"])); ?> </td>
                <td> <b><?= str_pad($vler["os"], 7, "0", STR_PAD_LEFT) ?></b> </td>
                <td> <?= $vler["placa"] ?> </td>
                <td> <?= $vler["modelo"] ?> </td>
                <td> <?= $vler["cor"] ?> </td>
                <td> <?= $vler["funcionario"] ?> </td>
                <td>

                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalreceita<?= $vler["os"] ?>">
                        Serviços
                    </button>


                    <!-- Modal -->
                    <div class="modal fade" id="modalreceita<?= $vler["os"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-flag" aria-hidden="true" style="color:green;"></i> Serviços</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <table class="table"> 
                                        <thead> 
                                            <tr> 
                                                <th>Item </th>
                                                <th>QTD </th>
                                                <th>Preço Unit </th>
                                                <th>Preço Total </th>

                                            </tr>
                                        </thead>
                                        <tbody> 
    <?php
    $total = 0;
    $ver = new Source\Models\Read();
    $ver->ExeRead("app_os_itens", "WHERE user_id = :a AND os = :b", "a={$_SESSION["user_id"]}&b={$vler["os"]}");
    $ver->getResult();
    if (empty($ver->getResult())) {
        echo "<tr><td>Não existe produtos ou serviços cadastrados nessa OS</td></tr>";
    } else {
        $total = 0;
        foreach ($ver->getResult() as $vos) {
            $total += $vos["valor_total"];
            ?>
                                                    <tr> 
                                                        <td><?= $vos["item"] ?> </td>
                                                        <td><?= $vos["qtd"] ?> </td>
                                                        <td>R$ <?= number_format($vos["valor_unit"] / 100, 2, ",", "."); ?> </td>
                                                        <td>R$ <?= number_format($vos["valor_total"] / 100, 2, ",", "."); ?> </td>

                                                    </tr>
        <?php }
    } ?>

                                            <tr> 
                                                <td> </td>
                                                <td> </td>
                                                <td>Total Compra </td>
                                                <td>R$ <?= number_format($total / 100, 2, ",", "."); ?> </td>
                                                <td> </td>
                                            </tr>

                                        </tbody>

                                    </table>




                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                </div>
                            </div>
                        </div>
                    </div>

                </td>
                <td> <a href="./os&os=<?= $vler["os"] ?>" target="_blank" style="font-size:2.0em; color:orange;"> <i class="fas fa-file-alt"></i> </a> </td>
                <td> 
                    <?php if ($vler["status"] == "1") { ?>
                        <p style="color:#006cad; font-weight: bold;"> Recepcionado </p> 
                    <?php } ?>
                    <?php if ($vler["status"] == "2") { ?>
                        <p style="color:orange; font-weight: bold;"> Em Andamento </p> 
                    <?php } ?>
                    <?php if ($vler["status"] == "3") { ?>
                        <p style="color:red; font-weight: bold;"> Aguardando Peças </p>
                    <?php } ?>
                    <?php if ($vler["status"] == "4") { ?>
                        <p style="color:green; font-weight: bold;"> Executado </p>
                    <?php } ?>
                    <?php if ($vler["status"] == "5") { ?>
                        <p style="color:#31b0d5; font-weight: bold;"> Executado / Faturado </p>
                    <?php } ?>
                    <?php if ($vler["status"] == "6") { ?>
                        <p style="color:red; font-weight: bold;"> Cancelado </p>
                    <?php } ?>

                    <?php if ($vler["status"] == "4") { ?>
                        <!--- Aqui função dar entrada  -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalreceitanew">
                            Lançar Entradas
                        </button>


                        <!-- Modal -->
                        <div class="modal fade" id="modalreceitanew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-flag" aria-hidden="true" style="color:green;"></i> Lançar Receitas</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form method="post" action="" id="receita" class="form">
                                            <input type="hidden" name="modo" value="entrada" />

                                            <div class="col-lg-12"> 
                                                <p><i class="fas fa-pen-fancy" aria-hidden="true"></i>Descrição </p>
                                                <input type="text" name="descricao" placeholder="Descrição do Lançamento" class="form-control" value="OS Nº <?= $vler["os"] ?>" />
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6"> 
                                                    </br>
                                                    <p><i class="far fa-money-bill-alt " ></i> Valor </p>

                                                    <input type="text" name="valor" id="valor" class="form-control" value="<?= number_format($total / 100, 2, ",", "."); ?> " />


                                                </div>
                                                <div class="col-lg-6"> 
                                                    </br>
                                                    <p><i class="fa fa-table" aria-hidden="true"></i> Data </p>
                                                    <input type="date" id="date" name="vencimento_em"  class="form-control input-datepicker" value="<?= date("Y-m-d") ?>" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6"> 
                                                    </br>
                                                    <p><i class="fa fa-book" ></i> Carteira </p>
                                                    <select name="carteira_id" class="form-control"> 
                                                        <?php
                                                        $loja = new Source\Models\Read();
                                                        $loja->ExeRead("app_lojas", "WHERE user_id = :a", "a={$_SESSION["user_id"]}");
                                                        $loja->getResult();
                                                        foreach ($loja->getResult() as $valorloja) {
                                                            ?>

                                                            <option value="<?= $valorloja["id"] ?>"><?= $valorloja["loja"] ?></option>
        <?php } ?>
                                                    </select>
                                                    </select>

                                                </div>
                                                <div class="col-lg-6"> 
                                                    </br>
                                                    <label><i class="fas fa-retweet"></i> Categoria </label>
                                                    <select name="categoria_id" class="form-control"> 
        <?php
        $cat = new Source\Models\Read();
        $cat->ExeRead("app_categ", "WHERE user_id = :a AND tipo = :b", "a={$_SESSION["user_id"]}&b=1");
        $cat->getResult();
        foreach ($cat->getResult() as $forrenda):
            ?>

                                                            <option value="<?= $forrenda["id"] ?>"><?= $forrenda["categoria"] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                
                                                
                                                
                                                
                                            </div>
                                            
                                               <div class="col-md-12"> 
                                                </br>
                                                    <label><i class="fas fa-retweet"></i> Forma de Pagamento </label>
                                                    <select name="forma_pagamento" class="form-control"> 
                                                        <option value="#">Selecione forma de pagamento </option>
                                                        <option value="dinheiro">Dinheiro </option>
                                                        <option value="cartao credito">Cartão de Crédito </option>
                                                        <option value="cartao debito">Cartão de Débito </option>
                                                        <option value="cheque">Cheque </option>
                                                        <option value="boleto">Boleto </option>
                                                    </select>
                                                    
                                                </div>
                                                
                                            
                                            </br>
                                            <h3> Repetições </h3>

                                            <div class="col-md-12">


                                                <div class="col-lg-12 col-md-12"> 

                                                    <label><i class="fas fa-retweet"></i> Repetição </label>
                                                    </br>




                                                    <script>



                                                        $(function () {

                                                            $(".camposExtras").hide();
                                                            $(".js_fixa").hide();
                                                            $(".js_parcelas").hide();
                                                            $('input[name="tipo"]').change(function () {
                                                                if ($('input[name="tipo"]:checked').val() === "Fixa") {
                                                                    $('.js_fixa').show();
                                                                } else {
                                                                    $('.js_fixa').hide();
                                                                }
                                                                if ($('input[name="tipo"]:checked').val() === "Parcela") {
                                                                    $('.js_parcelas').show();
                                                                } else {
                                                                    $('.js_parcelas').hide();
                                                                }
                                                            });

                                                        });
                                                    </script>



                                                    <input type="radio" name="tipo" value="Unica"  class="form" >  Unica

                                                    <input type="radio" name="tipo" value="Fixa" >  Fixa 

                                                    <input type="radio" name="tipo" value="Parcela" > Parcela

                                                    <!--<div class="camposExtras">
                                                        Aqui vem os dados que é para esconder ou aparecer
                                                    </div>-->

                                                </div>                                       

                                            </div>

                                            <div class="row"> 

                                                <div class="col-lg-12 js_fixa" id="ocultar"> 
                                                    </br>
                                                    <label class="js_fixa"> Fixas </label>
                                                    <select name="js_fixa" class="form-control"> 
                                                        <option value="0">Selecione periodo  </option>
                                                        <option value="mensal">Mensal </option>
                                                        <option value="anual">Anual </option>

                                                    </select>
                                                </div>

                                                <div class="col-lg-12 js_parcelas" id="ocultar"> 
                                                    </br>
                                                    <label class="js_parcelas"> Parcelas </label>
                                                    <select name="js_parcelas" class="form-control"> 
        <?php for ($i = 0; $i < 80; $i++) { ?>
                                                            <option value="<?= $i; ?>"><?= $i; ?> </option>
                                                        <?php } ?>

                                                    </select>
                                                </div>
                                            </div>
                                            </br>
                                            <input type="submit" name="submit" value="LANÇAR RECEITAS" class="btn btn-success" />
                                        </form>



                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">(X) Fechar</button>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--fim modal entradas -->

    <?php } else { ?>

                        <form method="post" action=""> 
                            <div class="form-group"> 
                                <select name="status" class="form-control"> 
                                    <option value="1"> Recepcionado </option>
                                    <option value="2"> Em Andamento </option>
                                    <option value="3"> Aguardando Peças </option>
                                    <option value="4"> Executado </option>
                                    <option value="5"> Executado / Faturado </option>
                                    <option value="6"> Cancelado </option>
                                </select>
                                <input type="hidden" name="acao"  value="MUDAR STATUS" />
                                <input type="hidden" name="id"  value="<?= $vler["id"] ?>" />
                                <input type="submit" class="btb btn-warning" name="atualiza"  value="MUDAR STATUS" />
                            </div>

                        </form>
    <?php } ?>
                </td>
                <td> <a href="painel&p=servicos-itens&editar=<?= $vler["os"] ?>"><i class="fas fa-edit"></i> </a></td>

            </tr>
<?php } ?>
<!--            <tr> 
            <td> Data </td>
            <td> Placa </td>
            <td> Veiculo </td>
            <td> Serviço </td>
            <td> Status </td>
            <td> Editar </td>
            <td> Deletar </td>
        </tr>-->
    </tbody>
</table>


            
            <?php 
            $pager->ExePaginator("app_os", "WHERE user_id = :a ORDER BY os DESC", "a={$_SESSION["user_id"]}");
            echo $pager->getPaginator();

            ?>
</div>


<script>



    $(function () {

        $('select[name=veiculo]').change(function () {
            $.post("<?= CONF_URL_BASE ?>/assets/functions/marca.php",
                    {veiculo: $(this).val()},
                    function (veiculo) {

                        $('select[name=marca1]').html(veiculo)

                    })
        });

        $('select[name=marca1]').change(function () {
            $.post("<?= CONF_URL_BASE ?>/assets/functions/modelo.php",
                    {marca: $(this).val()},
                    function (marca) {

                        $('select[name=modelo1]').html(marca)

                    })
        });

        $('select[name=modelo1]').change(function () {
            $.post("<?= CONF_URL_BASE ?>/assets/functions/ano.php",
                    {modelo: $(this).val()},
                    function (modelo) {

                        $('select[name=ano1]').html(modelo)

                    })
        });

        $('select[name=ano1]').change(function () {
            $.post("<?= CONF_URL_BASE ?>/assets/functions/ano.php",
                    {modelo: $(this).val()},
                    function (modelo) {

                        $('select[name=fipe]').html(modelo)

                    })
        });

//        $('select[name=ano1]').change(function () {
//            $.post("<?= CONF_URL_BASE ?>/assets/functions/codigofipe.php",
//                    {fipe: $(this).val()},
//                    function (fipe) {
//
//                        $('select[name=fipe]').html(fipe)
//
//                    })
//        });

        $('select[name=ano1]').change(function () {
            $.post("<?= CONF_URL_BASE ?>/assets/functions/preco.php",
                    {valor: $(this).val()},
                    function (valor) {

                        $('select[name=valor]').html(valor)

                    })
        });

        $('select[name=plano]').change(function () {
            $.post("<?= CONF_URL_BASE ?>/admin/plano_desc.php",
                    {plano: $(this).val()},
                    function (plano) {

                        $('select[name=plano_desc]').html(plano)

                    })
        });

        $('select[name=plano]').change(function () {
            $.post("<?= CONF_URL_BASE ?>/admin/plano_valor.php",
                    {valorplan: $(this).val()},
                    function (valorplan) {

                        $('select[name=plano_valor]').html(valorplan)

                    })
        });





    });





</script>

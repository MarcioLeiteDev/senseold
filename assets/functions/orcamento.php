<div class="container-fluid"> 
   
    <?php
    session_start();
    include '../../vendor/autoload.php';
    
    $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//var_dump($filtro);

$_SESSION["busca"] = $filtro["palavra"];

echo "<p>Sua busca por <b>" . $filtro["palavra"]  . "</b> Retornou os seguintes resultados." ;

    ?>



<table class="table"> 
    <thead> 
        <tr> 
            <th> Data </th>
            <th> OS Numero </th>
            <th> Placa </th>
            <th> Veiculo </th>
            <th> Cor </th>
           
            <th> Serviço </th>
            <th> Impressos </th>
            <th> Enviar </th>
            <th> Status </th>
            <th> Editar </th>

        </tr>
    </thead>
    <tbody>
        <?php
        $atual = filter_input(INPUT_GET, 'atual', FILTER_VALIDATE_INT);
        $pager = new Source\Support\Pager("./?p=orcamento&atual=", "Primeiro", "Ultimo", "1");
        $pager->ExePager($atual, 10);

        $ler = new Source\Models\Read();
        $ler->ExeRead("app_orcamento", "WHERE user_id = :a AND placa LIKE '%' :b '%' OR orcamento_id LIKE '%' :b '%' ORDER BY orcamento_id DESC LIMIT :limit OFFSET :offset", "a={$_SESSION["user_id"]}&b={$_SESSION["busca"]}&limit={$pager->getLimit()}&offset={$pager->getOffset()}");
        $ler->getResult();
        foreach ($ler->getResult() as $vler) {
            ?>
            <tr> 
                <td style="font-size: 0.8em;"> <?= date("d/m/Y H:i:s", strtotime($vler["data"])); ?> </td>
                <td> <b><?= str_pad($vler["orcamento_id"], 7, "0", STR_PAD_LEFT) ?></b> </td>
                <td> <?= $vler["placa"] ?> </td>
                <td> <?= $vler["modelo"] ?> </td>
                <td> <?= $vler["cor"] ?> </td>
                
                <td>

                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalreceita<?= $vler["orcamento_id"] ?>">
                        Serviços
                    </button>


                    <!-- Modal -->
                    <div class="modal fade" id="modalreceita<?= $vler["orcamento_id"] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    $ver->ExeRead("app_orcamento_itens", "WHERE user_id = :a AND orcamento_id = :b", "a={$_SESSION["user_id"]}&b={$vler["orcamento_id"]}");
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
                <td> <a href="<?=CONF_URL_BASE ?>/orcamento.php?os=<?= $vler["orcamento_id"] ?>" target="_blank" style="font-size:2.0em; color:orange;"> <i class="fas fa-file-alt"></i> </a> </td>
                <td>
                 <?php 
                    $orc = str_pad($vler["orcamento_id"], 7, "0", STR_PAD_LEFT);
                    
                    $base = CONF_URL_BASE;
                    

                    
                   // $img = "https://www.localhost/dflixcontrolnew/uploads/images/2020/12/associacao.jpg";
                    
                    $proposta = ""
                            . "*Orcamento:* {$orc} %0A "
                            . "*".CONF_SITE_NAME."* %0A"
                            . "*Endereço:* ".CONF_SITE_ADDR_STREET."  Nº ".CONF_SITE_ADDR_NUMBER."  %0A"
                            . "*CEP:* ".CONF_SITE_ADDR_ZIPCODE." Cidade ".CONF_SITE_ADDR_ZIPCODE."  "
                            . "*Telefone*".CONF_SITE_ADDR_TELEFONE." %0A"
                            . "*ORÇAMENTO PARA VEICULO ABAIXO* %0A"
                            . "*Cliente:* {$vler["cliente"]} %0A"
                            . "*Veiculo:* {$vler["tipo"]} %0A"
                            . "*Marca:* {$vler["marca"]} %0A"
                            . "*Modelo:* {$vler["modelo"]} %0A"
                            . "*Placa:* {$vler["placa"]} %0A"
                            . "*Cor:* {$vler["cor"]} %0A"
                            . "Visualize seu orçamento %0A {$base}/orcamento.php?os={$vler["orcamento_id"]} %0A";
                    ?>
                   
                    
                    <a href="https://web.whatsapp.com/send?phone=55<?= $vler["telefone"] ?>&text=<?= $proposta ?>" target="_blank" style="font-size:2.5em; color:green; text-decoration: none;"> <i class="fab fa-whatsapp-square"></i></a> </td>
                <td> 
                    <?php if ($vler["status"] == "1") { ?>
                        <p style="color:#006cad; font-weight: bold;"> Enviado </p> 
                    <?php } ?>
                    <?php if ($vler["status"] == "2") { ?>
                        <p style="color:green; font-weight: bold;"> Executar </p> 
                    <?php } ?>
                    <?php if ($vler["status"] == "3") { ?>
                        <p style="color:red; font-weight: bold;"> Cancelar </p>
                    <?php } ?>
                   

                    <?php if ($vler["status"] == "2") { ?>
                        <!--- Aqui função dar entrada  -->
                      
                        Aqui entra função para entrada OS

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
                <td> <a href="./?p=servicos-itens&editar=<?= $vler["orcamento_id"] ?>"><i class="fas fa-edit"></i> </a></td>

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

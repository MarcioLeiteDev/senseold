<div class="container-fluid">


    <?php
    if (!empty($_GET["update"])) {

        $view = new Source\Models\Read();
        $view->ExeRead("invoices", "WHERE id = :a", "a={$_GET["update"]}");
        $view->getResult();

        $entrada = new \Source\Core\Saidas();
        $entrada->update();
    } elseif (!empty($_GET["delete"])) {

        $entrada = new \Source\Core\Saidas();
        $entrada->delete();
        
    } else {
        $entrada = new \Source\Core\Saidas();
        $entrada->create();
    }
    ?>

    </br></br>

    <div class="col-12">
        <h3 class="bg bg-light p-2 text-gray">Lançar Saidas</h3>

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
<?php
if (!empty($_GET["update"])) {
    echo "Editar Saida";
} else {
    echo "Lançar Saida";
}
?>
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Saidas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="POST" action="">
                            <div class="form-group">
                                <label>Data Pagamento</label>
                                <input type="date" name="date_payment" id="date" class="form-control input-datepicker"
<?php
if (!empty($_GET["update"])) {
    echo "value='{$view->getResult()[0]["date_payment"]}'";
}
?>
                                       />
                            </div>
                            <div class="form-group">
                                <label>Descrição</label>
                                <input type="text" name="title" class="form-control"                                        
                                    <?php
                                if (!empty($_GET["update"])) {
                                    echo "value='{$view->getResult()[0]["title"]}'";
                                }
?>/>
                            </div>
                            <div class="form-group">
                                <label>Valor</label>
                                <input type="text" name="valor"  class="form-control"                                        
<?php
if (!empty($_GET["update"])) {
    echo "value='{$view->getResult()[0]["value"]}'";
}
?>/>
                            </div>
                            <div class="form-group">
                                <label>Forma de Pagamento</label>
                                <select class="form-control" name="method_payment">
<?php
if (!empty($_GET["update"])) {
    echo "<option value='{$view->getResult()[0]["method_payment"]}'>{$view->getResult()[0]["method_payment"]}</option>";
}
?>
                                    <option value="dinheiro"> Dinheiro</option>
                                    <option value="pix"> PIX</option>
                                    <option value="credito"> Crédito</option>
                                    <option value="debito"> Débito</option>
                                    <option value="cheque"> Cheque</option>

                                </select>
                            </div>

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



                                    <input type="radio" name="tipo" value="Unica"  class="form"
<?php
if (!empty($_GET["update"])) {
    if ($view->getResult()[0]["type"] == "Unica") {
        echo "checked";
    }
}
?>

                                           >  Unica



                                    <input type="radio" name="tipo" value="Parcela" 
<?php
if (!empty($_GET["update"])) {
    if ($view->getResult()[0]["type"] == "Parcela") {
        echo "checked";
    }
}
?>
                                           > Parcela

                                    <!--<div class="camposExtras">
                                        Aqui vem os dados que é para esconder ou aparecer
                                    </div>-->


                                </div>                                       

                            </div>

                            <div class="row"> 



                                <div class="col-lg-12 js_parcelas" id="ocultar"> 
                                    </br>
                                    <label class="js_parcelas"> Parcelas </label>
<!--                                    <select name="js_parcelas" class="form-control"> 
<?php for ($i = 0; $i < 24; $i++) { ?>
                                                <option value="<?= $i; ?>"><?= $i; ?> </option>
<?php } ?>

                                    </select>-->

                                    <input type="text" name="js_parcelas" class="form-control" placeholder="Digitar para separado por barra ex : 5/15/45" 
                                            <?php
                                if (!empty($_GET["update"])) {
                                    echo "value='{$view->getResult()[0]["js_parcelas"]}'";
                                }
?>
                                           />
                                </div>
                            </div>

<?php
if (!empty($_GET["update"])) {
    ?>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option > Selecione Status</option>
                                        <option value="paid" > Pago</option>
                                        <option value="unpaid" > Em Aberto</option>
                                    </select>
                                </div>

<?php } ?>

                            <div class="form-group">
                                </br>
                                <input type="submit" class="btn btn-success" value="ENVIAR" />
                            </div>


                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>

                    </div>
                </div>
            </div>
        </div>



    </div>


    </br></br>

    <div class="row">
        <div class="col-md-3"> 
            <form action="" method="post" >
                <label>INICIO </label>
                <input type="date" id="date" name="inicio"  class="form-control input-datepicker" />
        </div>
        <div class="col-md-3"> 
            <label>FIM </label>
            <input type="date" id="date" name="fim"  class="form-control input-datepicker" />
        </div>
        <div class="col-md-3"> 
            <label>Status </label>
            <select name="status" class="form-control">
                <option value="paid">Pago</option>
                <option value="unpaid">Em Aberto</option>
                <option value="null">Todos Resultados</option>
            </select>
        </div>
        <div class="col-md-3"> 
            </br>

            <input type="submit" class="btn btn-success" value="BUSCAR" />
        </div>
        </form>


    </div>

    <div class="col-12">
<?php
$search = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if (!empty($search['inicio'])) {
    $inicio = date("d/m/Y", strtotime($search["inicio"]));
    $fim = date("d/m/Y", strtotime($search["fim"]));
    echo "</br><p>Sua busca entre periodos  <b> {$inicio} </b>  e <b> {$fim} </b> com status em <b> {$search["status"]}</b> retornou seguintes resultados.</p>";
}
?>
    </div>

    </br></br>

    <table class="table table-responsive-md">
        <thead>
            <tr>
                <th>Data</th>

                <th>Descrição</th>
                <th>Valor</th>
                <th>Metodo Pagamento</th>
                <th>Status</th>
                <th>Editar</th>
                <th>Deletar</th>
            </tr>
        </thead>
        <tbody>
<?php
$atual = filter_input(INPUT_GET, 'atual', FILTER_VALIDATE_INT);
$pager = new Source\Support\Pager('index.php?p=entradas&atual=', 'Primeira', 'Ultima', '1');
$pager->ExePager($atual, 10);

$search = filter_input_array(INPUT_POST, FILTER_DEFAULT);


if (!empty($search["inicio"])) {

    // echo "<p> Sua busca por <b>{$search["search"]}</b> trouxe os seguintes resultados. <a href='./index.php?p=orcamento'>limpar busca </a> </p>";

    $inicio = $search["inicio"];
    $fim = $search["fim"];

    $read = new Source\Models\Read();
    $read->ExeRead("invoices", "WHERE mode = :mod AND date_payment BETWEEN :D1 AND :D2 AND status = :s  LIMIT :limit OFFSET :offset", "D1={$inicio}&D2={$fim}&mod=0&s={$search["status"]}&limit={$pager->getLimit()}&offset={$pager->getOffset()}");
    $read->getResult();
} else {

    $mes = date("m");
    $ano = date("Y");

    $read = new Source\Models\Read();
    $read->ExeRead("invoices", "WHERE mode = :mod AND MONTH(date_payment) = :m AND YEAR(date_payment) = :y ORDER BY date_payment ASC LIMIT :limit OFFSET :offset", "m={$mes}&y={$ano}&mod=0&limit={$pager->getLimit()}&offset={$pager->getOffset()}");
    $read->getResult();
}

foreach ($read->getResult() as $value) {
    ?>
                <tr>
                    <td><?= date("d/m/Y", strtotime($value["date_payment"])) ?></td>

                    <td><?= $value["title"] ?></td>
                    <td><?= number_format($value["value"] / 100, 2, ",", ".") ?></td>
                    <td><?= $value["method_payment"] ?></td>
                    <td><?php
            if ($value["status"] == "paid") {
                echo "<p class='alert alert-success p-2'> PAGO</p>";
            }
            if ($value["status"] == "unpaid") {
                echo "<p class='alert alert-danger p-2'> EM ABERTO</p>";
            }
    ?></td>
                    <td><a href="index.php?p=entradas&update=<?= $value["id"] ?>"> <button class="btn btn-sm btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                                </svg> Editar</button></a></td>
                    <td>

                        <a href="index.php?p=entradas&delete=<?= $value["id"] ?>"><button class="btn btn-sm btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                                Deletar</button></a>


                    </td>
                </tr>
<?php } ?>

        </tbody>

    </table>

<?php
$pager->ExePaginator("invoices");
echo $pager->getPaginator();
?>
</div>

<script type="text/javascript">
    $(function () {
        $("#price").maskMoney();
    })
    $(function () {
        $("#price").maskMoney();
    })
</script>
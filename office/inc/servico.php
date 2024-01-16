<div class="container-fluid">
    <h1>Serviço</h1>
    <?php
    if (!empty($_GET["acao"]) && $_GET["acao"] == "contrato") {

        $servico = new \Source\Core\Servicos();
        $servico->AlteraContrato();
    }
    if (!empty($_GET["acao"]) && $_GET["acao"] == "arquivos") {

        $servicos = new \Source\Core\Servicos();
        $servicos->Arquivos();
    }
    if (!empty($_GET["acao"]) && $_GET["acao"] == "delete") {

        $servicos = new \Source\Core\Servicos();
        $servicos->destroy();
    }

    ?>

    <div class="row">

        <div class="col-md-2">
            <form action="" method="post">
                <label>INICIO </label>
                <input type="date" id="date" name="inicio" class="form-control input-datepicker" />
        </div>
        <div class="col-md-2">
            <label>FIM </label>
            <input type="date" id="date" name="fim" class="form-control input-datepicker" />
        </div>
        <?php

$data_atual = new DateTime();

// $leve = $data_atual + 15 dias
$leve = clone $data_atual;
$leve->modify('+15 days');

// $moderado = $data_atual + 11 dias
$moderado = clone $data_atual;
$moderado->modify('+11 days');

// $normal = $data_atual + 7 dias
$normal = clone $data_atual;
$normal->modify('+7 days');

// $urgente = $data_atual + 3 dias
$urgente = clone $data_atual;
$urgente->modify('+3 days');

// $atrasado = $data_atual
$atrasado = clone $data_atual;


?>

        <div class="col-md-2">
            <label>PRIORIDADE </label>
            <select name="prioridade" id="prioridade" class="form-control">
                <option value="">Selecione Prioridade</option>
                <option value="<?= $leve->format('Y-m-d') ?>">leve</option>
                <option value="<?= $leve->format('Y-m-d') ?>">moderado</option>
                <option value="<?= $moderado->format('Y-m-d') ?>">normal</option>
                <option value="<?= $normal->format('Y-m-d') ?>">urgente</option>
                <option value="<?= $atrasado->format('Y-m-d') ?>">atrasado</option>
                <option value="<?= $atrasado->format('Y-m-d') ?>">entregue</option>
            </select>
        </div>
        <div class="col-md-2">
            <form method="POST" name="search" action="">
                <label>CLIENTE </label>
                <input type="text" name="search" class="form-control" />

        </div>
        <div class="col-md-2">
            <label>PARCEIRO </label>
            <select name="parceiro" class="form-control">
                <?php
                if ($_SESSION["nivel"] == 2) {
                ?>
                    <option value="<?= $_SESSION["user_id"]; ?>"><?= $_SESSION["user_id"]; ?></option>
                <?php } else { ?>
                    <option value="">Selecione o Parceiro</option>
                    <?php
                    $parceiro = new \Source\Models\Read();
                    $parceiro->ExeRead("users", "WHERE level = :a OR level = :b", "a=2&b=3");
                    $parceiro->getResult();
                    foreach ($parceiro->getResult() as $value) {
                    ?>
                        <option value="<?= $value["id"] ?>"> <?= $value["name"] ?></option>
                <?php }
                } ?>
            </select>
        </div>
        <div class="col-md-2">

            <button type="submit" class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                </svg> BUSCAR</button>
            </form>
        </div>
    </div>

    </br></br>
    <?php
    $search = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    if (!empty($search)) {

        // var_dump($search);
        $parceiro = $search["parceiro"];
        $inicio = $search["inicio"];
        $fim = $search["fim"];
        $nome = $search["search"];
        $prioridade = $search['prioridade'];

        echo "<p>Sua Busca retornou os seguintes resutlados. <a href='./index.php?p=servico'>limpar busca</a></p>";
    }
    ?>
    <table class="table table-responsive-md">
        <thead>
            <tr>
                <?php if ($_SESSION["nivel"] == 3) { ?>
                    <th>Data Intrada</th>
                    <th>Data Saida</th>
                    <th>Prioridade</th>
                    <th>Observações</th>
                <?php } ?>
                <th>Nome Serviço</th>
                <th>Orçamemto</th>
                <th>Preço</th>
                <th>Metodo Pagamento</th>
                <th>Árvore Genealógica</th>
                <th>Contrato</th>
                <th>Parceiro</th>
                <th>Arquivos</th>
                <th>Pagamentos</th>
                <th>Editar</th>
                <th>Deletar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $atual = filter_input(INPUT_GET, 'atual', FILTER_VALIDATE_INT);
            $pager = new Source\Support\Pager('index.php?p=servico&atual=', 'Primeira', 'Ultima', '1');
            $pager->ExePager($atual, 5);


            if (!empty($search)) {

                if ($inicio) {
                    $queryD = "end BETWEEN :d1 AND :d2";
                    $paramD = "d1={$inicio}&d2={$fim}&";
                } else {
                    $queryD = null;
                    $paramD = null;
                }

                $data_atual = date('Y-m-d');

                if ($prioridade) {
                    $queryD = "end BETWEEN :d1 AND :d2";
                    $paramD = "d1={$data_atual}&d2={$prioridade}&";
                } else {
                    $queryD = null;
                    $paramD = null;
                }

                if ($nome) {

                    if ($inicio) {
                        $query1 = "AND name LIKE '%' :n '%'";
                        $param1 = "n={$nome}&";
                    } else {
                        $query1 = "name LIKE '%' :n '%'";
                        $param1 = "n={$nome}&";
                    }
                } else {
                    $query1 = null;
                    $param1 = null;
                }

                if ($parceiro) {

                    if ($inicio || $nome) {
                        $query2 = "AND employer = :e";
                        $param2 = "e={$parceiro}&";
                    } else {
                        $query2 = "employer = :e";
                        $param2 = "e={$parceiro}";
                    }
                } else {
                    $query2 = null;
                    $param2 = null;
                }

                $servicos = new \Source\Models\Read();
                $servicos->ExeRead("services", "WHERE {$queryD} {$query1} {$query2} ORDER BY id DESC LIMIT :limit OFFSET :offset", "{$paramD}&{$param1}&{$param2}&limit={$pager->getLimit()}&offset={$pager->getOffset()}");
                $servicos->getResult();

        
            } else {

                if ($_SESSION["nivel"] == 2) {
                    $servicos = new \Source\Models\Read();
                    $servicos->ExeRead("services", "WHERE employer = :a ORDER BY id DESC LIMIT :limit OFFSET :offset", "a={$_SESSION["user_id"]}&limit={$pager->getLimit()}&offset={$pager->getOffset()}");
                    $servicos->getResult();
                }

                if ($_SESSION["nivel"] == 3) {
                    $servicos = new \Source\Models\Read();
                    $servicos->ExeRead("services", "ORDER BY end DESC LIMIT :limit OFFSET :offset", "limit={$pager->getLimit()}&offset={$pager->getOffset()}");
                    $servicos->getResult();
                }
                
            }
            
            foreach ($servicos->getResult() as $value) {
            ?>
                <tr>
                    <?php if ($_SESSION["nivel"] == 3) { ?>
                        <td><?= date("d/m/Y", strtotime($value["start"])); ?></td>
                        <td><?= date("d/m/Y", strtotime($value["end"])); ?></td>
                        <td>
                            <?php
                            // Suponha que você tenha a data de entrada e a data de saída armazenadas nas variáveis $start e $value["end"]
                            $dataInicio = date("Y-m-d");
                            $dataFim = $value["end"];

                            // Cria objetos DateTime para as datas de entrada e saída
                            $inicio = new DateTime($dataInicio);
                            $fim = new DateTime($dataFim);

                            // Calcula a diferença entre as duas datas
                            $diferenca = $inicio->diff($fim);

                            // Obtém a diferença em dias
                            $diferencaEmDias = $diferenca->days;

                            $prazo = "Prazo: " . $diferencaEmDias . " dias";

                            // Define os prazos para cada nível de prioridade
                            $prazoLeve = 15;
                            $prazoModerado = 11;
                            $prazoNormal = 7;
                            $prazoUrgente = 4;
                            $prazoAtrasado = 1;

                            // Determina a prioridade com base na diferença em dias
                            if ($diferencaEmDias >= $prazoLeve) {
                                $prioridade = "leve"; // grau 1
                            } elseif ($diferencaEmDias >= $prazoModerado) {
                                $prioridade = "moderado"; // grau 2
                            } elseif ($diferencaEmDias >= $prazoNormal) {
                                $prioridade = "normal"; // grau 3
                            } elseif ($diferencaEmDias >= $prazoUrgente) {
                                $prioridade = "urgente"; // grau 4
                            } elseif ($diferencaEmDias >= $prazoAtrasado) {
                                $prioridade = "atrasado"; // grau 5
                            } elseif ($diferencaEmDias <= $prazoAtrasado) {
                                $prioridade = "entregue ou atrasado"; // grau 5
                            } else {
                                $prioridade = "indefinido"; // ou qualquer valor padrão que você deseje atribuir
                            }                    

                            ?>

                            <?php if ($prioridade === "leve") { ?>

                                <div class="alert alert-info" role="alert">
                                    <?= $prioridade ?> </br> <?= $prazo ?>
                                </div>

                            <?php } ?>

                            <?php if ($prioridade === "moderado") { ?>

                                <div class="alert alert-primary" role="alert">
                                    <?= $prioridade ?> </br> <?= $prazo ?>
                                </div>

                            <?php } ?>
                            
                            <?php if ($prioridade === "normal") { ?>

                                <div class="alert alert-warning" role="alert">
                                    <?= $prioridade ?> </br> <?= $prazo ?>
                                </div>

                            <?php } ?>

                            <?php if ($prioridade === "urgente") { ?>

                                <div class="alert alert-danger" role="alert">
                                    <?= $prioridade ?> </br> <?= $prazo ?>
                                </div>

                            <?php } ?>

                            <?php if ($prioridade === "atrasado") { ?>

                                <div class="alert alert-danger" role="alert">
                                    <?= $prioridade ?> </br> <?= $prazo ?>
                                </div>

                            <?php } ?>

                            <?php if ($prioridade === "entregue ou atrasado") { ?>

                                <div class="alert alert-success" role="alert">
                                    <?= $prioridade ?> </br> <?= $prazo ?>
                                </div>

                            <?php } ?>
                        </td>
                        <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#obs<?= $value["id"] ?>">
                                Observações
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="obs<?= $value["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Observações</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <?= $value["obs"] ?>
                                            <hr>
                                            <a href="./index.php?p=cad-servico&update=<?= $value["id"] ?>"><button class="btn btn-primary">Editar</button></a>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    <?php } ?>
                    <td><?= $value["name"] ?></td>
                    <td><?php
                        $budget = new \Source\Models\Read();
                        $budget->ExeRead("budget", "WHERE id = :a", "a={$value["budget"]}");
                        $budget->getResult();
                        ?>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#orcamento<?= $value["budget"] ?>">
                            Orçamento
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="orcamento<?= $value["budget"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Orçamentos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <?= $budget->getResult()[0]["content"] ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                    <td><?= number_format($value["price"] / 100, 2, ",", ".") ?></td>
                    <td><?= $value["method_payment"] ?></td>
                    <td>


                        <A href="./index.php?p=arvore&servico=<?= $value["id"] ?>"> <button class="btn btn-success">Árvore Genealógica</button> </a>



                    </td>
                    <td>
                        <form method="POST" action="./index.php?p=servico&acao=contrato" class="form-inline">
                            <select name="contract" class="form-control">
                                <option>Selecione</option>
                                <?php
                                $read = new Source\Models\Read();
                                $read->ExeRead("contracts");
                                $read->getResult();
                                foreach ($read->getResult() as $contrato) {
                                ?>
                                    <option value="<?= $contrato["id"] ?>"><?= $contrato["title"] ?></option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="id" value="<?= $value["id"] ?>" />
                            <input type="submit" value="alterar" class="btn btn-success btn-sm" />
                        </form>
                        <a href="./contrato.php?servico=<?= $value["id"] ?>"> Download Contrato </a>
                    </td>
                    <td><?php
                        $employer = new \Source\Models\Read();
                        $employer->ExeRead("users", "WHERE id = :a", "a={$value["employer"]}");
                        echo $employer->getResult()[0]["name"];
                        ?></td>
                    <td>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal<?= $value["id"] ?>">
                            Arquivos
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal<?= $value["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Arquivos</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">


                                        <h3>Arquivos</h3>


                                        <h2>Enviar Arquivos</h2>
                                        <form method="POST" action="./index.php?p=servico&acao=arquivos" enctype="multipart/form-data" class="form-inline">
                                            <div class="form-group">
                                                <label>Arquivo</label>
                                                <input type="file" name="archive" class="form-control" />
                                                <input type="hidden" name="budget" value="<?= $value["budget"] ?>" class="form-control" />
                                                <input type="hidden" name="employer" value="<?= $value["employer"] ?>" class="form-control" />
                                                <input type="hidden" name="user_id" value="<?= $value["user_id"] ?>" class="form-control" />
                                                <input type="hidden" name="service_id" value="<?= $value["id"] ?>" class="form-control" />
                                                <input type="submit" name="submit" value="ENVIAR" class="btn btn-success" />
                                            </div>

                                        </form>

                                        <?php
                                        $arquivo = new \Source\Models\Read();
                                        $arquivo->ExeRead("archives", "WHERE service_id = :a", "a={$value["id"]}");
                                        $arquivo->getResult();
                                        foreach ($arquivo->getResult() as $arquivos) {
                                        ?>
                                            <p>Arquivo: <a href="<?= CONF_URL_BASE ?>/office/uploads/<?= $arquivos["archive"] ?>" target="_blank"> <?= $arquivos["archive"] ?> </a> </p>

                                        <?php } ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                    <td>
                        <!-- Aqui area de pagamentos -->

                        <?php
                        $ver = new Source\Models\Read();
                        $ver->ExeRead("invoices", "WHERE service_id = :a", "a={$value["id"]}");
                        $ver->getResult();
                        $soma = 1;
                        foreach ($ver->getResult() as $valor) {
                            $soma += $valor["value"];
                        }

                        $resto = $value["price"] - $soma;

                        // $falta = $value["price"] - $soma;

                        echo "Falta Lançar R$ " . number_format($resto / 100, 2, ",", ".");

                        if ($resto > 0) {
                        ?>
                            </br>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#faturasModal<?= $value["id"] ?>">
                                Lançar Entradas
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="faturasModal<?= $value["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Lançar Entradas</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form method="POST" action="">
                                                <div class="form-group">
                                                    <label>Data Pagamento</label>
                                                    <input type="date" name="date_payment" id="date" class="form-control input-datepicker" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Descrição</label>
                                                    <input type="text" name="title" class="form-control" />
                                                    <input type="hidden" name="service_id" value="<?= $value["id"] ?>" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Valor</label>
                                                    <input type="text" name="valor" class="form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label>Forma de Pagamento</label>
                                                    <select class="form-control" name="method_payment">

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
                                                            $(function() {

                                                                $(".camposExtras").hide();
                                                                $(".js_fixa").hide();
                                                                $(".js_parcelas").hide();
                                                                $('input[name="tipo"]').change(function() {
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



                                                        <input type="radio" name="tipo" value="Unica"> Unica



                                                        <input type="radio" name="tipo" value="Parcela"> Parcela

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

                                                        <input type="text" name="js_parcelas" class="form-control" placeholder="Digitar para separado por barra ex : 5/15/45" />
                                                    </div>
                                                </div>



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


                        <?php } ?>
                    </td>

                    <td><a href="./index.php?p=cad-servico&update=<?= $value["id"] ?>"><button class="btn btn-primary">Editar</button></a> </td>
                    <td><a href="./index.php?p=servico&acao=delete&id=<?= $value["id"] ?>"><button class="btn btn-danger"> Deletar</button></a> </td>


                </tr>
            <?php } ?>

        </tbody>

    </table>


    <?php
    $pager->ExePaginator("services");
    echo $pager->getPaginator();
    ?>
    <?php
    // var_dump($search);
    if ($search) {
    ?>
        <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
            </svg> <a href="./relatorio_servicos.php?array=<?php print_r($search)  ?>" target="_blank">Download Relatório</a></p>
    <?php } ?>
</div>
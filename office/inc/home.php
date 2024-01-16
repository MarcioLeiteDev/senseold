<?php 
    if($_SESSION["nivel"] == 2){
?>
<div class="container-fluid">
<h1>Dashboard</h1>
<p>Seja Bem Vindo <?= $_SESSION["nome"] ?>  </p>
</div>
<?php }?>
<?php 
    if($_SESSION["nivel"] == 3){
?>
<div class="container-fluid">

    <div class="row">
        <div class="col-md-4"> 
            <form action="" method="post" >
                <label>INICIO </label>
                <input type="date" id="date" name="inicio"  class="form-control input-datepicker" />
        </div>
        <div class="col-md-4"> 
            <label>FIM </label>
            <input type="date" id="date" name="fim"  class="form-control input-datepicker" />
        </div>
        <div class="col-md-4"> 
            </br>
            <input type="submit" class="btn btn-success" value="BUSCAR" />
        </div>
        </form>


    </div>

    <div class="col-md-12">
        <?php
        $search = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($search)) {
            $inicio = date("d/m/Y", strtotime($search["inicio"]));
            $fim = date("d/m/Y", strtotime($search["fim"]));
            echo "</br><p>Sua busca entre periodos  <b> {$inicio} </b>  e <b> {$fim} </b> retornou seguintes resultados.</p>";
        }
        ?>
    </div>

    <div class="row">

        <div class="col-md-6" >

            <div class="card-body">
                <h5 class="card-title bg-info text-white p-3">Orçamentos</h5>
                <table class="table">

                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Orçamento</th>
                            <th>Valor</th>
                            <th>Funcionario</th>
                            <!--th>Status</th-->
                            
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        if (!empty($search)) {

                            $inicio = $search["inicio"];
                            $fim = $search["fim"];

                            $orcamentos = new \Source\Models\Read();
                            $orcamentos->ExeRead("budget", "WHERE data BETWEEN :D1 AND :D2", "D1={$inicio}&D2={$fim}");
                            $orcamentos->getResult();

                            //  echo "Aqui faz a busca";  
                        } else {

                            $mes = date("m");
                            $ano = date("Y");

                            $orcamentos = new \Source\Models\Read();
                            $orcamentos->ExeRead("budget", "WHERE MONTH(data) = :c AND YEAR(data) = :d", "c={$mes}&d={$ano}");
                            $orcamentos->getResult();
                        }

                        //var_dump($search);

                        foreach ($orcamentos->getResult() as $value) {
                            ?>
                            <tr>
                                <td style="font-size: 0.7em;"><?= date("d/m/Y", strtotime($value["data"])) ?></td>
                                <td><?= $value["name"] ?></td>
                                <td><?= number_format($value["price"] / 100, 2, ",", ".") ?></td>
                                <td><?php
                        $funcionario = new \Source\Models\Read();
                        $funcionario->ExeRead("users", "WHERE id = :a", "a={$value["user_id"]}");
                        echo $funcionario->getResult()[0]["name"];
                            ?></td>
                                <td><?php
                                    if ($value["status"] == 1) {
                                        echo "<p class='alert alert-warning'> Criado </p>";
                                    }
                                    if ($value["status"] == 2) {
                                        echo "<p class='alert alert-info'> Enviado </p>";
                                    }
                                    if ($value["status"] == 3) {
                                        echo "<p class='alert alert-success'> Aprovado </p>";
                                    }
                                    ?></td>   
                            </tr>


                                <?php } ?>


                    </tbody>
                </table>

            </div>
        </div>


        <div class="col-md-6" >

            <div class="card-body">
                <h5 class="card-title bg-info text-white p-3">Serviços</h5>
                <table class="table">

                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Orçamento</th>
                            <th>Valor</th>
                            <th>Arquivos</th>
                            <th>Funcionario</th>
                            <!--th>Status</th-->
                        </tr>
                    </thead>

                    <tbody>

<?php
if (!empty($search)) {

    $inicio = $search["inicio"] . " 00:00:00";
    $fim = $search["fim"] . " 23:59:59";

    $services = new \Source\Models\Read();
    $services->ExeRead("services", "WHERE created_at BETWEEN :D1 AND :D2", "D1={$inicio}&D2={$fim}");
    $services->getResult();

    //  echo "Aqui faz a busca";  
} else {

    $mes = date("m");
    $ano = date("Y");

    $services = new \Source\Models\Read();
    $services->ExeRead("services", "WHERE MONTH(created_at) = :c AND YEAR(created_at) = :d", "c={$mes}&d={$ano}");
    $services->getResult();
}

//var_dump($search);

foreach ($services->getResult() as $value) {
    ?>
                            <tr>
                                <td style="font-size: 0.7em;"><?= date("d/m/Y", strtotime($value["created_at"])) ?></td>
                                <td><?= $value["name"] ?></td>
                                <td><?= number_format($value["price"] / 100, 2, ",", ".") ?></td>
                                <td>

                              

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalArquivos<?= $value["id"] ?>">
                                        Arquivos
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="modalArquivos<?= $value["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php
                                                    $arquivos = new \Source\Models\Read();
                                                    $arquivos->ExeRead("archives", "WHERE service_id = :a", "a={$value["id"]}");
                                                    $arquivos->getResult();
                                                    foreach ($arquivos->getResult() as $value) {
       
                                                            ?>
                                                    
                                                    <p> Arquivo : <a href="<?=CONF_URL_BASE ?>/uploads/<?=$value["archive"] ?>" target="blank"> <?=$value["archive"] ?> </a> </p>
                                                    <?php } ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </td>
                                <td><?php
                        $funcionario = new \Source\Models\Read();
                        $funcionario->ExeRead("users", "WHERE id = :a", "a={$value["employer"]}");
                        echo $funcionario->getResult()[0]["name"];
                        ?></td>
                                <!--td><?php
                        if ($value["status"] == 1) {
                            echo "<p class='alert alert-warning'> Criado </p>";
                        }
                        if ($value["status"] == 2) {
                            echo "<p class='alert alert-info'> Documento Enviado </p>";
                        }
                        if ($value["status"] == 3) {
                            echo "<p class='alert alert-success'> Em Processo </p>";
                        }
                        if ($value["status"] == 4) {
                            echo "<p class='alert alert-success'> Finalizado </p>";
                        }
                        if ($value["status"] == 5) {
                            echo "<p class='alert alert-success'> entregue </p>";
                        }
                        if ($value["status"] == 6) {
                            echo "<p class='alert alert-success'> Faturado </p>";
                        }
    ?></td-->   
                            </tr>


                                <?php } ?>


                    </tbody>
                </table>

            </div>
        </div>


        <div class="card" style="width: 29%; margin: 2%;">

            <div class="card-body">
                <h5 class="card-title bg bg-success p-2 text-white">Entradas</h5>
                <p class="card-text" style="font-size:1.2em; font-weight: bold;">
                    <?php 
                    $entrada = new \Source\Core\Entradas();
                    echo "R$ ".$entrada->Agora();
                    ?>
                    </p>
                <a href="index.php?p=entradas" class="btn btn-success">Lançar Entradas</a>
            </div>
        </div>

        <div class="card" style="width: 29%; margin: 2%;">

            <div class="card-body">
                <h5 class="card-title bg bg-danger p-2 text-white">Saidas</h5>
                <p class="card-text" style="font-size:1.2em; font-weight: bold;">
                     <?php 
                     $saida = new Source\Core\Saidas();
                    echo "R$ " . $saida->Agora();
                     ?>
                </p>
                <a href="index.php?p=saidas" class="btn btn-danger">Lançar Saidas</a>
            </div>
        </div>

        <div class="card" style="width: 29%; margin: 2%;">
            <?php 
            $balanco = $entrada->Agora() - $saida->Agora();
            
           
            ?>
            <div class="card-body">
                <h5 class="card-title <?php 
                if($balanco < 0 ){
                    echo "bg bg-danger p-2 text-white";
                }else{
                    echo "bg bg-success p-2 text-white";
                }
                ?>">Balanço</h5>
                <p class="card-text" style="font-size:1.2em; font-weight: bold;">R$ <?= $balanco ?></p>
                
            </div>
        </div>



    </div>
    
    
    <!--div class="col-12">
        <div id="curve_chart" style="width: 100%; height: 500px"></div>
    </div-->
    


</div>



  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mês', 'Entradas', 'Saidas'],

  
          ['<?php echo $menosUm = date("M", strtotime("-2 month")); ?>', <?php echo $entrada->menosDois(); ?> , <?php echo $saida->menosDois(); ?> ],
          ['<?php echo $menosUm = date("M", strtotime("-1 month")); ?>', <?php echo $entrada->menosUm(); ?> , <?php echo $saida->menosUm(); ?> ],
          ['<?php echo $agora = date('M');?>',  <?php echo $entrada->Agora(); ?> ,      <?php echo $saida->Agora() ?> ]
        ]);

        var options = {
          title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>

<?php } ?>



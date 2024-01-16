<div class="container-fluid">

    <div class="col-md-12">
        <h1>Orçamentos</h1>
        <?php
        $orcamento = new \Source\Core\Orcamento();
        $orcamento->delete();

        $orcamento->enviarEmail();
        ?>
    </div> 
    <div class="row">

        <div class="col-md-2"> 
            <form action="" method="post" >
                <label>INICIO </label>
                <input type="date" id="date" name="inicio"  class="form-control input-datepicker" />
        </div>
        <div class="col-md-2"> 
            <label>FIM </label>
            <input type="date" id="date" name="fim"  class="form-control input-datepicker" />
        </div>
        <div class="col-md-3">
            <form method="POST" name="search"  action="">
                <label>CLIENTE </label>
                <input type="text" name="search" class="form-control" />

        </div>
        <div class="col-md-3">
            <label>PARCEIRO </label>
            <select name="parceiro" class="form-control">
                <?php 
                if($_SESSION["nivel"] == 2){
                ?>
                 <option value="<?= $_SESSION["user_id"] ?>"> <?= $_SESSION["user_id"] ?> </option>
                <?php  }else{ ?>
                <option value="">Selecione o Parceiro</option>
                <?php
                $parceiro = new \Source\Models\Read();
                $parceiro->ExeRead("users", "WHERE level = :a OR level = :b", "a=2&b=3");
                $parceiro->getResult();
                foreach ($parceiro->getResult() as $value) {
                  
                    ?>
               
                    
                    <option value="<?= $value["id"] ?>"> <?= $value["name"] ?></option>
                   
                <?php } }?>
            </select>
        </div>
        <div class="col-md-2">

            <button type="submit"  class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg> BUSCAR</button> 
            </form>
        </div>
    </div>
</br>  </br> </br>

<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>Data</th>
            <th>Cliente</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Parceiro</th>
            <th>Valor</th>
            <th>Orçamento</th>
            <th>Status</th>
            <th>Enviar</th>
            <th>Editar</th>
            <th>Remover</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $atual = filter_input(INPUT_GET, 'atual', FILTER_VALIDATE_INT);
        $pager = new Source\Support\Pager('index.php?p=orcamento&atual=', 'Primeira', 'Ultima', '1');
        $pager->ExePager($atual, 5);

        $search = filter_input_array(INPUT_POST, FILTER_DEFAULT);


        if (!empty($search)) {

            echo "<p> Sua busca retornou os seguintes Resultados. <a href='./index.php?p=orcamento'>limpar busca </a> </p>";

            // var_dump($search);

            if ($_SESSION["nivel"] == 3) {

                $inicio = $search["inicio"];
                $fim = $search["fim"];

                if ($search["inicio"]) {

                    $queryD = "data BETWEEN :d1 AND :d2";
                    $paramD = "d1={$inicio}&d2={$fim}";
                    $and = " AND ";
                    // echo "Qery da data";
                } else {
                    $queryD = null;
                    $paramD = null;
                    $and = null;
                    // echo "query data nulo";
                }

                if ($search["search"]) {
                    $query1 = "{$and} name LIKE '%' :link '%'";
                    $param1 = "&link={$search["search"]}";
                    // echo "query do nome";
                } else {
                    $query1 = null;
                    $param1 = null;
                    // echo "query nula do nome ";
                }

                if ($search["parceiro"]) {

                    if ($search["inicio"]) {
                        $query2 = " {$and} user_id = :b ";
                        $param2 = "&b={$search["parceiro"]}";
                    } elseif ($search["search"]) {
                        $query2 = "{$and} user_id = :b";
                        $param2 = "&b={$search["parceiro"]}";
                    } else {
                        $query2 = "user_id = :b";
                        $param2 = "b={$search["parceiro"]}";
                    }
                } else {
                    $query2 = null;
                    $param2 = null;
                    //echo "&b={$search["parceiro"]}";
                }

                $read = new Source\Models\Read();
                $read->ExeRead("budget", "WHERE {$queryD} {$query1} {$query2}  ORDER BY id DESC LIMIT :limit OFFSET :offset", "{$paramD}{$param1}{$param2}&limit={$pager->getLimit()}&offset={$pager->getOffset()}");
                $read->getResult();
            } else {

                echo "sem buscas";

                $read = new Source\Models\Read();
                $read->ExeRead("budget", "ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$pager->getLimit()}&offset={$pager->getOffset()}");
                $read->getResult();

                echo "sem buscas";
            }
        } else {

            //Resultados sem busca 

            if ($_SESSION["nivel"] == 3) {
                $read = new Source\Models\Read();
                $read->ExeRead("budget", "ORDER BY id DESC LIMIT :limit OFFSET :offset", "limit={$pager->getLimit()}&offset={$pager->getOffset()}");
                $read->getResult();
            }

            if ($_SESSION["nivel"] == 2) {
               // var_dump($_SESSION);
                $read = new Source\Models\Read();
                $read->ExeRead("budget", "WHERE user_id = :a ORDER BY id DESC LIMIT :limit OFFSET :offset", "a={$_SESSION["user_id"]}&limit={$pager->getLimit()}&offset={$pager->getOffset()}");
                $read->getResult();
            }
        }




        foreach ($read->getResult() as $value) {
            ?>

            <tr>
                <td><?= date("d/m/Y", strtotime($value["data"])) ?></td>
                <td><?= $value["name"] ?></td>
                <td><?= $value["email"] ?></td>
                <td><?= $value["phone"] ?></td>
                <td><?php
        $vendedor = new Source\Models\Read();
        $vendedor->ExeRead("users", "WHERE id = :a", "a={$value["user_id"]}");

        echo $vendedor->getResult()[0]["name"];
            ?></td>
                <td><?= number_format($value["price"] / 100, 2, ",", ".") ?></td>
                <td>
                    <a href="./orcamento.php?id=<?= $value["id"] ?>" target="_blank"> <button class="btn btn-sm btn-success">Orçamento</button> </a>
                </td>
                <td><?php
                if ($value["status"] == 1) {
                    echo "<p class='bg-warning p-1 text-white'>Criado</p>";
                }
                if ($value["status"] == 2) {
                    echo "<p class='bg-info p-1 text-white'>Enviado</p>";
                }
                if ($value["status"] == 3) {
                    echo "<p class='bg-success p-1 text-white'>Aprovado</p>";
                }
            ?></td>
                <td>

                    <!-- enviar mensagens -->
                    <a href="index.php?p=orcamento&name=<?= $value["name"] ?>&email=<?= $value["email"] ?>&phone=<?= $value["phone"] ?>&content=<?= $value["id"] ?>">   <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                        </svg> </a>

                    <hr>

    <?php
    $base = CONF_URL_BASE;

    $whatsapp = str_replace("(", "", $value["phone"]);
    $whatsapp = str_replace(")", "", $value["phone"]);
    $whatsapp = str_replace("-", "", $value["phone"]);
    $whatsapp = str_replace(" ", "", $value["phone"]);

    $proposta = ""
            . "*Orcamento Sense Translate %0A "
            . "* Ola {$value["name"]} Conforme Combinado Segue Orçamento. %0A"
            . "Visualize seu orçamento baixe PDF %0A {$base}/office/orcamento.php?id={$value["id"]} %0A";
    ?>

                        <a href="https://api.whatsapp.com/send?phone=55<?= $whatsapp ?>&text=<?= $proposta ?>" target="_blank">    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                            </svg> </a>

                </td>
                <td>

                    <a href="index.php?p=editar-orcamento&id=<?= $value["id"] ?>"><button class="btn btn-sm btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                            </svg> Editar</button></a>

                </td>
                <td>

                    <a href="index.php?p=orcamento&delete=<?= $value["id"] ?>"><button class="btn btn-sm btn-danger">
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
$pager->ExePaginator("budget");
echo $pager->getPaginator();
?>
<?php
if ($search) {
    ?>
    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
            <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
        </svg> <a href="./relatorio_orcamento.php?array=<?php print_r($search) ?>" target="_blank">Download Relatório</a></p>
<?php } ?>
</div>
</div>


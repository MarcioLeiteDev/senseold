<div class="container-fluid">
    <h1>Clientes</h1>
    <?php 
    if(!empty($_GET["delete"])){
    $cliente = new \Source\Core\Clientes();
    $cliente->destroy();
    
    }
    ?>

    <div class="row">
        <div class="col-md-10">
            <form method="POST" name="search" action="" >
                <input type="text" name="search" class="form-control" />

        </div>
        <div class="col-md-2">

            <button type="submit"  class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg> BUSCAR</button> 
            </form>
        </div>
    </div>

</br></br>

<table class="table table-responsive-md">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Funcionario</th>

            <th>Serviços</th>
            <th>Arquivos</th>
            <th>Editar</th>
            <th>Deletar</th>
        </tr>
    </thead> 
    <tbody>
        <?php
        $atual = filter_input(INPUT_GET, 'atual', FILTER_VALIDATE_INT);
        $pager = new Source\Support\Pager('index.php?p=cliente&atual=', 'Primeira', 'Ultima', '1');
        $pager->ExePager($atual, 5);

        $search = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($search)) {

            echo "<p> Sua busca por <b>{$search["search"]}</b> trouxe os seguintes resultados. <a href='./index.php?p=cliente'>limpar busca </a> </p>";
            if ($_SESSION["nivel"] == 2) {
                $cliente = new \Source\Models\Read();
                $cliente->ExeRead("users", "WHERE user_id = :b AND level = :a AND name LIKE '%' :link '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "b={$_SESSION["user_id"]}&a=1&link={$search["search"]}&limit={$pager->getLimit()}&offset={$pager->getOffset()}");
                $cliente->getResult();
            }
            if ($_SESSION["nivel"] == 3) {
                $cliente = new \Source\Models\Read();
                $cliente->ExeRead("users", "WHERE level = :a AND name LIKE '%' :link '%' ORDER BY id DESC LIMIT :limit OFFSET :offset", "a=1&link={$search["search"]}&limit={$pager->getLimit()}&offset={$pager->getOffset()}");
                $cliente->getResult();
            }
        } else {

            if ($_SESSION["nivel"] == 2) {
                $cliente = new \Source\Models\Read();
                $cliente->ExeRead("users", "WHERE user_id = :b AND level = :a ORDER BY id DESC LIMIT :limit OFFSET :offset", "b={$_SESSION["user_id"]}&a=1&limit={$pager->getLimit()}&offset={$pager->getOffset()}");
                $cliente->getResult();
            }

            if ($_SESSION["nivel"] == 3) {
                $cliente = new \Source\Models\Read();
                $cliente->ExeRead("users", "WHERE level = :a ORDER BY id DESC LIMIT :limit OFFSET :offset", "a=1&limit={$pager->getLimit()}&offset={$pager->getOffset()}");
                $cliente->getResult();
            }
        }


        foreach ($cliente->getResult() as $value) {
            ?>
            <tr>
                <td><?= $value["name"] ?></td>
                <td><?= $value["email"] ?></td>
                <td><?= $value["phone"] ?></td>
                <td><?php
                    $funcionario = new \Source\Models\Read();
                    $funcionario->ExeRead("users", "WHERE id = :a", "a={$value["user_id"]}");
                    if ($funcionario->getResult()) {
                        echo $funcionario->getResult()[0]["name"];
                    } else {
                        null;
                    }
                    ?></td>         
                <td>
                    <?php
                    $servicos = new \Source\Models\Read();
                    $servicos->ExeRead("services", "WHERE user_id = :a", "a={$value["id"]}");
                    $servicos->getResult();
                    foreach ($servicos->getResult() as $servico) {
                        ?>
                        <p><?= $servico["name"] ?></p>
                    <?php } ?>

                </td>
                <td>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?= $value["id"] ?>">
                        Arquivos
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal<?= $value["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Arquivos</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h3>Arquivos enviados </h3>
                                    <?php
                                    $arquivos = new \Source\Models\Read();
                                    $arquivos->ExeRead("archives", "WHERE user_id = :a", "a={$value["id"]}");
                                    $arquivos->getResult();
                                    foreach ($arquivos->getResult() as $arquivo) {
                                        ?>

                                        <p> Arquivos :<a href="<?= CONF_URL_BASE ?>/uploads/<?= $arquivo["archive"] ?>" target="_blank"> <?= $arquivo["archive"] ?> </a></p>

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

                    <!--Editar  -->
                    <a href="index.php?p=editar-cliente&id=<?= $value["id"] ?>"><button class="btn btn-sm btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                            </svg> Editar</button></a>
                </td>
                
                <td>
                       <!--Deletar  -->
                    <a href="index.php?p=cliente&delete=<?= $value["id"] ?>"><button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i> Excluir</button></a>
                    
                </td>

            </tr>
        <?php } ?>
    </tbody> 

</table>

<?php
$pager->ExePaginator("users");
echo $pager->getPaginator();
?>
</div>


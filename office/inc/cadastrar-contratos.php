<div class="container-fluid">
    <h3>Cadastrar Contratos </h3>
    <?php
    if (!empty($_GET["update"])){

        $contrato = new Source\Core\Contratos();
        $contrato->editar ();
        
        $view = new Source\Models\Read();
        $view->ExeRead("contracts", "WHERE id = :a", "a={$_GET["update"]}");
        $view->getResult();
        
        }elseif (!empty($_GET["delete"])){
            
          $contrato = new Source\Core\Contratos();
          $contrato->delete();

    }else {

        $contrato = new Source\Core\Contratos();
        $contrato->cadastra();
    }
    ?>

    <div class="col-12">

        <form action="" method="POST"> 

            <div class="form-group">
                <label>Titulo</label>
                <input type="text" name="title" class="form-control" 
                       <?php 
                       if(!empty($_GET["update"])){
                           echo "value='{$view->getResult()[0]["title"]}'";
                       }
                       ?>
                       />
            </div>


            <div class="form-group">
                <label>Conteudo</label>
                <textarea id="mytextarea" name="content" class="form-control" >
                 <?php 
                       if(!empty($_GET["update"])){
                           echo "{$view->getResult()[0]["content"]}";
                       }
                       ?>
                </textarea>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-success" value="CADASTRAR" />
            </div>

        </form>

    </div>


    <div class="col-12">
        <table class="table table-responsive-md">
            <thead>
                <tr>
                    <th>Titulo</th>              
                    <th>Editar</th>
                    <th>Deletar</th>
                </tr>
            </thead>

            <tbody>
<?php
$contratos = new Source\Models\Read();
$contratos->ExeRead("contracts", "ORDER BY id DESC");
$contratos->getResult();
foreach ($contratos->getResult() as $value) {
    ?>
                    <tr>
                        <td><?= $value["title"] ?></td>        
                        <td><a href="index.php?p=cadastrar-contratos&update=<?= $value["id"] ?>"> <button class="btn btn-info btn-sm"> Editar</button> </a></td>
                        <td><a href="index.php?p=cadastrar-contratos&delete=<?= $value["id"] ?>"> <button class="btn btn-danger btn-sm"> Deletar</button> </a></td>
                    </tr>
<?php } ?>
            </tbody>
        </table>
    </div>

</div>


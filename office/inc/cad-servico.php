<div class="container">
<?php

    if (!empty($_GET["update"])) {
        ?>
        <h2>Atualizar Serviços</h2>
        <?php }else{ ?>
    <h2>Cadastrar Serviços</h2>
    <?php } ?>
    <?php
    if (!empty($_GET["update"])) {

        $dados = new \Source\Models\Read();
        $dados->ExeRead("services", "WHERE id = :a", "a={$_GET["update"]}");
        $dados->getResult();

        $servico = new Source\Core\Servicos();
        $servico->update();
        
    } else {
        $servico = new Source\Core\Servicos();
        $servico->cadastra();
    }
    ?>
    <form method="post" action="">
        <div class="form-group">
            <label>Cliente</label>

            <select name="user_id" class="form-control">
                <?php
                if (!empty($_GET["update"])) {
                    ?>
                    <option value="<?= $dados->getResult()[0]["user_id"] ?>"><?= $dados->getResult()[0]["user_id"] ?></option>
                <?php } ?>
                <?php
                $read = new \Source\Models\Read();
                $read->ExeRead("users", "WHERE level = :a", "a=1");
                $read->getResult();
                foreach ($read->getResult() as $value) {
                    ?>
                    <option value="<?= $value["id"] ?>"><?= $value["name"] ?></option>
                <?php } ?>
            </select>


        </div>
        <div class="form-group">
            <label>Nome do Projeto</label>
            <input name="name" type="text" class="form-control" 
<?php
if (!empty($_GET["update"])) {
    echo "value={$dados->getResult()[0]["name"]}''";
}
?>
                   />   
        </div>
        <div class="form-group">
            <label>Valor</label>
            <input type="text" name="price" class="form-control" 
<?php
if (!empty($_GET["update"])) {
    echo "value={$dados->getResult()[0]["price"]}''";
}
?>
                   />
        </div>
        <div class="form-group">
            <label>Metodo Pagamento</label>
            <input type="text" name="method_payment" class="form-control" 
<?php
if (!empty($_GET["update"])) {
    echo "value={$dados->getResult()[0]["method_payment"]}";
}
?>
                   />
        </div>

      <?php  if ($_SESSION["nivel"] == 3 ) { ?>

        <div class="form-group">
        <label>Data Entrada</label>  
        <input type="date" name="start" class="form-control" 
<?php
if (!empty($_GET["update"])) {
    echo "value={$dados->getResult()[0]["start"]}";
}
?>
                   /> 
        </div>
        <div class="form-group">
        <label>Data Saída</label>  
        <input type="date" name="end" class="form-control" 
<?php
if (!empty($_GET["update"])) {
    echo "value={$dados->getResult()[0]["end"]}";
}
?>
                   /> 
        </div>

        <div class="form-group">
        <label>Anotações</label>  
        <textarea name="obs" class="form-control" >
<?php
if (!empty($_GET["update"])) {
    echo "{$dados->getResult()[0]["obs"]}";
}
?>
                  </textarea> 
        </div>       

        <?php } ?>

        <div class="form-group">

            <input type="submit"  class="btn btn-success" value="enviar" />
        </div>

    </form>
</div>


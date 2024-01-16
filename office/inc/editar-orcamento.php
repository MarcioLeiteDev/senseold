<div class="container-fluid">
    <h1>Editar Orçamento</h1>
    <?php
    $orcamento = new Source\Core\Orcamento();
    $orcamento->editar();
    
    $ver = new \Source\Models\Read();
    $ver->ExeRead("budget", "WHERE id = :a", "a={$_GET["id"]}");
    $ver->getResult();
    
    ?>
    <form action="" method="POST">
        <div class="form-group">
            <label>Cliente</label>
            <input type="text" value="<?=  $ver->getResult()[0]["name"]?>" name="name" class="form-control" />
        </div> 
        <div class="form-group">
            <label>Email</label>
            <input type="text" value="<?=  $ver->getResult()[0]["email"]?>" name="email" class="form-control" />
        </div> 
        <div class="form-group">
            <label>Tetefones</label>
            <input type="text" value="<?=  $ver->getResult()[0]["phone"]?>" name="phone" class="form-control" />
        </div> 
        <div class="form-group">
            <label>Orçamento</label>
            <textarea id="mytextarea" name="content" class="form-control" > 
            <?=  $ver->getResult()[0]["content"]?>
            </textarea>
        </div> 
        <div class="form-group">
            <label>Preço</label>
            <input type="text" value="<?=  $ver->getResult()[0]["price"]?>" name="price" class="form-control" />
        </div> 
        <div class="form-group">
            <label>Forma de Pagamento</label>
            <input type="text" value="<?=  $ver->getResult()[0]["payment_method"]?>" name="payment_method" class="form-control" />
        </div> 
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="<?= $ver->getResult()[0]["status"]?>">
            <?php
            if($ver->getResult()[0]["status"] == 1){
                echo "Criado";
            }
            if($ver->getResult()[0]["status"] == 2){
                echo "Enviado";
            }
            if($ver->getResult()[0]["status"] == 3){
                echo "Aprovado";
            }
            
            
            ?>
                
                </option>
                <option value="1">Criado</option>
                <option value="2">Enviado</option>
                <option value="3">Aprovado</option>
            </select>
        </div> 
        <div class="form-group">
            <input type="hidden" name="id" value="<?=  $ver->getResult()[0]["id"]?>" />
           
            <input type="submit" value="cadastrar" class="btn btn-success" />
        </div> 

    </form>
</div>


<script>
    $(document).ready(function () {
        $('#summernote').summernote();

    });
</script>

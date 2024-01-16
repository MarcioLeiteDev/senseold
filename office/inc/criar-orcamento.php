<div class="container-fluid">
    <h1>Criar Orçamento</h1>
    <?php
    $orcamento = new Source\Core\Orcamento();
    $orcamento->cadastra();
    ?>
    <form action="" method="POST">
        
        <?php 
        if($_SESSION["nivel"] == 3){
            $use = new Source\Models\Read();
            $use->ExeRead("users", "WHERE level = :a", "a=2");
            $use->getResult();
        ?>
         <div class="form-group">
            
            <label>Parceiro</label>
            <select name="user_id" class="form-control">
                <?php foreach ($use->getResult() as $value) {
                          ?>
                <option value="<?=$value["id"] ?>"> <?=$value["name"] ?> </option>
                <?php } ?>
            </select>
            
        </div> 
        
        <?php } ?>
        
        <div class="form-group">
            
            <label>Cliente</label>
            <input type="text" name="name" class="form-control" />
        </div> 
        <div class="form-group">
            <label>Email</label>
            <input type="text" name="email" class="form-control" />
        </div> 
        <div class="form-group">
            <label>Tetefones</label>
            <input type="text" name="phone" class="form-control" />
        </div> 
        <div class="form-group">
            <label>Orçamento</label>
            <textarea id="mytextarea" name="content" class="form-control" > </textarea>
        </div> 
        <div class="form-group">
            <label>Preço</label>
            <input type="text" name="price" class="form-control" />
        </div> 
        <div class="form-group">
            <label>Forma de Pagamento</label>
            <input type="text" name="payment_method" class="form-control" />
        </div> 
        <div class="form-group">
            <input type="submit" value="cadastrar" class="btn btn-success" />
        </div> 

    </form>
</div>


<script>
    $(document).ready(function () {
        $('#summernote').summernote();

    });
</script>

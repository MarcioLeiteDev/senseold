<div class="container-fluid">
    <h1>Editar Usuario</h1>
    <?php 
    $view = new Source\Models\Read();
    $view->ExeRead("users", "WHERE id = :a", "a={$_GET["id"]}");

    
    $usuario = new Source\Core\Usuarios();
    $usuario->editar();
    ?>
    <form action="" method="post">
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" value="<?= $view->getResult()[0]["name"] ?>" class="form-control" />
        </div>
        
        <div class="form-group">
            <label>E-mail</label>
            <input type="text" name="email" value="<?= $view->getResult()[0]["email"] ?>" class="form-control" />
        </div>
        
        <div class="form-group">
            <label>Senha</label>
            <input type="password" name="password" class="form-control" />
        </div>
        
        <div class="form-group">
            <label>Nivel</label>
            <select name="level" class="form-control">
                <option value="<?= $view->getResult()[0]["level"] ?>"> <?= $view->getResult()[0]["level"] ?></option>
                <option value="1">Cliente</option>
                <option value="2">Funcionario</option>
                <option value="3">Administrador</option>
            </select>
            </br>
            <input type="submit" class="btn btn-success" value="CADASTRAR" />
        </div>
        
        
    </form>
</div>


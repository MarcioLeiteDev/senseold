<div class="container-fluid">
    <h1>Cadastrar Usuario</h1>
    <?php 
    $usuario = new Source\Core\Usuarios();
    $usuario->cadastra();
    ?>
    <form action="" method="post">
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" class="form-control" />
        </div>
        
        <div class="form-group">
            <label>E-mail</label>
            <input type="text" name="email" class="form-control" />
        </div>
        
        <div class="form-group">
            <label>Senha</label>
            <input type="password" name="password" class="form-control" />
        </div>
        
        <div class="form-group">
            <label>Nivel</label>
            <select name="level" class="form-control">
                <option value="1">Cliente</option>
                <option value="2">Funcionario</option>
                <option value="3">Administrador</option>
            </select>
            </br>
            <input type="submit" class="btn btn-success" value="CADASTRAR" />
        </div>
        
        
    </form>
</div>


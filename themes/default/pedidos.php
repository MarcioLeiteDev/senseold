

<header class="container backwhite"> 

    <h1>Meus Serviços </h1>
    <?php 
    $servicos = new \Source\Core\Servicos();
    $servicos->Arquivos();
    ?>
    
    <div class="col-12">
        <p>Olá <b><?= $_SESSION["nome"] ?></b>, seja bem vindo</p>
    </div>
   
    
    <table class="table"> 
        <thead> 
            <tr> 
                <th>Data </th>
                <th>Serviço </th>
                <th>Itens </th>
                <th>Valor </th>
                <th>Pagamento </th>
                <th>Arquivos </th>
                <th>Status </th>
            </tr>
        </thead>
        
        <tbody> 
            
            <?php 
            $service = new \Source\Models\Read();
            $service->ExeRead("services", "WHERE user_id = :a", "a={$_SESSION["user_id"]}");
            $service->getResult();
            foreach ($service->getResult() as $value) {

            ?>

        <tr> 
            <td><?= date("d/m/Y",strtotime($value["created_at"]))?></td>
                <td><?= $value["id"] ?></td>
                <td>
               <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Itens do Pedido
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Orçamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <?php 
       $itens = new \Source\Models\Read();
       $itens->ExeRead("budget", "WHERE id = :a", "a={$value["budget"]}");
       echo $itens->getResult()[0]["content"];
       ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        
      </div>
    </div>
  </div>
</div>
               
                
                <!-- Aqui itens dos peddo -->
                </td>
                <td>R$ <?= number_format($value["price"] / 100,2,",",".")  ?> </td>
                <td><?= $value["method_payment"] ?></td>
                <td>
                
                    <!-- Arquivos -->
                    <!-- Button trigger modal -->
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#arquivosModal">
  Arquivos
</button>

<!-- Modal -->
<div class="modal fade" id="arquivosModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Arquivos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <h2>Enviar Arquivos</h2>
          <form method="POST" action="" enctype="multipart/form-data" class="form-inline">
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
          
          <h3>Arquivos Enviados</h3>
          <?php 
              $arquivos = new \Source\Models\Read();
              $arquivos->ExeRead("archives", "WHERE user_id = :a", "a={$_SESSION["user_id"]}");
              $arquivos->getResult();
              foreach ($arquivos->getResult() as $value) {

              ?>
          
          <p> Arquivo: <a href="<?= CONF_URL_BASE ?>/uploads/<?= $value["archive"] ?>" target="_blank"> <?php $trata = explode("/", $value["archive"]); echo $trata[3] ?> </a> Status: <?= $value["status"] ?> </p>
          
              <?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
        
      </div>
    </div>
  </div>
</div>
                    
                </td>
                <td>Status Pagamento </td>
            </tr>
            <?php } ?>
       
        </tbody>
    
    </table>
    
    
    
      </header>

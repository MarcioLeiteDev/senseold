

<header class="container backwhite"> 

    <h1>Pagamento </h1>
    
    <?php 
    if(empty($_SESSION["user_id"])){
        header("location:./entrar");
       
    }
   
   // var_dump($_SESSION);
    
    ?>
    
    
    
    <div class="container"> 
        <h1> Pedido Nº <?= $_SESSION["pedido_id"] ?> </h1>
        <p> Total do pedido R$ <?php
        $pedidoTotal = $_SESSION["frete"] + $_SESSION["totalPedido"];
        
        echo number_format($pedidoTotal / 100,2, "," , ".");
                
                ?></p>
        <p>Método de Entrega: <?=$_SESSION["freteTipo"] ?> </p>
        
        <h4> Itens do Pedido </h4>
        <?php
         $total = 0;
                foreach ($_SESSION['carrinho'] as $id => $qtd) {
 
                    ?>
                        <tr>
                            <td><img src="<?=CONF_URL_BASE ?>/uploads/<?php $id;
                            
                            $viewValor = new \Source\Models\Read();
                            $viewValor->ExeRead("app_prod_var", "WHERE produto_id = :a", "a={$id}");
                           echo $viewValor->getResult()[0]["imagem"];
                            
                             ?>" /> </td>
                            <td><?php 
                             $id;
                                        $nomeProd = new \Source\Models\Read();
                                        $nomeProd->ExeRead("app_prod", "WHERE id = :a", "a={$id}");
                                       echo $nomeProd->getResult()[0]["produto"];
                                        
                                        
                                        ?></td>
                            <td>R$ <?php 
                            $id; 
                            $viewValor = new \Source\Models\Read();
                            $viewValor->ExeRead("app_prod_var", "WHERE produto_id = :a", "a={$id}");
                            $valor = $viewValor->getResult()[0]["valor"];
                           echo $exiveValor = number_format($valor / 100, 2, ",", ".");
                            ?></td>
                            <!--<td><?php echo $id; ?></td>-->
                            
                        </tr>
                        
            <?php } ?>
                        
                        <tr>
    </div>     


<div class="row">
    <div class="col-lg-7 mx-auto">
      <div id="pagamento" class="bg-white rounded-lg shadow-sm p-5">
        <!-- Credit card form tabs -->
        <ul role="tablist" class="nav bg-light nav-pills rounded-pill nav-fill mb-3">
          <li class="nav-item">
            <a data-toggle="pill" href="#nav-tab-card" class="nav-link active rounded-pill">
                                <i class="fa fa-credit-card"></i>
                                Cartão de Crédito
                            </a>
          </li>
<!--          <li class="nav-item">
            <a data-toggle="pill" href="#nav-tab-paypal" class="nav-link rounded-pill">
                                <i class="fa fa-paypal"></i>
                                Paypal
                            </a>
          </li>-->
          <li class="nav-item">
            <a data-toggle="pill" href="#nav-tab-bank" class="nav-link rounded-pill">
                                <i class="fa fa-university"></i>
                                 Boleto Bancário
                             </a>
          </li>
        </ul>
        <!-- End -->


        <!-- Credit card form content -->
        <div class="tab-content">

          <!-- credit card info-->
          <div id="nav-tab-card" class="tab-pane fade show active">
<!--            <p class="alert alert-success">Some text success or error</p>-->
              <?php 
              $transacao = new \Source\Core\Transacao();
              $transacao->cartao_credito();
              ?>
              <form action="" method="post">
              <div class="form-group">
                <label for="username">Nome (igual cartão de crédito)</label>
                <input type="text" name="username" placeholder="Nome igual do cartão" required class="form-control">
              </div>
              <div class="form-group">
                <label for="cardNumber">Numero Cartão</label>
                <div class="input-group">
                  <input type="text" name="cardNumber" placeholder="Numero do cartão" class="form-control" required>
                  <div class="input-group-append">
                    <span class="input-group-text text-muted">
                                                <i class="fa fa-cc-visa mx-1"></i>
                                                <i class="fa fa-cc-amex mx-1"></i>
                                                <i class="fa fa-cc-mastercard mx-1"></i>
                                            </span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-8">
                  <div class="form-group">
                    <label><span class="hidden-xs" name="">Data Expiração</span></label>
                    <div class="input-group">
                      <input type="number" placeholder="MM" name="expiration_month" class="form-control" required>
                      <input type="number" placeholder="YY" name="expiration_year" class="form-control" required>
                      <input type="hidden"  name="payment_method" value="credit_card">
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group mb-4">
                    <label data-toggle="tooltip" title="3  digitos atrás do seu cartão">CVV
                                                <i class="fa fa-question-circle"></i>
                                            </label>
                      <input type="text" name="cvv" required class="form-control">
                  </div>
                </div>



              </div>
                  <input type="hidden" name="total" value="<?= $pedidoTotal  ?>" />
                <input type="submit" name="transacao" class="subscribe btn btn-primary btn-block rounded-pill shadow-sm" value="Confirmar" />
              <!--<button type="button" class="subscribe btn btn-primary btn-block rounded-pill shadow-sm"> Confirm  </button>-->
            </form>
          </div>
          <!-- End -->

          <!-- Paypal info -->
          <div id="nav-tab-paypal" class="tab-pane fade">
            <p>Paypal is easiest way to pay online</p>
            <p>
              <button type="button" class="btn btn-primary rounded-pill"><i class="fa fa-paypal mr-2"></i> Log into my Paypal</button>
            </p>
            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
          </div>
          <!-- End -->

          <!-- bank transfer info -->
          <div id="nav-tab-bank" class="tab-pane fade">
            <h6>Boleto Bancário</h6>
            <dl>
              <dt>Boletos</dt>
              <dd> Gerar boleto em meu e-mail</dd>
            </dl>
            <dl>
              <dt>
                  <form action="" method="post"> 
                   <input type="hidden" name="payment_method" value="boleto" />
                   <input type="hidden" name="total" value="<?= $pedidoTotal  ?>" />
                      <input type="submit" name="transacao" value="GERAR BOLETO" class="subscribe btn btn-primary btn-block rounded-pill shadow-sm" />
                  </form>
                  </dd>
            </dl>
            <dl>
              <dt>IBAN</dt>
              <dd>CZ7775877975656</dd>
            </dl>
            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            </p>
          </div>
          <!-- End -->
        </div>
        <!-- End -->

      </div>
    </div>
  </div>
    
    </header>


  

             
      
   
  
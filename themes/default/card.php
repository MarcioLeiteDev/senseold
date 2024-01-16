

<header class="container backwhite"> 

  <?php 
  $carrinho = new Source\Core\Carrinho();
  $carrinho->carrinho();
  
  if(!empty($_GET["acao"]) && $_GET["acao"] == "pedido"){
    $carrinho = new \Source\Core\Carrinho();
    $carrinho->pedidoWeb();
  }


  ?> 
    

    
    

<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">Carrinho de Compras</h1>
     </div>
</section>

<div class="container mb-4">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col"> </th>
                            <th scope="col">Produto</th>
                            <th scope="col">Valor Unit.</th>
                            <th scope="col" class="text-center">Quantidade</th>
                            <th scope="col" class="text-right">Sub Total</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php
            if (count($_SESSION['carrinho']) == 0) {
                echo "
                
                    <div class='alert alert-warning'>Não há produto no carrinho</div>
                
            ";
            } else {

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
                            <td> <span class="btn btn-success"> <a href="<?=CONF_URL_BASE ?>/carrinho&acao=add&id=<?= $id ?>" style="text-decoration:none; color:#fff;">adicionar + </a> </span> Qtd <?php echo $qtd ?></td>
                            <td class="text-right">R$ <?php 
                            $subTotal = $valor * $qtd;
                        echo  $exibesub = number_format($subTotal / 100, 2, ",", ".");
                          
                          $total += $subTotal;
                          
                          $_SESSION["totalItens"] = $total;
                            ?></td>
                            <td class="text-right"><a href="<?= CONF_URL_BASE ?>/carrinho&acao=del&id=<?= $id ?>"><button class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button> </a></td>
                        </tr>
                        
            <?php } ?>
                        
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Sub-Total</td>
                            <td class="text-right"><?php $viewTotal = $total;
                            echo number_format($viewTotal / 100, 2, ",", ".");
                            ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                            <form action="<?= CONF_URL_BASE ?>/carrinho" method="post">
                  <div class="row panel-body" align="left">
                <div class="col-md-12">
                
                <div class="col-md-12">
                    <label>SERVIÇO</label>
                      <select class="form-control" name="servico">
                        <option value="BALCAO">RETIRAR BALCÃO</option>
                        <option value="SEDEX">SEDEX</option>
                        <option value="PAC">PAC</option>
                    </select>
                  </div>
    
                    <input type="hidden"  name="origem" value="08120470" id="cep-origem" />                  
               <input type="hidden"  name="peso" value="1.5" id="peso" />
               <input type="hidden"  name="altura" value="16" id="peso" />
               <input type="hidden" value="16" name="largura" id="peso" /> 
               <input type="hidden" value="16" name="comprimento" id="peso" />  
                
                <div class="form-group col-md-12">
                    <label>CEP DESTINO</label>
                      <input type="text" class="form-control" name="destino" id="cep-destino" />                  
                  </div>


                <div class="form-group">
                <button class="btn btn-success col-md-offset-3 col-md-6">Calcular Frete</button>
                </div>
                </div>
                </form>
                                
                                <?php 
                                # 
# implementa funcao de calculo de preços e prazos 
# para serviços dos correios
#
         $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
         
         if(!empty($filtro)){
             
             if($filtro["servico"] == "BALCAO"){
                 
//    $_SESSION["frete"] = "0.00";
//    $_SESSION["freteTipo"] = "BALCÃO";
//    $valorFrete = str_replace(".", "", $_resultado['valor']);
//    $valorFrete = str_replace(",", "", $_resultado['valor']);

    $_SESSION["cep"] = $_POST['destino'];
    $_SESSION["frete"] = "0";
    $_SESSION["freteTipo"] = $_POST['servico'];
    
    echo "TIPO: RETIRAR NO BALCÃO";
    echo "<br>";
    echo "VALOR: 0.00";
    echo "<br>";
    echo "PRAZO: 1HS ";
    
    var_dump($_SESSION);
                 
             }else{
         
if( !function_exists( 'calculaFrete' ))
{
   function calculaFrete(
      $cod_servico, /* codigo do servico desejado */
      $cep_origem,  /* cep de origem, apenas numeros */
      $cep_destino, /* cep de destino, apenas numeros */
      $peso,        /* valor dado em Kg incluindo a embalagem. 0.1, 0.3, 1, 2 ,3 , 4 */
      $altura,      /* altura do produto em cm incluindo a embalagem */
      $largura,     /* altura do produto em cm incluindo a embalagem */
      $comprimento, /* comprimento do produto incluindo embalagem em cm */
      $valor_declarado='0' /* indicar 0 caso nao queira o valor declarado */
   ){

      $cod_servico = strtoupper( $cod_servico );
      if( $cod_servico == 'SEDEX10' ) $cod_servico = 40215 ; 
      if( $cod_servico == 'SEDEXACOBRAR' ) $cod_servico = 40045 ; 
      if( $cod_servico == 'SEDEX' ) $cod_servico = 40010 ; 
      if( $cod_servico == 'PAC' ) $cod_servico = 41106 ;

      # ###########################################
      # Código dos Principais Serviços dos Correios
      # 41106 PAC sem contrato
      # 40010 SEDEX sem contrato
      # 40045 SEDEX a Cobrar, sem contrato
      # 40215 SEDEX 10, sem contrato
      # ###########################################

      $correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=".$cep_origem."&sCepDestino=".$cep_destino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado=".$valor_declarado."&sCdAvisoRecebimento=n&nCdServico=".$cod_servico."&nVlDiametro=0&StrRetorno=xml";

      $xml = simplexml_load_file($correios);

      $_arr_ = array();
      if($xml->cServico->Erro == '0'):
         $_arr_['codigo'] = $xml -> cServico -> Codigo ;
         $_arr_['valor'] = $xml -> cServico -> Valor ;
         $_arr_['prazo'] = $xml -> cServico -> PrazoEntrega .' Dias' ;
         // return $xml->cServico->Valor;
         return $_arr_ ; 
      else:
         return false;
      endif;
   }
}
if(!empty($_POST['origem'])){
$origem = $_POST['origem'];
    $destino = $_POST['destino'];
    $peso = $_POST['peso'];
    $altura = $_POST['altura'];
    $largura = $_POST['largura'];
    $comprimento = $_POST['comprimento'];
    $servico = $_POST['servico'];
    $_resultado = calculaFrete( 
        $servico, 
        $origem, 
        $destino, 
        $peso, 
        $altura, $largura, $comprimento, 0 );
    

    
    $valorFrete = str_replace(".", "", $_resultado['valor']);
    $valorFrete = str_replace(",", "", $_resultado['valor']);

    $_SESSION["cep"] = $_POST['destino'];
    $_SESSION["frete"] = $valorFrete;
    $_SESSION["freteTipo"] = $_POST['servico'];
    echo "TIPO: ".$_POST['servico'];
    echo "<br>";
    echo "VALOR: ".$_resultado['valor'];
    echo "<br>";
    echo "PRAZO: ".$_resultado['prazo'];
    
      var_dump($_SESSION);
}



         }  }                           
                                ?>
                            
                            
                            </td>
                            <td class="text-right"><?php
                            
                            if(empty($_resultado['valor'])){
                                 $result = 0;
                            } else{
                                echo $result =  $_resultado['valor'];
                            } ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><strong>Total</strong></td>
                            <td class="text-right"><strong><?php 
                            
                            $trata = str_replace(".", "", $result);
                            $trata = str_replace(",", "", $result);
                            
                           // echo $trata;
                            
                           $totalPedido = $trata + $total;
                           
                           $_SESSION["totalPedido"] = $totalPedido;
                           
                           echo "R$" . number_format($totalPedido / 100, 2, ",", ".");
//                            
//                            echo $totalPedido;
                            
                            ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
            <?php } ?>
        <div class="col mb-2">
            <div class="row">
                <div class="col-sm-12  col-md-6">
                    <button class="btn btn-block btn-light"><a href="<?= CONF_URL_BASE ?>/produtos"style="text-decoration:none; color:#000;">Continue Comprando</a></button>
                </div>
                <?php 
                if(!empty($_SESSION["freteTipo"])){
                ?>
                <div class="col-sm-12 col-md-6 text-right">
                    <button class="btn btn-lg btn-block btn-success text-uppercase"><a href="<?= CONF_URL_BASE ?>/carrinho&acao=pedido">Pagamento</a></button>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

    
    
      </header>
      
<style> 
/*
** Style Simple Ecommerce Theme for Bootstrap 4
** Created by T-PHP https://t-php.fr/43-theme-ecommerce-bootstrap-4.html
*/
.bloc_left_price {
    color: #c01508;
    text-align: center;
    font-weight: bold;
    font-size: 150%;
}
.category_block li:hover {
    background-color: #007bff;
}
.category_block li:hover a {
    color: #ffffff;
}
.category_block li a {
    color: #343a40;
}
.add_to_cart_block .price {
    color: #c01508;
    text-align: center;
    font-weight: bold;
    font-size: 200%;
    margin-bottom: 0;
}
.add_to_cart_block .price_discounted {
    color: #343a40;
    text-align: center;
    text-decoration: line-through;
    font-size: 140%;
}
.product_rassurance {
    padding: 10px;
    margin-top: 15px;
    background: #ffffff;
    border: 1px solid #6c757d;
    color: #6c757d;
}
.product_rassurance .list-inline {
    margin-bottom: 0;
    text-transform: uppercase;
    text-align: center;
}
.product_rassurance .list-inline li:hover {
    color: #343a40;
}
.reviews_product .fa-star {
    color: gold;
}
.pagination {
    margin-top: 20px;
}
footer {
    background: #343a40;
    padding: 40px;
}
footer a {
    color: #f8f9fa!important
}

</style>

             
      
   
  
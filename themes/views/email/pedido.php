<?php $v->layout("_theme", ["title" => "Pedido" . CONF_SITE_NAME]); ?>

<h2>Pedido enviado com Sucesso <?= $nome ?> </h2>
<p>Dados do Pedido <?= $_SESSION["pedido_id"] ?> </p>

<table>
<?php

            $total = 0;
            foreach ($_SESSION['carrinho'] as $id => $qtd) {

                $ler = new \Source\Models\Read();
                $ler->ExeRead("app_prod_var", "WHERE produto_id = :a", "a={$id}");
                $ler->getResult();

                $nomeProd = new \Source\Models\Read();
                $nomeProd->ExeRead("app_prod", "WHERE id = :a", "a={$id}");
                $nomeProd->getResult();

                $nome = $nomeProd->getResult()[0]["produto"];
                $preco = number_format($ler->getResult()[0]["valor"] / 100, 2, ',', '.');
                $sub = number_format($ler->getResult()[0]["valor"] / 100 * $qtd, 2, ',', '.');
                $total += $ler->getResult()[0]["valor"] * $qtd;

                //cadastra itens no banco
                $DadosItens = [
                    "pedido_id" => $_SESSION["pedido_id"],
                    "produto_id" => $id,
                    "produto_qtd" => $qtd,
                    "valor" => $ler->getResult()[0]["valor"]
                ];
               // print_r($DadosItens) ;
                
               // print_r($_SESSION);
                
               // echo "<div class=\"vintecinco\"><img src=\"".CONF_URL_BASE."/uploads/{$ler->getResult()[0]["imagem"]}\" style=\"width:50px;\" /> </div>

//<div class=\"cinquenta\"> {$nome} => Qtd {$qtd} </div>
//<div class=\"vintecinco\"> {$sub} </div>";
           

?>

    <tr>
        <td> <img src="<?= CONF_URL_BASE?>/uploads/<?= $ler->getResult()[0]["imagem"] ?>" style="width: 50px;" /> </td>
        <td> <?= $nome ?>  Qtd <?=$qtd ?>  </td>
        <td> <?= $sub ?> </td>
    </tr>
    
  
<?php } ?>

      <tr>
        <td> Frete <?= $_SESSION["freteTipo"];?> </td>
        <td> Valor Frete  <?= $_SESSION["frete"];?>  </td>
        <td> Total Pedido = <?php 
         $total = $_SESSION["totalPedido"] + $_SESSION["frete"];
         
         echo number_format($total / 100, 2, "," , ".");
        ?> </td>
    </tr>
    
</table>

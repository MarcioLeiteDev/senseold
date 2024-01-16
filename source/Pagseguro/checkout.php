<?php
header("access-control-allow-origin: https://pagseguro.uol.com.br");
header("Content-Type: text/html; charset=UTF-8",true);
date_default_timezone_set('America/Sao_Paulo');

require_once("PagSeguro.class.php");
$PagSeguro = new PagSeguro();
	
//EFETUAR PAGAMENTO	
$venda = array("codigo"=>"1",
			   "valor"=>298.98,
			   "descricao"=>"VENDA DE NONONONONONO",
			   "nome"=>"Marcio Leite",
			   "email"=>"mbleusou@gmail.com",
			   "telefone"=>"(11) 2641-4655",
			   "rua"=>"Rua dos Trilhos",
			   "numero"=>"45",
			   "bairro"=>"Itaim",
			   "cidade"=>"Sâo Paulo",
			   "estado"=>"SP", //2 LETRAS MAIÚSCULAS
			   "cep"=>"08120470",
			   "codigo_pagseguro"=>"");
			   
$PagSeguro->executeCheckout($venda,"http://localhost/praticaphp/source/PagSeguro/checkout.php".$_GET['codigo']);

//----------------------------------------------------------------------------


//RECEBER RETORNO
if( isset($_GET['transaction_id']) ){
	$pagamento = $PagSeguro->getStatusByReference($_GET['codigo']);
	
	$pagamento->codigo_pagseguro = $_GET['transaction_id'];
	if($pagamento->status==3 || $pagamento->status==4){
		//ATUALIZAR DADOS DA VENDA, COMO DATA DO PAGAMENTO E STATUS DO PAGAMENTO
            
                var_dump($pagamento);
		
	}else{
		//ATUALIZAR NA BASE DE DADOS
	}
}

?>
<?php
ob_start();
require '../vendor/autoload.php';
$dados = new Source\Models\Read();
$dados->ExeRead("services", "WHERE id = :a", "a={$_GET["servico"]}");
$dados->getResult();

$puxa_usuario = $dados->getResult()[0]['user_id'];
$puxa_contrato = $dados->getResult()[0]['contract'];

$usuario = new Source\Models\Read();
$usuario->ExeRead("users","WHERE id = :a", "a={$puxa_usuario}");
$usuario->getResult();

$contrato = new Source\Models\Read();
$contrato->ExeRead("contracts","WHERE id = :a", "a={$puxa_contato}");
$contrato->getResult();

require '../dompdf/autoload.inc.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;
// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml(" <div style='width: 100%; text-align: center;'>
    
        <h2 style='text-align: center;'>CONTRATO SENSE TRANSLATE </br> Traduções</h2> 
        
        <h3 style='text-align: center;'>Contrato Nº {$dados->getResult()[0]["id"]}  </h3> </th>
       
    </div>
    
    <div style='float: left; width: 33%;'>
        <p><b>Cliente</b></p>
        <p>{$usuario->getResult()[0]["name"]}</p>
    </div>
    
    <div style='float: left; width: 33%;'>
        <p><b>E-mail</b></p>
        <p>{$usuario->getResult()[0]["email"]}</p>
    </div>
    
    <div style='float: left; width: 33%;'>
        <p><b>Telefone</b></p>
        <p>{$usuario->getResult()[0]["phone"]}</p>
    </div>
    
    <div style='clear: both;'></div>
    
    <div style='width: 100%;  '>
        <h3 style='text-align: center;'>Termos </h3>
        {$contrato->getResult()[0]['content']}
    </div>
    
    
   
     <p>
         <h3>Sense Translate</h3>
         <p>Fone:(11) 9 5059-0525</p>
         <p>E-mail: contato@sensetranslate.com</p>
         <p>www.sensetranslate.com</p>
      </p>   ");

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream( 
        "contrato.pdf",
        array(
            "Attachment" => true //para realizar download alterar para true
        )
);
?>




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
$contrato->ExeRead("contracts", "WHERE id = :a", "a={$puxa_contrato}");
$contrato->getResult();






require '../dompdf/autoload.inc.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;
// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml(" <div style='width: 100%; text-align: center;'>
        <img src='data:image/jpeg;base64,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' />

        <h2 style='text-align: center;'>SENSE TRANSLATE </br> Traduções</h2> 
        
        <h3 style='text-align: center;'>Contrato Nº   </h3> </th>
       
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




<?php

require '../vendor/autoload.php';

print_r($_GET["array"]);

$tratar = explode("=>", $_GET["array"]);

$trata_inicio = explode("[", $tratar['1']);
$inicio = $trata_inicio['0'];

$trata_fim = explode("[", $tratar['2']);
$fim = $trata_fim['0'];

$search = $tratar['3'];
$parceiro = $tratar['4'];

var_dump($tratar);


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Data');
$sheet->setCellValue('B1', 'Cliente');
$sheet->setCellValue('C1', 'Preço');
$sheet->setCellValue('D1', 'Metodo Pagamento');
$sheet->setCellValue('E1', 'Parceiro');
$sheet->setCellValue('F1', 'Orçamento ID');
$sheet->setCellValue('G1', 'Orçamento');
      
                if($inicio){
                    
                   $queryD = "data BETWEEN :d1 AND :d2";
                   $paramD = "d1={$inicio}&d2={$fim}";
                   $and = " AND ";
                   // echo "Qery da data";
                }else{
                   $queryD = null;
                   $paramD = null;
                   $and = null;
                   // echo "query data nulo";
                }
                
                if(empty($search)){
                    $query1 = "{$and} name LIKE '%' :link '%'";
                    $param1 = "&link={$search}";
                   // echo "query do nome";
                }else{
                    $query1 = null;
                    $param1 = null;
                  //  echo "query nula do nome ";
                }
                
                if(empty($parceiro)){
                    
                    if($search){
                        $query2 = " {$and} employer = :b ";
                        $param2 = "&b={$search}";
                    }elseif($search || $inicio){
                        $query2 = "AND employer = :b";
                        $param2 = "&b={$search["parceiro"]}";
                    }else{
                        $query2 = "employer = :b";
                        $param2 = "b={$search["parceiro"]}"; 
                    }
                 
                }else{
                    $query2 = null;
                    $param2 = null;
                    //echo "&b={$search["parceiro"]}";
                }


$read = new \Source\Models\Read();
$read->ExeRead("services" , "WHERE {$queryD}{$query1}{$query2}" , "{$paramD}{$param1}{$param2}");
$read->getResult();

//var_dump($read->getResult());
$i = 1;
foreach ($read->getResult() as $value) {
    $preco = number_format($value['price'] / 100, 2, ",", ".");
    $i++;
    
    $orca = new \Source\Models\Read();
    $orca->ExeRead("budget", "WHERE id = :a", "a={$value["budget"]}");
    $orca->getResult();
    
    $parca = new \Source\Models\Read();
    $parca->ExeRead("users", "WHERE id = :a", "a={$value["employer"]}");
    $parca->getResult();
    
$sheet->setCellValue("A{$i}", "{$value['data']}");
$sheet->setCellValue("B{$i}", "{$value['name']}");
$sheet->setCellValue("C{$i}", "{$preco}");
$sheet->setCellValue("D{$i}", "{$value['method_payment']}");
$sheet->setCellValue("E{$i}", "{$parca->getResult()[0]["name"]}");
$sheet->setCellValue("F{$i}", "{$value["budget"]}");
$sheet->setCellValue("G{$i}", "{$orca->getResult()[0]["content"]}");

 
}
       

$writer = new Xlsx($spreadsheet);
$writer->save('relatorio_servicos.xlsx');



?>

<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <title>Relatorio Orçamentos</title>
  </head>
  <body>
      <a href='./relatorio_servicos.xlsx' class="btn btn-success m-5"> <h1>Baixar Arquivo</h1> </a>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->
  </body>
</html>


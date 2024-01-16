<?php 
//session_start();

$ano = explode("|", $_POST['modelo']);

print_r($ano);




?>

<option> SELECIONE ANO</option>


                        <?php 

//string json contendo os dados de um funcionário

                     // echo"https://parallelum.com.br/fipe/api/v1/{$ano[0]}/marcas/{$ano[1]}/modelos/{$ano[2]}/anos"; 

 
$json_file = file_get_contents("https://parallelum.com.br/fipe/api/v1/{$ano[0]}/marcas/{$ano[1]}/modelos/{$ano[2]}/anos");   
$json_str = json_decode($json_file, true);
$itens = $json_str;

//print_r($itens);


foreach ( $itens as $e ) 
   
    { 
    $d="|";
    echo "<option value=\"{$ano[0]}|{$ano[1]}|{$ano[2]}|{$e['codigo']}|{$e['nome']}\">{$e['nome']} </option>";

    
    
    } 
    
   
?> 





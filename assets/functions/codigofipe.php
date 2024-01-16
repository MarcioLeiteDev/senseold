<?php 
session_start();

$fipe = explode("|", $_POST['fipe']);


print_r($fipe);

?>

                        <?php 

//string json contendo os dados de um funcionário

$json_file = file_get_contents("https://parallelum.com.br/fipe/api/v1/{$fipe[0]}/marcas/{$fipe[1]}/modelos/{$fipe[2]}/anos/{$fipe[3]}");   
$json_str = json_decode($json_file, true);
$itens = $json_str;

    
    echo "<option value=\"{$itens['CodigoFipe']}\">{$itens['CodigoFipe']} </option>";
    
    echo "";
 
?> 




<?php

$puxa = $_POST['marca'];
 
 $trata = explode("|", $puxa);
 
 //echo "https://parallelum.com.br/fipe/api/v1/{$trata['2']}/marcas/{$trata['1']}/modelos";
 

            $json_file = file_get_contents("https://parallelum.com.br/fipe/api/v1/{$trata['2']}/marcas/{$trata['1']}/modelos");
            $json_str = json_decode($json_file, true);
             $itens = $json_str;

   
           // print_r($itens);

            
$arr_result = $itens;
foreach($arr_result as $data)
{
if(is_array($data))
{
foreach($data as $other_data)
{
echo "<option value='{$trata['2']}|{$trata['1']}|{$other_data['codigo']}|{$other_data['nome']}'> {$other_data['nome']} </option>" ;
}
}
else
{
echo $data, '<br/>';
}
}



        
            ?> 


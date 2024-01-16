            <?php

 echo $puxa = $_POST["veiculo"];
 //$puxa = "motos";
 
 

            $json_file = file_get_contents("https://parallelum.com.br/fipe/api/v1/{$puxa}/marcas");
            $json_str = json_decode($json_file, true);
            $itens = $json_str;

            $d = "|";

            foreach ($itens as $e) {

                echo "<option value=\"{$e['nome']}{$d}{$e['codigo']}{$d}{$puxa}\">{$e['nome']} </option>";
            }

        
            ?> 

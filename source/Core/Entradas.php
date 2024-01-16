<?php

namespace Source\Core;

class Entradas {

    private $filtro;

    public function __construct() {
        $filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->filtro = $filtro;
    }

    public function create() {


        if (!empty($this->filtro['title'])) {

            // var_dump($this->filtro);
            //aqui é função entrada unica
            if ($this->filtro["tipo"] == "Unica") {

                $this->filtro["valor"] = str_replace(".", "", $this->filtro["valor"]);
                $this->filtro["valor"] = str_replace(",", "", $this->filtro["valor"]);
                $this->filtro["valor"] = str_replace("R", "", $this->filtro["valor"]);
                $this->filtro["valor"] = str_replace("$", "", $this->filtro["valor"]);

                $agora = date("Y-m-d");

                if ($this->filtro["date_payment"] > $agora) {
                    $status = 'unpaid';
                }
                if ($this->filtro["date_payment"] <= $agora) {
                    $status = 'paid';
                }


                $Dados = [
                    "user_id" => $_SESSION["user_id"],
                    "type" => $this->filtro["tipo"],
                    "mode" => 1,
                    "title" => $this->filtro["title"],
                    "method_payment" => $this->filtro["method_payment"],
                    "value" => $this->filtro["valor"],
                    "parcel" => $this->filtro["js_parcelas"],
                    "date_payment" => $this->filtro["date_payment"],
                    "status" => $status
                ];

                $cad = new \Source\Models\Create();
                $cad->ExeCreate("invoices", $Dados);
                if ($cad->getResult()) {
                    echo "<p class='alert alert-success'> Fatura cadastrada com sucesso </p>";
                } else {
                    echo "<p class='alert alert-danger'> Erro ao cadastrar </p>";
                }
            }

            //aqui é função entrada PArcelas
            if ($this->filtro["tipo"] == "Parcela") {

                //  var_dump($this->filtro);

                $trata = explode("/", $this->filtro["js_parcelas"]);

                $limite = end($trata);

                //  echo $limite;
                //  var_dump($trata);

                $contar = count($trata);

                $agora = date("Y-m-d");
                for ($i = 0; $i < $contar; $i++) {


                    $this->filtro["valor"] = str_replace(".", "", $this->filtro["valor"]);
                    $this->filtro["valor"] = str_replace(",", "", $this->filtro["valor"]);
                    $this->filtro["valor"] = str_replace("R", "", $this->filtro["valor"]);
                    $this->filtro["valor"] = str_replace("$", "", $this->filtro["valor"]);
                    
                    $vencimento = date('Y-m-d', strtotime("+{$trata[$i]} day", strtotime($this->filtro["date_payment"])));

                    $agora = date("Y-m-d");

                    if ($vencimento > $agora) {
                        $status = 'unpaid';
                    }
                    if ($vencimento <= $agora) {
                        $status = 'paid';
                    }


                    $Dados = [
                        "user_id" => $_SESSION["user_id"],
                        "type" => $this->filtro["tipo"],
                        "mode" => 1,
                        "title" => $this->filtro["title"],
                        "method_payment" => $this->filtro["method_payment"],
                        "value" => $this->filtro["valor"],
                        "parcel" => $i + 1,
                        "js_parcelas" => $this->filtro["js_parcelas"],
                        "date_payment" => $vencimento,
                        "status" => $status
                    ];


                   // echo $trata[$i] . '</br>';

                 //   var_dump($Dados);

                    $cad = new \Source\Models\Create();
                    $cad->ExeCreate("invoices", $Dados);
                    if ($cad->getResult()) {
                        echo "<p class='alert alert-success'> Fatura cadastrada com sucesso </p>";
                    } else {
                        echo "<p class='alert alert-danger'> Erro ao cadastrar </p>";
                    }
                }
            }
        }
    }
    
    public function createService() {


        if (!empty($this->filtro['title'])) {

            // var_dump($this->filtro);
            //aqui é função entrada unica
            if ($this->filtro["tipo"] == "Unica") {

                $this->filtro["valor"] = str_replace(".", "", $this->filtro["valor"]);
                $this->filtro["valor"] = str_replace(",", "", $this->filtro["valor"]);
                $this->filtro["valor"] = str_replace("R", "", $this->filtro["valor"]);
                $this->filtro["valor"] = str_replace("$", "", $this->filtro["valor"]);

                $agora = date("Y-m-d");

                if ($this->filtro["date_payment"] > $agora) {
                    $status = 'unpaid';
                }
                if ($this->filtro["date_payment"] <= $agora) {
                    $status = 'paid';
                }


                $Dados = [
                    "user_id" => $_SESSION["user_id"],
                    "type" => $this->filtro["tipo"],
                    "service_id" => $this->filtro["service_id"],
                    "mode" => 1,
                    "title" => $this->filtro["title"],
                    "method_payment" => $this->filtro["method_payment"],
                    "value" => $this->filtro["valor"],
                    "parcel" => $this->filtro["js_parcelas"],
                    "date_payment" => $this->filtro["date_payment"],
                    "status" => $status
                ];

                $cad = new \Source\Models\Create();
                $cad->ExeCreate("invoices", $Dados);
                if ($cad->getResult()) {
                    echo "<p class='alert alert-success'> Fatura cadastrada com sucesso </p>";
                } else {
                    echo "<p class='alert alert-danger'> Erro ao cadastrar </p>";
                }
            }

            //aqui é função entrada PArcelas
            if ($this->filtro["tipo"] == "Parcela") {

                //  var_dump($this->filtro);

                $trata = explode("/", $this->filtro["js_parcelas"]);

                $limite = end($trata);

                //  echo $limite;
                //  var_dump($trata);

                $contar = count($trata);

                $agora = date("Y-m-d");
                for ($i = 0; $i < $contar; $i++) {


                    $this->filtro["valor"] = str_replace(".", "", $this->filtro["valor"]);
                    $this->filtro["valor"] = str_replace(",", "", $this->filtro["valor"]);
                    $this->filtro["valor"] = str_replace("R", "", $this->filtro["valor"]);
                    $this->filtro["valor"] = str_replace("$", "", $this->filtro["valor"]);
                    
                    $vencimento = date('Y-m-d', strtotime("+{$trata[$i]} day", strtotime($this->filtro["date_payment"])));

                    $agora = date("Y-m-d");

                    if ($vencimento > $agora) {
                        $status = 'unpaid';
                    }
                    if ($vencimento <= $agora) {
                        $status = 'paid';
                    }


                    $Dados = [
                        "user_id" => $_SESSION["user_id"],
                        "type" => $this->filtro["tipo"],
                        "service_id" => $this->filtro["service_id"],
                        "mode" => 1,
                        "title" => $this->filtro["title"],
                        "method_payment" => $this->filtro["method_payment"],
                        "value" => $this->filtro["valor"],
                        "parcel" => $i + 1,
                        "js_parcelas" => $this->filtro["js_parcelas"],
                        "date_payment" => $vencimento,
                        "status" => $status
                    ];


                   // echo $trata[$i] . '</br>';

                 //   var_dump($Dados);

                    $cad = new \Source\Models\Create();
                    $cad->ExeCreate("invoices", $Dados);
                    if ($cad->getResult()) {
                        echo "<p class='alert alert-success'> Fatura cadastrada com sucesso </p>";
                    } else {
                        echo "<p class='alert alert-danger'> Erro ao cadastrar </p>";
                    }
                }
            }
        }
    }

    public function update() {
        
        
        if(!empty($this->filtro)){

        $this->filtro["valor"] = str_replace(".", "", $this->filtro["valor"]);
        $this->filtro["valor"] = str_replace(",", "", $this->filtro["valor"]);
        $this->filtro["valor"] = str_replace("R", "", $this->filtro["valor"]);
        $this->filtro["valor"] = str_replace("$", "", $this->filtro["valor"]);

        $Dados = [
            "user_id" => $_SESSION["user_id"],
            "type" => $this->filtro["tipo"],
            "mode" => 1,
            "title" => $this->filtro["title"],
            "method_payment" => $this->filtro["method_payment"],
            "value" => $this->filtro["valor"],
            "parcel" => $this->filtro["js_parcelas"],
            "date_payment" => $this->filtro["date_payment"],
            "status" => $this->filtro["status"]
        ];

      //  var_dump($Dados);

        $update = new \Source\Models\Update();
        $update->ExeUpdate("invoices", $Dados, "WHERE id = :a", "a={$_GET["update"]}");
        $update->getResult();
        
        if($update->getResult()){
            echo "<p class='alert alert-success'>Update realizado com sucesso</p>";
            
            echo "<meta http-equiv=\"refresh\" content=\"2; URL='index.php?p=entradas'\"/>
";
        }else{
            echo "<p class='alert alert-danger'>Erro ao atualizar </p>";
        }
        
        }

    
       // var_dump($this->filtro);
    }
    
    public function updateService() {
        
        
        if(!empty($this->filtro)){

        $this->filtro["valor"] = str_replace(".", "", $this->filtro["valor"]);
        $this->filtro["valor"] = str_replace(",", "", $this->filtro["valor"]);
        $this->filtro["valor"] = str_replace("R", "", $this->filtro["valor"]);
        $this->filtro["valor"] = str_replace("$", "", $this->filtro["valor"]);

        $Dados = [
            "user_id" => $_SESSION["user_id"],
            "type" => $this->filtro["tipo"],
            'service_id' => $this->filtro["service_id"],
            "mode" => 1,
            "title" => $this->filtro["title"],
            "method_payment" => $this->filtro["method_payment"],
            "value" => $this->filtro["valor"],
            "parcel" => $this->filtro["js_parcelas"],
            "date_payment" => $this->filtro["date_payment"],
            "status" => $this->filtro["status"]
        ];

      //  var_dump($Dados);

        $update = new \Source\Models\Update();
        $update->ExeUpdate("invoices", $Dados, "WHERE id = :a", "a={$_GET["update"]}");
        $update->getResult();
        
        if($update->getResult()){
            echo "<p class='alert alert-success'>Update realizado com sucesso</p>";
            
            echo "<meta http-equiv=\"refresh\" content=\"2; URL='index.php?p=entradas'\"/>
";
        }else{
            echo "<p class='alert alert-danger'>Erro ao atualizar </p>";
        }
        
        }

    
       // var_dump($this->filtro);
    }
    
    public function delete() {
        
        if(!empty($_GET["delete"])){
            
            $delete = new \Source\Models\Delete();
            $delete->ExeDelete("invoices", "WHERE id = :a", "a={$_GET["delete"]}");
            if($delete->getResult()){
                echo "<p class='alert alert-success'> Fatura deletada com sucesso</p>";
                echo "<meta http-equiv=\"refresh\" content=\"2; URL='index.php?p=entradas'\"/>";
            }else{
                echo "<p class='alert alert-danger'> Erro deletar Fatura</p>";
            }
            
        }
        
    }
    
     public function Agora() {

        $this->agora = date("m-Y");
        $mparam = date("m");
        $aparam = date("Y");

            $read = new \Source\Models\Read();
            $read->ExeRead("invoices", "WHERE mode = :v AND status = :a  AND MONTH(date_payment) = :m AND YEAR(date_payment) = :y ",
                    "m={$mparam}&y={$aparam}&v=1&a=paid");
       
        $read->getResult();
        $agora = 0;
        foreach ($read->getResult() as $value) {
            $agora += $value['value'];
        }

        return number_format($agora / 100, 2, ".", "");
    }
    
    public function menosUm() {
       
        $data = date("m-Y");
        $data = date("m-Y", strtotime("-1 month"));

        $tratar = explode("-", $data);

        $param1 = $tratar['0'];
        $param2 = $tratar['1'];
        
         $read = new \Source\Models\Read();
            $read->ExeRead("invoices", "WHERE  status = :s AND MONTH(date_payment) = :m AND YEAR(date_payment) = :y AND mode = :v",
                    "s=paid&m={$param1}&y={$param2}&v=1");
   
        $read->getResult();
        $menosUm = 0;
        foreach ($read->getResult() as $value) {
            $agora += $value['valor'];
        }
        
        if($menosUm == 0){
            return 0;
        }else{
            return number_format($menosUm / 100, 2, ".", "");
        }

        
        
     
    }
    
    public function menosDois() {
       
        $data = date("m-Y");
        $data = date("m-Y", strtotime("-2 month"));

        $tratar = explode("-", $data);

        $param1 = $tratar['0'];
        $param2 = $tratar['1'];
        
         $read = new \Source\Models\Read();
            $read->ExeRead("invoices", "WHERE  status = :s AND MONTH(date_payment) = :m AND YEAR(date_payment) = :y AND mode = :v",
                    "s=paid&m={$param1}&y={$param2}&v=1");
   
        $read->getResult();
        $menosDois = 0;
        foreach ($read->getResult() as $value) {
            $agora += $value['valor'];
        }
        
        if($menosDois == 0){
            return 0;
        }else{
            return number_format($menosDois / 100, 2, ".", "");
        }

        
        
     
    }

}

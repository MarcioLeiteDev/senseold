<?php


namespace Source\Core;


class Afiliados {
    
    private $filtro;
   
    public function __construct() {
        
        $filtro = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);
        
        $this->filtro = $filtro;
    }
    
    
    public function n1() {
        $read = new \Source\Models\Read();
        $read->ExeRead("app_transacoes", "WHERE n1 = :n1", "n1={$_SESSION["user_id"]}");
        $read->getResult();
        
        $vn1 = 0;
        foreach ($read->getResult() as $value) {
            $vn1 += $value["amount"];
        }
        
        $comissao = number_format($vn1/100 , 2, ".", ".");
               
        return  $comissao = $comissao / 100 * 3;

    }
    
    public function n2() {
        $read = new \Source\Models\Read();
        $read->ExeRead("app_transacoes", "WHERE n2 = :n2", "n2={$_SESSION["user_id"]}");
        $read->getResult();
        
        $vn1 = 0;
        foreach ($read->getResult() as $value) {
            $vn1 += $value["amount"];
        }
        
        $comissao = number_format($vn1/100 , 2, ".", ".");
               
        return  $comissao = $comissao / 100 * 3;

    }
    
    public function n3() {
        $read = new \Source\Models\Read();
        $read->ExeRead("app_transacoes", "WHERE n3 = :n3", "n3={$_SESSION["user_id"]}");
        $read->getResult();
        
        $vn1 = 0;
        foreach ($read->getResult() as $value) {
            $vn1 += $value["amount"];
        }
        
        $comissao = number_format($vn1/100 , 2, ".", ".");
               
        return  $comissao = $comissao / 100 * 3;

    }
    
    public function n4() {
        $read = new \Source\Models\Read();
        $read->ExeRead("app_transacoes", "WHERE n4 = :n4", "n4={$_SESSION["user_id"]}");
        $read->getResult();
        
        $vn1 = 0;
        foreach ($read->getResult() as $value) {
            $vn1 += $value["amount"];
        }
        
        $comissao = number_format($vn1/100 , 2, ".", ".");
               
        return  $comissao = $comissao / 100 * 3;

    }
    
    public function n5() {
        $read = new \Source\Models\Read();
        $read->ExeRead("app_transacoes", "WHERE n5 = :n5", "n5={$_SESSION["user_id"]}");
        $read->getResult();
        
        $vn1 = 0;
        foreach ($read->getResult() as $value) {
            $vn1 += $value["amount"];
        }
        
        $comissao = number_format($vn1/100 , 2, ".", ".");
               
        return  $comissao = $comissao / 100 * 3;

    }
    
    public function n6() {
        $read = new \Source\Models\Read();
        $read->ExeRead("app_transacoes", "WHERE n6 = :n6", "n6={$_SESSION["user_id"]}");
        $read->getResult();
        
        $vn1 = 0;
        foreach ($read->getResult() as $value) {
            $vn1 += $value["amount"];
        }
        
        $comissao = number_format($vn1/100 , 2, ".", ".");
               
        return  $comissao = $comissao / 100 * 3;

    }
    
    public function n7() {
        $read = new \Source\Models\Read();
        $read->ExeRead("app_transacoes", "WHERE n7 = :n7", "n7={$_SESSION["user_id"]}");
        $read->getResult();
        
        $vn1 = 0;
        foreach ($read->getResult() as $value) {
            $vn1 += $value["amount"];
        }
        
        $comissao = number_format($vn1/100 , 2, ".", ".");
               
        return  $comissao = $comissao / 100 * 3;

    }
    
    public function n8() {
        $read = new \Source\Models\Read();
        $read->ExeRead("app_transacoes", "WHERE n8 = :n8", "n8={$_SESSION["user_id"]}");
        $read->getResult();
        
        $vn1 = 0;
        foreach ($read->getResult() as $value) {
            $vn1 += $value["amount"];
        }
        
        $comissao = number_format($vn1/100 , 2, ".", ".");
               
        return  $comissao = $comissao / 100 * 3;

    }
    
    public function n9() {
        $read = new \Source\Models\Read();
        $read->ExeRead("app_transacoes", "WHERE n9 = :n9", "n9={$_SESSION["user_id"]}");
        $read->getResult();
        
        $vn1 = 0;
        foreach ($read->getResult() as $value) {
            $vn1 += $value["amount"];
        }
        
        $comissao = number_format($vn1/100 , 2, ".", ".");
               
        return  $comissao = $comissao / 100 * 3;

    }
    
    public function n10() {
        $read = new \Source\Models\Read();
        $read->ExeRead("app_transacoes", "WHERE n10 = :n10", "n10={$_SESSION["user_id"]}");
        $read->getResult();
        
        $vn1 = 0;
        foreach ($read->getResult() as $value) {
            $vn1 += $value["amount"];
        }
        
        $comissao = number_format($vn1/100 , 2, ".", ".");
               
       return $comissao = $comissao / 100 * 3;

    }
    
    public function total() {
        
      $total =  $this->n1() + $this->n2() + $this->n3() + $this->n4() + $this->n5() + $this->n6() + $this->n7() + $this->n8() + $this->n9() + $this->n10() ;
        
    return number_format($total  , 2, ".", ".");
    }
    
    public function saque() {
        
        if($this->filtro["valor"]){

             
             if($this->filtro["valor"] >= $this->balanco()){
                 echo "<div class=\"alert alert-danger\" role=\"alert\">
               <h5>Saldo Insuficiente</h5>  </div>";
                 unset($this->filtro["submit"]);
                // var_dump($this->filtro);
                 return;
             }
             unset($this->filtro["submit"]);
             $this->filtro["user_id"] = $_SESSION["user_id"];
             $this->filtro["valor"] = str_replace(".", "", $this->filtro["valor"]);
             $this->filtro["valor"] = str_replace(",", "", $this->filtro["valor"]);
             
             $this->filtro["date"] = date("Y-m-d H:i:s");
             
             $cad = new \Source\Models\Create();
             $cad->ExeCreate("app_saques", $this->filtro);
             $cad->getResult();
             
             if($cad->getResult()){
                 echo "<div class=\"alert alert-success\" role=\"alert\">
               <h5>Saque solicitado com sucesso</h5>  </div>";
             }else{
                 echo "<div class=\"alert alert-danger\" role=\"alert\">
               <h5>Erro ao processar saque</h5>  </div>"; 
             }

        }
        
        
    }
    
    public function dadosSaques() {
        
        $read = new \Source\Models\Read();
        $read->ExeRead("app_saques", "WHERE user_id = :id", "id={$_SESSION["user_id"]}");
        $read->getResult();
        
        if(!empty($read->getResult())){
            return $read->getResult();
        }else{
            null;
        }
        
    }
    
    public function totalSaques() {
        $read = new \Source\Models\Read();
        $read->ExeRead("app_saques", "WHERE user_id = :id", "id={$_SESSION["user_id"]}");
        $read->getResult();
        $total = 0;
        foreach ($read->getResult() as $value) {
            $total += $value["valor"];
        }
        return number_format($total / 100, 2, ".", ".");
        
    }
    
    public function balanco() {
       $balanco = $this->total() - $this->totalSaques();
       return number_format($balanco, 2, ".", ".");
    }

}

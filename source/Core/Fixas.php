<?php



namespace Source\Core;


class Fixas {
    
    public function __construct() {
       $this->fixas();
    }
    
    public function fixas() {
        
           echo $hoje = date("Y-m-d");
           echo $busca = date('Y-m-d', strtotime("+15 days", strtotime($hoje)));
        
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE tipo = :a AND repetir_em  BETWEEN  :m AND  :y  ", "a=Fixa&m={$hoje}&y={$busca}");
            $read->getResult();
            
            foreach ($read->getResult() as $data) {
                
                $repetir = date('Y-m-d', strtotime("+1 month", strtotime($data["vencimento_em"])));
                
                  $Dados = [
                        "modo" => $data["modo"],
                        "descricao" => $data["descricao"],
                        "vencimento_em" => $data["vencimento_em"],
                        "valor" => $data["valor"],
                        "carteira_id" => $data["carteira_id"],
                        "categoria_id" => $data["categoria_id"],
                        "tipo" => $data["tipo"],
                        "js_parcelas" => 0,
                        "user_id" => $data["user_id"],
                        "status" => "unpaid",
                        "repetir_em" => $repetir
                    ];
                  
                  //verifica se ja existe uma fatura gerada
                  $verifica = new \Source\Models\Read();
                  $verifica->ExeRead("app_faturas", "WHERE descricao = :a AND vencimento_em = :b ", "a={$data["descricao"]}&b={$repetir}");
                  $verifica->getResult();
                  if($verifica->getResult()){
                      echo "Ja existe uma fatura cadastrada";
                  }else{
                      echo "cadastra nova fatura";
                      
                      $cad = new \Source\Models\Create();
                      $cad->ExeCreate("app_faturas", $Dados);
                      $cad->getResult();
                      if($cad->getResult()){
                          echo "Fatura cadastrada com Sucesso;";
                      }else{
                          echo "Erro casdastrar fatura";
                      }
                      
                      var_dump($Dados);
                  }

                
               // var_dump($Dados);
                echo "<hr>";
                
            }
        
    }
}

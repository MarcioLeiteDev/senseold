<?php

namespace Source\Core;

class Transacao {

    private $filtro;
    
    private $transacao;

    public function __construct() {

        $filtro = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED);

        $this->filtro = $filtro;
    }

    public function cartao_credito() {

        if (!empty($this->filtro)) {
            
            if($this->filtro["payment_method" == "boleto"]){
               $this->transacao();
              
               
            }

            $pagarme = new \PagarMe\Client(CONF_PAGARME_TEST);

            $card = $pagarme->cards()->create([
                'holder_name' => "{$this->filtro["username"]}",
                'number' => "{$this->filtro["cardNumber"]}",
                'expiration_date' => "{$this->filtro["expiration_month"]}{$this->filtro["expiration_year"]}",
                'cvv' => "{$this->filtro["cvv"]}"
            ]);

            if ($card->valid == true) {

                $cartao = [
                    "brand" => $card->brand,
                    "last_digits" => $card->last_digits,
                    "cvv" => $this->filtro["cvv"],
                    "name" => $this->filtro["username"],
                    "hash" => $card->id,
                    "status" => "active",
                    "user_id" => $_SESSION["user_id"]
                ];

                $cad = new \Source\Models\Create();
                $cad->ExeCreate("app_cartao_credito", $cartao);
                $cad->getResult();

                if ($cad->getResult()) {
                   // echo "cartão cadastrado";
                    // qui entra chamado da outra função que é a operação
                    $this->transacao();
                    
                } else {
                    echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
                <h5>Cartão Recusado pela Operadora </h5>  </div>";
                }
            } else {
                echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
                <h5>Cartão Inválido </h5>  </div>";
            }
        }
       // var_dump($this->filtro);
    }

    public function transacao() {
        $pagarme = new \PagarMe\Client( CONF_PAGARME_TEST );
        
     //  var_dump($this->filtro);

//        $preco = explode("|", $this->filtro["plano"]);
//        $preco["1"];
        
        $ver = new \Source\Models\Read();
        $ver->ExeRead("usuarios", "WHERE id = :id", "id={$_SESSION["user_id"]}");
        $ver->getResult();
        
        if($this->filtro["payment_method"] == "credit_card"){
        
        $transaction = $pagarme->transactions()->create([
            'amount' => $this->filtro["total"],
            'payment_method' => $this->filtro["payment_method"],
            'card_holder_name' => "{$this->filtro["username"]}",
            'card_cvv' => "{$this->filtro["cvv"]}",
            'card_number' => "{$this->filtro["cardNumber"]}",
            'card_expiration_date' => "{$this->filtro["expiration_month"]}{$this->filtro["expiration_year"]}",
            'customer' => [
                'external_id' => "{$_SESSION["user_id"]}",
                'name' => "{$ver->getResult()[0]["first_name"]} {$ver->getResult()[0]["last_name"]}",
                'type' => 'individual',
                'country' => 'br',
                'documents' => [
                    [
                        'type' => 'cpf',
                        'number' => "00000000000"
                    ]
                ],
                'phone_numbers' => ['+5511000000000'],
                'email' => "{$ver->getResult()[0]["email"]}"
            ]
        ]);
        }
        
        if($this->filtro["payment_method"] == "boleto"){
        
          $transaction = $pagarme->transactions()->create([
    'amount' => 1000,
    'payment_method' => 'boleto',
   
    'customer' => [
        'external_id' => '1',
        'name' => 'Nome do cliente',
        'type' => 'individual',
        'country' => 'br',
        'documents' => [
          [
            'type' => 'cpf',
            'number' => '00000000000'
          ]
        ],
        'phone_numbers' => [ '+551199999999' ],
        'email' => 'cliente@email.com'
    ]
    
]);
                
        var_dump($transaction);
        }

        
        
                
                if($transaction->status == "paid"){
                    echo "<div class='alert alert-success'>pagamento realizado com sucesso</div>";
                    
                    $Dados = [
                        "status" => 2,
                        "metodo_pagamento" => $transaction->payment_method,
                        "transacao_id" => $transaction->tid,
                        "bandeira" => $transaction->card_brand,
                        "digitos" => $transaction->card_last_digits
                    ];
                    
                    $atualizaPedido = new \Source\Models\Update();
                    $atualizaPedido->ExeUpdate("app_pedidos", $Dados, "WHERE pedido_id = :a" , "a={$_SESSION["pedido_id"]}");
                    $atualizaPedido->getResult();
                    if($atualizaPedido->getResult()){
                        sleep(5);
                        
            $boot = new \Source\Models\Read();
            $boot->ExeRead("usuarios", "WHERE id = :id", "id={$_SESSION["user_id"]}");
            $boot->getResult();
            
            $view = new \Source\Models\View(__DIR__ . "/../../themes/views/email");
            $message = $view->render("pagamento", [
                 "nome" => $boot->getResult()[0]["first_name"] . " " . $boot->getResult()[0]["first_name"],
                "forma_pagamento" => $transaction->payment_method,
                "bandeira" => $transaction->card_brand,
                "digitos" => $transaction->card_last_digits
            ]);
            
             $email = new \Source\Support\Email();
                 $email->bootstrap(
                         "Pedido" . CONF_SITE_NAME, 
                         $message, 
                         $boot->getResult()[0]["email"], 
                         $boot->getResult()[0]["first_name"])->send();
                        
                        
                       if($email->send()) {
                         header("location:./pedidos"); 
                         unset($_SESSION["carrinho"]);
                         unset($_SESSION["frete"]);
                         unset($_SESSION["freteTipo"]);
                         unset($_SESSION["totalPedido"]);
                         unset($_SESSION["pedido_id"]);
                         unset($_SESSION["pagamento"]);
                         unset($_SESSION["cep"]);
                       }else{
                           echo "erro enviar email";
                       }
                       
                       // echo "atualizado com sucesso";
                    }else{
                       echo "erro"; 
                    }
                    
                    
                    //$this->matricula($transaction->id);
                }else{
                    echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
                <h5>Pagamento Recusado pela Operadora </h5>  </div>";
                }
               
      // var_dump($transaction);
    }

    public function matricula($data) {
        $plano = explode("|", $this->filtro["plano"]);
        
        $ver = new \Source\Models\Read();
        $ver->ExeRead("app_cartao_credito", "WHERE user_id = :id" , "id={$_SESSION["user_id"]}");
        $ver->getResult();
        
        $Dados = [
           "user_id" => "{$_SESSION["user_id"]}",
            "plano_id" => "{$plano["0"]}",
            "card_id" => "{$ver->getResult()[0]["id"]}",              
            "status" => "active",
            "transacao" => "{$data}",
            "status_pagamento" => "active",
            "inicio" => date("Y-m-d"),
            "vencimento_dia" => date("d"),
            "proximo_vencimento" => date('Y-m-d', strtotime("+1 month", strtotime(date('Y-m-d')))),
            "ultima_mudanca" => date("Y-m-d")
                    
        ];
            
            $cad = new \Source\Models\Create();
            $cad->ExeCreate("app_matriculas", $Dados);
            $cad->getResult();
            
            $Param = [
                "nivel" => $plano["0"]
            ];
            
            //atualiza o nivel do usuario
            $nivel = new \Source\Models\Update();
            $nivel->ExeUpdate("usuarios", $Param, "WHERE id = :id", "id={$_SESSION["user_id"]}");
            
            $_SESSION["nivel"] = $plano["0"];
            
            $boot = new \Source\Models\Read();
            $boot->ExeRead("usuarios", "WHERE id = :id", "id={$_SESSION["user_id"]}");
            $boot->getResult();
            
            if($cad->getResult()){
              //envia e-mail de notificação
                 $view = new \Source\Models\View(__DIR__ . "/../../themes/views/email");
                 $message = $view->render("matricula", [
                     "nome" => $boot->getResult()[0]["first_name"] . " " . $boot->getResult()[0]["first_name"]
                     
                 ]);
                 $email = new \Source\Support\Email();
                 $email->bootstrap(
                         "Conta Dflix Control Ativada", 
                         $message, 
                         $boot->getResult()[0]["email"], 
                         $boot->getResult()[0]["first_name"])->send();
                
              // echo "matricula criada com sucesso"; 
               $this->pagamento($Dados["transacao"]);
              // $this->pagamento();
            }else{
                echo "erro inesperado";
            }

            //chama função pagamento // alimenta tabel app_transacoes
        
//        var_dump($this->filtro);
//        var_dump($Dados);
    }
    
    public function pagamento($transacao) {
       
        $money = explode("|", $this->filtro["plano"]);
        
        $afiliados = new \Source\Models\Read();
        $afiliados->ExeRead("usuarios", "WHERE id = :id", "id={$_SESSION["user_id"]}");
        $afiliados->getResult();
        
        $arruma = new \Source\Models\Read();
        $arruma->ExeRead("app_matriculas", "WHERE transacao = :t", "t={$transacao}");
        $arruma->getResult();
        
        $Dados = [
            "user_id" => $_SESSION["user_id"],
            "card_id" => $arruma->getResult()[0]["card_id"],
            "matricula_id" => $arruma->getResult()[0]["id"],
            "transacao" => $transacao,
            "amount" => $money["1"],
            "status" => "paid",
            "n1" => $afiliados->getResult()[0]['n1'],
            "n2" => $afiliados->getResult()[0]['n2'],
            "n3" => $afiliados->getResult()[0]['n3'],
            "n4" => $afiliados->getResult()[0]['n4'],
            "n5" => $afiliados->getResult()[0]['n5'],
            "n6" => $afiliados->getResult()[0]['n6'],
            "n7" => $afiliados->getResult()[0]['n7'],
            "n8" => $afiliados->getResult()[0]['n8'],
            "n9" => $afiliados->getResult()[0]['n9'],
            "n10" =>$afiliados->getResult()[0]['n10']
        ];
        
        $cad = new \Source\Models\Create();
        $cad->ExeCreate("app_transacoes", $Dados);
        $cad->getResult();
        
        if($cad->getResult()){
            echo "<div class=\"alert alert-success col-md-12\" role=\"alert\">
                <h5>Plano Ativado com Sucesso </h5>  </div>";
        }else{
            echo "<div class=\"alert alert-danger col-md-12\" role=\"alert\">
                <h5>Erro ao ativar Plano </h5>  </div>";
        }
        
     
    }

    
}

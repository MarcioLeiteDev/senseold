<?php

use Source\Models\Controller;

namespace Source\App;

class App extends \Source\Models\Controller {

    public function __construct() {
        parent::__construct(__DIR__ . "/../../themes/app/");
    }

    public function home(): void {



        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        $read = new \Source\Models\Read();
        $read->ExeRead("app_categorias", "WHERE type = :c", "c=renda");
        $read->getResult();

        $renda = $read->getResult();

        $read2 = new \Source\Models\Read();
        $read2->ExeRead("app_categorias", "WHERE type = :c", "c=despesa");
        $read2->getResult();

        $despesa = $read2->getResult();

        $read3 = new \Source\Models\Read();
        $read3->ExeRead("app_carterias", "WHERE user_id = :i ", "i={$_SESSION['user_id']}");
        $read3->getResult();

        $carteira = $read3->getResult();

        $fatura = new \Source\Core\Faturas();
        $fatura->registra();

        $fatura->proxPagto();

        $fatura->proxReceita();

        $agora = new \Source\Core\Entradas();

        $entradadash = $agora->Total();


        $agora->rodapegrafico();
        //var_dump($agora->rodapegrafico());

        $agora->chartEntrada();

        $agora->Agora();
        // var_dump($agora->Agora());

        $saida = new \Source\Core\Saidas();
        $saida->chartSaida();

        $saidadash = $saida->Total();

        $balanco = $entradadash - $saidadash;

        $sessaocarteira = new \Source\Core\SessaoCarteiras();
        $vcarteira = $sessaocarteira->sessaoCarteira();

        $agora->pieEntradaIcon();
        // var_dump($agora->pieEntradaIcon());

        $piechart = new \Source\Core\pieChart();

        echo $this->view->render("home", [
            "head" => $head,
            "renda" => $renda,
            "despesa" => $despesa,
            "carteira" => $carteira,
            "rodape" => $agora->rodapegrafico(),
            "entrada" => $agora->chartEntrada(),
            "entradadash" => $entradadash,
            "saidadash" => $saidadash,
            "saida" => $saida->chartSaida(),
            "balanco" => $balanco,
            "sessao_carteira" => $_SESSION['nome_carteira'],
            "entrada_icon" => $agora->pieEntradaIcon(),
            "aluguel" => $piechart->aluguel(),
            "alimentacao" => $piechart->alimentacao(),
            "compras" => $piechart->compras(),
            "educacao" => $piechart->educacao(),
            "entretenimento" => $piechart->entretenimento(),
            "impostos" => $piechart->impostos(),
            "outros" => $piechart->outros(),
            "saude" => $piechart->saude(),
            "viagens" => $piechart->viagens(),
            "combustivel" => $piechart->combustivel(),
            "proxpgto" => $fatura->proxPagto(),
            "proxpgtofixa" => $fatura->proxPagtoFixa(),
            "proxreceita" => $fatura->proxReceita(),
            "proxreceitafixa" => $fatura->proxReceitaFixa(),
            "fixas" => $fatura->Fixas()
        ]);
    }

    public function sessaoCarteira() {
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        var_dump($data);

        $sessao = new \Source\Core\SessaoCarteiras();
        $sessao->sessaoCarteira();
        header("location:./");
        return $sessao->sessaoCarteira();
    }

    public function agenda() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("agenda", [
            "head" => $head
        ]);
    }

    public function produtos() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("produtos", [
            "head" => $head
        ]);
    }

    public function produtosVariacao() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        echo $this->view->render("produtos-variacao", [
            "head" => $head
        ]);
    }
    
     /**
     * 
     * @return void
     */
    public function produtosCateg(): void {
        
       


        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "./assets/image/footer-bg.jpg");


        echo $this->view->render("prod-categ", [
            "head" => $head
        ]);
    }

    public function entrada() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
           
                $read3 = new \Source\Models\Read();
        $read3->ExeRead("app_carterias", "WHERE user_id = :i ", "i={$_SESSION['user_id']}");
        $read3->getResult();

        $carteira = $read3->getResult();
        
                $read = new \Source\Models\Read();
        $read->ExeRead("app_categorias", "WHERE type = :c", "c=renda");
        $read->getResult();

        $renda = $read->getResult();
        

        echo $this->view->render("entrada", [
            "head" => $head ,
            "carteira" => $carteira,
            "renda" => $renda
            
        ]);
    }
    
    public function saida() {
         $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
         
        $read3 = new \Source\Models\Read();
        $read3->ExeRead("app_carterias", "WHERE user_id = :i ", "i={$_SESSION['user_id']}");
        $read3->getResult();

        $carteira = $read3->getResult();
        
        $read = new \Source\Models\Read();
        $read->ExeRead("app_categorias", "WHERE type = :c", "c=despesa");
        $read->getResult();

        $categorias = $read->getResult();
        
           $read = new \Source\Models\Read();
        $read->ExeRead("app_categorias", "WHERE type = :c", "c=renda");
        $read->getResult();

        $renda = $read->getResult();
        
        
               
         
         echo $this->view->render("saidas", [
            "head" => $head,
            "carteira" => $carteira,
            "categorias" => $categorias,
             "renda" => $renda
            
        ]);
         
    }
    
    public function carteira() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
        $read = new \Source\Models\Read();
        $read->ExeRead("app_carterias", "WHERE user_id = :id", "id={$_SESSION["user_id"]}");
        $read->getResult();
        $cart =  $read->getResult();
        
        echo $this->view->render("carteira", [
            "head" => $head,
            "carteiras" => $cart
            
        ]);
         
        
    }
    
    public function assinatura() {
         $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
         
                 echo $this->view->render("assinatura", [
            "head" => $head
            
        ]);
         
    }
    
    public function perfil() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("perfil", [
            "head" => $head
            
        ]);
        
    }
    
    public function afiliados() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("afiliados", [
            "head" => $head
            
        ]);
        
    }
    
    public function orcamento() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("orcamento", [
            "head" => $head
            
        ]);
        
    }
    
    public function contrato() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("contrato", [
            "head" => $head
            
        ]);
        
    }
    
    public function plano() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("plano", [
            "head" => $head
            
        ]);
        
    }
    
    public function cliente() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("cliente", [
            "head" => $head
            
        ]);
        
    }
    
    public function post() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("post", [
            "head" => $head
            
        ]);
        
    }
    
    public function postHome() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("post-home", [
            "head" => $head
            
        ]);
        
    }
    
    public function postCateg() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("post-categ", [
            "head" => $head
            
        ]);
        
    }
    
    public function clienteCadastra() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("cliente_cadastra", [
            "head" => $head
            
        ]);
        
    }
    
    public function clienteEndereco() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("cliente_endereco", [
            "head" => $head
            
        ]);
        
    }
    
    public function clienteContato() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("cliente_contato", [
            "head" => $head
            
        ]);
        
    }
    
    public function pedido() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("pedido", [
            "head" => $head
            
        ]);
        
    }
    
    public function pedidoVeiculo() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("pedido_veiculos", [
            "head" => $head
            
        ]);
        
    }
    
    public function pedidoPlanos() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("pedido_planos", [
            "head" => $head
            
        ]);
        
    }
    
    public function pedidoItens() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("pedido_itens", [
            "head" => $head
            
        ]);
        
    }
    
    public function pedidoDetalhes() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("pedido_detalhes", [
            "head" => $head
            
        ]);
        
    }
    
    public function pedidoLocal() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("pedido_local", [
            "head" => $head
            
        ]);
        
    }
    
    public function pedidoAgendar() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("pedido_agendar", [
            "head" => $head
            
        ]);
        
    }
    
    public function pedidoRecibo() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("pedido_recibo", [
            "head" => $head
            
        ]);
        
    }
    
    public function financeiro() {
      //  $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
       $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");

        $read = new \Source\Models\Read();
        $read->ExeRead("app_categorias", "WHERE type = :c", "c=renda");
        $read->getResult();

        $renda = $read->getResult();

        $read2 = new \Source\Models\Read();
        $read2->ExeRead("app_categorias", "WHERE type = :c", "c=despesa");
        $read2->getResult();

        $despesa = $read2->getResult();

        $read3 = new \Source\Models\Read();
        $read3->ExeRead("app_carterias", "WHERE user_id = :i ", "i={$_SESSION['user_id']}");
        $read3->getResult();

        $carteira = $read3->getResult();

        $fatura = new \Source\Core\Faturas();
        $fatura->registra();

        $fatura->proxPagto();

        $fatura->proxReceita();

        $agora = new \Source\Core\Entradas();

        $entradadash = $agora->Total();


        $agora->rodapegrafico();
        //var_dump($agora->rodapegrafico());

        $agora->chartEntrada();

        $agora->Agora();
        // var_dump($agora->Agora());

        $saida = new \Source\Core\Saidas();
        $saida->chartSaida();

        $saidadash = $saida->Total();

        $balanco = $entradadash - $saidadash;

        $sessaocarteira = new \Source\Core\SessaoCarteiras();
        $vcarteira = $sessaocarteira->sessaoCarteira();

        $agora->pieEntradaIcon();
        // var_dump($agora->pieEntradaIcon());

        $piechart = new \Source\Core\pieChart();

        echo $this->view->render("home", [
            "head" => $head,
            "renda" => $renda,
            "despesa" => $despesa,
            "carteira" => $carteira,
            "rodape" => $agora->rodapegrafico(),
            "entrada" => $agora->chartEntrada(),
            "entradadash" => $entradadash,
            "saidadash" => $saidadash,
            "saida" => $saida->chartSaida(),
            "balanco" => $balanco,
            "sessao_carteira" => $_SESSION['nome_carteira'],
            "entrada_icon" => $agora->pieEntradaIcon(),
            "aluguel" => $piechart->aluguel(),
            "alimentacao" => $piechart->alimentacao(),
            "compras" => $piechart->compras(),
            "educacao" => $piechart->educacao(),
            "entretenimento" => $piechart->entretenimento(),
            "impostos" => $piechart->impostos(),
            "outros" => $piechart->outros(),
            "saude" => $piechart->saude(),
            "viagens" => $piechart->viagens(),
            "combustivel" => $piechart->combustivel(),
            "proxpgto" => $fatura->proxPagto(),
            "proxpgtofixa" => $fatura->proxPagtoFixa(),
            "proxreceita" => $fatura->proxReceita(),
            "proxreceitafixa" => $fatura->proxReceitaFixa(),
            "fixas" => $fatura->Fixas()
        ]);
        
    }
    
    public function sair() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("sair", [
            "head" => $head
            
        ]);
        
    }
    
    public function caixa() {
        $head = $this->seo->render(CONF_SITE_NAME, CONF_SITE_DESC, CONF_SITE_DOMAIN, "https://thumbs.dreamstime.com/b/imagem-de-fundo-bonita-do-c%C3%A9u-da-natureza-64743176.jpg");
        
         echo $this->view->render("caixa", [
            "head" => $head
            
        ]);
        
    }

}

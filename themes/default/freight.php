

<header class="container backwhite"> 

    <h1>Frete </h1>
    
    <?php 
    if(empty($_SESSION["user_id"])){
        header("location:./entrar");
       
    }
   
    $frete = new \Source\Core\Carrinho();
    $frete->frete();
    
    ?>
    
    
    
    <div class="container"> 
        <h1> Pedido Nº <?= $_SESSION["pedido_id"] ?> </h1>
        <p> Total do pedido R$ <?php
        $total = $_SESSION["frete"] + $_SESSION["totalPedido"];
        
        echo number_format($total / 100,2, "," , ".");
                
                ?></p>
        <p>Método de Entrega: <?=$_SESSION["freteTipo"] ?> </p>
        
        <h4> Itens do Pedido </h4>
        <?php
         $total = 0;
                foreach ($_SESSION['carrinho'] as $id => $qtd) {
 
                    ?>
                        <tr>
                            <td><img src="<?=CONF_URL_BASE ?>/uploads/<?php $id;
                            
                            $viewValor = new \Source\Models\Read();
                            $viewValor->ExeRead("app_prod_var", "WHERE produto_id = :a", "a={$id}");
                           echo $viewValor->getResult()[0]["imagem"];
                            
                             ?>" /> </td>
                            <td><?php 
                             $id;
                                        $nomeProd = new \Source\Models\Read();
                                        $nomeProd->ExeRead("app_prod", "WHERE id = :a", "a={$id}");
                                       echo $nomeProd->getResult()[0]["produto"];
                                        
                                        
                                        ?></td>
                            <td>R$ <?php 
                            $id; 
                            $viewValor = new \Source\Models\Read();
                            $viewValor->ExeRead("app_prod_var", "WHERE produto_id = :a", "a={$id}");
                            $valor = $viewValor->getResult()[0]["valor"];
                           echo $exiveValor = number_format($valor / 100, 2, ",", ".");
                            ?></td>
                           
                            
                        </tr>
                        
            <?php } ?>
                        
                       
    </div>     




<div class="col-md-12"> 
            <div class="row">
                <div class="col-md-12">
                    <h3 class="border-bottom col-md-12"> Cadastrar Endereço Entrega do Pedido <?= $_SESSION["pedido_id"] ?> </h3>  

                    <form method="post" action="">


                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-6">
                                    <label>Selecione o Tipo </label>


                                    <select name="tipo" class="form-control"> 
                                   
                                        <option value="#">Tipo de Endereço </option>
                                        <option value="1">Residêncial </option>
                                        <option value="2">Empresarial </option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>Cep </label>
                                    <input type="text" id="cep" value="<?= $_SESSION["cep"] ?>"  onblur="pesquisacep(this.value);" class="form-control" placeholder="Nome ou Razão Social" name="cep" />
                                </div>

                            </div>
                        </div>


                        <div class=" col-md-12"> 

                            <div class="row"> 
                                <div class="col-md-10"> 
                                    <label>Logradouro </label>
                                    <input type="text" id="logradouro" class="form-control" name="logradouro" placeholder="logradouro" />
                                </div>
                                <div class="col-md-2"> 
                                    <label>Numero </label>
                                    <input type="text"  class="form-control" name="numero" placeholder="nº" />
                                </div>
                            </div>

                            <div class="row"> 
                                <div class="col-md-8"> 
                                    <label>Complemento </label>
                                    <input type="text"  class="form-control" name="complemento" placeholder="complemento" />
                                </div>
                                <div class="col-md-4"> 
                                    <label>Bairro </label>
                                    <input type="text"  id="bairro"  class="form-control" name="bairro" placeholder="bairro" />
                                </div>
                            </div>

                            <div class="row"> 
                                <div class="col-md-6"> 
                                    <label>Cidade </label>
                                    <input type="text"  id="cidade" class="form-control" name="cidade" placeholder="cidade" />
                                </div>
                                <div class="col-md-6"> 
                                    <label>UF </label>
                                    <input type="text"  id="uf"  class="form-control" name="uf" placeholder="uf" />
                                </div>
                            </div>

                        </div>
                        </br>
                        <div class="col-md-12">
                            </br>
                            <input type="hidden" name="user_id" value="<?= $_SESSION["user_id"] ?>" />
                            <input type="hidden" name="pedido_id" value="<?= $_SESSION["pedido_id"] ?>" />
                            <input type="submit" value="cadastrar" class="btn btn-success" />

                           
                    </form>

                </div>
                        
                        </header>


<!-- Adicionando Javascript -->
<script type="text/javascript" >

    function limpa_formulário_cep() {
        //Limpa valores do formulário de cep.
        document.getElementById('logradouro').value = ("");
        document.getElementById('bairro').value = ("");
        document.getElementById('cidade').value = ("");
        document.getElementById('uf').value = ("");

    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('logradouro').value = (conteudo.logradouro);
            document.getElementById('bairro').value = (conteudo.bairro);
            document.getElementById('cidade').value = (conteudo.localidade);
            document.getElementById('uf').value = (conteudo.uf);

        } //end if.
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }

    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('logradouro').value = "...";
                document.getElementById('bairro').value = "...";
                document.getElementById('cidade').value = "...";
                document.getElementById('uf').value = "...";


                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = '//viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    }
    ;

</script>

               
<div class="container-fluid">
    <h1>Cadastrar Cliente</h1>
    <?php
    
    $cliente = new Source\Core\Clientes();
    $cliente->cadastra();
    
    ?>
    <form action="" method="POST">
        <div class="row">
        <div class="col-md-12">
            <label>Nome</label>
            <input type="text" name="name" class="form-control" />
        </div>
        
        <div class="col-md-6">
            <label>Email</label>
            <input type="text" name="email" class="form-control" />
        </div>
        
        <div class="col-md-6">
            <label>Telefone</label>
            <input type="text" name="phone" class="form-control" />
        </div>
        
            
            
            <div class="col-md-12"><h3>Dados de Correspondência</h3></div>
            
             <div class="form-group col-md-2">
            <label class="vinte">
                CEP 
            </label>
            <input name="cep" type="text" id="cep" value="" class="form-control"  maxlength="9"
                   onblur="pesquisacep(this.value);" />
        </div>

        <div class="form-group col-md-8">
            <label>
                END.RES: </label>
            <input name="endereco" type="text" id="endereco" class="form-control" />
        </div>
        <div class="form-group col-md-2">
            <label>Numeroº</label>
            <input name="numero" type="text" id="numero" class="form-control"  />

        </div>

        <div class="form-group col-md-5">
            <label> 
                COMPLEMENTO:
            </label>
            <input name="complemento" type="text" id="complemento" class="form-control" />
        </div>

        <div class="form-group col-md-3">
            <label> BAIRRO : </label>
            <input name="bairro" type="text" id="bairro"  class="form-control" />
        </div>

        <div class="form-group col-md-3">
            <label>CIDADE: </label>        

            <input name="cidade" type="text" id="cidade" class="form-control"  />
        </div>  

        <div class="form-group col-md-1">
            <label>UF:</label>
            <input name="uf" type="text" id="uf" class="form-control" />
        </div>

            <div class="col-md-12">
                
                <input type="submit" class="btn btn-primary" value="CADASTRAR"/>
            </div>

        
        
        </div>
    </form>
</div>

<!-- Adicionando Javascript -->
<script type="text/javascript" >

    function limpa_formulário_cep() {
        //Limpa valores do formulário de cep.
        document.getElementById('endereco').value = ("");
        document.getElementById('bairro').value = ("");
        document.getElementById('cidade').value = ("");
        document.getElementById('uf').value = ("");

    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('endereco').value = (conteudo.logradouro);
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
                document.getElementById('endereco').value = "...";
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
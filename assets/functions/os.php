<?php
session_start();
include '../../vendor/autoload.php';

$filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);



$_SESSION["busca"] = $filtro["palavra"];

$user = $_SESSION["user_id"];

//var_dump($_SESSION);


$filtro["user_id"] = $_SESSION["user_id"];
echo "<p>Sua busca por <b>" . $filtro["palavra"]  . "</b> Retornou os seguintes resultados." ;
?>


<table class="table blog"> 
                <thead> 
                    <tr> 
                        <th> Imagem</th>
                        <th> Loja</th>
                        <th> Produto</th>
                        <th> Categoria</th>
                        <th> QTD</th>
                        <th> Preço</th>
                        <th> Qtd</th>
                     
                    </tr>
                </thead>
                <tbody> 
                    <?php 
                    $atual = filter_input(INPUT_GET, 'atual', FILTER_VALIDATE_INT);
                    $pager = new Source\Support\Pager("./?p=orcamento-itens&editar={$_SESSION["orcamento"]}&atual=" , "Primeiro" , "Ultimo" , "1");
                    $pager->ExePager($atual, 5);
                    
                    $exibe = new Source\Models\Read();
                    $exibe->ExeRead("app_estoque", "WHERE produto LIKE '%' :b '%'  OR categoria LIKE '%' :b '%' LIMIT :limit OFFSET :offset", 
                            "b={$filtro["palavra"]}&limit={$pager->getLimit()}&offset={$pager->getOffset()}");
                    $exibe->getResult();
                    foreach ($exibe->getResult() as $value) {

                    ?>
                    <tr> 
                        <td> <?php 
                        $urlbase = CONF_URL_BASE;
                        if(!empty($value["imagem"])){
                          echo "<img src='./../uploads/{$value["imagem"]}' width='100'  />";  
                        }else{
                           echo "<img src='{$urlbase}/assets/imagens/produto-sem-imagem.jpg' width='100' />";    
                        }
                        
                        ?></td>
                        <td> <?= $value["loja"] ?></td>
                        <td> <?= $value["produto"] ?></td>
                        <td> <b><?= $value["categoria"] ?></b></td>
                        <td> <?= $value["qtd"] ?></td>
                        <td>R$ <?= number_format($value["preco_venda"] / 100 , 2 , "." , ","); ?></td>
                        <td> 
                            <form action="" method="post"> 
                                <input type="text" name="qtd" class="form-control" />
                                <input type="hidden" name="acao" value="add" />
                                <input type="hidden" name="origem" value="estoque" />
                                <input type="hidden" name="id" value="<?= $value["id"] ?>" />
                                <input type="submit" class="btn btn-info" value="cadastrar" />
                            </form>
                        
                        </td>
                        
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            <?php 
            $pager->ExePaginator("app_estoque", "WHERE produto LIKE '%' :b '%'  OR categoria LIKE '%' :b '%' ", "b={$_SESSION["busca"]}");
            echo $pager->getPaginator();

            ?>

<?php
session_start();
include '../../vendor/autoload.php';

$filtro = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$_SESSION["busca"] = $filtro["palavra"];

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
                        <th> Editar</th>
                        <th> Excluir <img src="" width="100"</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php 
                    $atual = filter_input(INPUT_GET, 'atual', FILTER_VALIDATE_INT);
                    $pager = new Source\Support\Pager("?p=estoque&atual=" , "Primeiro" , "Ultimo" , "1");
                    $pager->ExePager($atual, 5);
                    
                    $exibe = new Source\Models\Read();
                    $exibe->ExeRead("app_estoque", "WHERE user_id = :a AND produto LIKE '%' :b '%'  OR categoria LIKE '%' :b '%' LIMIT :limit OFFSET :offset", "a={$_SESSION["user_id"]}&b={$_SESSION["busca"]}&limit={$pager->getLimit()}&offset={$pager->getOffset()}");
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
                        <td> <a href="?p=estoque&editar=<?= $value["id"] ?>"><i class="fas fa-edit"></i></a></td>
                        <td><a href="?p=estoque&deletar=<?= $value["id"] ?>" style="text-decoration: none; color: red;"> <i class="fas fa-trash-alt"></i></a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            
            <?php 
            $pager->ExePaginator("app_estoque");
            echo $pager->getPaginator();

            ?>

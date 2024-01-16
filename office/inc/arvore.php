<div class="container">
    <h3>Árvore Genealógica</h3>
    <?php
    if (!empty($_GET["delete"])) {
        $arvore = new Source\Core\Arvore();
        $arvore->delete();
    } elseif (!empty($_GET["update"])) {

        $dados = new Source\Models\Read();
        $dados->ExeRead("genealogy_tree", "WHERE id = :a", "a={$_GET["update"]}");
        $dados->getResult();

        $arvore = new Source\Core\Arvore();
        $arvore->update();
    } else {

        $arvore = new Source\Core\Arvore();
        $arvore->cadastra();
    }
    ?>


    <form class="form" name="form" method="POST" action="">
        <div class="form-group">
            <label>Nome</label>
            <input type="text" name="name" class="form-control" 
            <?php
            if (!empty($_GET["update"])) {
                echo "value='{$dados->getResult()[0]['name']}'";
            }
            ?>
                   />
        </div>


        <div class="form-group">
            <label>Tipo</label>
            <select name="type" class="form-control">
                <?php
                if (!empty($_GET["update"])) {
                    echo "<option value='{$dados->getResult()[0]['type']}'>{$dados->getResult()[0]['type']}</option>";
                }
                ?>
                <option value="1">Antenato</option>
                <option value="2">Requerente</option>
            </select>
        </div>

        <div class="form-group">
            <label>Origem</label>
            <select class="form-control" name="origin">

                <?php
                if (!empty($_GET["update"])) {
                    echo "<option value='{$dados->getResult()[0]['origin']}'>{$dados->getResult()[0]['origin']}</option>";
                }
                ?>

                <option> Selecione a Origem</option>


                <?php
                $origem = new Source\Models\Read();
                $origem->ExeRead("genealogy_tree", "WHERE service = :a ORDER BY name ASC", "a={$_GET["servico"]}");
                $origem->getResult();
                if ($origem->getResult()) {
                    ?>


                    <?php foreach ($origem->getResult() as $value) { ?>
                        <option value="<?= $value["name"] ?>"> <?= $value["name"] ?></option> 
                    <?php } ?>

                <?php } ?>
            </select>
            <!--input type="text" class="form-control" name="origin" /-->
        </div>

        <div class="form-group">
            <label>Menor de Idade</label>
            <select name="smaller" class="form-control">
                <option value="0">Não</option>
                <option value="1">Sim</option>
            </select>
        </div>



        <div class="form-group">
            <input type="hidden" name="service"  value="<?= $_GET["servico"] ?>" />
            <input type="submit"class="btn btn-success" value="cadastrar" />
        </div>

    </form>


    <div class="col-12 bg-light p-4">
        <h3>Imprimir Arvore</h3>
        <form action="./arvore.php" method="get" target="blank">
            <div class="form-group">
                <label>Fonte Número</label>
                <select name="fonte" class="form-control">

                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                </select>
            </div>
            <div class="form-group">
                <label>Largura</label>
                <input type="text" name="largura" class="form-control" />
            </div>
            <input type="hidden" name="servico" value="<?= $_GET["servico"] ?>" />
            <input type="submit" class="btn btn-outline-warning" value="ver pagina" />

        </form>
        <!--h4> <a href="./arvore.php?servico=<?= $_GET["servico"] ?>" target="blank">Link da Pagina </a></h4-->
    </div>

    <!-- Arvore CSS -->

    <div class="tree">
        <ul>
            <li>
                <?php
                $nivel1 = new Source\Models\Read();
                $nivel1->ExeRead("genealogy_tree", "WHERE service = :a ORDER BY id ASC", "a={$_GET["servico"]}");
                $nivel1->getResult();
                if ($nivel1->getResult()) {
                    ?>
                    <a href="#" > <?= $nivel1->getResult()[0]['name'] ?> 
                        <?php
                        if ($nivel1->getResult()[0]['smaller'] == 1) {
                            echo " <b>- Minore</b>";
                        }
                        ?></a> 
                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&delete=<?= $nivel1->getResult()[0]['id'] ?>"><i class="fa-solid fa-trash-can" style="font-size:1.5em; color:red;"></i></a>
                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&update=<?= $nivel1->getResult()[0]['id'] ?>"><i class="fa-solid fa-pen" style="font-size:1.5em; color:green;"></i></a>

                    <?php
                    $nivel2 = new Source\Models\Read();
                    $nivel2->ExeRead("genealogy_tree", "WHERE origin = :b AND service = :c", "b={$nivel1->getResult()[0]['name']}&c={$_GET["servico"]}");
                    $nivel2->getResult();

                    if ($nivel2->getResult()) {
                        ?>
                        <ul>

                            <?php foreach ($nivel2->getResult() as $n2) { ?>
                                <li><a href="#" class="<?php
                                    if ($n2["type"] == 2) {
                                        echo "solicitante";
                                    } else {
                                        echo "patriado";
                                    }
                                    ?>"> <?= $n2["name"] ?> 
                                           <?php
                                           if ($n2["smaller"] == 1) {
                                               echo " <b> - Minore</b>";
                                           }
                                           ?></a> 
                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&delete=<?= $nivel2->getResult()[0]['id'] ?>"><i class="fa-solid fa-trash-can" style="font-size:1.5em; color:red;"></i></a>
                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&update=<?= $nivel2->getResult()[0]['id'] ?>"><i class="fa-solid fa-pen" style="font-size:1.5em; color:green;"></i></a>



                                    <?php
                                    $nivel3 = new Source\Models\Read();
                                    $nivel3->ExeRead("genealogy_tree", "WHERE origin = :a AND service = :b", "a={$n2["name"]}&b={$_GET["servico"]}");
                                    $nivel3->getResult();
                                    if ($nivel3->getResult()) {
                                        ?>
                                        <ul>
                                            <?php foreach ($nivel3->getResult() as $n3) { ?>
                                                <li><a href="#" class="<?php
                                                    if ($n3["type"] == 2) {
                                                        echo "solicitante";
                                                    } else {
                                                        echo "patriado";
                                                    }
                                                    ?>"><?= $n3["name"] ?>
                                                           <?php
                                                           if ($n3["smaller"] == 1) {
                                                               echo " <b> - Minore</b>";
                                                           }
                                                           ?>
                                                    </a> 
                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&delete=<?= $nivel3->getResult()[0]['id'] ?>"><i class="fa-solid fa-trash-can" style="font-size:1.5em; color:red;"></i></a>
                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&update=<?= $nivel3->getResult()[0]['id'] ?>"><i class="fa-solid fa-pen" style="font-size:1.5em; color:green;"></i></a>


                                                    <?php
                                                    $nivel4 = new Source\Models\Read();
                                                    $nivel4->ExeRead("genealogy_tree", "WHERE origin = :a AND service = :b", "a={$n3["name"]}&b={$_GET["servico"]}");
                                                    $nivel4->getResult();
                                                    if ($nivel4->getResult()) {
                                                        ?>
                                                        <ul>
                                                            <?php foreach ($nivel4->getResult() as $n4) { ?>
                                                                <li><a href="#" class="<?php
                                                                    if ($n4["type"] == 2) {
                                                                        echo "solicitante";
                                                                    } else {
                                                                        echo "patriado";
                                                                    }
                                                                    ?>"> <?= $n4["name"]; ?> 
                                                                           <?php
                                                                           if ($n4["smaller"] == 1) {
                                                                               echo " <b> - Minore</b>";
                                                                           }
                                                                           ?>
                                                                    </a>  
                                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&delete=<?= $nivel4->getResult()[0]['id'] ?>"><i class="fa-solid fa-trash-can" style="font-size:1.5em; color:red;"></i></a>
                                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&update=<?= $nivel4->getResult()[0]['id'] ?>"><i class="fa-solid fa-pen" style="font-size:1.5em; color:green;"></i></a>

                                                                    <?php
                                                                    $nivel5 = new Source\Models\Read();
                                                                    $nivel5->ExeRead("genealogy_tree", "WHERE origin = :a AND service = :b", "a={$n4["name"]}&b={$_GET["servico"]}");
                                                                    $nivel5->getResult();
                                                                    if ($nivel5->getResult()) {
                                                                        ?>
                                                                        <ul>
                                                                            <?php foreach ($nivel5->getResult() as $n5) { ?>
                                                                                <li><a href="#" class="<?php
                                                                                    if ($n5["type"] == 2) {
                                                                                        echo "solicitante";
                                                                                    } else {
                                                                                        echo "patriado";
                                                                                    }
                                                                                    ?>"><?= $n5["name"] ?>
                                                                                           <?php
                                                                                           if ($n5["smaller"] == 1) {
                                                                                               echo " <b> - Minore</b>";
                                                                                           }
                                                                                           ?>
                                                                                    </a> 
                                                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&delete=<?= $nivel5->getResult()[0]['id'] ?>"><i class="fa-solid fa-trash-can" style="font-size:1.5em; color:red;"></i></a>
                                                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&update=<?= $nivel5->getResult()[0]['id'] ?>"><i class="fa-solid fa-pen" style="font-size:1.5em; color:green;"></i></a>

                                                                                    <?php
                                                                                    $nivel6 = new Source\Models\Read();
                                                                                    $nivel6->ExeRead("genealogy_tree", "WHERE origin = :a AND service = :b", "a={$n5["name"]}&b={$_GET["servico"]}");
                                                                                    $nivel6->getResult();
                                                                                    if ($nivel6->getResult()) {
                                                                                        ?>
                                                                                        <ul>
                                                                                            <?php foreach ($nivel6->getResult() as $n6) { ?>
                                                                                                <li><a href="#" class="<?php
                                                                                                    if ($n6["type"] == 2) {
                                                                                                        echo "solicitante";
                                                                                                    } else {
                                                                                                        echo "patriado";
                                                                                                    }
                                                                                                    ?>"><?= $n6["name"] ?>
                                                                                                           <?php
                                                                                                           if ($n6["smaller"] == 1) {
                                                                                                               echo " <b> - Minore</b>";
                                                                                                           }
                                                                                                           ?>
                                                                                                    </a> 
                                                                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&delete=<?= $nivel6->getResult()[0]['id'] ?>"><i class="fa-solid fa-trash-can" style="font-size:1.5em; color:red;"></i></a>
                                                                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&update=<?= $nivel6->getResult()[0]['id'] ?>"><i class="fa-solid fa-pen" style="font-size:1.5em; color:green;"></i></a>

                                                                                                    <?php
                                                                                                    $nivel7 = new Source\Models\Read();
                                                                                                    $nivel7->ExeRead("genealogy_tree", "WHERE origin = :a AND service = :b", "a={$n6["name"]}&b={$_GET["servico"]}");
                                                                                                    $nivel7->getResult();
                                                                                                    if ($nivel7->getResult()) {
                                                                                                        ?>  
                                                                                                        <ul>
                                                                                                            <?php foreach ($nivel7->getResult() as $n7) { ?>
                                                                                                                <li><a href="#" class="<?php
                                                                                                                    if ($n7["type"] == 2) {
                                                                                                                        echo "solicitante";
                                                                                                                    } else {
                                                                                                                        echo "patriado";
                                                                                                                    }
                                                                                                                    ?>"> <?= $n7["name"] ?>
                                                                                                                           <?php
                                                                                                                           if ($n7["smaller"] == 1) {
                                                                                                                               echo " <b> - Minore</b>";
                                                                                                                           }
                                                                                                                           ?>
                                                                                                                    </a> 
                                                                                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&delete=<?= $nivel7->getResult()[0]['id'] ?>"><i class="fa-solid fa-trash-can" style="font-size:1.5em; color:red;"></i></a>
                                                                                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&update=<?= $nivel7->getResult()[0]['id'] ?>"><i class="fa-solid fa-pen" style="font-size:1.5em; color:green;"></i></a>

                                                                                                                    <?php
                                                                                                                    $nivel8 = new Source\Models\Read();
                                                                                                                    $nivel8->ExeRead("genealogy_tree", "WHERE origin = :a AND service = :b", "a={$n7["name"]}&b={$_GET["servico"]}");
                                                                                                                    $nivel8->getResult();
                                                                                                                    if ($nivel8->getResult()) {
                                                                                                                        ?>  
                                                                                                                        <ul>
                                                                                                                            <?php foreach ($nivel8->getResult() as $n8) { ?>
                                                                                                                                <li><a href="#" class="<?php
                                                                                                                                    if ($n8["type"] == 2) {
                                                                                                                                        echo "solicitante";
                                                                                                                                    } else {
                                                                                                                                        echo "patriado";
                                                                                                                                    }
                                                                                                                                    ?>"> <?= $n8["name"] ?>
                                                                                                                                           <?php
                                                                                                                                           if ($n8["smaller"] == 1) {
                                                                                                                                               echo " <b> - Minore</b>";
                                                                                                                                           }
                                                                                                                                           ?>
                                                                                                                                    </a> 
                                                                                                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&delete=<?= $nivel8->getResult()[0]['id'] ?>"><i class="fa-solid fa-trash-can" style="font-size:1.5em; color:red;"></i></a>
                                                                                                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&update=<?= $nivel8->getResult()[0]['id'] ?>"><i class="fa-solid fa-pen" style="font-size:1.5em; color:green;"></i></a>
                                                                                                                                    </svg></span></a>

                                                                                                                                    <?php
                                                                                                                                    $nivel9 = new Source\Models\Read();
                                                                                                                                    $nivel9->ExeRead("genealogy_tree", "WHERE origin = :a AND service = :b", "a={$n8["name"]}&b={$_GET["servico"]}");
                                                                                                                                    $nivel9->getResult();
                                                                                                                                    if ($nivel9->getResult()) {
                                                                                                                                        ?>  
                                                                                                                                        <ul>
                                                                                                                                            <?php foreach ($nivel9->getResult() as $n9) { ?>
                                                                                                                                                <li><a href="#" class="<?php
                                                                                                                                                    if ($n9["type"] == 2) {
                                                                                                                                                        echo "solicitante";
                                                                                                                                                    } else {
                                                                                                                                                        echo "patriado";
                                                                                                                                                    }
                                                                                                                                                    ?>"> <?= $n9["name"] ?> 
                                                                                                                                                           <?php
                                                                                                                                                           if ($n9["smaller"] == 1) {
                                                                                                                                                               echo " <b> - Minore</b>";
                                                                                                                                                           }
                                                                                                                                                           ?>

                                                                                                                                                    </a> 
                                                                                                                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&delete=<?= $nivel9->getResult()[0]['id'] ?>"><i class="fa-solid fa-trash-can" style="font-size:1.5em; color:red;"></i></a>
                                                                                                                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&update=<?= $nivel9->getResult()[0]['id'] ?>"><i class="fa-solid fa-pen" style="font-size:1.5em; color:green;"></i></a>
                                                                                                                                                    </svg></span></a>

                                                                                                                                                    <?php
                                                                                                                                                    $nivel10 = new Source\Models\Read();
                                                                                                                                                    $nivel10->ExeRead("genealogy_tree", "WHERE origin = :a AND service = :b", "a={$n9["name"]}&b={$_GET["servico"]}");
                                                                                                                                                    $nivel10->getResult();
                                                                                                                                                    if ($nivel10->getResult()) {
                                                                                                                                                        ?>     
                                                                                                                                                        <ul>
                                                                                                                                                            <?php foreach ($nivel10->getResult() as $n10) { ?>
                                                                                                                                                                <li><a href="#"><?= $n10["name"] ?>

                                                                                                                                                                        <?php
                                                                                                                                                                        if ($n10["smaller"] == 1) {
                                                                                                                                                                            echo " <b> - Minore</b>";
                                                                                                                                                                        }
                                                                                                                                                                        ?>

                                                                                                                                                                    </a>

                                                                                                                                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&delete=<?= $nivel10->getResult()[0]['id'] ?>"><i class="fa-solid fa-trash-can" style="font-size:1.5em; color:red;"></i></a>
                                                                                                                                                                    <a href="./index.php?p=arvore&servico=<?= $_GET["servico"] ?>&update=<?= $nivel10->getResult()[0]['id'] ?>"><i class="fa-solid fa-pen" style="font-size:1.5em; color:green;"></i></a>
                                                                                                                                                                    </svg></span></a>
                                                                                                                                                                </li>
                                                                                                                                                            <?php } ?>
                                                                                                                                                        </ul>      


                                                                                                                                                    <?php } ?>
                                                                                                                                                </li>
                                                                                                                                            <?php } ?>
                                                                                                                                        </ul>


                                                                                                                                    <?php } ?>

                                                                                                                                </li>
                                                                                                                            <?php } ?>
                                                                                                                        </ul>


                                                                                                                    <?php } ?>


                                                                                                                </li>  
                                                                                                            <?php } ?>
                                                                                                        </ul>

                                                                                                    <?php } ?>

                                                                                                </li>

                                                                                            <?php } ?>

                                                                                        </ul> 

                                                                                    <?php } ?>



                                                                                </li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    <?php } ?>

                                                                </li>
                                                            <?php } ?>
                                                        </ul>

                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>

                                </li>
                            <?php } ?>



                        </ul>

                        <?php
                    }
                }
                ?>
                <!-- aqui fim vozão master -->
            </li>

        </ul>

    </div>

</div>



</div>



<style>
    /*Now the CSS*/
    * {margin: 0; padding: 0;}

    .tree ul {
        padding-top: 20px; position: relative;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    .patriado{
        background: #fff;
    }

    .solicitante{
        background: #CCC;
    }

    .tree li {
        float: left; text-align: center;
        list-style-type: none;
        position: relative;
        padding: 20px 5px 0 5px;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    /*We will use ::before and ::after to draw the connectors*/

    .tree li::before, .tree li::after{
        content: '';
        position: absolute; top: 0; right: 50%;
        border-top: 1px solid #ccc;
        width: 50%; height: 20px;
    }
    .tree li::after{
        right: auto; left: 50%;
        border-left: 1px solid #ccc;
    }

    /*We need to remove left-right connectors from elements without 
    any siblings*/
    .tree li:only-child::after, .tree li:only-child::before {
        display: none;
    }

    /*Remove space from the top of single children*/
    .tree li:only-child{ padding-top: 0;}

    /*Remove left connector from first child and 
    right connector from last child*/
    .tree li:first-child::before, .tree li:last-child::after{
        border: 0 none;
    }
    /*Adding back the vertical connector to the last nodes*/
    .tree li:last-child::before{
        border-right: 1px solid #ccc;
        border-radius: 0 5px 0 0;
        -webkit-border-radius: 0 5px 0 0;
        -moz-border-radius: 0 5px 0 0;
    }
    .tree li:first-child::after{
        border-radius: 5px 0 0 0;
        -webkit-border-radius: 5px 0 0 0;
        -moz-border-radius: 5px 0 0 0;
    }

    /*Time to add downward connectors from parents*/
    .tree ul ul::before{
        content: '';
        position: absolute; top: 0; left: 50%;
        border-left: 1px solid #ccc;
        width: 0; height: 20px;
    }

    .tree li a{
        border: 1px solid #ccc;
        padding: 5px 10px;
        text-decoration: none;
        color: #666;
        font-family: arial, verdana, tahoma;
        font-size: 0.6em;
        display: inline-block;

        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    /*Time for some hover effects*/
    /*We will apply the hover effect the the lineage of the element also*/
    .tree li a:hover, .tree li a:hover+ul li a {
        background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
    }
    /*Connector styles on hover*/
    .tree li a:hover+ul li::after, 
    .tree li a:hover+ul li::before, 
    .tree li a:hover+ul::before, 
    .tree li a:hover+ul ul::before{
        border-color:  #94a0b4;
    }

    /*Thats all. I hope you enjoyed it.
    Thanks :)*/
</style>


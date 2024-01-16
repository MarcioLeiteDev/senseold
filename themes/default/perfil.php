<?php $v->layout("_theme"); ?>

<header class="container backwhite"> 

    <h1>Cliente </h1>
    
    <?php 
    if(!empty($_SESSION["carrinho"])){
        header("location:./carrinho");
       // echo "eita";
    }
    ?>
    
    
    
      </header>

<?php
session_start();
require '../vendor/autoload.php';

?>

<!doctype html>
<html lang="pt-br">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/7e04532e8d.js" crossorigin="anonymous"></script>

   <script src="https://cdn.tiny.cloud/1/m3hz4cg05xyawh6oij7oqfhs82e3sbhwud17vgxco9lbbg4j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
   
   <script>
      tinymce.init({
        selector: '#mytextarea'
      });
    </script>
    <style>
        .link{
            color:#fff;
            text-decoration: none;
        }
    </style>
        
        <title>Área Administrativa</title>
    </head>


    <body>
        <div class="container-fluid">
            <div class="col-12">
                
                <?php 
                if($_SESSION["nivel"] == 3){
                ?>
                
                <nav class="navbar navbar-expand-lg navbar-dark bg-info">
  <a class="navbar-brand" href="#">
      <img src="../assets/image/logo.jpg" width="150" />
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class ="nav navbar-nav ml-auto">
                            <li class ="nav-item link">
                                <a class ="nav-link" href="index.php"> Home </a>
                            </li>
                            
                
                            
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false" >
                                    Usuários
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="index.php?p=cadastrar-usuario">Cadastrar</a>
                                    <a class="dropdown-item" href="index.php?p=usuarios">Editar</a>

                                </div>
                            </li>
                      

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false" >
                                    Orçamentos
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="index.php?p=criar-orcamento">Cadastrar</a>
                                    <a class="dropdown-item" href="index.php?p=orcamento">Editar</a>

                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false" >
                                    Cliente
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="index.php?p=cadastrar-cliente">Cadastrar</a>
                                    <a class="dropdown-item" href="index.php?p=cliente">Editar</a>

                                </div>
                            </li>


                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false" >
                                    Serviços
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <!--a class="dropdown-item" href="index.php?p=cadastrar-servico">Cadastrar</a-->
                                    <a class="dropdown-item" href="index.php?p=servico">Editar</a>
                                    <a class="dropdown-item" href="index.php?p=cad-servico">Cadastrar</a>

                                </div>
                            </li>
                            
                    

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false" >
                                    Contratos
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="index.php?p=cadastrar-contratos">Contratos</a>
                                 

                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false" >
                                    Financeiro
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="index.php?p=entradas">Entradas</a>
                                    <a class="dropdown-item" href="index.php?p=saidas">Saidas</a>
                                    <!--a class="dropdown-item" href="index.php?p=balanco">Balanco</a-->

                                </div>
                            </li>
                          

                        </ul>
  </div>
</nav>
                

                
                
                <?php } ?>
                
                <?php 
                if($_SESSION["nivel"] == 2 ) {
                ?>
                
                
                
                
                                
                <nav class="navbar navbar-expand-lg navbar-dark bg-info">
  <a class="navbar-brand" href="#">
      <img src="../assets/image/logo.jpg" width="150" />
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
   <ul class ="nav navbar-nav">
                            <li class ="nav-item link">
                                <a class ="nav-link" href="index.php" style="text-decoration:none; color:#fff;"> Home </a>
                            </li>
                            
                
  
                      

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false" style="text-decoration:none; color:#fff;">
                                    Orçamentos
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="index.php?p=criar-orcamento">Cadastrar</a>
                                    <a class="dropdown-item" href="index.php?p=orcamento">Editar</a>

                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false" style="text-decoration:none; color:#fff;">
                                    Cliente
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="index.php?p=cadastrar-cliente">Cadastrar</a>
                                    <a class="dropdown-item" href="index.php?p=cliente">Editar</a>

                                </div>
                            </li>


                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false" style="text-decoration:none; color:#fff;">
                                    Serviços
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <!--a class="dropdown-item" href="index.php?p=cadastrar-servico">Cadastrar</a-->
                                    <a class="dropdown-item" href="index.php?p=servico">Serviços</a>

                                </div>
                            </li>
                            
                    



 
                          

                        </ul>
  </div>
</nav>
                


                
                <?php } ?>
                
                
            </div>
            <div class="col-12">
                <div class="container text-right bg-light p-2">

                    <p>Ola <b> <?= $_SESSION['nome'] ?> </b> você esta logado <a href="sair.php"><button class="btn btn-lg btn-danger">Sair</button></a>  </p>
                </div>
                <div class =”container”>
                    <p> 
                        <?php
                        if (empty($_GET['p'])) {
                            include './inc/home.php';
                        } else {
                            include "./inc/{$_GET['p']}.php";
                        }
                        ?>
                    </P>
                </div>
            </div>
        </div>
        

    </body>


    





    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->


<!--<script type="text/javascript" src="js/jquery.js"></script>-->

<!--<script type="text/javascript" src="js/Chart.min.js"> </script>-->

        <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
        <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
        
        <script src="<?= CONF_URL_BASE ?>/assets/js/jquery.maskMoney.js" ></script>


</html>


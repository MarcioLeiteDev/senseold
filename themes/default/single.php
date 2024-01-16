
<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5ee2605daf41c40012be9344&product=inline-share-buttons" async="async"></script>

<header class="container backwhite"> 

    
    <?php 
    
    $url = $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
     
     $tratar = explode("/", $url);
     
    // var_dump($tratar);
     
     $read = new Source\Models\Read();
     $read->ExeRead("app_post", "WHERE slug = :a", "a={$tratar["2"]}");
     $read->getResult();
    
    ?>
    
    <img src="<?=CONF_URL_BASE ?>/admin/uploads/<?= $read->getResult()[0]["imagem"]?>" alt="<?= $read->getResult()[0]["title"]?>" title="<?= $read->getResult()[0]["title"]?>" width="100%" /> 
    
    <?= $read->getResult()[0]["content"]?>
    
    <h5 class="border-bottom"> Compartilhe nas redes sociais </h5>
<div class="sharethis-inline-share-buttons"></div>
      </header>
      


             
      
   
  
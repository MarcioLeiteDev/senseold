<?php $v->layout("_theme", ["title" => "Confirme e ative sua conta no ".CONF_SITE_NAME." "]); ?>

<h2>Seja bem-vindo(a) ao <?= CONF_SITE_NAME ?> <?= $first_name; ?>.</h2>
<p>Você esta recebendo esse e-mail pois foi cadastrado no site</p>

<p>Acesse a area de usuários usando as credenciais abaixo</p>
<p>Usuario : <?= $email; ?></p>
<p>Senha : <?= $password; ?></p>
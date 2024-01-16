<?php $v->layout("_theme", ["" => ""]); ?>

<h2>Sense Translate</h2>
<h3>Orçamento</h3>
<p>Olá <?= $nome; ?>, conforme combinado segue orçamento</p>
<p><a href="<?= CONF_URL_BASE?>/office/orcamento.php?id=<?= $content; ?>">Clique aqui para baixar em  PDF</a></p>

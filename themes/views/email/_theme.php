<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title><?= $title; ?></title>
    <style>
        body {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            font-family: Helvetica, sans-serif;
        }

        table {
            max-width: 500px;
            padding: 0 10px;
            background: #ffffff;
        }

        .content {
            font-size: 16px;
            margin-bottom: 25px;
            padding-bottom: 5px;
            border-bottom: 1px solid #EEEEEE;
        }

        .content p {
            margin: 25px 0;
        }

        .footer {
            font-size: 14px;
            color: #888888;
            font-style: italic;
        }

        .footer p {
            margin: 0 0 2px 0;
        }
        .dez{ width: 10%; float: left;}
        .quinze{ width: 15%; float: left;}
        .vinte{ width: 20%; float: left;}
        .vintecinco{ width: 25%; float: left;}
        .trinta{ width: 30%; float: left;}
        .trintatres{ width: 33%; float: left;}
        .quarenta{ width: 40%; float: left;}
        .cinquenta{ width: 50%; float: left;}
        
    </style>
</head>
<body>
<table role="presentation" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="content">
                <?= $v->section("content"); ?>
                <p>Atenciosamente, equipe <?= CONF_SITE_NAME; ?>.</p>
            </div>
            <div class="footer">
                <p><?= CONF_SITE_NAME; ?> - <?= CONF_SITE_TITLE; ?></p>
                <p><?= CONF_SITE_ADDR_STREET; ?>
                    , <?= CONF_SITE_ADDR_NUMBER; ?><?= (CONF_SITE_ADDR_COMPLEMENT ? ", " . CONF_SITE_ADDR_COMPLEMENT : ""); ?></p>
                <p><?= CONF_SITE_ADDR_CITY; ?>/<?= CONF_SITE_ADDR_STATE; ?> - <?= CONF_SITE_ADDR_ZIPCODE; ?></p>
            </div>
        </td>
    </tr>
</table>
</body>
</html>

<?php

/**
 * DATABASE
 */

    define("CONF_DB_HOST", "www.sensetranslate.com");
    define("CONF_DB_USER", "senset65_dflix");
    define("CONF_DB_PASS", "dflix7778");
    define("CONF_DB_NAME", "senset65_dflix");


/**
 * PROJECT URLs
 */
define("CONF_URL_BASE", "https://www.localhost/sensetranslate"
        . "");
define("CONF_URL_APP", "https://www.sensetranslate.com/office");
define("CONF_URL_TEST", "https://www.sensetranslate.com");
define("CONF_URL_ADMIN", "/admin");
define("LINK_ASSETS_APP", "https://www.sensetranslate.com/office");

/**
 * SITE
 */
define("CONF_SITE_NAME", "Sense Translate");
define("CONF_SITE_TITLE", "Sense Translate Empresa de Traduções");
define("CONF_SITE_DESC",
        "Sense Translate empresa de traduções,traduções nas linguas Português, Inglês, Espanhol, Italiano, Francês, Alemão, Japonês e Chinês.consulte-nos  ");
define("CONF_SITE_LANG", "pt_BR");
define("CONF_SITE_DOMAIN", "sensetranslate.com.br");
define("CONF_SITE_ADDR_STREET", "Rua Fernado Falcão");
define("CONF_SITE_ADDR_NUMBER", "1219");
define("CONF_SITE_ADDR_COMPLEMENT", "");
define("CONF_SITE_ADDR_CITY", "São Paulo");
define("CONF_SITE_ADDR_STATE", "SP");
define("CONF_SITE_ADDR_ZIPCODE", "03180-003");
define("CONF_SITE_ADDR_TELEFONE", "(11) 9 5059-0525");



/**
 * DATES
 */
define("CONF_DATE_BR", "d/m/Y H:i:s");
define("CONF_DATE_APP", "Y-m-d H:i:s");

/**
 * PASSWORD
 */
define("CONF_PASSWD_MIN_LEN", 8);
define("CONF_PASSWD_MAX_LEN", 40);
define("CONF_PASSWD_ALGO", PASSWORD_DEFAULT);
define("CONF_PASSWD_OPTION", ["cost" => 10]);

/**
 * VIEW
 */
define("CONF_VIEW_PATH", __DIR__ . "/../../shared/views");
define("CONF_VIEW_EXT", "php");
define("CONF_VIEW_THEME", "default");
define("CONF_VIEW_APP", "http://www.sensetranslate.com/themes/admin");
//define("CONF_VIEW_APP", "cafeapp");

/**
 * UPLOAD
 */
define("CONF_UPLOAD_DIR", "storage");
define("CONF_UPLOAD_IMAGE_DIR", "images");
define("CONF_UPLOAD_FILE_DIR", "files");
define("CONF_UPLOAD_MEDIA_DIR", "medias");

/**
 * IMAGES
 */
define("CONF_IMAGE_CACHE", CONF_UPLOAD_DIR . "/" . CONF_UPLOAD_IMAGE_DIR . "/cache");
define("CONF_IMAGE_SIZE", 2000);
define("CONF_IMAGE_QUALITY", ["jpg" => 75, "png" => 5]);

/**
 * MAIL
 */
define("CONF_MAIL_HOST", "mail.sensetranslate.com");
define("CONF_MAIL_PORT", "587");
define("CONF_MAIL_USER", "send@sensetranslate.com");
define("CONF_MAIL_PASS", "dflix7778");
define("CONF_MAIL_SENDER", ["name" => "Sense Translate", "address" => "send@sensetranslate.com"]);
define("CONF_MAIL_SUPPORT", "contato@sensetranslate.com");
define("CONF_MAIL_OPTION_LANG", "br");
define("CONF_MAIL_OPTION_HTML", true);
define("CONF_MAIL_OPTION_AUTH", true);
define("CONF_MAIL_OPTION_SECURE", "tls");
define("CONF_MAIL_OPTION_CHARSET", "utf-8");

/**
 * PAGAR.ME
 */
define("CONF_PAGARME_MODE", "test");
define("CONF_PAGARME_LIVE", "ak_live_7wFTUfIRHFUuG0LDYI2VZ9BkeQ6XrR");
define("CONF_PAGARME_TEST", "ak_test_7wFTUfIRHFUuG0LDYI2VZ9BkeQ6XrR");
define("CONF_PAGARME_BACK", CONF_URL_BASE) . "/pay/callback";




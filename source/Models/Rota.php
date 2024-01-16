<?php

namespace Source\Models;

class Rota {

    private $url;

    public function __construct() {

        $url = $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];


        $this->url = $url;

        $this->includes();
    }

    public function includes() {
        //home
        $verurl = explode("/", $this->url);
        if ($verurl['0'] == "www.localhost") {
            $var = $verurl["2"];
            if (!empty($verurl["3"])) {
                $var2 = $verurl["3"];
            }
        } else {
            $var = $verurl["1"];
            if (!empty($verurl["2"])) {
                $var2 = $verurl["2"];
            }
        }



        if (!empty($_GET["acao"])) {
            $acao = $_GET["acao"];
        } else {
            $acao = null;
        }

        if (!empty($_GET["id"])) {
            $param = $_GET["id"];
        } else {
            $param = null;
        }

        if (empty($var)) {

            include'./themes/default/home.php';
        } else {

            if ($var == "produtos" && !empty($var2)) {

                include'./themes/default/single-products.php';
            } else {

                if ($var == "sair") {

                    include'./themes/default/sair.php';
                } else {


                    if ($var == "pedidos") {

                        include'./themes/default/pedidos.php';
                    } else {

                        if ($var == "pagamento") {

                            include'./themes/default/payment.php';
                        } else {

                            if ($var == "blog") {

                                include'./themes/default/blog.php';
                            } else {




                                if ($var == "entrar") {

                                    include'./themes/default/login.php';
                                } else {

                                    if ($var == "cadastrar") {

                                        include'./themes/default/register.php';
                                    } else {

                                        if ($var == "recuperar-senha&email={$_GET["email"]}&token={$_GET["token"]}") {

                                            include'./themes/default/repass.php';
                                        } else {

                                            if ($var == "esqueceu-senha") {

                                                include'./themes/default/forget.php';
                                            } else {

                                                if ($var == "produtos") {

                                                    include'./themes/default/products.php';
                                                } else {

                                                    if ($var == "produtos") {

                                                        include'./themes/default/products.php';
                                                    } else {

                                                        if ($var == "carrinho") {

                                                            include'./themes/default/card.php';
                                                        } else {


                                                            if ($var == "carrinho&acao={$acao}") {

                                                                include'./themes/default/card.php';
                                                            } else {


                                                                if ($var == "carrinho&acao={$acao}&id={$param}") {

                                                                    include'./themes/default/card.php';
                                                                } else {

                                                                    if ($var == "pagamento") {

                                                                        include'./themes/default/payment.php';
                                                                    } else {





                                                                        if ($var) {

                                                                            include'./themes/default/single.php';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

}

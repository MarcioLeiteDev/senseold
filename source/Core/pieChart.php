<?php

namespace Source\Core;

class pieChart {

    public function __construct() {
        
    }



    public function aluguel() {

        $agora = date("m-Y");
        $mparam = date("m");
        $aparam = date("Y");

        if ($_SESSION['carteira'] == "geral") {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND categoria_id = :cat ",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&cat=6");
        } else {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND carteira_id = :c AND categoria_id = :cat",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&c={$_SESSION['carteira']}&cat=6");
        }
        $read->getResult();
        $agora = 0;
        foreach ($read->getResult() as $value) {
            $agora += $value['valor'];
        }

        return number_format($agora / 100, 2, ".", "");
    }

    public function alimentacao() {

        $agora = date("m-Y");
        $mparam = date("m");
        $aparam = date("Y");

        if ($_SESSION['carteira'] == "geral") {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND categoria_id = :cat ",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&cat=5");
        } else {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND carteira_id = :c AND categoria_id = :cat",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&c={$_SESSION['carteira']}&cat=5");
        }
        $read->getResult();
        $agora = 0;
        foreach ($read->getResult() as $value) {
            $agora += $value['valor'];
        }

        return number_format($agora / 100, 2, ".", "");
    }
    
    public function compras() {

        $agora = date("m-Y");
        $mparam = date("m");
        $aparam = date("Y");

        if ($_SESSION['carteira'] == "geral") {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND categoria_id = :cat ",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&cat=7");
        } else {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND carteira_id = :c AND categoria_id = :cat",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&c={$_SESSION['carteira']}&cat=7");
        }
        $read->getResult();
        $agora = 0;
        foreach ($read->getResult() as $value) {
            $agora += $value['valor'];
        }

        return number_format($agora / 100, 2, ".", "");
    }
    
    
    public function educacao() {

        $agora = date("m-Y");
        $mparam = date("m");
        $aparam = date("Y");

        if ($_SESSION['carteira'] == "geral") {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND categoria_id = :cat ",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&cat=8");
        } else {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND carteira_id = :c AND categoria_id = :cat",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&c={$_SESSION['carteira']}&cat=8");
        }
        $read->getResult();
        $agora = 0;
        foreach ($read->getResult() as $value) {
            $agora += $value['valor'];
        }

        return number_format($agora / 100, 2, ".", "");
    }
    
    
    public function entretenimento() {

        $agora = date("m-Y");
        $mparam = date("m");
        $aparam = date("Y");

        if ($_SESSION['carteira'] == "geral") {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND categoria_id = :cat ",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&cat=9");
        } else {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND carteira_id = :c AND categoria_id = :cat",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&c={$_SESSION['carteira']}&cat=9");
        }
        $read->getResult();
        $agora = 0;
        foreach ($read->getResult() as $value) {
            $agora += $value['valor'];
        }

        return number_format($agora / 100, 2, ".", "");
    }
    
    
    public function impostos() {

        $agora = date("m-Y");
        $mparam = date("m");
        $aparam = date("Y");

        if ($_SESSION['carteira'] == "geral") {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND categoria_id = :cat ",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&cat=10");
        } else {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND carteira_id = :c AND categoria_id = :cat",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&c={$_SESSION['carteira']}&cat=10");
        }
        $read->getResult();
        $agora = 0;
        foreach ($read->getResult() as $value) {
            $agora += $value['valor'];
        }

        return number_format($agora / 100, 2, ".", "");
    }
    
    
    public function outros() {

        $agora = date("m-Y");
        $mparam = date("m");
        $aparam = date("Y");

        if ($_SESSION['carteira'] == "geral") {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND categoria_id = :cat ",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&cat=14");
        } else {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND carteira_id = :c AND categoria_id = :cat",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&c={$_SESSION['carteira']}&cat=14");
        }
        $read->getResult();
        $agora = 0;
        foreach ($read->getResult() as $value) {
            $agora += $value['valor'];
        }

        return number_format($agora / 100, 2, ".", "");
    }
    
    
    public function saude() {

        $agora = date("m-Y");
        $mparam = date("m");
        $aparam = date("Y");

        if ($_SESSION['carteira'] == "geral") {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND categoria_id = :cat ",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&cat=11");
        } else {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND carteira_id = :c AND categoria_id = :cat",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&c={$_SESSION['carteira']}&cat=11");
        }
        $read->getResult();
        $agora = 0;
        foreach ($read->getResult() as $value) {
            $agora += $value['valor'];
        }

        return number_format($agora / 100, 2, ".", "");
    }
    
    
    public function viagens() {

        $agora = date("m-Y");
        $mparam = date("m");
        $aparam = date("Y");

        if ($_SESSION['carteira'] == "geral") {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND categoria_id = :cat ",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&cat=13");
        } else {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND carteira_id = :c AND categoria_id = :cat",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&c={$_SESSION['carteira']}&cat=13");
        }
        $read->getResult();
        $agora = 0;
        foreach ($read->getResult() as $value) {
            $agora += $value['valor'];
        }

        return number_format($agora / 100, 2, ".", "");
    }
    
    public function combustivel() {

        $agora = date("m-Y");
        $mparam = date("m");
        $aparam = date("Y");

        if ($_SESSION['carteira'] == "geral") {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND categoria_id = :cat ",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&cat=16");
        } else {
            $read = new \Source\Models\Read();
            $read->ExeRead("app_faturas", "WHERE user_id = :id AND status = :s AND MONTH(vencimento_em) = :m AND YEAR(vencimento_em) = :y AND modo = :v AND carteira_id = :c AND categoria_id = :cat",
                    "id={$_SESSION['user_id']}&s=paid&m={$mparam}&y={$aparam}&v=saida&c={$_SESSION['carteira']}&cat=16");
        }
        $read->getResult();
        $agora = 0;
        foreach ($read->getResult() as $value) {
            $agora += $value['valor'];
        }

        return number_format($agora / 100, 2, ".", "");
    }

}

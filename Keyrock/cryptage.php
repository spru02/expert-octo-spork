<?php

    function iv(){

        $iv = openssl_random_pseudo_bytes(16);
        return base64_encode($iv);
    }

    function encrypt($key, $password, $iv){

        $iv = base64_decode($iv);
        $lenght = 16 - strlen($password) % 16;
        $password = $password . str_repeat(chr($lenght),$lenght);
        $password = openssl_encrypt($password, "AES-256-CBC", $key, 0, $iv);
        return base64_encode($password);

    }

    function decrypt($key, $password, $iv){

        $iv = base64_decode($iv);
        $password = base64_decode($password);
        $password = openssl_decrypt($password, "AES-256-CBC", $key, 0, $iv);
        return @substr($password, 0, -ord($password(strlen($password) - 1)));

    }

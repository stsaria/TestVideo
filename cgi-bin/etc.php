<?php
    function redirectBackPage(){
        if (isset($_SERVER['HTTP_REFERER'])){
            header("Location: ".$_SERVER['HTTP_REFERER']);
        }
        exit;
    }
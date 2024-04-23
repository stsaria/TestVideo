<?php
    include "../cgi-bin/videoPost.php";
    include "../cgi-bin/etc.php";

    if(!(!empty($_FILES) && isset($_POST["upload_title"]) && isset($_POST["upload_description"]))){echo "Error : args error"; exit;}
    $title = htmlspecialchars($_POST["upload_title"]);
    $description = htmlspecialchars($_POST["upload_description"], ENT_QUOTES, 'UTF-8');

    postVideo($title, $description, $_FILES['upload_video']);
    redirectBackPage();
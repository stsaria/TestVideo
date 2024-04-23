<?php
    include "../cgi-bin/comment.php";

    $commentFile = "../comments/".$_GET['videoId'].".csv";

    if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['name']) && isset($_GET['videoId'])){
        writeData($commentFile);
        header("Location: watch.php?videoId=".$_GET['videoId']);
    } else {
        readData($commentFile);
    }
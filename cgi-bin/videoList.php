<?php
    $rows = [];
    $all = false;
    if (isset($_GET["all"])){if ($_GET["all"] == "true"){$all = true;}}
    $fp = fopen("../videos/videos.csv", 'rb');
    if ($fp){
        if (flock($fp, LOCK_SH)){
            while ($row = fgetcsv($fp)) {
                $rows[] = $row;
            }
            if ($rows && $all == false){if (count($rows) >= 30){$rows = array_slice($rows, -30);}}
            $rows = array_reverse($rows);
            foreach ($rows as $row){
                $link = "watch.php?videoId=".$row[0];
                echo "<li style=\"margin-right: 100px;\">".$row[2]."|ID:".$row[3]."</br><a href=".$link.">".$row[1];
                if(!file_exists("videos/hls/".$row[0].".m3u8")){echo "(処理中)";}
                echo "</a></li>";
            }
            flock($fp, LOCK_UN);
        } else {
            echo '<script>alert("File lock failed.");</script>';
        }
    }
    fclose($fp);
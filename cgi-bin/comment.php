<?php
    date_default_timezone_set('Asia/Tokyo');
    function readData($commentFile){
        $num_response = 0;
        $rows = [];
        $data = '';
        $fp = fopen($commentFile, 'rb');
        if ($fp){
            if (flock($fp, LOCK_SH)){
                while ($row = fgetcsv($fp)) {
                    $rows[] = $row;
                }
                if (!empty($rows)): ?>
                    <ol>
                <?php foreach ($rows as $row): ?>
                    <?php $num_response++ ?>
                    <strong><li id="<?=$num_response?>"><?=$row[0]?></strong> ID:<?=$row[3]?> <?=$row[2]?></br>
                    <?=$row[1]?></li>
                <?php endforeach; ?>
                    </ol>
                <?php else: ?>
                    
                <?php endif; ?>
                <?php
                flock($fp, LOCK_UN);
            }else{
                echo '<script>alert("File lock failed.");</script>';
                exit;
            }
        }
        fclose($fp);
        return $data;
    }
    function writeData($commentFile){
        $num_response = 0;
        $name = htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8');
        if ($name === "Anonymous"){$name = "Anonymous@Fake";}
        else if ($name === ""){$name = "Anonymous";}
        $contents = nl2br(htmlspecialchars($_GET['contents'], ENT_QUOTES, 'UTF-8'));
        $contents = str_replace("<br>", "", $contents);
        if ($contents == ""){return;}
        else if (count(explode("/",$contents)) > 5){return;}
        if (strlen($contents) >= 4){
            if ($contents[0].$contents[1].$contents[2] == "///" && is_numeric($contents[3])){
                $resnum = "";
                $a_contents = "<a href=#reSnuM>///".$contents[3];
                $resnum = $contents[3];
                if (is_numeric($contents[4])){$a_contents = $a_contents.$contents[4]; $resnum = $resnum.$contents[4];}
                if (is_numeric($contents[5])){$a_contents = $a_contents.$contents[5]; $resnum = $resnum.$contents[5];}
                $a_contents = $a_contents."</a>".str_replace("///".$resnum, '', $contents);
                $contents = str_replace("reSnuM", $resnum, $a_contents);
            }
        }
        $fp = fopen($commentFile, 'rb');
        if ($fp){
            if (flock($fp, LOCK_SH)){
                while ($row = fgetcsv($fp)){
                    $rows[] = $row;
                }
                if (!empty($rows)): ?>
                    <ul>
                <?php foreach ($rows as $row): ?>
                    <?php $num_response++ ?>
                <?php endforeach; ?>
                    
                <?php else: ?>
                    
                <?php endif; ?>
                <?php
                flock($fp, LOCK_UN);
            }else{
                echo '<script>alert("File lock failed.");</script>';
                exit;
            }
        } else {exit;}
        if($num_response >= 200){
            echo '<script>alert("Response > 200");</script>';
            exit;
        }
        
        $fp = fopen($commentFile, 'a');
        if ($fp){
            if (flock($fp, LOCK_EX)){
                if (fputcsv($fp, [$name, $contents, date("Y/m/d H:i"), hash("fnv1a32", $_SERVER['REMOTE_ADDR'])]) === FALSE){
                    echo '<script>alert("File write failed.");</script>';
                    exit;
                }
                flock($fp, LOCK_UN);
            }else{
                echo '<script>alert("File lock failed.");</script>';
                exit;
            }
        } else {exit;}
        fclose($fp);
    }
?>
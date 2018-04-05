<?php

    require_once('inc/config.php');

    $id = $db->real_escape_string($_GET['id']);
    $uid = $db->real_escape_string($_GET['uid']);

    if(!isset($id)){
        echo "1: raum mit 2 st&uuml;hlen<br>";
        echo "2: raum mit einem cola automaten<br>";
        echo "vergiss bitte nicht die userid einzugeben!(?uid)";
    }else{
        $code = rand(100,500).rand(500,1000);
        switch($id){
            case 1:
                $db->query("INSERT INTO `rooms` (`id`, `caption`, `owner`, `description`, `category`, `model_name`) VALUES ('', '$code', '0', 'Dein Raum im Bubbo Hotel =)', '29', 'model_e')");
                $qry = $db->query("SELECT id FROM rooms WHERE caption = '$code'")->fetch_object();
                $id = $id->id;
                
                $db->query("INSERT INTO `items` (`id`, `user_id`, `room_id`, `base_item`, `x`, `y`) VALUES ('', '0', '$id', '5', '9', '8')");
                $db->query("INSERT INTO `items` (`id`, `user_id`, `room_id`, `base_item`, `x`, `y`) VALUES ('', '0', '$id', '5', '9', '7')");
                $db->query("UPDATE rooms SET caption = 'Mein Startraum', owner = '$uid' WHERE caption = '$code'");
                $db->query("UPDATE items SET user_id = '$uid' WHERE room_id = '$id'");
            break;
            case 2:

            break;
        }
        echo 'Raum erstellt!';
        exit();
    }

?>
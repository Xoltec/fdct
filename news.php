<?php

    require 'global.php';
    
    if(!checkSession()){
        header('Location: index.php');   
    }
	
    if(isset($_GET['id'])){
        $id = secure($_GET['id']); 

        if(isset($_POST['like'])){
            $checkuser = $db->query('SELECT * FROM cms_news_voting WHERE username="'.secure($userData->username).'" AND article="'.$id.'"')->num_rows;

            if($checkuser == '1'){
                $tpl->assign('error', 'Du hast bereits gevotet!');
            }else{
                $db->query('INSERT INTO cms_news_voting (`username`, `choice`, `article`) VALUES ("'.secure($userData->username).'", "Like", "'.$id.'")');
                $tpl->assign('error', 'Du hast erfolgreich gevotet!');
            }
        }

        if(isset($_POST['dislike'])){
            $checkuser = $db->query('SELECT * FROM cms_news_voting WHERE username="'.secure($userData->username).'" AND article="'.$id.'"')->num_rows;

            if($checkuser == '1'){
                $tpl->assign('error', 'Du hast bereits gevotet!');
            }else{
                $db->query('INSERT INTO cms_news_voting (`username`, `choice`, `article`) VALUES ("'.secure($userData->username).'", "Dislike", "'.$id.'")');
                $tpl->assign('error', 'Du hast erfolgreich gevotet!');
            }
        }

        if(isset($_POST['com_send'])){
            if(empty($_POST['com_text'])){
                $tpl->assign('error', 'Bitte fülle alle Felder aus!');
            }else{
                if(strlen($_POST['com_text']) < 5){
                    $tpl->assign('error', 'Du hast zu wenig Zeichen eingegeben!');
                }else{
                    $check = $db->query('SELECT username FROM cms_news_comments WHERE article="'.$id.'" ORDER BY id DESC LIMIT 1')->fetch_array();
                    
                    if($check['username'] !== $userData->username){
                        $db->query("INSERT INTO `cms_news_comments` (`username`, `text`, `date`, `article`) VALUES ('".secure($userData->username)."','".secure($_POST['com_text'])."','".time()."','".$id."')");
                        $tpl->assign('error', 'Du hast den Kommentar erfolgreich abgeschickt!');
                    }else{
                        $tpl->assign('error', 'Du kannst erst wieder einen Kommentar schreiben, wenn ein anderer einen schreibt!');
                    }  
                }
            }
        }
    }else{
        header('Location: 404.php');
    }

    $tpl->assign('page', 'news');
    $tpl->display('news.tpl');

?>
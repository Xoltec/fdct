<?php

    require_once('global.php');
    
    if(checkSession()){
        header('Location: fdct-overview');   
    }

    if(isset($_POST['login'])){
        
        $result = $db->query('SELECT * FROM users WHERE username = "'.secure($_POST['username']).'" AND password = "'.secure(hashPassword($_POST['password'])).'"');
        $checkBann = $db->query('SELECT * FROM bans WHERE value = "'.secure($_POST['username']).'" AND bantype = "user" OR value = "'.$_SERVER['REMOTE_ADDR'].'" AND bantype = "ip" LIMIT 1');
        $getBann = $checkBann->fetch_object();
        
        if(empty($_POST['username']) || empty($_POST['password'])){
            
			$tpl->assign('log_err', 'Bitte fülle alle Felder aus!');
            
		}else{
            
            if($checkBann->num_rows >= 1){
                
                if($getBann->expire < time() && $result->num_rows > 0){
					$_SESSION['b_username'] = secure(strtolower($_POST['username']));
                    $_SESSION['b_password'] = secure(hashPassword($_POST['password']));
                    $db->query('UPDATE users SET ip_last = "'.$_SERVER['REMOTE_ADDR'].'", online = "1", disconnect = "0" WHERE username = "'.secure($_POST['username']).'" AND password = "'.secure(hashPassword($_POST['password'])).'"');
                    header('Location: me.php');
                    
				}else{
                    
					$tpl->assign('log_err', 'Du bist bis zum '.date("d.m.Y H:s", $getBann->expire).' gesperrt! Grund: '.$getBann->reason);
                    
				}
                
            }else{
                
                if($result->num_rows > 0){
                    $_SESSION['b_username'] = secure(strtolower($_POST['username']));
                    $_SESSION['b_password'] = secure(hashPassword($_POST['password']));
                    $db->query('UPDATE users SET ip_last = "'.$_SERVER['REMOTE_ADDR'].'", online = "1", disconnect = "0" WHERE username = "'.secure($_POST['username']).'" AND password = "'.secure(hashPassword($_POST['password'])).'"');
                    header('Location: fdct-overview');
                    
                }else{
                    
                    $tpl->assign('log_err', 'Deine Daten stimmen nicht mit denen aus der Datenbank überein!');
                    
                }
            }
		}   
    }

    $tpl->display('index.tpl');

?>

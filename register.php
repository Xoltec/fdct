<?php

    require_once('global.php');
    
    if(checkSession()){
        header('Location: me.php');   
    }

    if(isset($_POST['register'])){
        
		if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password_re']) || empty($_POST['email']) || empty($_POST['fullname'])){
			$tpl->assign('reg_err', 'Bitte fülle alle Felder aus!');
		}else{
			if(strlen($_POST['username']) < 2){
				$tpl->assign('reg_err', 'Dieser Username ist zu kurz. Verwende einen Usernamen mit mindestens 3 Zeichen!');
			}else{
				if(substr($_POST['username'], 0, 4) == 'MOD-'){
					$tpl->assign('reg_err', 'Usernamen mit "MOD-" am Anfang sind unzulässig.');
				}else{
					if(preg_match('/[^a-z\d\-=\?!@:\.]/i', $_POST['username'])){
						$tpl->assign('reg_err', 'Bitte wähle einen zulässigen Usernamen!');
					}else{
						if(strlen($_POST['password']) < 8){
							$tpl->assign('reg_err', 'Dieses Passwort ist zu kurz. Dein Passwort muss mindestens 8 Zeichen lang sein!');
						}else{
							$user_check = $db->query("SELECT id FROM users WHERE username = '".secure($_POST['username'])."' LIMIT 1");		
								
							if($user_check->num_rows == 1){
								$tpl->assign('reg_err', 'Der Username ist bereits vergeben!');
							}else{
								if($_POST['password_re'] !== $_POST['password']){
								    $tpl->assign('reg_err', 'Die beiden Passwörter stimmen nicht überein!');
								}else{
								    $email_check = $db->query("SELECT mail FROM users WHERE mail = '".secure($_POST['email'])."' LIMIT 1");
											
								    if($email_check->num_rows == 1){
								        $tpl->assign('reg_err', 'Diese E-Mail ist bereits in Benutzung!');
								    }else{
								        if(preg_match('/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i', $_POST['email'])){
								            $db->query('INSERT INTO users (`username`, `password`, `mail`, `fullname`, `auth_ticket`, `rank`, `credits`, `vip_points`, `activity_points`, `look`, `motto`, `account_created`, `last_online`, `online`, `ip_last`, `ip_reg`, `vip`) VALUES ("'.secure($_POST['username']).'", "'.secure(hashPassword($_POST['password'])).'", "'.secure($_POST['email']).'","'.secure($_POST['fullname']).'", "-/-", "1", "'.secure($register['credits']).'", "'.secure($register['duckets']).'", "'.secure($register['pixels']).'", "'.secure($register['look']).'", "'.secure($register['motto']).'", "'.secure(time()).'", "'.secure(time()).'", "1", "'.secure($_SERVER['REMOTE_ADDR']).'", "'.secure($_SERVER['REMOTE_ADDR']).'", "'.secure($register['vip']).'")') or die('Fehler: '.$db->error);
								            $_SESSION['b_username'] = secure($_POST['username']);
								            $_SESSION['b_password'] = secure(hashPassword($_POST['password']));
								            header('Location: fdct-overview');
								        }else{
								            $tpl->assign('reg_err', 'Bitte geben Sie eine gültige E-Mail Adresse an!');
								        }
								    }
								}
							}
						}
					}
				}
			}
		}
	}

    $tpl->display('register.tpl');

?>

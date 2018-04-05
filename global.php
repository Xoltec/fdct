<?php

    error_reporting(E_ALL);

    session_start();

    require_once('inc/config.php');
    require_once('smarty/libs/Smarty.class.php');

    // header
    header('Content-Type: text/html; charset=utf-8');

    // utf-8
    $db->query('SET NAMES "utf-8"');

    // db
    $Settings = $db->query('SELECT * FROM cms_configuration')->fetch_object();
    $Server = $db->query('SELECT * FROM server_status')->fetch_object();
    $Newest = $db->query('SELECT id FROM cms_news ORDER BY id DESC LIMIT 1')->fetch_object();

    // smarty
    $tpl = new Smarty();

    $tpl->template_dir = 'smarty/templates/';
    $tpl->compile_dir = 'smarty/templates_c/';
    $tpl->cache_dir = 'smarty/cache/';
    $tpl->config_dir = 'smarty/configs/';

    $tpl->assign('sitename', $Settings->sitename);
    $tpl->assign('sitepath', $Settings->sitepath);
    $tpl->assign('acp', $Settings->acp);

    $tpl->assign('users_on', $Server->users_online);

    $tpl->assign('newestnews', 'news.php?id='.$Newest->id.'');

    // user data
    if(isset($_SESSION['b_username']) && isset($_SESSION['b_password'])){
        $userData = $db->query('SELECT * FROM users WHERE username="'.$_SESSION['b_username'].'"')->fetch_object();
        
        $tpl->assign('id', $userData->id);
        $tpl->assign('user', $userData->username);
        $tpl->assign('name', $userData->fullname);
        $tpl->assign('mail', $userData->mail);
        $tpl->assign('rank', $userData->rank);
        $tpl->assign('auth_ticket', $userData->auth_ticket);
        $tpl->assign('credits', $userData->credits);
        $tpl->assign('pixels', $userData->activity_points);
        $tpl->assign('duckets', $userData->vip_points);
        $tpl->assign('motto', $userData->motto);
        $tpl->assign('avatar', 'http://www.habbo.nl/habbo-imaging/avatarimage?figure='.$userData->look);
    }

    // register 
    $register = array(
        'credits' => '0',    // Anfangstaler eintragen  
        'pixels' => '0',      // Anfangspixel eintragen
        'duckets' => '0',      // Anfangsduckets eintragen
        'motto' => 'Herzlich Willkommen im '.$Settings->sitename.'-Hotel',      // Anfangsmotto eintragen
        'look' => 'hr-115-42.hd-190-1.ch-215-62.lg-285-91.sh-290-62',       // Anfangslook eintragen
        'vip' => '0'        // Sollen die User bei der Registrierung VIP bekommen? - 0 = Nein; 1 = Ja
    );

    // function
    function secure($var){
        global $db;
        return $db->real_escape_string($var);
    }

    function hashPassword($var){
        $salt = '$%hgy5djk3tgbG^bhk';
        return sha1(sha1(sha1(sha1($var))).$salt);
    }

    function checkSession(){
        if(isset($_SESSION['b_username']) && isset($_SESSION['b_password'])){
            return true;    
        }else{
            return false;   
        }
    }

?>

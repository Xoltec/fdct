<?php

    require_once('global.php');
    
    if(!checkSession()){
        header('Location: index.php');   
    }

    $tpl->assign('page', 'staff');
    $tpl->display('staff.tpl');

?>
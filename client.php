<?php
mysql_connect("5.1.80.219","root","benlaxxr");
mysql_select_db("habbo");
$id = $_GET['id'];
$sso = $_GET['sso'];
mysql_query("UPDATE `users` SET `auth_ticket`='$sso' WHERE (`id`='$id')");
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Bubbo Beta Client</title>
<link rel="stylesheet" type="text/css" href="http://beta.bubbo.ws/hotel3553/web-img/css/hotel.css">
<script type="text/javascript" src="http://beta.bubbo.ws/hotel3553/web-img/js/jquery.js"></script>
<script type="text/javascript" src="http://beta.bubbo.ws/hotel3553/web-img/js/swfobject.js"></script>
<script type="text/javascript">
        var flashvars = {
            "avatareditor.promohabbos": "https://www.habbo.com/api/public/lists/hotlooks",
            "flash.client.origin": "popup",
            "client.notify.cross.domain": "1",
            "connection.info.host": "5.1.80.219",
            "connection.info.port": "30000",
            "site.url": "{{global_url}}",
            "url.prefix": "{{global_url}}",
            "client.reload.url": "{{global_url}}{{client_name}}",
            "client.fatal.error.url": "{{global_url}}/client/",
            "client.connection.failed.url": "{{global_url}}/client/",
            "logout.url": "{{global_url}}{{client_name}}",
            "logout.disconnect.url": "{{global_url}}{{client_name}}",
            "external.variables.txt" : "http://beta.bubbo.ws/swfs/gamedata/external_variables.txt", 
            "external.texts.txt" : "http://beta.bubbo.ws/swfs/gamedata/external_flash_texts.txt", 
            "external.figurepartlist.txt" : "http://beta.bubbo.ws/swfs/gamedata/figuredata.xml", 
            "external.override.texts.txt" : "http://beta.bubbo.ws/swfs/gamedata/override/external_flash_override_texts.txt", 
            "external.override.variables.txt" : "http://beta.bubbo.ws/swfs/gamedata/override/external_override_variables.txt", 
            "productdata.load.url" : "http://beta.bubbo.ws/swfs/gamedata/productdata.txt", 
            "furnidata.load.url" : "http://beta.bubbo.ws/swfs/gamedata/furnidata.xml", 
            "sso.ticket": "<?=$sso;?>",
            "account_id": "1",
            "client.allow.cross.domain": "1",
            "unique_habbo_id": "1",
            "flash.client.url": "http://beta.bubbo.ws/swfs/gordon/PRODUCTION-201601012205-226667486/",
            "user.hash": "1337",
            "supersonic_custom_css": "http://beta.bubbo.ws/hotel3553/web-img/css/sonic.css",
            "client.starting": "Bitte warten! Bubbo Beta wird geladen...",
            "supersonic_application_key": "2abb40ad",
            "has.identity": "1",
            "spaweb": "1",
        };
    </script>
<script type="text/javascript" src="http://beta.bubbo.ws/hotel3553/web-img/js/habboapinew.js"></script>
<script type="text/javascript">
        var params = {
            "base": "http://beta.bubbo.ws/swfs/gordon/PRODUCTION-201601012205-226667486/",
            "allowScriptAccess": "always",
            "menu": "false",
            "wmode": "opaque"
        };
        swfobject.embedSWF('http://beta.bubbo.ws/swfs/gordon/PRODUCTION-201601012205-226667486/Habbo.swf', 'flash-container', '100%', '100%', '11.1.0', '/web-img/swf/expressInstall.swf', flashvars, params, null, null);
    </script>
</head>
<body>
<div id="client-ui">
<div id="flash-wrapper">
<div id="flash-container">
<div id="content" style="width: 400px; margin: 20px auto 0 auto; display: none">
<p>FLASH NOT INSTALLED</p>
<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://beta.bubbo.ws/hotel3553/web-img/habbo-web/stuff/get_flash_player.png" alt="Get Adobe Flash player"/></a></p>
</div>
</div>
</div>
<div id="content" class="client-content"></div>
<iframe id="page-content" class="hidden" allowtransparency="true" frameBorder="0" src="about:blank"></iframe>
</div>
</body>
</html>
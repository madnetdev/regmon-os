<?php
$PATH_2_ROOT = '../';
require_once($PATH_2_ROOT.'_settings.regmon.php');

setcookie ("USERNAME", '', time()-3600, '/'.$CONFIG['REGmon_Folder']);
//setcookie ("LANG", '', time()-3600, '/'.$CONFIG['REGmon_Folder']); // we keep the LANG
setcookie ("HASH", '', time()-3600, '/'.$CONFIG['REGmon_Folder']);
setcookie ("ATHLETE", '', time()-3600, '/'.$CONFIG['REGmon_Folder']);
setcookie ("UID", '', time()-3600, '/'.$CONFIG['REGmon_Folder']);
setcookie ("ACCOUNT", '', time()-3600, '/'.$CONFIG['REGmon_Folder']);

session_start();
session_unset();
session_destroy();

//we need only this but I leave the others for reference
header( 'Location: '.$PATH_2_ROOT.'login.php' );
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="1;url=/">
        <script type="text/javascript">
            window.location.href = "..";
        </script>
        <title>REGmon - Page Redirection</title>
    </head>
    <body>
        If you are not redirected automatically, follow the link to <a href='..'>REGmon</a>
    </body>
</html>

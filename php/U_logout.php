<?php
session_start();
session_unset();
session_destroy();
header("Location:/inventory_sheet/php/User_login.php" );
exit();
?>
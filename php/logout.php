<?php
session_start();
session_unset();
session_destroy();
header("Location:/inventory_sheet/index.php" );
exit();
?>
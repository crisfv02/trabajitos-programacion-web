<?php
session_start();
session_destroy();
header("Location: Logintienda.php");
exit;
?>

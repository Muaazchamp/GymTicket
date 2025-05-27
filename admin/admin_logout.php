<?php
session_start();
session_destroy();
header("Location: /GymTicket/pages/login.php");
exit;

?>

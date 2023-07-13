<?php
include '../includes/conn.php';
session_start();
session_destroy();
header('Location:login');
exit();


?>
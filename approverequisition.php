<?php
include 'includes/conn.php';
include 'utils/requisitions.php';
if ((!isset($_SESSION['hotelsys']))) {
   header('Location:login');
} else {
   $id = $_GET['id'];
   update_requisition($pdo, $id, ['status' => 1]);
   header('Location:' . $_SERVER['HTTP_REFERER']);
}

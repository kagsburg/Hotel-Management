<?php
include 'includes/conn.php';
include 'utils/requisitions.php';
// include 'utils/dbquery.php';
if ((!isset($_SESSION['hotelsys']))) {
   header('Location:login');
} else {
   $id = $_GET['id'];
   $confirmed = $_SESSION['hotelsys'];
   confirm_requisition($pdo,$id,$confirmed);

//    confirm issued stock
confirm_issued_stock($pdo, $id);

   header('Location:' . $_SERVER['HTTP_REFERER']);

}
?>
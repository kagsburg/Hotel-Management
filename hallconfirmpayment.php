<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != 'Restaurant Attendant')) {
   header('Location:login.php');
} else {
   $order_id = $_GET['id'];
   // if (isset($_POST['submit'])) {
      // $mode = $_POST['mode'];
      // $fullname = mysqli_real_escape_string($con, trim($_POST['fullname']));
      // $phone = mysqli_real_escape_string($con, trim($_POST['phone']));
      $restorders = mysqli_query($con, "UPDATE hallreservations SET payment_status='Paid' WHERE hallreservation_id='$order_id'");
      // if ($mode == 'Credit') {
      //    mysqli_query($con, "INSERT INTO creditpayments(order_id,fullname,phone,timestamp,status) VALUES('$order_id','$fullname','$phone','$timenow',0)");
      // }
   // }
}
header('Location:' . $_SERVER['HTTP_REFERER']);

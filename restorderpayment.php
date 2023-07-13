<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != 'Restaurant Attendant') && ($_SESSION['sysrole'] != 'Accountant')) {
  header('Location:login.php');
} else {
  $order_id = $_GET['id'];
  if (isset($_POST['submit'])) {
    $mode = $_POST['mode'];
    $fullname = mysqli_real_escape_string($con, trim($_POST['fullname']));
    $phone = mysqli_real_escape_string($con, trim($_POST['phone']));
    $comment = mysqli_real_escape_string($con, trim($_POST['comment']));
    $restorders = mysqli_query($con, "UPDATE  orders SET  status=1,mode='$mode' WHERE order_id='$order_id'");
    if ($mode == 'Credit') {
      mysqli_query($con, "INSERT INTO creditpayments(order_id,fullname,phone,comment,timestamp,status) VALUES('$order_id','$fullname','$phone','$comment','$timenow',0)");
    }
  }
}
header('Location:' . $_SERVER['HTTP_REFERER']);

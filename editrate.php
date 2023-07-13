<?php
include 'includes/conn.php';
if ((!isset($_SESSION['hotelsys'])) || ($_SESSION['hotelsyslevel'] != 1)) {
  header('Location:login.php');
} else {
  $id = $_GET['id'];
  if (isset($_POST['currency'], $_POST['rate'])) {
    $currency =  mysqli_real_escape_string($con, trim($_POST['currency']));
    $rate =  mysqli_real_escape_string($con, trim($_POST['rate']));
    if ((empty($currency) || (empty($rate)))) {
      $errors[] = 'Enter All Fields To Proceed';
    }
    $check = mysqli_query($con, "SELECT * FROM rates WHERE currency='$currency' AND status=1 AND rate_id!='$id'") or die(mysqli_error($con));
    if (mysqli_num_rows($check) > 0) {
      $errors[] = 'Currency already added';
    }
    if (!empty($errors)) {
      foreach ($errors as $error) {
        echo '<div class="alert alert-danger">' . $error . '</div>';
      }
    } else {
      mysqli_query($con, "UPDATE rates SET currency='$currency',rate='$rate' WHERE rate_id='$id'") or die(mysqli_error($con));
      header('Location:' . $_SERVER['HTTP_REFERER']);
    }
  }
}

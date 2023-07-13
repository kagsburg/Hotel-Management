<?php
include 'includes/conn.php';
if ((!isset($_SESSION['hotelsys'])) || ($_SESSION['hotelsyslevel'] != 1)) {
   header('Location:login.php');
} else {
   $id = $_GET['id'];
   if (isset($_POST['package'], $_POST['charge'])) {
      $package =  mysqli_real_escape_string($con, trim($_POST['package']));
      $rate =  mysqli_real_escape_string($con, trim($_POST['rate']));
      $package =  mysqli_real_escape_string($con, trim($_POST['package']));
      $charge =  mysqli_real_escape_string($con, trim($_POST['charge']));
      $days =  mysqli_real_escape_string($con, trim($_POST['days']));
      if ((empty($package) || (empty($charge)) || empty($days))) {
         echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
      }
      if (is_numeric($charge) == FALSE) {
         echo '<div class="alert alert-danger"><i class="fa fa-warning"></i>Charge should be an Integer</div>';
      } else {
         mysqli_query($con, "UPDATE poolpackages SET poolpackage='$package',charge='$charge',days='$days' WHERE poolpackage_id='$id'") or die(mysqli_error($con));
         header('Location:' . $_SERVER['HTTP_REFERER']);
      }
   }
}

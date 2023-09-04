<?php
include 'includes/conn.php';
if ((!isset($_SESSION['hotelsys'])) || ($_SESSION['hotelsyslevel'] != 1)) {
   header('Location:login.php');
} else {
   $id = $_GET['id'];
   if (isset($_POST['name_update'], $_POST['location_update'])) {
    $package =  mysqli_real_escape_string($con, trim($_POST['name_update']));
    $charge =  mysqli_real_escape_string($con, trim($_POST['location_update']));
    $contact =  mysqli_real_escape_string($con, trim($_POST['contact_update']));
    $days =  mysqli_real_escape_string($con, trim($_POST['email_update']));
      if ((empty($package) || (empty($charge)) || empty($contact))) {
         echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
      } else {
         mysqli_query($con, "UPDATE sponsors SET company_name='$package',company_location='$charge',company_email='$days',company_contact='$contact' WHERE sponsor_id ='$id'") or die(mysqli_error($con));
         header('Location:' . $_SERVER['HTTP_REFERER']);
      }
   }
}

<?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
   }
$id=$_GET['id'];
?>
 <link href="css/bootstrap.min.css" rel="stylesheet">
<?php
   $change=  mysqli_query($con,"UPDATE hallreservations  SET status='0' WHERE hallreservation_id='$id'") or die(mysqli_errno($con)); 
echo '<div class="alert alert-success">Reservation successfully Cancelled.Click <a href="hallbookings">here</a> to go to reservations</a>';
?>
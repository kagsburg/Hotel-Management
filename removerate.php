<?php
include 'includes/conn.php';
if ((!isset($_SESSION['hotelsys'])) || ($_SESSION['hotelsyslevel'] != 1)) {
    header('Location:login.php');
} else {
    $id = $_GET['id'];

    mysqli_query($con, "UPDATE rates SET status='0' WHERE rate_id='$id'") or die(mysqli_error($con));
    header('Location:' . $_SERVER['HTTP_REFERER']);
}

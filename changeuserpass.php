<?php
include 'includes/conn.php';
$id = $_GET['id'];

if (isset($_POST['password'])) {
    $password = $_POST["password"];
    $repeat = $_POST["repeat"];

    if ($password != $repeat) {
        die("Passwords do not match");
    }
    $pass = md5($password);

    mysqli_query($con, "UPDATE users SET password='$pass' WHERE employee='$id'") or die(mysqli_error($con));
    header('Location:' . $_SERVER['HTTP_REFERER']);
} else {
    header('Location:' . $_SERVER['HTTP_REFERER']);
}

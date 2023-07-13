<?php
$hostname = "localhost";
$username = "d0000_user";
$password = '&)Ey!M02JyMB';
$database = "d0000";
$con = new mysqli($hostname, $username, $password, $database);
if (mysqli_connect_errno())
    die(mysqli_connect_error());
session_start();

$dsn = "mysql:host=$hostname;dbname=$database";
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

date_default_timezone_set("Africa/Nairobi");
$datenow = date('m/d/Y',  time());
$timenow =  strtotime($datenow);
$getsettings = mysqli_query($con, "SELECT * FROM settings");
$row = mysqli_fetch_array($getsettings);
$hotelname = $row['hotelname'];
$nif = $row['nif'];
$hoteladdress = $row['hoteladdress'];
$corporatename = $row['corporatename'];
$hotelcontacts =  $row['hotelcontacts'];
$hotelmanager = $row['hotelmanager'];
$logo = $row['logo'];

<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login.php');
}
// foreach ($_SESSION["reqproducts"] as $product) { //loop though items and prepare html content
    unset($_SESSION["reqproducts"]);
// }
header('Location:addrequisition');

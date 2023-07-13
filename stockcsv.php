<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
  header('Location:login.php');
} else {


  $delimiter = ",";

  $filename = "Stock Items as of  " . date('d/m/Y', $timenow) . ".csv";

  $f = fopen('php://memory', 'w');

  $fields = [
    'ID', 
    'Stock Item', 
    'Min Stock', 
    'In Stock', 
    'Weighted Price',
    'Unit', 
    'Category', 
    'Status'
  ];

  fputcsv($f, $fields, $delimiter);
  $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE status=1");
  while ($row =  mysqli_fetch_array($stock)) {
    $stockitem_id = $row['stockitem_id'];
    $cat_id = $row['category_id'];
    $stockitem = $row['stock_item'];
    $minstock = $row['minstock'];
    $measurement = $row['measurement'];
    $status = $row['status'];
    $wprice = $row['wprice'];
    $getadded = mysqli_query($con, "SELECT SUM(quantity) as addedstock FROM stockitems WHERE item_id='$stockitem_id'") or die(mysqli_error($con));
    $rowa = mysqli_fetch_array($getadded);
    $addedstock = $rowa['addedstock'];
    $getissued = mysqli_query($con, "SELECT SUM(quantity) as issuedstock FROM issueditems WHERE item_id='$stockitem_id'") or die(mysqli_error($con));
    $rowi = mysqli_fetch_array($getissued);
    $issuedstock = $rowi['issuedstock'];
    $getlossed = mysqli_query($con, "SELECT SUM(quantity) as lossedstock FROM losseditems WHERE item_id='$stockitem_id'") or die(mysqli_error($con));
    $rowl = mysqli_fetch_array($getlossed);
    $lossedstock = $rowl['lossedstock'];
    // $getkitchenitems = mysqli_query($con, "SELECT SUM(quantity) AS kitchenstock FROM kitchenstockitems  WHERE stockitem_id='$stockitem_id'") or die(mysqli_error($con));
    // $rowc = mysqli_fetch_array($getkitchenitems);
    // $totalconsumed = $rowc["kitchenstock"];

    $stockleft = $addedstock - $issuedstock - $lossedstock;
    $getmeasure =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
    $row2 =  mysqli_fetch_array($getmeasure);
    $measurement2 = $row2['measurement'];

    $getcat =  mysqli_query($con, "SELECT * FROM categories WHERE status=1 AND category_id='$cat_id'");
    $row1 =  mysqli_fetch_array($getcat);
    $category_id = $row1['category_id'];
    $category = $row1['category'];
    if ($stockleft <= $minstock) {
      $status = 'LOW';
    } else {
      $status = 'HIGH';
    }
    $lineData = [
      $stockitem_id, 
      $stockitem, 
      $minstock, 
      $stockleft, 
      $wprice,
      $measurement2, 
      $category, 
      $status
    ];

    fputcsv($f, $lineData, $delimiter);
  }

  fputcsv($f, $lineData, $delimiter);

  fseek($f, 0);

  header('Content-Type: text/xls');

  header('Content-Disposition: attachment; filename="' . $filename . '";');

  fpassthru($f);
}

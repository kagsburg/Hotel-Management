<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login');
} else {
   $st = $_GET['st'];
   $en = $_GET['en'];


   $delimiter = ",";

   $filename = "Inventory report from " . date('d/m/Y_H_i', $st) . " to " . date('d/m/Y_H_i', $en) . ".csv";

   $f = fopen('php://memory', 'w');

   fwrite($f, "sep=,\n");
   $fields = [
      'Item',
      'In Stock',
      'Quantity Added',
      'Quantity Issued',
      'Quantity Lossed',
      'Quantity Remained',
   ];

   fputcsv($f, $fields, $delimiter, chr(0));
   $totalin = 0;
   $totaladded = 0;
   $totalissued = 0;
   $totallossed = 0;
   $totalremained = 0;

   $items = mysqli_query($con, "SELECT * FROM stock_items WHERE status=1 ");
   while ($row = mysqli_fetch_array($items)) {
      $item = $row['stock_item'];
      $measure = $row['measurement'];
      $stockitem_id = $row['stockitem_id'];
      $cat_id = $row['category_id'];
      $stockitem = $row['stock_item'];
      $minstock = $row['minstock'];
      $price = $row['price'];
      $measurement = $row['measurement'];
      $status = $row['status'];

      $gettotadded = mysqli_query($con, "SELECT SUM(quantity) as addedstock FROM stockitems AS q LEFT JOIN addedstock AS o ON o.addedstock_id = q.addedstock_id WHERE item_id='$stockitem_id' AND date >= $st AND date <= $en") or die(mysqli_error($con));
      $rowtota = mysqli_fetch_array($gettotadded);
      $totaddedstock = $rowtota['addedstock'];
      $gettotissued = mysqli_query($con, "SELECT SUM(quantity) as issuedstock FROM issueditems AS q LEFT JOIN issuedstock AS o ON o.issuedstock_id = q.issuedstock_id WHERE item_id='$stockitem_id' AND date >= $st AND date <= $en") or die(mysqli_error($con));
      $rowtoti = mysqli_fetch_array($gettotissued);
      $totissuedstock = $rowtoti['issuedstock'];
      $gettotlossed = mysqli_query($con, "SELECT SUM(quantity) as lossedstock FROM losseditems AS q LEFT JOIN itemlosses AS o ON o.itemloss_id = q.itemloss_id WHERE item_id='$stockitem_id' AND date >= $st AND date <= $en") or die(mysqli_error($con));
      $rowtotl = mysqli_fetch_array($gettotlossed);
      $totlossedstock = $rowtotl['lossedstock'];

      $instock = $totaddedstock - $totissuedstock - $totlossedstock;


      $getadded = mysqli_query($con, "SELECT SUM(quantity) as addedstock FROM stockitems AS q LEFT JOIN addedstock AS o ON o.addedstock_id = q.addedstock_id WHERE item_id='$stockitem_id' AND date >= $st AND date <= $en") or die(mysqli_error($con));
      $rowa = mysqli_fetch_array($getadded);
      $addedstock = $rowa['addedstock'];
      $getissued = mysqli_query($con, "SELECT SUM(quantity) as issuedstock FROM issueditems AS q LEFT JOIN issuedstock AS o ON o.issuedstock_id = q.issuedstock_id WHERE item_id='$stockitem_id' AND date >= $st AND date <= $en") or die(mysqli_error($con));
      $rowi = mysqli_fetch_array($getissued);
      $issuedstock = $rowi['issuedstock'];
      $getlossed = mysqli_query($con, "SELECT SUM(quantity) as lossedstock FROM losseditems AS q LEFT JOIN itemlosses AS o ON o.itemloss_id = q.itemloss_id WHERE item_id='$stockitem_id' AND date >= $st AND date <= $en") or die(mysqli_error($con));
      $rowl = mysqli_fetch_array($getlossed);
      $lossedstock = $rowl['lossedstock'];
      // $getkitchenitems = mysqli_query($con, "SELECT SUM(quantity) AS kitchenstock FROM kitchenstockitems  WHERE stockitem_id='$stockitem_id'") or die(mysqli_error($con));
      // $rowc = mysqli_fetch_array($getkitchenitems);
      // $totalconsumed = $rowc["kitchenstock"];


      $stockleft = $addedstock - $issuedstock - $lossedstock;
      $totalin += $instock;
      $totaladded += $addedstock;
      $totalissued += $issuedstock;
      $totallossed += $lossedstock;
      $totalremained += $stockleft;

      $lineData = [
         $item,
         $instock ?? 0,
         $addedstock ?? 0,
         $issuedstock ?? 0,
         $lossedstock ?? 0,
         $stockleft ?? 0,
      ];

      fputcsv($f, $lineData, $delimiter, chr(0));
   }

   // fwrite($f, "\n");
   // $lineData = [
   //    'TOTAL',
   //    $totalin,
   //    $totaladded,
   //    $totalissued,
   //    $totallossed,
   //    $totalremained,
   // ];

   // fputcsv($f, $lineData, $delimiter, chr(0));

   fseek($f, 0);

   header('Content-Type: text/xls');

   header('Content-Disposition: attachment; filename="' . $filename . '";');

   fpassthru($f);
}

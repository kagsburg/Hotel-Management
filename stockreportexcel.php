<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login');
} else {
   $st = $_GET['st'];
   $en = $_GET['en'];
   $ty = $_GET['ty'];

   $delimiter = ",";

   $filename = $ty . " stock report from " . date('d/m/Y', $st) . " to " . date('d/m/Y', $en) . ".csv";

   $f = fopen('php://memory', 'w');

   fwrite($f, "sep=,\n");

   $total = 0;
   if ($ty == 'Added' || $ty == "all") {
      if ($ty == "all")
         fwrite($f, "Added Stock\n");

      $fields = [
         'Date',
         'Item',
         'Quantity',
      ];

      fputcsv($f, $fields, $delimiter, chr(0));

      $addedstock = mysqli_query($con, "SELECT * FROM addedstock WHERE  date>='$st' AND date<='$en' AND status=1");
      while ($row = mysqli_fetch_array($addedstock)) {
         $date = $row['date'];
         $addedstock_id = $row['addedstock_id'];
         $getadded = mysqli_query($con, "SELECT * FROM stockitems WHERE  status=1  AND addedstock_id='$addedstock_id'");
         $row2 =  mysqli_fetch_array($getadded);
         $quantity = $row2['quantity'];
         $item_id = $row2['item_id'];
         $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$item_id' ");
         $row3 =  mysqli_fetch_array($stock);
         $item = $row3['stock_item'];
         $measure = $row3['measurement'];
         $measurements =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measure'");
         $row4 = mysqli_fetch_array($measurements);
         $measurement = $row4['measurement'];

         $lineData = [
            date('d/m/Y', $date),
            $item . ' (' . $measurement . ')',
            $quantity,
         ];

         fputcsv($f, $lineData, $delimiter, chr(0));
      }
   }
   if ($ty == 'Lossed' || $ty == "all") {
      if ($ty == "all")
         fwrite($f, "\nLossed Stock\n");

      $fields = [
         'Date',
         'Item',
         'Quantity',
      ];

      fputcsv($f, $fields, $delimiter, chr(0));

      $stocklossed = mysqli_query($con, "SELECT * FROM itemlosses WHERE status=1  AND date>='$st' AND date<='$en'");
      while ($row = mysqli_fetch_array($stocklossed)) {
         $date = $row['date'];
         $itemloss_id = $row['itemloss_id'];
         $getlossed = mysqli_query($con, "SELECT * FROM losseditems WHERE  status=1  AND itemloss_id='$itemloss_id'");
         $row2 =  mysqli_fetch_array($getlossed);
         $quantity = $row2['quantity'];
         $item_id = $row2['item_id'];
         $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$item_id' ");
         $row3 =  mysqli_fetch_array($stock);
         $item = $row3['stock_item'];
         $measure = $row3['measurement'];
         $measurements =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measure'");
         $row4 = mysqli_fetch_array($measurements);
         $measurement = $row4['measurement'];


         $lineData = [
            date('d/m/Y', $date),
            $item . ' (' . $measurement . ')',
            $quantity,
         ];

         fputcsv($f, $lineData, $delimiter, chr(0));
      }
   }
   if ($ty == 'Issued' || $ty == "all") {
      if ($ty == "all")
         fwrite($f, "\nIssued Stock\n");

      $fields = [
         'Date',
         'Item',
         'Quantity',
         'Department',
      ];

      fputcsv($f, $fields, $delimiter, chr(0));

      $issuedstock = mysqli_query($con, "SELECT * FROM issuedstock WHERE status=1  AND date>='$st' AND date<='$en'");
      while ($row = mysqli_fetch_array($issuedstock)) {
         $date = $row['date'];
         $issuedstock_id = $row['issuedstock_id'];
         $department_id = $row['department_id'];
         $getissued = mysqli_query($con, "SELECT * FROM issueditems WHERE  status=1  AND issuedstock_id='$issuedstock_id'");
         $row2 =  mysqli_fetch_array($getissued);
         $quantity = $row2['quantity'];
         $item_id = $row2['item_id'];
         $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$item_id' ");
         $row3 =  mysqli_fetch_array($stock);
         $item = $row3['stock_item'];
         $measure = $row3['measurement'];
         $measurements =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measure'");
         $row4 = mysqli_fetch_array($measurements);
         $measurement = $row4['measurement'];
         if ($department_id === "-2") {
            $dept = "Small Stock";
         } else {
            $depts =  mysqli_query($con, "SELECT * FROM departments WHERE department_id='$department_id'");
            $rowd = mysqli_fetch_array($depts);
            $dept = $rowd['department'];
         }

         $lineData = [
            date('d/m/Y', $date),
            $item . ' (' . $measurement . ')',
            $quantity,
            $dept,
         ];

         fputcsv($f, $lineData, $delimiter, chr(0));
      }
   }




   fseek($f, 0);

   header('Content-Type: text/xls');

   header('Content-Disposition: attachment; filename="' . $filename . '";');

   fpassthru($f);
}

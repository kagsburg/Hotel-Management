<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login');
} else {
   $st = $_GET['st'];
   $en = $_GET['en'];
   $cat = $_GET['cat'];
  
   $delimiter = ",";

   $filename = "Restaurant report from " . date('d/m/Y', $st) . " to " . date('d/m/Y', $en) . ".csv";

   $f = fopen('php://memory', 'w');

   fwrite($f, "sep=,\n");
   $fields = [
      'ITEM',
      'QUANTITY',
      'PRICE',
      'TVA',
      'TOTAL',
   ];

   fputcsv($f, $fields, $delimiter, chr(0));

   $totalitems = 0;
   $totalcharge = 0;
   $totalvat = 0;
   $totalnet = 0;


   $ordereditems =  mysqli_query($con, "SELECT food_id FROM restaurantorders  GROUP BY food_id") or die(mysqli_error($con));
   while ($row3 =  mysqli_fetch_array($ordereditems)) {
      $food_id = $row3['food_id'];
      $getquery = "SELECT * FROM menuitems WHERE menuitem_id='$food_id'";
      if ($cat != 'all') {
         $getquery .= "AND menucategory='$cat'";
      }
      $getfoodmenu = mysqli_query($con, $getquery) or die(mysqli_error($con));
      if (mysqli_num_rows($getfoodmenu) > 0) {
         $rowf =  mysqli_fetch_array($getfoodmenu);
         $menuitem = $rowf['menuitem'];

         $items = 0;
         $totaltax = 0;
         $total = 0;
         $net = 0;

         $restorders = mysqli_query($con, "SELECT * FROM orders WHERE status=1 AND timestamp>='$st' AND timestamp<='$en' ");
         if (mysqli_num_rows($restorders) > 0) {
            while ($row =  mysqli_fetch_array($restorders)) {
               $order_id = $row['order_id'];
               $guest = $row['guest'];
               $rtable = $row['rtable'];
               $vat = $row['vat'];
               $foodsordered =  mysqli_query($con, "SELECT * FROM restaurantorders WHERE food_id='$food_id'  AND order_id='$order_id'");
               if (mysqli_num_rows($foodsordered) > 0) {
                  $row4 =  mysqli_fetch_array($foodsordered);
                  $price = $row4['foodprice'];
                  $quantity = $row4['quantity'];
                  $tax = $row4['tax'];
                  if ($tax == 1) {
                     $puhtva = round($price / (($vat / 100) + 1));
                     $tva = $price - $puhtva;
                  } else {
                     $tva = 0;
                     $puhtva = $price;
                  }
                  $pthtva = $puhtva * $quantity;
                  $total = ($total + $pthtva);
                  $vatamount = $tva * $quantity;
                  $totaltax = $totaltax + $vatamount;
                  $items = $items + $quantity;
                  $net = $totaltax + $total;
               }
            }
         }
         if ($items > 0) {
            $lineData = [
               $menuitem,
               $items,
               $total,
               $totaltax,
               $net,
            ];

            fputcsv($f, $lineData, $delimiter, chr(0));

            $totalitems = $totalitems + $items;
            $totalcharge = $totalcharge + $total;
            $totalvat = $totalvat + $totaltax;
            $totalnet = $totalnet + $net;
         }
      }
   }

   fwrite($f, "\n");
   $lineData = [
      "TOTAL",
      $totalitems,
      $totalcharge,
      $totalvat,
      $totalnet,
   ];

   fputcsv($f, $lineData, $delimiter);

   fseek($f, 0);

   header('Content-Type: text/xls');

   header('Content-Disposition: attachment; filename="' . $filename . '";');

   fpassthru($f);
}

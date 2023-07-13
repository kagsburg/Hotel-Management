<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login');
} else {
   $st = $_GET['start'];
   $en = $_GET['end'];
   $st = strtotime($_GET['start']);
   $en = strtotime($_GET['end']);


   $delimiter = ",";

   $filename = "Expenses report from " . date('d/m/Y', $st) . " to " . date('d/m/Y', $en) . ".csv";

   $f = fopen('php://memory', 'w');

   fwrite($f, "sep=,\n");
   $fields = [
      'Date',
      'Expense',
      'Cost',
   ];

   fputcsv($f, $fields, $delimiter, chr(0));

   $totalcosts = 0;
   $costs = mysqli_query($con, "SELECT * FROM costs WHERE status='1' AND date>='$st' AND date<='$en'") or die(mysqli_errno($con));

   while ($row = mysqli_fetch_array($costs)) {
      $cost_id = $row['cost_id'];
      $cost_item = $row['cost_item'];
      $amount = $row['amount'];
      $date = $row['date'];
      $creator = $row['creator'];
      $totalcosts = $amount + $totalcosts;

      $lineData = [
         date('d/m/Y', $date),
         $cost_item,
         $amount,
      ];

      fputcsv($f, $lineData, $delimiter, chr(0));
   }

   fseek($f, 0);

   header('Content-Type: text/xls');

   header('Content-Disposition: attachment; filename="' . $filename . '";');

   fpassthru($f);
}

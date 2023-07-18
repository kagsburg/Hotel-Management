<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login');
} else {
   $start = strtotime($_GET['start']);
   $end = strtotime($_GET['end']);

   $delimiter = ",";

   $filename = "Conference room report from " . date('d/m/Y', $start) . " to " . date('d/m/Y', $end) . ".csv";

   $f = fopen('php://memory', 'w');

   fwrite($f, "sep=,\n");
   $fields = [
      'Customer',
      'People',
      'Dates',
      'Purpose',
      'Status',
      'Charge',
   ];

   fputcsv($f, $fields, $delimiter, chr(0));

   $totalcosts = 0;
   $reservations = mysqli_query($con, "SELECT * FROM hallreservations WHERE status IN(1,2) AND timestamp>='$start' AND timestamp<='$end'");
   while ($row =  mysqli_fetch_array($reservations)) {
      $hallreservation_id = $row['hallreservation_id'];
      $fullname = $row['fullname'];
      $checkin = $row['checkin'];
      $phone = $row['phone'];
      $checkout = $row['checkout'];
      $status = $row['status'];
      $people = $row['people'];
      $purpose = $row['purpose'] ?? "";
      $description = $row['description'];
      $country = $row['country'];
      $charge = $row['charge'];
      $creator = $row['creator'];
      $vat = 18;
      $getdays = (($checkout - $checkin) / (24 * 3600)) + 1;
      $vatamount = ($people * $charge * $vat) / 100;
      $hallcost = ($charge * $people) + $vatamount;
      $totalcosts += $hallcost;

      if (!empty($purpose)) {
         $purposes = mysqli_query($con, "SELECT * FROM hallpurposes WHERE hallpurpose_id='$purpose'");
         $row3 = mysqli_fetch_array($purposes);
         $hallpurpose_id = $row3['hallpurpose_id'];
         $hallpurpose = $row3['hallpurpose'];
      } else {
         $hallpurpose = "";
      }

      $lineData = [
         $fullname,
         $people,
         date('d/m/Y', $checkin) . ' to ' . date('d/m/Y', $checkout),
         $hallpurpose,
         ($status == 1) ? 'BOOKED' : (($status == 2) ? 'CHECKED IN' : ""),
         $hallcost,
      ];

      fputcsv($f, $lineData, $delimiter, chr(0));
   }

   fseek($f, 0);

   header('Content-Type: text/xls');

   header('Content-Disposition: attachment; filename="' . $filename . '";');

   fpassthru($f);
}

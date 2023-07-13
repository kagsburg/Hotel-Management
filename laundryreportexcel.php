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

   $filename = "Laundry report from " . date('d/m/Y', $st) . " to " . date('d/m/Y', $en) . ".csv";

   $f = fopen('php://memory', 'w');

   fwrite($f, "sep=,\n");
   $fields = [
      // 'ID',
      // 'Client',
      // 'Resident',
      'Items',
      'Quantity',
      'Price',
      // 'Created By',
      'HTVA',
      'VAT',
      'Total Price',
   ];

   fputcsv($f, $fields, $delimiter, chr(0));

   $totalcosts = 0;
   $laundry = mysqli_query($con, "SELECT * FROM laundry WHERE status IN (1) AND timestamp>='$st' AND timestamp<='$en'");

   while ($row =  mysqli_fetch_array($laundry)) {
      $laundry_id = $row['laundry_id'];
      $reserve_id = $row['reserve_id'];
      $clothes = $row['clothes'];
      $package_id = $row['package_id'];
      $charge = $row['charge'];
      $customername = $row['customername'];
      $phone = $row['phone'];
      $timestamp = $row['timestamp'];
      $status = $row['status'];
      $creator = $row['creator'];
      $getyear = date('Y', $timestamp);
      $count = 1;
      $beforeorders =  mysqli_query($con, "SELECT * FROM laundry WHERE status IN (0,1) AND  laundry_id<'$laundry_id'") or die(mysqli_error($con));
      while ($rowb = mysqli_fetch_array($beforeorders)) {
         $timestamp2 = $rowb['timestamp'];
         $getyear2 = date('Y', $timestamp2);
         if ($getyear == $getyear2) {
            $count = $count + 1;
         }
      }
      if (strlen($count) == 1) {
         $invoice_no = '000' . $count;
      }
      if (strlen($count) == 2) {
         $invoice_no = '00' . $count;
      }
      if (strlen($count) == 3) {
         $invoice_no = '0' . $count;
      }
      if (strlen($count) >= 4) {
         $invoice_no = $count;
      }
      $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
      if (mysqli_num_rows($reservation) > 0) {

         $row2 =  mysqli_fetch_array($reservation);
         $firstname = $row2['firstname'];
         $lastname = $row2['lastname'];
         $room_id = $row2['room'];
         $phone = $row2['phone'];
         $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
         $row1 =  mysqli_fetch_array($roomtypes);
         $roomnumber = $row1['roomnumber'];
         $customername = $firstname . ' ' . $lastname . ' (' . $roomnumber . ')';
      }
      $getpackage = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1' AND laundrypackage_id='$package_id'");
      $row3 = mysqli_fetch_array($getpackage);
      $laundrypackage = $row3['laundrypackage'];

      $totalcharge = $charge * $clothes;
      $vatamount = (($totalcharge * $vat) / 100);

                           $htva = $totalcharge - $vatamount;
                           $net = $htva + $vatamount;

                           $totalcosts += $totalcharge;

      $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                                                   $row = mysqli_fetch_array($employee);
                                                   $employee_id = $row['employee_id'];
                                                   $fullname = $row['fullname'];

      $lineData = [
         // $invoice_no,
         // $customername,
         // ($reserve_id > 0) ? 'Yes' : 'No',
         $laundrypackage,
         $clothes,
         $charge,
         // $fullname,
         $htva,
         $vatamount,
         $totalcharge,
      ];

      fputcsv($f, $lineData, $delimiter, chr(0));
   }

   fseek($f, 0);

   header('Content-Type: text/xls');

   header('Content-Disposition: attachment; filename="' . $filename . '";');

   fpassthru($f);
}

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

   $filename = "Gym and Pool Report from " . date('d/m/Y', $st) . " to " . date('d/m/Y', $en) . ".csv";

   $f = fopen('php://memory', 'w');

   fwrite($f, "sep=,\n");
   $fields = [
      'ID',
      'Client',
      'Start Date',
      'End Date',
      'Created By',
      'Package',
      'Reduction',
      'Charge',
      'HTVA',
      'VAT',
      'NET'
   ];

   fputcsv($f, $fields, $delimiter, chr(0));

   $totalcosts = 0;
                    $total = 0;
                    $totalred = 0;
                    $totalvat = 0;
                    $totalhtva = 0;

   $subscriptions = mysqli_query($con, "SELECT * FROM poolsubscriptions WHERE status='1'  AND timestamp>='$st' AND timestamp<='$en'");
   while ($row =  mysqli_fetch_array($subscriptions)) {
      $poolsubscription_id = $row['poolsubscription_id'];
      $fullname = $row['firstname'] . " " . $row["lastname"];
      $startdate = $row['startdate'];
      $enddate = $row['enddate'];
      $charge = $row['charge'];
      $creator = $row['creator'];
      $package = $row['package'];
      $reduction = empty($row['reduction']) ? 0 : $row['reduction'];
      $getpackage = mysqli_query($con, "SELECT * FROM poolpackages WHERE status='1' AND poolpackage_id='$package'");
      $row1 = mysqli_fetch_array($getpackage);
      $gymbouquet_id = $row1['poolpackage_id'];
      $package = $row1['poolpackage'];
      $days = $row1['days'] - 1;
      $enddate = strtotime("+{$days} days", $startdate);

      if (strlen($poolsubscription_id) == 1) {
         $pin = '000' . $poolsubscription_id;
      }
      if (strlen($poolsubscription_id) == 2) {
         $pin = '00' . $poolsubscription_id;
      }
      if (strlen($poolsubscription_id) == 3) {
         $pin = '0' . $poolsubscription_id;
      }
      if (strlen($poolsubscription_id) >= 4) {
         $pin = $poolsubscription_id;
      }
      $total += $charge;
                                $totalred += $reduction;

                                $vatamount = ((($charge - $reduction) * $vat) / 110);

                                $htva = $charge - $vatamount - $reduction;
                                $net = $htva + $vatamount;

                                $totalvat += $vatamount;
                                $totalhtva += $htva;
                                $totalcosts += $net;

      $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
      $row = mysqli_fetch_array($employee);
      $employee_id = $row['employee_id'];
      $fullname = $row['fullname'];

      $lineData = [
         $pin,
         $fullname,
         date('d/m/Y', $startdate),
         date('d/m/Y', $enddate),
         $fullname,
         $package,
         $reduction,
         $charge,
         $htva,
         $vatamount,
         $net
      ];

      fputcsv($f, $lineData, $delimiter, chr(0));
   }

   fseek($f, 0);

   header('Content-Type: text/xls');

   header('Content-Disposition: attachment; filename="' . $filename . '";');

   fpassthru($f);
}

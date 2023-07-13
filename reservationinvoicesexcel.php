<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login');
} else {

   function getForexConvertedAmount($currencyrate, $amount)
   {
      return intval($amount) * floatval($currencyrate);
   }

   $start = $_GET['st'];
   $end = $_GET['en'];

   $delimiter = ",";

   $filename = "Reservation Invoices between " . date('d/m/Y', $start) . " to " . date('d/m/Y', $end) . ".csv";

   $f = fopen('php://memory', 'w');
   fwrite($f, "sep=,\n");

   $fields = [
      "Guest",
      "Room Number",
      "Check In",
      "Check Out",
      "Status",
      "Total Bill",
      "Amount Paid",
   ];

   fputcsv($f, $fields, $delimiter);

   $dtotalcharge = 0;
   $totaladvance = 0;
   $reservations = mysqli_query($con, "SELECT * FROM reservations WHERE timestamp>='$start' AND timestamp<='$end' AND status IN (0,1,2) ORDER BY reservation_id DESC");


   while ($row =  mysqli_fetch_array($reservations)) {
      $reservation_id = $row['reservation_id'];
      $id = $reservation_id;
      $firstname = $row['firstname'];
      $lastname = $row['lastname'];
      $checkin = $row['checkin'];
      $phone = $row['phone'];
      $adults = $row['adults'];
      $checkout = $row['checkout'];
      $actualcheckout = $row['actualcheckout'];
      $room_id = $row['room'];
      $email = $row['email'];
      $status = $row['status'];
      $reduction = $row['reduction'];

      $currency = $row['currency'];
      $currencyrate = 1;
      if (!empty($currency) && $currency !== "USD") {
         $getcurrencies = mysqli_query($con, "SELECT * FROM rates WHERE currency='$currency' AND status='1'");
         $curow = mysqli_fetch_array($getcurrencies);
         $currencyrate = $curow["rate"];
      }

      $getnumber = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
      $row1 =  mysqli_fetch_array($getnumber);
      $roomnumber = $row1['roomnumber'];
      $type_id = $row1['type'];



      $roomtypes = mysqli_query($con, "SELECT * FROM roomtypes WHERE roomtype_id='$type_id'");
      $row1 =  mysqli_fetch_array($roomtypes);
      $roomtype = $row1['roomtype'];
      $dollarCharge =  $row1['charge'];
      $sharecharge = $row1["sharecharge"];
      $dollarCharge = ($adults > 1 && isset($sharecharge)) ? $sharecharge : $dollarCharge;
      // $charge = getForexConvertedAmount($currencyrate, $dollarCharge);

      if ($status == 2) {
         $nights = round(($actualcheckout - $checkin) / (3600 * 24));
      } else {
         $nights =  round(($checkout - $checkin) / (3600 * 24));
      }

      $totalcharge = $dollarCharge * $nights;
      if (!empty($reduction))
         $totalcharge -= ($reduction * $nights);
      $totalcharge = getForexConvertedAmount($currencyrate, $totalcharge);

      $totalotherservices = 0;
      $getotherservices = mysqli_query($con, "SELECT * FROM otherservices WHERE reservation_id='$id' AND status=1") or die(mysqli_error($con));
      if (mysqli_num_rows($getotherservices) > 0) {
         while ($row3 = mysqli_fetch_array($getotherservices)) {
            $otherservice_id = $row3['otherservice_id'];
            $otherservice = $row3['otherservice'];
            $currency = $row3['currency'];
            if ($currency == 'USD') {
               $rate = $usdtariff;
            } else {
               $rate = 1;
            }
            $reduction = $row3['reduction'] * $rate;
            $price = $row3['price'] * $rate;
            $timestamp = $row3['timestamp'];
            $subtotal = $price - $reduction;
            $totalotherservices = $totalotherservices + $subtotal;
         }
      }

      $restbill = 0;
      $restorder = mysqli_query($con, "SELECT * FROM orders WHERE guest='$id' AND status IN(1,2)");
      if (mysqli_num_rows($restorder) > 0) {
         while ($row =  mysqli_fetch_array($restorder)) {
            $order_id = $row['order_id'];
            $guest = $row['guest'];
            $timestamp = $row['timestamp'];
            $totalcharges = mysqli_query($con, "SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
            $row =  mysqli_fetch_array($totalcharges);
            $totalrestcosts = getForexConvertedAmount($currencyrate, $row['totalcosts']);
            $restbill = $totalrestcosts + $restbill;
         }
      }

      $totallaundry = 0;
      $laundry = mysqli_query($con, "SELECT * FROM laundry WHERE status='1' AND reserve_id='$id' ORDER BY timestamp");
      if (mysqli_num_rows($laundry)) {
         while ($row =  mysqli_fetch_array($laundry)) {
            $laundry_id = $row['laundry_id'];
            $reserve_id = $row['reserve_id'];
            $clothes = $row['clothes'];
            $package_id = $row['package_id'];
            $timestamp = $row['timestamp'];
            $status = $row['status'];
            $creator = $row['creator'];
            $invoice_no = 23 * $id;
            $charge = getForexConvertedAmount($currencyrate, $row['charge']);
            $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
            $row2 =  mysqli_fetch_array($reservation);
            $firstname = $row2['firstname'];
            $lastname = $row2['lastname'];
            $room_id = $row2['room'];
            $phone = $row2['phone'];

            $getpackage = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1' AND laundrypackage_id='$package_id'");
            $row3 = mysqli_fetch_array($getpackage);
            $laundrypackage = $row3['laundrypackage'];
            $totallaundry = $totallaundry + $charge;
         }
      }

      $totalbill = $totallaundry + $restbill + $totalcharge + $totalotherservices;

      if ($status != 2) {
         $getpayments = mysqli_query($con, "SELECT SUM(amount) AS totalpaid FROM payments WHERE reservation_id='$id'");
         $payrow = mysqli_fetch_array($getpayments);
         $totalpaid = $payrow['totalpaid'];
      } else {
         $getpayments = mysqli_query($con, "SELECT * FROM checkoutdetails WHERE reserve_id='$id'");
         $payrow = mysqli_fetch_array($getpayments);
         $totalpaid = $payrow['paidamount'];
      }

      $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
      $row1 =  mysqli_fetch_array($roomtypes);
      $roomtype = $row1['roomnumber'];

      $name = $firstname . ' ' . $lastname;
      $stat = "";
      if (($timenow > $checkout) && ($status == 2)) {
         $stat = "Guest Out";
      } else if (($timenow > $checkout) && ($status == 1)) {
         $stat = "Pending Guest Out";
      } else if ($timenow < $checkout) {
         $stat = "Guest In";
      }

      $lineData = [
         $name,
         $roomtype,
         date('d/m/Y', $checkin),
         date('d/m/Y', $checkout),
         $stat,
         $totalbill,
         $totalpaid,
      ];

      fputcsv($f, $lineData, $delimiter);
   }
   fseek($f, 0);

   header('Content-Type: text/xls');

   header('Content-Disposition: attachment; filename="' . $filename . '";');

   fpassthru($f);
}

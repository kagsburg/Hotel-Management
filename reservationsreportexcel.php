<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
} else {
    $st = $_GET['start'];
    $en = $_GET['end'];
    $start = strtotime($_GET['start']);
    $end = strtotime($_GET['end']);

    $delimiter = ",";

    $filename = "Reservations report from " . date('d/m/Y', $start) . " to " . date('d/m/Y', $end) . ".csv";

    $f = fopen('php://memory', 'w');
    fwrite($f, "sep=,\n");

    $fields = [
        "Guest",
        "Room Number",
        "No. Occupants",
        "Origin",
        "Business",
        "Check In",
        "Check Out",
        "Charge",
        "Amount paid",
        "Status",
    ];

    fputcsv($f, $fields, $delimiter);

    $dtotalcharge = 0;
    $totaladvance = 0;
    $reservations = mysqli_query($con, "SELECT * FROM reservations WHERE timestamp>='$start' AND timestamp<='$end' AND status IN(0,1,2)");
    function getForexConvertedAmount($currencyrate, $amount)
    {
        return intval($amount) * floatval($currencyrate);
    }

    while ($row =  mysqli_fetch_array($reservations)) {
        // $row =  mysqli_fetch_array($reservations);

        $reserve_id = $row['reservation_id'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $checkin = $row['checkin'];
        $phone = $row['phone'];
        $checkout = $row['checkout'];
        $room_id = $row['room'];
        $email = $row['email'];
        $adults = $row['adults'] ?? 0;
        $kids = $row['kids'] ?? 0;
        $business = $row['business'];
        $origin = $row['origin'];
        $status = $row['status'];
        $creator = $row['creator'];
        $status = $row['status'];
        $charge = $row['charge'];
        $advance = $row['advance'];


        if ($status == 2) {
            $checkedouts = mysqli_query($con, "SELECT * FROM checkoutdetails WHERE reserve_id='$reserve_id'");
            $row2 = mysqli_fetch_array($checkedouts);
            // $checkoutdetails_id = $row2['checkoutdetails_id'];
            // $reserve_id = $row2['reserve_id'];
            $paidamount = $row2['paidamount'] ?? 0;
            $totalbill = $row2['totalbill'] ?? 0;
        } else {
            $getpayments = mysqli_query($con, "SELECT SUM(amount) AS totalpaid FROM payments WHERE reservation_id='$reserve_id'");
            $payrow = mysqli_fetch_array($getpayments);
            $paidamount = $payrow['totalpaid'];
        }
        $checkout = $row['checkout'];
        $actualcheckout = $row['actualcheckout'];
        $reduction = $row['reduction'];
        $room_id = $row['room'];
        $email = $row['email'];
        $status = $row['status'];
        $adults = $row['adults'];
        $country = $row['origin'];
        $creator = $row['creator'];

        $currency = $row['currency'];
        $currencyrate = 1;
        if (!empty($currency) && $currency !== "USD") {
            $getcurrencies = mysqli_query($con, "SELECT * FROM rates WHERE currency='$currency' AND status='1'");
            $curow = mysqli_fetch_array($getcurrencies);
            $currencyrate = $curow["rate"];
        }

        if ($status == 2) {
            $nights = round(($actualcheckout - $checkin) / (3600 * 24));
        } else {
            $nights =  round(($checkout - $checkin) / (3600 * 24));
        }

        $getnumber = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
        $row1 =  mysqli_fetch_array($getnumber);
        $roomnumber = $row1['roomnumber'];
        $type_id = $row1['type'];

        $roomtypes = mysqli_query($con, "SELECT * FROM roomtypes WHERE roomtype_id='$type_id'");
        $row1 =  mysqli_fetch_array($roomtypes);
        $roomtype = $row1['roomtype'];
        $dollarCharge =  $row1['charge'];
        $charge = getForexConvertedAmount($currencyrate, $dollarCharge);

        $totalcharge = $dollarCharge * $nights;
        if (!empty($reduction))
            $totalcharge -= $reduction;
        $totalcharge = getForexConvertedAmount($currencyrate, $totalcharge);
        // $totalotherservices = 0;
        // $getotherservices = mysqli_query($con, "SELECT * FROM otherservices WHERE reservation_id='$reserve_id' AND status=1") or die(mysqli_error($con));
        // if (mysqli_num_rows($getotherservices) > 0) {
        //     while ($row3 = mysqli_fetch_array($getotherservices)) {
        //         $otherservice_id = $row3['otherservice_id'];
        //         $otherservice = $row3['otherservice'];
        //         $currency = $row3['currency'];
        //         if ($currency == 'USD') {
        //             $rate = $usdtariff;
        //         } else {
        //             $rate = 1;
        //         }
        //         $reduction = $row3['reduction'] * $rate;
        //         $price = $row3['price'] * $rate;
        //         $timestamp = $row3['timestamp'];
        //         $subtotal = $price - $reduction;
        //         $totalotherservices = $totalotherservices + $subtotal;
        //     }
        // }

        // $restbill = 0;
        // $restorder = mysqli_query($con, "SELECT * FROM orders WHERE guest='$reserve_id' AND status IN(1,2)");
        // if (mysqli_num_rows($restorder) > 0) {
        //     while ($row =  mysqli_fetch_array($restorder)) {
        //         $order_id = $row['order_id'];
        //         $guest = $row['guest'];
        //         $timestamp = $row['timestamp'];
        //         $totalcharges = mysqli_query($con, "SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
        //         $row =  mysqli_fetch_array($totalcharges);
        //         $totalrestcosts = getForexConvertedAmount(1, $row['totalcosts']);
        //         $restbill = $totalrestcosts + $restbill;
        //     }
        // }

        // $totallaundry = 0;
        // $laundry = mysqli_query($con, "SELECT * FROM laundry WHERE status='1' AND reserve_id='$reserve_id' ORDER BY timestamp");
        // if (mysqli_num_rows($laundry)) {
        //     while ($row =  mysqli_fetch_array($laundry)) {
        //         $laundry_id = $row['laundry_id'];
        //         $reserve_id = $row['reserve_id'];
        //         $clothes = $row['clothes'];
        //         $package_id = $row['package_id'];
        //         $timestamp = $row['timestamp'];
        //         $status = $row['status'];
        //         $creator = $row['creator'];
        //         $invoice_no = 23 * $reserve_id;
        //         $charge = getForexConvertedAmount(1, $row['charge']);
        //         $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
        //         $row2 =  mysqli_fetch_array($reservation);
        //         $firstname = $row2['firstname'];
        //         $lastname = $row2['lastname'];
        //         $room_id = $row2['room'];
        //         $phone = $row2['phone'];

        //         $getpackage = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1' AND laundrypackage_id='$package_id'");
        //         $row3 = mysqli_fetch_array($getpackage);
        //         $laundrypackage = $row3['laundrypackage'];
        //         $totallaundry = $totallaundry + $charge;
        //     }
        // }

        // $totalbill = $totallaundry + $restbill + $totalcharge + $totalotherservices;

        $advance = $paidamount;
        $dtotalcharge += $totalcharge;
        $totaladvance += $advance;

        $name = $firstname . ' ' . $lastname;
        $stat = "";
        if ($status == 0) {
            $stat =  'Pending';
        }
        if ($status == 1) {
            $stat =  'Guest In';
        }
        if ($status == 2) {
            $stat =  'Guest Out';
        }

        $lineData = [
            $name,
            $roomtype,
            $adults + $kids,
            $origin,
            $business,
            date('d/m/Y', $checkin),
            date('d/m/Y', $checkout),
            number_format($totalcharge),
            number_format($advance),
            $stat,
        ];

        fputcsv($f, $lineData, $delimiter);
    }
    fseek($f, 0);

    header('Content-Type: text/xls');

    header('Content-Disposition: attachment; filename="' . $filename . '";');

    fpassthru($f);
}

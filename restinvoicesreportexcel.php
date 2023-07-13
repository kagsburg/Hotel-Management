<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
} else {
    $st = $_GET['st'];
    $en = $_GET['en'];
    $at = $_GET['at'];
    $end = $en;
    $delimiter = ",";

    $filename = "Restaurant invoices report from" . date('d/m/Y', $st) . ".csv";

    $f = fopen('php://memory', 'w');

    $fields = array('Invoice Id', 'Date', 'Guest', 'Total Bill');

    fputcsv($f, $fields, $delimiter);
    $totalsells = 0;
    $totalcreditpaid = 0;
    $totalcreditbalance = 0;
    $totalbonus = 0;
    $totalcash = 0;
    $residentspaid = 0;
    $residentsunpaid = 0;
    $restorders = mysqli_query($con, "SELECT * FROM orders WHERE status IN (1, 2) AND timestamp>='$st' AND timestamp<='$end' AND creator='$at'");
    while ($row =  mysqli_fetch_array($restorders)) {
        $order_id = $row['order_id'];
        $guest = $row['guest'];
        $rtable = $row['rtable'];
        $vat = $row['vat'];
        $waiter = $row['waiter'];
        $status = $row['status'];
        $mode = $row['mode'];
        $timestamp = $row['timestamp'];
        $getyear = date('Y', $timestamp);
        $count = 1;
        $creator = $row['creator'];
        $beforeorders =  mysqli_query($con, "SELECT * FROM orders WHERE status IN (1,2)  AND  order_id<'$order_id'") or die(mysqli_error($con));
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
        $foodsordered =  mysqli_query($con, "SELECT * FROM restaurantorders WHERE order_id='$order_id' AND status=1");
        $roomnumber = '';
        if ($guest > 0) {
            $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$guest'");
            $row =  mysqli_fetch_array($reservation);
            $firstname1 = $row['firstname'];
            $lastname1 = $row['lastname'];
            $room_id = $row['room'];
            $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
            $row1 =  mysqli_fetch_array($roomtypes);
            $roomnumber = $row1['roomnumber'];
            $resident = $firstname1 . ' ' . $lastname1 . ' (' . $roomnumber . ')';
        } else {
            $resident = 'Non Resident';
        }
        $totaltax = 0;
        $totaltax = 0;
        $foodsordered =  mysqli_query($con, "SELECT * FROM restaurantorders WHERE order_id='$order_id' ");
        while ($row3 =  mysqli_fetch_array($foodsordered)) {
            $restorder_id = $row3['restorder_id'];
            $food_id = $row3['food_id'];
            $price = $row3['foodprice'];
            $quantity = $row3['quantity'];
            $tax = $row3['tax'];
            $subprice = $price * $quantity;
            if ($tax == 1) {
                $taxamount = ($subprice * $vat) / 110;
                $totaltax = $totaltax + $taxamount;
            } else {
                $taxamount = 0;
            }
        }
        $totalcharges = mysqli_query($con, "SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
        $row =  mysqli_fetch_array($totalcharges);
        $totalcosts = $row['totalcosts'];
        $net = $totaltax + $totalcosts;
        // echo number_format($net);
        if ($guest > 0) {
            $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$guest'");
            $rowg = mysqli_fetch_array($reservation);
            $status = $rowg['status'];
            if ($status == 2) {
                $residentspaid = $residentspaid + $net;
            } else {
                $residentsunpaid = $residentsunpaid + $net;
            }
        } else {
            if ($mode == 'Credit') {
                $checkcredit = mysqli_query($con, "SELECT * FROM creditpayments WHERE order_id='$order_id'") or die(mysqli_error($con));
                $rowc = mysqli_fetch_array($checkcredit);
                $cstatus = $rowc['status'];
                if ($cstatus == 0) {
                    $totalcreditbalance = $totalcreditbalance + $net;
                } else {
                    $totalcreditpaid = $totalcreditpaid + $net;
                }
            }
            if ($mode == 'Cash') {
                $totalcash = $totalcash + $net;
            }
            if ($mode == 'Bonus') {
                $totalbonus = $totalbonus + $net;
            }
        }
        $totalsells = $totalsells + $net;
        $total = ($totalsells - ($totalcreditbalance + $residentsunpaid));

        $lineData = array($invoice_no, date('d/m/Y', $timestamp), $resident, number_format($net));

        fputcsv($f, $lineData, $delimiter);
    }
    $lineData = array('TOTAL SELL', '', '', number_format($totalsells));
    fputcsv($f, $lineData, $delimiter);
    $lineData = array('TOTAL CASH', '', '', number_format($totalcash));
    fputcsv($f, $lineData, $delimiter);
    $lineData = array('TOTAL BONUS', '', '', number_format($totalbonus));
    fputcsv($f, $lineData, $delimiter);
    $lineData = array('TOTAL CREDIT PAID', '', '', number_format($totalcreditpaid));
    fputcsv($f, $lineData, $delimiter);
    $lineData = array('RESIDENTS BILLS PAID', '', '', number_format($residentspaid));
    fputcsv($f, $lineData, $delimiter);
    $lineData = array('TOTAL CREDIT UNPAID', '', '', number_format($totalcreditbalance));
    fputcsv($f, $lineData, $delimiter);
    $lineData = array('RESIDENTS BILLS UNPAID', '', '', number_format($residentsunpaid));
    fputcsv($f, $lineData, $delimiter);
    $lineData = array('TOTAL', '', '', number_format($total));
    fputcsv($f, $lineData, $delimiter);
    fseek($f, 0);

    header('Content-Type: text/xls');

    header('Content-Disposition: attachment; filename="' . $filename . '";');

    fpassthru($f);
}

<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
?>
<!DOCTYPE html>
<html>

<head>
    <style type="text/css" media="print">
        @page {
            size: auto;
            /* auto is the initial value */
            margin: 0;
            /* this affects the margin in the printer settings */
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>All Guests In</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/guestsinprint.php';
    } else {
    ?>
        <div class="wrapper wrapper-content p-xl">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-sm-2"><img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive"></div>
                    <div class="col-sm-4">
                        <address>
                            <h3></h3>
                            <strong><?php echo $hotelname; ?></strong><br>
                            <?php echo $hoteladdress; ?><br>
                            <strong>NIF : </strong><?php echo $nif; ?><br />
                            <strong>P : </strong><?php echo $hotelcontacts; ?><br />
                        </address>

                    </div>



                </div>
                <h1 class="text-center">All Guests In</h1>
                <div class="table-responsive m-t">

                    <table class="table invoice-table table-bordered">
                        <thead>
                            <tr>
                                <th>Guest</th>
                                <th>Room Number</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Adults</th>
                                <th>Children</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $reservations = mysqli_query($con, "SELECT * FROM reservations WHERE checkout>'$timenow' AND status='1' ORDER BY reservation_id DESC");
                            while ($row =  mysqli_fetch_array($reservations)) {
                                $reservation_id = $row['reservation_id'];
                                $firstname = $row['firstname'];
                                $lastname = $row['lastname'];
                                $checkin = $row['checkin'];
                                $phone = $row['phone'];
                                $checkout = $row['checkout'];
                                $room_id = $row['room'];
                                $adults = $row['adults'];
                                $nationality = $row['nationality'];
                                $kids = $row['kids'];

                            ?>

                                <tr class="gradeA">
                                    <td><?php echo $firstname . ' ' . $lastname; ?></td>

                                    <td class="center">
                                        <?php
                                        $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                        $row1 =  mysqli_fetch_array($roomtypes);
                                        $roomtype = $row1['roomnumber'];
                                        echo $roomtype; ?>
                                    </td>
                                    <td><?php echo date('d/m/Y', $checkin); ?></td>
                                    <td><?php echo date('d/m/Y', $checkout); ?></td>
                                    <td class="center"> <?php echo $adults; ?> </td>
                                    <td> <?php echo $kids; ?>
                                    </td>


                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div><!-- /table-responsive -->



                <div class="well m-t">
                    <strong style="font-style: italic">@<?php echo date('Y', $timenow); ?> All Rights Reserved To <?php echo $hotelname; ?><strong>
                </div>

                <?php
                $empid = $_SESSION['emp_id'];
                $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$empid'");
                $row = mysqli_fetch_array($employee);
                // $employee_id = $row['employee_id'];
                $fullname = $row['fullname'] ?? "";
                ?>
                <table class="table invoice-total">
                    <tbody>
                        <tr>
                            <td style="padding-bottom: 50px;"><strong>Created by <?php echo $fullname; ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    <?php } ?>
    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>
<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login.php');
}
?>
<!DOCTYPE html>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?djddjjd" rel="stylesheet">
    <link href="css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">

    <script src='js/plugins/fullcalendar/moment.min.js'></script>
    <script src="js/jquery-1.10.2.js"></script>
    <script src='js/plugins/fullcalendar/jquery-ui.custom.min.js'></script>
    <script src='js/plugins/fullcalendar/fullcalendar.min.js'></script>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script>
        $(document).ready(function() {
            /* initialize the external events
            -----------------------------------------------------------------*/
            $.ajax({
                url: 'getbookings.php',
                type: 'POST',
                data: 'type=fetch',
                async: false,
                success: function(response) {
                    json_events = response;
                }
            });
            /* initialize the calendar
            -----------------------------------------------------------------*/
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                buttonIcons: false, // show the prev/next text
                weekNumbers: true,
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events

                events: JSON.parse(json_events)
            });


        });
    </script>
    <style>
        .fc-event-title {
            color: #fff;
        }
    </style>
</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/index.php';
    } else {
    ?>
        <div id="wrapper">

            <?php include 'nav.php'; ?>
            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

                        </div>
                        <ul class="nav navbar-top-links navbar-right">


                            <li>
                                <a href="logout">
                                    <i class="fa fa-sign-out"></i> Log out
                                </a>
                            </li>
                        </ul>

                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-9">
                        <h2>Dashboard</h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>

                        </ol>
                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <?php
                        if (($level == 1) || ($role == 'Restaurant Attendant')) {
                        ?>
                            <div class="col-lg-4">
                                <div class="widget style1 lazur-bg">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <i class="fa fa-cutlery fa-5x"></i>
                                        </div>
                                        <div class="col-xs-8 text-right">
                                            <span>Restaurant orders Today</span>
                                            <h2 class="font-bold"> <?php
                                                                    $today = mysqli_query($con, "SELECT * FROM orders WHERE round(($timenow-timestamp)/(3600*24))+1=1");
                                                                    echo mysqli_num_rows($today);
                                                                    ?>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        if (($level == 1) || ($role == 'Receptionist') || ($role == 'Marketing and Events')) {
                        ?>
                            <div class="col-lg-4">
                                <div class="widget style1 navy-bg">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <i class="fa fa-building-o fa-5x"></i>
                                        </div>
                                        <div class="col-xs-8 text-right">
                                            <span>Reservations Made Today</span>
                                            <h2 class="font-bold">
                                                <?php
                                                $today = mysqli_query($con, "SELECT * FROM reservations WHERE round(($timenow-timestamp)/(3600*24))+1=1");
                                                echo mysqli_num_rows($today);
                                                ?>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        if (($level == 1) || ($role == 'Hall Attendant')|| ($role == 'Marketing and Events')) {
                        ?>
                            <div class="col-lg-4">
                                <div class="widget style1 yellow-bg">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <i class="fa fa-money fa-5x"></i>
                                        </div>
                                        <div class="col-xs-8 text-right">
                                            <span>Hall Bookings Today</span>
                                            <h2 class="font-bold">
                                                <?php
                                                $reservations = mysqli_query($con, "SELECT * FROM hallreservations WHERE status!='0' AND round(($timenow-timestamp)/(3600*24))+1=1   ORDER BY hallreservation_id DESC");
                                                echo mysqli_num_rows($reservations);
                                                ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                    <?php

                    if (($level == 1) || ($role == 'Receptionist')|| ($role == 'Marketing and Events')) {
                    ?>
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">

                                        <h5>Booking Schedule</h5>

                                    </div>
                                    <div class="ibox-content">
                                        <div id='calendar'></div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>



</body>

</html>
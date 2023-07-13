<?php
include 'includes/conn.php';

if (!isset($_SESSION['hotelsys'])) {
    header('Location:login.php');
}
?>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Costs | Hotel Manager</title>
    <script src="ckeditor/ckeditor.js"></script>
    <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">



    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">



    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">


    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/costs.php';
    } else {
    ?>
        <div id="wrapper">

            <?php include 'nav.php'; ?>
            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
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
                    <div class="col-lg-10">
                        <h2>Hotel Expenses</h2>
                        <ol class="breadcrumb">
                            <li> <a href="index.php"><i class="fa fa-home"></i> Home</a> </li>
                            <li>
                                <a href="costs">Expenses</a>
                            </li>
                            <li class="active">
                                <strong>Hotel Expenses</strong>
                            </li>
                        </ol>
                    </div>

                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="widget style1 lazur-bg">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-home fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span>Expenses Incurred Today</span>
                                        <h2 class="font-bold">
                                            <?php
                                            $today = mysqli_query($con, "SELECT COALESCE(SUM(amount), 0) AS todaycosts FROM costs WHERE status='1' AND round(($timenow-date)/(3600*24))+1=1");
                                            $row =  mysqli_fetch_array($today);
                                            $today = $row['todaycosts'];
                                            echo $today;
                                            ?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="widget style1 navy-bg">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-home fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span>Expenses Incurred In Past 7 days</span>
                                        <h2 class="font-bold">
                                            <?php
                                            $week = mysqli_query($con, "SELECT COALESCE(SUM(amount),0) AS weekcosts FROM costs WHERE status='1' AND round(($timenow-date)/(3600*24))<=7");
                                            $row =  mysqli_fetch_array($week);
                                            $week = $row['weekcosts'];
                                            echo $week;
                                            ?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="widget style1 red-bg">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <i class="fa fa-home fa-5x"></i>
                                    </div>
                                    <div class="col-xs-8 text-right">
                                        <span>Expenses Incurred in Past 30 Days</span>
                                        <h2 class="font-bold">
                                            <?php
                                            $month = mysqli_query($con, "SELECT COALESCE(SUM(amount),0) AS monthcosts FROM costs WHERE status='1' AND round(($timenow-date)/(3600*24))<=30");
                                            $row =  mysqli_fetch_array($month);
                                            $month = $row['monthcosts'];
                                            echo $month;
                                            ?>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">

                                    <h5>Hotel Expenses</h5>
                                    <a href="costsprint" target="_blank" class="btn btn-sm btn-warning pull-right"><i class="fa fa-print"></i> Print PDF</a>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $costs = mysqli_query($con, "SELECT * FROM costs WHERE status='1'") or die(mysqli_errno($con));
                                    if (mysqli_num_rows($costs) > 0) {
                                    ?>
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>

                                                <tr>
                                                    <th>Item</th>
                                                    <th>Cost</th>
                                                    <th>Department</th>
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                    <th>Added By</th>
                                                    <th>Action</th>
                                                </tr>

                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row = mysqli_fetch_array($costs)) {
                                                    $cost_id = $row['cost_id'];
                                                    $cost_item = $row['cost_item'];
                                                    $amount = $row['amount'];
                                                    $date = $row['date'];
                                                    $creator = $row['creator'];
                                                    $description = $row['description'];
                                                    $department_id = $row['department_id'];
                                                    $getdept =  mysqli_query($con, "SELECT * FROM departments WHERE status=1 AND department_id='$department_id'");
                                                    $row2 = mysqli_fetch_array($getdept);
                                                    $department = $row2['department'] ?? "";
                                                ?>
                                                    <tr class="gradeA">
                                                        <td><?php echo $cost_item; ?></td>
                                                        <td><?php echo $amount; ?> </td>
                                                        <td><?php echo $department; ?> </td>
                                                        <td><?php echo date('d/m/Y', $date); ?> </td>
                                                        <td><?php echo $description; ?></td>
                                                        <td>
                                                            <div class="tooltip-demo">
                                                                <?php
                                                                $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                                                                $row = mysqli_fetch_array($employee);
                                                                // $employee_id = $row['employee_id'];
                                                                $fullname = $row['fullname'] ?? "";
                                                                echo $fullname; ?> </div>
                                                        </td>
                                                        <td>
                                                            <a href="editcost?id=<?php echo $cost_id; ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
                                                            <a href="hidecost?id=<?php echo $cost_id; ?>" class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $cost_id; ?>()"><i class="fa fa-delete"></i>Remove</a>
                                                            <script type="text/javascript">
                                                                function confirm_delete<?php echo $cost_id; ?>() {
                                                                    return confirm('You are about To Remove this Item. Are you sure you want to proceed?');
                                                                }
                                                            </script>
                                                        </td>

                                                    </tr> <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class="alert alert-danger">No Expenses Incurred yet</div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>




                    </div>
                <?php } ?>
                <!-- Mainly scripts -->
                <script src="js/jquery-1.10.2.js"></script>
                <script src="js/bootstrap.min.js"></script>

                <!-- Custom and plugin javascript -->
                <script src="js/inspinia.js"></script>
                <script src="js/plugins/pace/pace.min.js"></script>

                <!-- Chosen -->
                <script src="js/plugins/chosen/chosen.jquery.js"></script>

                <!-- Input Mask-->
                <!--<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>-->

                <!-- Data picker -->
                <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

                <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
                <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
                <!-- iCheck -->
                <!--<script src="js/plugins/iCheck/icheck.min.js"></script>-->

                <!-- MENU -->
                <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
                <script>
                    $(document).ready(function() {

                        $('#data_1 .input-group.date').datepicker({
                            todayBtn: "linked",
                            keyboardNavigation: false,
                            forceParse: false,
                            calendarWeeks: true,
                            autoclose: true,
                            format: "dd/mm/yyyy",
                        });
                        $('.dataTables-example').dataTable();

                        /* Init DataTables */
                        var oTable = $('#editable').dataTable();

                        /* Apply the jEditable handlers to the table */
                        oTable.$('td').editable('http://webapplayers.com/example_ajax.php', {
                            "callback": function(sValue, y) {
                                var aPos = oTable.fnGetPosition(this);
                                oTable.fnUpdate(sValue, aPos[0], aPos[1]);
                            },
                            "submitdata": function(value, settings) {
                                return {
                                    "row_id": this.parentNode.getAttribute('id'),
                                    "column": oTable.fnGetPosition(this)[2]
                                };
                            },

                            "width": "90%"
                        });
                    });
                </script>

</body>


</html>
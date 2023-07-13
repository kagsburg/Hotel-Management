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

    <title>Add Expense | Hotel Manager</title>
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
        include 'fr/addcost.php';
    } else {
    ?>

        <div id="wrapper">

            <?php
            include 'nav.php';
            ?>

            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

                        </div>
                        

                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Add Hotel Expense</h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>
                            <li>
                                <a href="costs">Expenses</a>
                            </li>
                            <li class="active">
                                <strong>Add Expense</strong>
                            </li>
                        </ol>
                    </div>

                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">

                        <div class="col-lg-8">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">

                                    <h5>Add Hotel Expense<small>Ensure to fill all necessary fields</small></h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    include_once 'includes/thumbs3.php';
                                    if (isset($_POST['item'], $_POST['amount'], $_POST['date'])) {
                                        if ((empty($_POST['item'])) || (empty($_POST['amount'])) || (empty($_POST['date'])) || (empty($_POST['department']))) {
                                            echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Fill All Fields To Proceed</div>';
                                        } else {
                                            $item =  mysqli_real_escape_string($con, trim($_POST['item']));
                                            $department = $_POST['department'];
                                            $amount =  mysqli_real_escape_string($con, trim($_POST['amount']));
                                            $description =  mysqli_real_escape_string($con, trim($_POST['description']));
                                            $time = mysqli_real_escape_string($con, $_POST['stt_time']);
                                            $datearr = explode("/", $_POST['date']);
                                            $date =  mysqli_real_escape_string($con, $_POST['date']);
                                            $date = strtotime("$date $time");

                                            mysqli_query($con, "INSERT INTO costs(cost_item,amount,date,department_id,description,creator,status) VALUES('$item','$amount','$date','$department','$description','" . $_SESSION['emp_id'] . "','1')") or die(mysqli_errno($con));

                                            echo '<div class="alert alert-success"><i class="fa fa-check"></i>Expense successfully added</div>';
                                        }
                                    }



                                    ?>
                                    <form method="post" class="form-horizontal" action='' name="form" enctype="multipart/form-data">
                                        <div class="form-group"><label class="col-sm-2 control-label">Item</label>

                                            <div class="col-sm-10"><input type="text" class="form-control" name='item' placeholder="Enter item" required='required'></div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Amount</label>

                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <span class="input-group-addon">TSHS</span><input type="text" class="form-control" name="amount" required="required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="">
                                            <label class="col-sm-2 control-label">Date</label>
                                            <div class="col-sm-10">
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="date" class="form-control" name="date">
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="form-group" >
                                            <label class="col-sm-2 control-label">Time</label>
                                            <div class="col-sm-10">
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="time" class="form-control" name="stt_time" placeholder="time" required="required" />
                                                </div>
                                            </div>                                            
                                        </div>
                                        

                                        <div class="form-group"><label class="col-sm-2 control-label">Department</label>

                                            <div class="col-sm-10">
                                                <select name="department" class="form-control">
                                                    <option value="" selected="selected"> Select ...</option>
                                                    <?php
                                                    $depts =  mysqli_query($con, "SELECT * FROM departments WHERE status=1");
                                                    while ($row = mysqli_fetch_array($depts)) {
                                                        $dept_id = $row['department_id'];
                                                        $dept = $row['department'];
                                                        $status = $row['status'];
                                                    ?>
                                                        <option value="<?php echo $dept_id; ?>"> <?php echo $dept; ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name='description' placeholder="Enter description"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <button class="btn btn-primary" name="submit" type="submit">Add Cost</button>
                                            </div>
                                        </div>
                                    </form>


                                </div>


                            </div>

                        </div>



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
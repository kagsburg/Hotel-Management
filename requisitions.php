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

    <title>Requisitions | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    if (false && (isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/requisitions.php';
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
                        <h2>Requisitions</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li class="active">
                                <strong>Requisitions</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>All Requisitions <small>Sort, search</small></h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $userclause = ($_SESSION['hotelsyslevel'] == 1) ? '' : 'AND user_id = ' . $_SESSION['emp_id'];
                                    $list = mysqli_query($con, "SELECT * FROM requisitions WHERE status IN (1,0) $userclause ORDER BY requisition_id DESC");
                                    if (mysqli_num_rows($list) > 0) {
                                    ?>
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Requisition id</th>
                                                    <th>Created On</th>
                                                    <th>Department</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row =  mysqli_fetch_array($list)) {
                                                    $requisition_id = $row['requisition_id'];
                                                    $status = $row['status'] == '1' ? 'Approved' : 'Pending';
                                                    $timestamp = $row['requisition_date'];
                                                    $user_id = $row['user_id'];
                                                    // get user details
                                                    $user = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM employees WHERE employee_id = $user_id"));
                                                    $designation = $user['designation'];
                                                    // get department details
                                                    $department = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM designations WHERE designation_id = $designation"));
                                                ?>

                                                    <tr class="gradeA">
                                                        <td><?php echo str_pad($requisition_id, 4, "0", STR_PAD_LEFT); ?></td>
                                                        <td><?php echo  $timestamp; ?></td>
                                                        <td> <?php echo $status; ?></td>
                                                        <td>
                                                            <a href="requisition?id=<?php echo $requisition_id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>Details</a>
                                                            <?php if ($status == 'Pending') { ?>
                                                                <a href="removerequisition?id=<?php echo $requisition_id; ?>" class="btn btn-danger btn-xs" onclick="return cdelete<?php echo $requisition_id; ?>()"><i class="fa fa-trash"></i>Remove</a>
                                                            <?php } ?>
                                                            <script type="text/javascript">
                                                                function cdelete<?php echo $requisition_id; ?>() {
                                                                    return confirm('You are about To Delete this item. Do you want to proceed?');
                                                                }
                                                            </script>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else{ ?>
                                        <!-- show requisition not found issue  -->
                                        <div class="alert alert-danger">
                                            <h3>No Requisitions Found</h3>
                                        </div>
                                    <?php } ?>
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
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('.dataTables-example').dataTable();

            /* Init DataTables */
            var oTable = $('#editable').dataTable();

            // /* Apply the jEditable handlers to the table */
            // oTable.$('td').editable('http://webapplayers.com/example_ajax.php', {
            //     "callback": function(sValue, y) {
            //         var aPos = oTable.fnGetPosition(this);
            //         oTable.fnUpdate(sValue, aPos[0], aPos[1]);
            //     },
            //     "submitdata": function(value, settings) {
            //         return {
            //             "row_id": this.parentNode.getAttribute('id'),
            //             "column": oTable.fnGetPosition(this)[2]
            //         };
            //     },

            //     "width": "90%"
            // });


        });

        function fnClickAddRow() {
            $('#editable').dataTable().fnAddData([
                "Custom row",
                "New row",
                "New row",
                "New row",
                "New row"
            ]);

        }
    </script>
</body>

</html>
<?php
include 'includes/conn.php';
include 'utils/services.php';
if (($_SESSION['hotelsyslevel'] != 1)){
    header('Location:login.php');
}
?>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Services | Hotel Manager</title>
    <script src="ckeditor/ckeditor.js"></script>
    <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/services.php';
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
                        <h2>Services</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>

                            <li class="active">
                                <strong>Services</strong>
                            </li>
                        </ol>
                    </div>

                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">


                        <div class="col-lg-10">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Services</h5>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-striped table-bordered table-hover" id="dtx1">

                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Service</th>
                                                <th>Price</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $services = get_all_services($pdo, 1);
                                            if (count($services) > 0) {
                                                foreach ($services as $row) {
                                                    $service_id = $row['service_id'];
                                                    $name = $row['service_name'];
                                                    $price = $row['service_price'];
                                                    // $sharecharge = $row['sharecharge'];
                                                    $status = $row['status'];
                                                   
                                            ?>
                                                    <tr class="gradeA">
                                                        <td><?php echo $service_id; ?></td>
                                                        <td><?php echo $name; ?></td>
                                                        <td><?php echo number_format($price); ?></td>                                                        

                                                        <td>
                                                            <?php
                                                            if ((false && $_SESSION['hotelsyslevel'] == 1)) {
                                                            ?>
                                                                <a href="editroomtype?id=<?php echo $service_id; ?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Edit</a>

                                                                <a href="hideroomtype?id=<?php echo $service_id; ?>" class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $service_id; ?>()"><i class="fa fa-arrow-down"></i>Remove</a>
                                                                <script type="text/javascript">
                                                                    function confirm_delete<?php echo $service_id; ?>() {
                                                                        return confirm('You are about To Perform  this Action. Are you sure you want to proceed?');
                                                                    }
                                                                </script>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>




                                        </tbody>
                                    </table>
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
                        $('#dtx1').dataTable({
                            "language": {
                                "emptyTable": "<p class='text-center pt-2'>No Room Types Added Yet</p>"
                            }
                        });

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
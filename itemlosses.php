<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != 'Store Attendant')) {
    header('Location:login.php');
}
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Item Losses | Hotel Manager</title>

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
        include 'fr/itemlossess.php';
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
                            <li><a href="logout">Logout</a> </li>
                        </ul>

                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Item Losses</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>


                            <li class="active">
                                <strong>View Losses</strong>
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
                                    <h5>All Losses<small>Sort, search</small></h5>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Reason</th>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                                <th>Added By</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $getitems = mysqli_query($con, "SELECT * FROM losseditems WHERE status=1");
                                            while ($product = mysqli_fetch_array($getitems)) {
                                                $itemloss_id = $product['itemloss_id'];
                                                $losseditem_id = $product["losseditem_id"];
                                                $item_id = $product["item_id"];
                                                $quantity = $product["quantity"];
                                                $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$item_id'");
                                                $row2 =  mysqli_fetch_array($stock);
                                                $stockitem1 = $row2['stock_item'];
                                                $list = mysqli_query($con, "SELECT * FROM itemlosses WHERE status=1 AND itemloss_id='$itemloss_id'");
                                                $row3 =  mysqli_fetch_array($list);
                                                $date = $row3['date'];
                                                $reason = $row3['reason'];

                                            ?>

                                                <tr class="gradeA">
                                                    <td><?php echo date('d/m/Y', $date); ?></td>
                                                    <td><?php echo $reason; ?></td>
                                                    <td><?php echo $stockitem1; ?></td>
                                                    <td><?php echo $quantity; ?></td>
                                                    <td>
                                                        <?php
                                                        $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$employee_id'");
                                                        $row = mysqli_fetch_array($employee);
                                                        $employee_id = $row['employee_id'];
                                                        $fullname = $row['fullname'];
                                                        echo $fullname; ?></td>
                                                    <td>

                                                        <a href="removelosseditem?id=<?php echo $losseditem_id; ?>" class="btn btn-danger btn-xs" onclick="return confirm_delete<?php echo $losseditem_id; ?>()"><i class="fa fa-trash-o"></i>Remove</a>
                                                    </td>
                                                </tr>
                                                <script type="text/javascript">
                                                    function confirm_delete<?php echo $losseditem_id; ?>() {
                                                        return confirm('You are about To Remove this item. Are you sure you want to proceed?');
                                                    }
                                                </script>
                                            <?php } ?>
                                        </tbody>
                                    </table>

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
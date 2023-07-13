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

    <title>Menu ITems | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/foodmenu.php';
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
                    <div class="col-lg-12">
                        <h2>Hotel Food Menu</h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>

                            <li class="active">
                                <strong>View Menu</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">

                        <div class="col-lg-12">
                        <a href="menuitemsexcel" class="btn btn-primary mb-2" target="_blank">EXPORT TO EXCEL</a>
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>All Main Menu Items <small>Sort, search</small></h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $menu = mysqli_query($con, "SELECT * FROM menuitems WHERE status=1 ORDER BY menuitem");
                                    if (mysqli_num_rows($menu) > 0) {

                                    ?>
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>Menu Item</th>
                                                    <th>Category</th>
                                                    <th>Type</th>
                                                    <th>Price</th>
                                                    <th>Taxed</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row =  mysqli_fetch_array($menu)) {
                                                    $menuitem_id = $row['menuitem_id'];
                                                    $menuitem = $row['menuitem'];
                                                    $itemprice = $row['itemprice'];
                                                    $type = $row['type'];
                                                    $taxed = $row['taxed'];
                                                    $category = $row['category'];
                                                    $menucategory = $row['menucategory'];
                                                    $status = $row['status'];
                                                    $creator = $row['creator'];
                                                    if (!empty($menucategory)) {
                                                        $getcat =  mysqli_query($con, "SELECT * FROM menucategories WHERE status=1 AND category_id='$menucategory'");
                                                        $row1 =  mysqli_fetch_array($getcat);
                                                        $categoryname = $row1['category'];
                                                    } else {
                                                        $categoryname = "";
                                                    }
                                                ?>

                                                    <tr class="gradeA">
                                                        <td><?php echo $menuitem; ?></td>
                                                        <td><?php echo $categoryname; ?></td>
                                                        <td><?php if ($type == 'drink') {
                                                                echo $type . ' (' . $category . ')';
                                                            } else {
                                                                echo $type;
                                                            } ?></td>
                                                        <td class="center">
                                                            <?php echo $itemprice; ?>
                                                        </td>
                                                        <td> <?php if ($taxed == 'yes') {
                                                                    echo $taxed;
                                                                } else {
                                                                    echo 'no';
                                                                } ?></td>
                                                        <td class="center">
                                                            <button data-toggle="modal" data-target="#products<?php echo $menuitem_id; ?>" class="btn btn-xs btn-success">Products</button>
                                                                
                                                                    
                                                            <a href="editmenuitem?id=<?php echo $menuitem_id; ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
                                                                    <?php
                                                                    if (($creator == $_SESSION['hotelsys']) || ($_SESSION['hotelsyslevel'] == 1)) {
                                                                        ?>
                                                                <a href="hideitem.php?id=<?php echo $menuitem_id . '&&status=' . $status; ?>" class="btn btn-danger  btn-xs" onclick="return confirm_delete<?php echo $menuitem_id; ?>()">Remove <i class="fa fa-arrow-up"></i></a>


                                                            <?php
                                                            }
                                                            ?>
                                                            <script type="text/javascript">
                                                                function confirm_delete<?php echo $menuitem_id; ?>() {
                                                                    return confirm('You are about To Remove this Item. Are you sure you want to proceed?');
                                                                }
                                                            </script>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    <?php } else { ?>
                                        <div class="alert alert-danger">No Menu Items Added Yet</div>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
        $menu = mysqli_query($con, "SELECT * FROM menuitems WHERE status=1 ORDER BY menuitem");
        while ($row =  mysqli_fetch_array($menu)) {
            $menuitem_id = $row['menuitem_id'];

        ?>
            <div id="products<?php echo $menuitem_id; ?>" class="modal fade" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Menu item contents</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>Item</td>
                                        <td>Unit</td>
                                        <td>Qty</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $products = mysqli_query($con, "SELECT * FROM menuitemproducts WHERE menuitem_id='$menuitem_id' AND status=1") or die(mysqli_error($con));
                                    while ($row = mysqli_fetch_array($products)) {
                                        $stockitem_id = $row['stockitem_id'];
                                        $quantity = $row['quantity'];
                                        $stockitem = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$stockitem_id'");
                                        $row1 =  mysqli_fetch_array($stockitem);
                                        $stockitem = $row1['stock_item'];
                                        $measurement = $row1['measurement'];
                                        $getmeasure =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
                                        $row2 =  mysqli_fetch_array($getmeasure);
                                        $measurement2 = $row2['measurement'];

                                    ?>
                                        <tr>
                                            <td><?php echo $stockitem; ?></td>
                                            <td><?php echo $measurement2; ?></td>
                                            <td><?php echo $quantity; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    <?php }
    } ?>
    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>
    <script src="js/plugins/chosen/chosen.jquery.js"></script>
    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
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
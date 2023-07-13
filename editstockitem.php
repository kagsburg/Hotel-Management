<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login.php');
}
$id = $_GET['id'];
?>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Stock Item | Hotel Manager</title>
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
        include 'fr/editstockitem.php';
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
                        <ul class="nav navbar-top-links navbar-right">
                            <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
                            <li><a href="switchlanguage?lan=en">English</a> </li>
                        </ul>

                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Edit Stock Item</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li>
                                <a href="stockitems">Stock</a>
                            </li>
                            <li class="active">
                                <strong>Edit Stock Item</strong>
                            </li>
                        </ol>
                    </div>

                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">

                        <div class="col-lg-7">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">

                                    <h5>Edit Stock Item<small> Ensure to fill all necessary fields</small></h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if (isset($_POST['item'], $_POST['measurement'])) {
                                        if ((empty($_POST['measurement'])) || (empty($_POST['item'])) || (empty($_POST['category']))) {
                                            echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Fill The Fields To Proceed</div>';
                                        } else {
                                            $measurement = $_POST['measurement'];
                                            $item =  mysqli_real_escape_string($con, trim($_POST['item']));
                                            $minstock =  mysqli_real_escape_string($con, trim($_POST['minstock']));
                                            $price =  mysqli_real_escape_string($con, trim($_POST['price']));
                                            $category =  mysqli_real_escape_string($con, trim($_POST['category']));
                                            mysqli_query($con, "UPDATE stock_items SET stock_item='$item',category_id='$category',minstock='$minstock',measurement='$measurement',price='$price' WHERE stockitem_id='$id'") or die(mysqli_error($con));
                                            echo '<div class="alert alert-success"><i class="fa fa-check"></i>Stock Item successfully Edited</div>';
                                        }
                                    }
                                    $stockitem = mysqli_query($con, "SELECT * FROM stock_items WHERE status=1 AND stockitem_id='$id'");
                                    $row =  mysqli_fetch_array($stockitem);
                                    $stockitem_id = $row['stockitem_id'];
                                    $cat_id = $row['category_id'];
                                    $stockitem = $row['stock_item'];
                                    $minstock = $row['minstock'];
                                    $price = $row['price'];
                                    $measurement = $row['measurement'];
                                    $status = $row['status'];
                                    $getmeasure =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
                                    $row2 =  mysqli_fetch_array($getmeasure);
                                    $measurement2 = $row2['measurement'];
                                    $getcat =  mysqli_query($con, "SELECT * FROM categories WHERE status=1 AND category_id='$cat_id'");
                                    $row1 =  mysqli_fetch_array($getcat);
                                    $category_id = $row1['category_id'];
                                    $category = $row1['category'];
                                    ?>
                                    <form method="post" class="form" action='' name="form" enctype="multipart/form-data">
                                        <div class="form-group"><label class="control-label">Item Name</label>
                                            <input type="text" class="form-control" name='item' placeholder="Enter item Name" required='required' value="<?php echo $stockitem; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Measurement</label>

                                            <select class="form-control" name='measurement'>
                                                <option value="<?php echo $measurement; ?>" selected="selected"><?php echo $measurement2; ?></option>
                                                <?php

                                                $measurements =  mysqli_query($con, "SELECT * FROM stockmeasurements");
                                                while ($row = mysqli_fetch_array($measurements)) {
                                                    $measure_id = $row['measurement_id'];
                                                    $measure = $row['measurement'];
                                                ?>
                                                    <option value="<?php echo $measure_id; ?>"><?php echo $measure; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Category</label>

                                            <select class="form-control" name='category'>
                                                <option value="<?php echo $cat_id; ?>" selected="selected"><?php echo $category; ?></option>

                                                <?php
                                                $getcats =  mysqli_query($con, "SELECT * FROM categories WHERE status=1");
                                                while ($row1 =  mysqli_fetch_array($getcats)) {
                                                    $category_id = $row1['category_id'];
                                                    $category = $row1['category'];
                                                ?>
                                                    <option value="<?php echo $category_id; ?>"><?php echo $category; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group"><label class="control-label">Minimum Stock</label>
                                            <input type="text" class="form-control" name='minstock' placeholder="Enter minimum" value="<?php echo $minstock; ?>">
                                        </div>
                                        <div class="form-group"><label class="control-label">Price</label>
                                            <input type="text" class="form-control" name='price' placeholder="Enter price" value="<?php echo $price; ?>">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary" name="submit" type="submit">Edit Item</button>
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
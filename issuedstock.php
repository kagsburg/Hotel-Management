<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login.php');
}
// get user's designation and then department 
$userid = $_SESSION['hotelsys'];
$getuser = mysqli_query($con, "SELECT * FROM users WHERE user_id='$userid'");
$rowu = mysqli_fetch_array($getuser);
$employe = $rowu['employee'];
// get user's designation 
$getdesignation = mysqli_query($con, "SELECT * FROM employees WHERE employee_id ='$employe' and status ='1'");
$row34 = mysqli_fetch_array($getdesignation);
$designation = $row34['designation'];
// get department id from designation
$getdepart= mysqli_query($con, "SELECT * FROM designations WHERE designation_id ='$designation' and status ='1'");
$row32 = mysqli_fetch_array($getdepart);
$department_id = $row32['department_id'];
// get user's department
$getdepartment = mysqli_query($con, "SELECT * FROM departments WHERE department_id ='$department_id' and status ='1'");
$row35 = mysqli_fetch_array($getdepartment);
$department = $row35['department_id'];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Stock Items | Hotel Manager</title>

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
        include 'fr/stockitems.php';
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
                        <h2>Stock Items</h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>

                            <li class="active">
                                <strong>View Stock Items</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="pull-right">
                                <!-- <a href="stockprintpreview" class="btn btn-sm btn-warning">Print Preview</a>
                                <a href="stockprint" target="_blank" class="btn btn-sm btn-warning">Print PDF</a>
                                <a href="stockcsv" class="btn btn-sm btn-primary">Export to Excel</a>
                                <a href="getstockreport" class="btn btn-sm btn-info">Get Report</a> -->
                            </div>
                            <br>
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>All Issued ITems <small>Sort, search</small></h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                                    $stock = mysqli_query($con, "SELECT * FROM issuedstock WHERE department_id='$department' and status=1");
                                    if (mysqli_num_rows($stock) > 0) {
                                    ?>
                                        <table class="table table-striped table-bordered table-hover dataTables-example">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Stock Item</th>
                                                    <th>Min Stock</th>
                                                    <th>In Stock</th>
                                                    <th>Weighted Price</th>
                                                    <th>Unit</th>
                                                    <th>Category</th>
                                                    <th>Stock Status</th>
                                                    <!-- <th>Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($rowa =  mysqli_fetch_array($stock)) {
                                                    $issuedstock_id =$rowa['issuedstock_id'];
                                                    // get issued items
                                                    $getissueditems = mysqli_query($con, "SELECT * FROM issueditems WHERE issuedstock_id='$issuedstock_id'  ") or die(mysqli_error($con));
                                                    if (mysqli_num_rows($getissueditems) > 0){
                                                        $rowi = mysqli_fetch_array($getissueditems);
                                                        
                                                        $stockitem_id = $rowi['item_id'];
                                                        // get stock item
                                                        $getstockitem = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$stockitem_id' and status =1") or die(mysqli_error($con));
                                                        if (mysqli_num_rows($getstockitem) > 0){
                                                        $row = mysqli_fetch_array($getstockitem);
                                                    $stockitem = $row['stock_item'];
                                                    $cat_id = $row['category_id'];
                                                    $minstock = $row['minstock'];
                                                    $price = $row['price'];
                                                    $measurement = $row['measurement'];
                                                    $status = $row['status'];
                                                    $wprice = $row['wprice'];
                                                    $getadded = mysqli_query($con, "SELECT SUM(quantity) as addedstock FROM stockitems WHERE item_id='$stockitem_id'") or die(mysqli_error($con));
                                                    $rowa = mysqli_fetch_array($getadded);
                                                    $addedstock = $rowa['addedstock'];
                                                    $getissued = mysqli_query($con, "SELECT SUM(quantity) as issuedstock FROM issueditems WHERE item_id='$stockitem_id'") or die(mysqli_error($con));
                                                    $rowi = mysqli_fetch_array($getissued);
                                                    $issuedstock = $rowi['issuedstock'];
                                                    $getlossed = mysqli_query($con, "SELECT SUM(quantity) as lossedstock FROM losseditems WHERE item_id='$stockitem_id'") or die(mysqli_error($con));
                                                    $rowl = mysqli_fetch_array($getlossed);
                                                    $lossedstock = $rowl['lossedstock'];                                                    
                                                    // $getkitchenitems = mysqli_query($con, "SELECT SUM(quantity) AS kitchenstock FROM kitchenstockitems  WHERE stockitem_id='$stockitem_id'") or die(mysqli_error($con));
                                                    // $rowc = mysqli_fetch_array($getkitchenitems);
                                                    // $totalconsumed = $rowc["kitchenstock"];
                                                        
                                                    
                                                    $stockleft = $addedstock - $issuedstock - $lossedstock;
                                                ?>
                                                    <tr class="gradeA">
                                                        <td><?php echo $stockitem_id; ?></td>
                                                        <td><?php echo $stockitem; ?></td>
                                                        <td><?php echo $minstock; ?></td>
                                                        <td><?php echo $stockleft; ?></td>
                                                        <td><?php echo number_format($wprice); ?></td>
                                                        <td>
                                                            <div class="tooltip-demo">
                                                                <?php
                                                                $getmeasure =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
                                                                $row2 =  mysqli_fetch_array($getmeasure);
                                                                $measurement2 = $row2['measurement'];
                                                                echo $measurement2; ?> </div>
                                                        </td>
                                                        <td><?php
                                                            if (isset($cat_id)) {
                                                                $getcat =  mysqli_query($con, "SELECT * FROM categories WHERE status=1 AND category_id='$cat_id'");
                                                                $row1 =  mysqli_fetch_array($getcat);
                                                                $category_id = $row1['category_id'];
                                                                $category = $row1['category'];
                                                                echo $category;
                                                            }
                                                            ?></td>
                                                        <th><?php if ($stockleft <= $minstock) {
                                                                echo '<div class="text-danger">LOW</div>';
                                                            } else {
                                                                echo '<div class="text-success">HIGH</div>';
                                                            } ?></th>
                                                        <!-- <td class="center">
                                                            <a href="itemdetails?id=<?php echo $stockitem_id; ?>" class="btn btn-info btn-xs"><i class="fa fa-plus"></i> Item Details</a>
                                                            <?php
                                                            if (($_SESSION['hotelsyslevel'] == 1)) {
                                                            ?>
                                                                <a href="editstockitem?id=<?php echo $stockitem_id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i> Edit</a>
                                                                <a href="removestockitem?id=<?php echo $stockitem_id; ?>" class="btn btn-danger btn-xs" onclick="return confirm_delete<?php echo $stockitem_id; ?>()"><i class="fa fa-trash-o"></i>Remove</a>
                                                                <script type="text/javascript">
                                                                    function confirm_delete<?php echo $stockitem_id; ?>() {
                                                                        return confirm('You are about To Remove this item. Are you sure you want to proceed?');
                                                                    }
                                                                </script>
                                                            <?php } ?>
                                                        </td> -->
                                                    </tr>
                                                <?php } }else {
                                                    echo '<div class="alert alert-warning">No Stock Items Found</div>';
                                                } 
                                            }?>
                                            </tbody>
                                        </table>
                                <?php } else {?>
                                    <div class="alert alert-danger">
                                        <p>No Stock Items Found</p>
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
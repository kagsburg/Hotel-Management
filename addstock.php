<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Stock - Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/addstock.php';
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
                        <h2>Add Stock</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="stockitems">Stock</a> </li>
                            <li class="active">
                                <strong>Add Stock</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content">

                    <div class="row">

                        <div class="col-lg-10">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Add New Stock <small>All fields marked (*) shouldn't be left blank</small></h5>

                                </div>

                                <div class="ibox-content">
                                    <?php
                                    if (isset($_POST['submit'])) {
                                        $date = mysqli_real_escape_string($con, strtotime($_POST['date']));
                                        if (empty($date)) {
                                            $errors[] = 'Date is required';
                                        }
                                        if ($timenow < $date) {
                                            $errors[] = 'Date should not be later';
                                        }
                                        if (!empty($errors)) {
                                            foreach ($errors as $error) {
                                                echo '<div class="alert alert-danger">' . $error . '</div>';
                                            }
                                        } else {
                                            $supplier = $_POST['supplier'];
                                            $item = $_POST['item'];
                                            $quantity = $_POST['quantity'];
                                            $price = $_POST['price'];
                                            mysqli_query($con, "INSERT INTO addedstock(date,admin_id,status) VALUES(UNIX_TIMESTAMP(),'" . $_SESSION['hotelsys'] . "',1)") or die(mysqli_errno($con));
                                            $last_id = mysqli_insert_id($con);
                                            $allproducts = sizeof($item);
                                            for ($i = 0; $i < $allproducts; $i++) {
                                                $activity = $fullname . ' added ' . $quantity[$i];
                                                mysqli_query($con, "INSERT INTO stockitems(item_id,quantity,addedstock_id,supplier_id,price,status) VALUES('$item[$i]','$quantity[$i]','$last_id','$supplier[$i]','$price[$i]',1)");
                                                mysqli_query($con, "INSERT INTO stockevents(item_id,activity,timestamp,status) VALUES('$item[$i]','$activity','$date','1')") or die(mysqli_error($con));
                                                
                                                $getprev = mysqli_query($con, "SELECT price FROM stockitems LEFT JOIN addedstock ON stockitem_id = item_id WHERE item_id='$item[$i]' ORDER BY date desc");
                                                $olditem = mysqli_fetch_array($getprev);
                                                $wprice = (($olditem["price"] ?? 0) + $price[$i]) / 2;
                                                mysqli_query($con, "UPDATE stock_items SET wprice='$wprice' WHERE stockitem_id='$item[$i]'") or die(mysqli_error($con));
                                            }
                                    ?>
                                            <div class="alert alert-success"><i class="fa fa-check"></i>Stock Successfully Added</div>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <form method="post" name='form' class="form" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="form-group col-lg-6"><label class="control-label">* Date </label>
                                                <input type="date" name="date" class="form-control" required="required" max="<?php echo date('Y-m-d', $timenow); ?>">
                                            </div>
                                        </div>
                                        <div class='subobj'>
                                            <div class='row'>
                                                <div class="form-group col-lg-6"><label class="control-label">* Product </label>
                                                    <select data-placeholder="Choose item..." name="item[]" class="chosen-select" style="width:100%;" tabindex="2">
                                                        <option value="" selected="selected">choose item..</option>
                                                        <?php
                                                        $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE status=1");
                                                        while ($row =  mysqli_fetch_array($stock)) {
                                                            $stockitem_id = $row['stockitem_id'];
                                                            $cat_id = $row['category_id'];
                                                            $stockitem = $row['stock_item'];
                                                            $minstock = $row['minstock'];
                                                            $measurement = $row['measurement'];
                                                            $status = $row['status'];
                                                            $getmeasure =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
                                                            $row2 =  mysqli_fetch_array($getmeasure);
                                                            $measurement2 = $row2['measurement'];
                                                        ?>
                                                            <option value="<?php echo $stockitem_id; ?>"><?php echo $stockitem . ' (' . $measurement2 . ')'; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-5"><label class="control-label">Quantity</label>
                                                    <input type="text" name='quantity[]' class="form-control" placeholder="Enter Quantity">
                                                </div>

                                                <div class="form-group col-lg-1">
                                                    <a href='#' class="subobj_button btn btn-success" style="margin-top:25px">+</a>
                                                </div>
                                                <div class="form-group col-lg-6"><label class="control-label">Supplier</label>
                                                    <select data-placeholder="Choose supplier..." name="supplier[]" class="chosen-select" style="width:100%;" tabindex="2">
                                                        <option value="" selected="selected">choose supplier..</option>
                                                        <?php
                                                        $suppliers =  mysqli_query($con, "SELECT * FROM suppliers WHERE status=1") or die(mysqli_error($con));
                                                        while ($row =  mysqli_fetch_array($suppliers)) {
                                                            $supplier_id = $row['supplier_id'];
                                                            $suppliername = $row['suppliername'];
                                                            $email = $row['email'];
                                                        ?>
                                                            <option value="<?php echo $supplier_id; ?>"><?php echo $suppliername; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-6"><label class="control-label">Price</label>
                                                    <input type="number" name='price[]' class="form-control" placeholder="Enter Unit Price" step="0.0001">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-success" type="submit" name="submit">Add Stock</button>
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
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/chosen/chosen.jquery.js"></script>
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <!-- iCheck -->
    <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>

</html>
<script type="text/javascript">
    $('.dataTables-example').dataTable();
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {
            allow_single_deselect: true
        },
        '.chosen-select-no-single': {
            disable_search_threshold: 10
        },
        '.chosen-select-no-results': {
            no_results_text: 'Oops, nothing found!'
        },
        '.chosen-select-width': {
            width: "95%"
        }
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
    $('.subobj_button').click(function(e) { //on add input button click
        e.preventDefault();
        $('.subobj').append('<div class="row"><div class="col-lg-12"><hr style="border-top: dashed 1px #b7b9cc;"></div><div class="col-lg-11"><div class="row"> <div class="form-group col-lg-6"><label class="control-label">* Product</label>   <select data-placeholder="Choose item..." name="item[]" class="chosen-select" style="width:100%;" tabindex="2">     <option value="" selected="selected">choose item..</option>       <?php $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE status=1");
                                                                                                                                                                                                                                                                                                                                                                                                                                        while ($row =  mysqli_fetch_array($stock)) {
                                                                                                                                                                                                                                                                                                                                                                                                                                            $stockitem_id = $row['stockitem_id'];
                                                                                                                                                                                                                                                                                                                                                                                                                                            $stockitem = preg_replace('/[^a-zA-Z0-9\-]/', ' ', $row['stock_item']);
                                                                                                                                                                                                                                                                                                                                                                                                                                            $measurement = $row['measurement'];
                                                                                                                                                                                                                                                                                                                                                                                                                                            $getmeasure =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
                                                                                                                                                                                                                                                                                                                                                                                                                                            $row2 =  mysqli_fetch_array($getmeasure);
                                                                                                                                                                                                                                                                                                                                                                                                                                            $measurement2 = $row2['measurement'];              ?>      <option value="<?php echo $stockitem_id; ?>"><?php echo $stockitem . ' (' . $measurement2 . ')'; ?></option>               <?php } ?>            </select></div><div class="form-group col-lg-6"><label class="control-label">* Quantity</label>  <input type="number" name="quantity[]" class="form-control" placeholder="Enter Quantity" required="required">  </div>                   <div class="form-group col-lg-6"><label class="control-label">Supplier</label> <select data-placeholder="Choose supplier..." name="supplier[]" class="chosen-select" style="width:100%;" tabindex="2">  <option value="" selected="selected">choose supplier..</option>         <?php $suppliers =  mysqli_query($con, "SELECT * FROM suppliers WHERE status=1") or die(mysqli_error($con));
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            while ($row =  mysqli_fetch_array($suppliers)) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $supplier_id = $row['supplier_id'];
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $suppliername = $row['suppliername'];
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $email = $row['email'];     ?>   <option value="<?php echo $supplier_id; ?>"><?php echo $suppliername; ?></option>   <?php } ?>              </select>     </div> <div class="form-group col-lg-6"><label class="control-label">Price</label><input type="number" name="price[]" class="form-control" placeholder="Enter Unit Price" step="0.0001"></div></div> </div> <button class="remove_subobj  btn btn-danger" style="height:30px;margin-top:22px"><i class="fa fa-minus"></i></button></div>'); //add input box
        var config = {
            '.chosen-select': {},
            '.chosen-select-deselect': {
                allow_single_deselect: true
            },
            '.chosen-select-no-single': {
                disable_search_threshold: 10
            },
            '.chosen-select-no-results': {
                no_results_text: 'Oops, nothing found!'
            },
            '.chosen-select-width': {
                width: "95%"
            }
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    });
    $('.subobj').on("click", ".remove_subobj", function(e) { //user click on remove text
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });
</script>
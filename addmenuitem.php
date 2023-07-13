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

    <title>Add Menu ITem | Hotel Manager</title>

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
        include 'fr/addmenuitem.php';
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
                            <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
                            <li><a href="switchlanguage?lan=en">English</a> </li>
                        </ul>

                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-12">
                        <h2>Add Menu Item</h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>
                            <li>
                                <a href="foodmenu">Menu Items</a>
                            </li>
                            <li class="active">
                                <strong>Add Menu ITem</strong>
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
                                    <h5>Add New Menu Item <small>Sort, search</small></h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    //                            include_once 'includes/thumbs3.php';
                                    if (isset($_POST['item'], $_POST['price'])) {
                                        $item =  mysqli_real_escape_string($con, trim($_POST['item']));
                                        $itemtype = mysqli_real_escape_string($con, trim($_POST['itemtype']));
                                        $category = mysqli_real_escape_string($con, trim($_POST['category']));
                                        $menucategory = mysqli_real_escape_string($con, trim($_POST['menucategory']));
                                        $price =  mysqli_real_escape_string($con, trim($_POST['price']));
                                        if (isset($_POST['taxed'])) {
                                            $taxed = $_POST['taxed'];
                                        } else {
                                            $taxed = 'no';
                                        }
                                        $stockitems = $_POST['stockitems'];
                                        $quantity = $_POST['quantity'];
                                        if ((empty($_POST['item'])) || (empty($_POST['price'])) || (empty($_POST['menucategory'])) || (empty($_POST['itemtype']))) {
                                            echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Enter all fields  To Proceed</div>';
                                        } else  if (is_numeric($price) == FALSE) {
                                            echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Price Should Be An Integer</div>';
                                        } else {

                                            mysqli_query($con, "INSERT INTO menuitems(menuitem,itemprice,type,taxed,category,menucategory,creator,status) VALUES('$item','$price','$itemtype','$taxed','$category','$menucategory','" . $_SESSION['emp_id'] . "','1')") or die(mysqli_error($con));
                                            $last_id = mysqli_insert_id($con);
                                            $allproducts = sizeof($stockitems);
                                            for ($i = 0; $i < $allproducts; $i++) {
                                                mysqli_query($con, "INSERT INTO menuitemproducts(stockitem_id,menuitem_id,quantity,status) VALUES('$stockitems[$i]','$last_id','$quantity[$i]',1)") or die(mysqli_error($con));
                                            }
                                            echo '<div class="alert alert-success"><i class="fa fa-check"></i>Menu Item successfully added</div>';
                                        }
                                    }

                                    ?>
                                    <form method="post" class="form" action='' name="form" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="form-group col-lg-6"><label class="control-label">Menu Item</label>
                                                <input type="text" class="form-control" name='item' placeholder="Enter item name" required='required'>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="control-label">Menu Category</label>
                                                <select name="menucategory" class="form-control itemtype">
                                                    <option value="" selected="selected">Select Category</option>
                                                    <?php
                                                    $getcats =  mysqli_query($con, "SELECT * FROM menucategories WHERE status=1");
                                                    while ($row1 =  mysqli_fetch_array($getcats)) {
                                                        $category_id = $row1['category_id'];
                                                        $category = $row1['category'];
                                                    ?>
                                                        <option value="<?php echo $category_id; ?>"><?php echo $category; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="control-label">Item Type</label>
                                                <select name="itemtype" class="form-control itemtype">
                                                    <option value="" selected="selected">Select Type</option>
                                                    <option value="food">food</option>
                                                    <option value="drink">drink</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6 drinkcategory" style="display: none">
                                                <label class="control-label">Drink Category</label>
                                                <select name="category" class="form-control">
                                                    <option value="" selected="selected">Select Category</option>
                                                    <option value="local">Local Drink</option>
                                                    <option value="imported">Imported Drink</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-lg-6"><label class="control-label">Price</label>
                                                <input name="price" class="form-control" placeholder="Enter item price" type="number" step="0.0001">
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="yes" name="taxed">
                                                    <label class="form-check-label" for="defaultCheck1">
                                                        Is item Taxed?
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='subobj'>
                                            <h3>Add Menu Item Contents</h3>
                                            <div class='row'>
                                                <div class="form-group col-lg-6"><label class="control-label">* Stock Item </label>
                                                    <select data-placeholder="Choose item..." name="stockitems[]" class="chosen-select" style="width:100%;" tabindex="2">
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
                                                    <input type="number" name='quantity[]' class="form-control" placeholder="Enter Quantity" step="0.00001">
                                                </div>

                                                <div class="form-group col-lg-1">
                                                    <a href='#' class="subobj_button btn btn-success" style="margin-top:25px">+</a>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-sm" name="submit" type="submit">Add item</button>
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

    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>
    <script src="js/plugins/chosen/chosen.jquery.js"></script>
    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script>
        $('.itemtype').on('change', function() {
            var getoption = $(this).val();
            if (getoption === 'drink') {
                $('.drinkcategory').show();
            } else {
                $('.drinkcategory').hide();
            }
        });
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
            <?php
            if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {  ?>
                $('.subobj').append('<div class="row"><div class="col-lg-12"><hr style="border-top: dashed 1px #b7b9cc;"></div><div class="col-lg-11"><div class="row"> <div class="form-group col-lg-6"><label class="control-label">* Article en stock</label>   <select data-placeholder="Choisissez l article..." name="stockitems[]" class="chosen-select" style="width:100%;" tabindex="2">     <option value="" selected="selected">Choisissez l article..</option>       <?php $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE status=1");
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    while ($row =  mysqli_fetch_array($stock)) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $stockitem_id = $row['stockitem_id'];
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $stockitem = preg_replace('/[^a-zA-Z0-9\-]/', ' ', $row['stock_item']);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $measurement = $row['measurement'];
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $getmeasure =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $row2 =  mysqli_fetch_array($getmeasure);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        $measurement2 = $row2['measurement'];              ?>      <option value="<?php echo $stockitem_id; ?>"><?php echo $stockitem . ' (' . $measurement2 . ')'; ?></option>               <?php } ?>            </select></div><div class="form-group col-lg-6"><label class="control-label">* Quantité</label>  <input type="number" name="quantity[]" class="form-control" placeholder="Quantité" required="required"  step="0.01">  </div></div> </div> <button class="remove_subobj  btn btn-danger" style="height:30px;margin-top:22px"><i class="fa fa-minus"></i></button></div>'); //add input box
            <?php } else { ?>
                $('.subobj').append('<div class="row"><div class="col-lg-12"><hr style="border-top: dashed 1px #b7b9cc;"></div><div class="col-lg-11"><div class="row"> <div class="form-group col-lg-6"><label class="control-label">* Stock Item</label>   <select data-placeholder="Choose item..." name="stockitems[]" class="chosen-select" style="width:100%;" tabindex="2">     <option value="" selected="selected">choose item..</option>       <?php $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE status=1");
                                                                                                                                                                                                                                                                                                                                                                                                                                                            while ($row =  mysqli_fetch_array($stock)) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                $stockitem_id = $row['stockitem_id'];
                                                                                                                                                                                                                                                                                                                                                                                                                                                                $stockitem = preg_replace('/[^a-zA-Z0-9\-]/', ' ', $row['stock_item']);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                $measurement = $row['measurement'];
                                                                                                                                                                                                                                                                                                                                                                                                                                                                $getmeasure =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
                                                                                                                                                                                                                                                                                                                                                                                                                                                                $row2 =  mysqli_fetch_array($getmeasure);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                $measurement2 = $row2['measurement'];              ?>      <option value="<?php echo $stockitem_id; ?>"><?php echo $stockitem . ' (' . $measurement2 . ')'; ?></option>               <?php } ?>            </select></div><div class="form-group col-lg-6"><label class="control-label">* Quantity</label>  <input type="number" name="quantity[]" class="form-control" placeholder="Enter Quantity" required="required"  step="0.01">  </div></div> </div> <button class="remove_subobj  btn btn-danger" style="height:30px;margin-top:22px"><i class="fa fa-minus"></i></button></div>'); //add input box
            <?php } ?>
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
</body>

</html>
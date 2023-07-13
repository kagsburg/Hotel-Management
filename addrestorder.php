<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != "Restaurant Attendant")&& ($_SESSION['sysrole'] != 'Kitchen Exploitation Officer')) {
    header('Location:login.php');
}
$waiter = $_GET['waiter'];
$guest = $_GET['guest'];
$vat = $_GET['vat'];
//       $customer=$_GET['customer'];
//      $discount=$_GET['discount'];
$ordertype = $_GET['ordertype'];
$table = $_GET['table'];
//       if($discount==''){
//                         $discount=0;
//                     }
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Restaurant Order- Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/addrestorder.php';
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
                        <h2>Add New order</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li class="active">
                                <strong>Add Order</strong>
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
                                    <h5>Add New Order </h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if ((empty($waiter))) {
                                        echo '<div class="alert alert-danger">Waiter/ Waitress Required</div>';
                                    } else {

                                        if (isset($_SESSION["rproducts"]) && count($_SESSION["rproducts"]) > 0) { //if we have session variable
                                            //		$cart_box = '<ul class="cart-products-loaded">';
                                            //        if($ordertype==2){
                                            //    mysqli_query($con,"INSERT INTO orders(customer,guest,rtable,discount,timestamp,creator,status) VALUES('$ordertype','$customer','$table','$discount','$timenow','".$_SESSION['emp_id']."','2')") or die(mysqli_errno($con));
                                            //          }
                                            //          else if($ordertype==4){
                                            //                 mysqli_query($con,"INSERT INTO  orders(customer,guest,rtable,discount,timestamp,creator,status) VALUES('$ordertype','$hall','$table','$discount','$timenow','".$_SESSION['emp_id']."','2')") or die(mysqli_errno($con));
                                            //          }
                                            //                 else if (($ordertype==1)||($ordertype==3)) {
                                            //                        if($guest==''){
                                            //                         $guest=0;
                                            //                     }
                                            //    mysqli_query($con,"INSERT INTO orders(customer,guest,rtable,discount,timestamp,creator,status) VALUES('$ordertype','$guest','$table','$discount','$timenow','".$_SESSION['emp_id']."','2')") or die(mysqli_errno($con));
                                            mysqli_query($con, "INSERT INTO orders(customer,guest,rtable,waiter,vat,mode,timestamp,creator,orderstatus,status) VALUES('$ordertype','$guest','$table','$waiter','$vat','',UNIX_TIMESTAMP(),'" . $_SESSION['emp_id'] . "','received','2')") or die(mysqli_error($con));
                                            //          }   
                                            $order_id = mysqli_insert_id($con);
                                            $addrestround =  mysqli_query($con, "INSERT INTO restrounds(order_id,instructions,waiter,timestamp) VALUES('$order_id','','$waiter',UNIX_TIMESTAMP())") or die(mysqli_error($con));
                                            $restround_id = mysqli_insert_id($con);
                                            foreach ($_SESSION["rproducts"] as $product) { //loop though items and prepare html content			
                                                $menuitem = $product["menuitem"];
                                                $itemprice = $product["itemprice"];
                                                $item_id = $product["item_id"];
                                                $product_qty = $product["product_qty"];
                                                $getfooditem = mysqli_query($con, "SELECT * FROM menuitems WHERE status='1' AND menuitem_id='$item_id'");
                                                $row =  mysqli_fetch_array($getfooditem);
                                                $taxed = $row['taxed'];
                                                if ($taxed == 'yes') {
                                                    $tax = 1;
                                                } else {
                                                    $tax = 0;
                                                }
                                                mysqli_query($con, "INSERT INTO restaurantorders(food_id,foodprice,quantity,order_id,tax,restround_id) VALUES('$item_id','$itemprice','$product_qty','$order_id','$tax','$restround_id')") or die(mysqli_error($con));
                                                $products = mysqli_query($con, "SELECT * FROM menuitemproducts WHERE menuitem_id='$item_id'") or die(mysqli_error($con));
                                                while ($row = mysqli_fetch_array($products)) {
                                                    $stockitem_id = $row['stockitem_id'];
                                                    $quantity = $row['quantity'];
                                                    $stockitem = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$stockitem_id'");
                                                    $row1 =  mysqli_fetch_array($stockitem);
                                                    $stockitem = $row1['stock_item'];
                                                    mysqli_query($con, "INSERT INTO consumeditems(stockitem_id,menuitem_id,order_id,items,quantity,status) VALUES('$stockitem_id','$item_id','$order_id','$product_qty','$quantity',1)");
                                                }
                                                unset($_SESSION["rproducts"]);
                                            }

                                    ?>

                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-10">
                                                <div class="alert alert-success"><i class="fa fa-check"></i> Order Items Successfully Added.Click <strong>
                                                        <a href="restinvoice_print.php?id=<?php echo $order_id; ?>" target="_blank">Here</a></strong> To view Order</div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>


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
    <!-- iCheck -->
    <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>

</html>
<script type="text/javascript">
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
</script>
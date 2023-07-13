<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != 'Store Attendant')) {
    header('Location:login.php');
}
$id = $_GET['id'];

?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>List Details- Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/purchaselist.php';
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
                        <h2>List Details</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="approvedlists">List</a> </li>
                            <li class="active">
                                <strong>List Details</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content">
                    <div class="row">
                        <div class="col-lg-4">

                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>List Details</h5>

                                </div>
                                <div class="ibox-content">
                                    <div class="feed-activity-list">
                                        <?php
                                        $list = mysqli_query($con, "SELECT * FROM purchaselists WHERE purchaselist_id='$id'");
                                        $row = mysqli_fetch_array($list);
                                        $purchaselist_id = $row['purchaselist_id'];
                                        $creator = $row['creator'];
                                        $status = $row['status'];
                                        $timestamp = $row['timestamp'];
                                        ?>

                                        <div class="feed-element">
                                            <div class="media-body ">
                                                <strong>List ID</strong> : <?php echo $purchaselist_id; ?> <br>
                                            </div>
                                        </div>
                                        <div class="feed-element">
                                            <div class="media-body ">
                                                <strong>Created on</strong> :
                                                <?php echo date('d/m/Y', $timestamp); ?><br>
                                            </div>
                                        </div>
                                        <div class="feed-element">
                                            <div class="media-body ">
                                                <strong>Added By</strong> :
                                                <?php
                                                $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                                                $row = mysqli_fetch_array($employee);
                                                $employee_id = $row['employee_id'];
                                                $fullname = $row['fullname'];
                                                echo $fullname; ?><br>
                                            </div>
                                        </div>
                                        <div class="feed-element">
                                            <div class="media-body ">
                                                <strong>Status</strong> :
                                                <?php if ($status == 1) {
                                                    echo 'Approved';
                                                } else if ($status == 3) {
                                                    echo 'Verified';                                                
                                                } else {
                                                    echo 'Pending';
                                                } ?><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (($status == 3) && ($_SESSION['hotelsyslevel'] == 1) && ($_SESSION['sysrole'] == "director")) { ?>
                                <a href="approvelist?id=<?php echo $id; ?>" class="btn btn-primary" onclick="return confirm_approve()"><i class="fa fa-thumbs-up"></i> Approve List</a>
                                <script type="text/javascript">
                                    function confirm_approve() {
                                        return confirm('You are about To Approve this list. Are you sure you want to proceed?');
                                    }
                                </script>
                            <?php } ?>
                            <?php if (($status == 0) && ($_SESSION['hotelsyslevel'] == 1) && ($_SESSION['sysrole'] == "manager")) { ?>
                                <a href="verifylist?id=<?php echo $id; ?>" class="btn btn-primary" onclick="return confirm_verify()"><i class="fa fa-thumbs-up"></i> Verify List</a>
                                <script type="text/javascript">
                                    function confirm_verify() {
                                        return confirm('You are about To verify this list. Are you sure you want to proceed?');
                                    }
                                </script>
                            <?php } ?>
                        </div>
                        <div class="col-lg-8">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>List Items</h5>

                                </div>
                                <div class="ibox-content ">


                                    <div class="table-responsive m-t">


                                        <table class="table invoice-table">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Subtotal</th>
                                                    <?php if (($_SESSION['hotelsyslevel'] == 1)) { ?>
                                                        <th>Action</th>
                                                    <?php } ?>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $total = 0;
                                                $getitems =  mysqli_query($con, "SELECT * FROM purchaseditems WHERE purchaselist_id='$id'");
                                                while ($product = mysqli_fetch_array($getitems)) {
                                                    //set variables to use them in HTML content below
                                                    $purchaseitem_id = $product["purchaseditem_id"];
                                                    $price = $product["price"];
                                                    $item_id = $product["item_id"];
                                                    $quantity = $product["quantity"];
                                                    $status2 = $product["status"];

                                                    $subtotal = ($price * $quantity);
                                                    $total = ($total + $subtotal);
                                                    $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$item_id'");
                                                    $row2 =  mysqli_fetch_array($stock);
                                                    $stockitem1 = $row2['stock_item'];
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <div>
                                                                <strong>
                                                                    <?php echo $stockitem1; ?>
                                                                </strong>
                                                            </div>
                                                        </td>
                                                        <td> <?php echo $quantity; ?></td>
                                                        <td> <?php echo number_format($price); ?></td>
                                                        <td><?php echo number_format($subtotal); ?></td>

                                                        <td>
                                                            <?php if (($_SESSION['hotelsyslevel'] == 1)) { ?>
                                                                <a data-toggle="modal" class="btn btn-success btn-xs" href="#modal-form<?php echo $purchaseitem_id ?>"><i class="fa fa-edit"></i> Edit</a>
                                                            <?php } ?>
                                                        </td>


                                                    </tr>
                                                <?php } ?>

                                            </tbody>
                                        </table>

                                    </div><!-- /table-responsive -->

                                    <table class="table invoice-total">
                                        <tbody>
                                            <tr>

                                                <td><strong>TOTAL :</strong></td>
                                                <td><strong><?php echo number_format($total); ?></strong></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $getitems =  mysqli_query($con, "SELECT * FROM purchaseditems WHERE purchaselist_id='$id'");
            while ($product = mysqli_fetch_array($getitems)) {
                //set variables to use them in HTML content below
                $purchaseitem_id = $product["purchaseditem_id"];
                $item_id = $product["item_id"];
                $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$item_id'");
                $row3 =  mysqli_fetch_array($stock);
                $stockitem2 = $row3['stock_item'];
                $quantity = $product["quantity"];
                $price = $product["price"];
            ?>
                <div id="modal-form<?php echo $purchaseitem_id ?>" class="modal fade" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h3 class="m-t-none m-b">Edit <?php echo $stockitem2; ?></h3>
                                        <form role="form" action="edititemprice.php?id=<?php echo $purchaseitem_id; ?>" method="POST">
                                            <div class="form-group">
                                                <label for="qty<?php echo $purchaseitem_id ?>">Quantity</label>
                                                <input type="number" id="qty<?php echo $purchaseitem_id ?>" name="quantity" class="form-control" required="required" value="<?php echo $quantity; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="prc<?php echo $purchaseitem_id ?>">Unit Price</label>
                                                <input type="number" step="0.01" name="unitprice" id="prc<?php echo $purchaseitem_id ?>" class="form-control" required="required" value="<?php echo $price; ?>">
                                            </div>
                                            <div>
                                                <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Edit</strong></button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
    <!-- Mainly scripts -->

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
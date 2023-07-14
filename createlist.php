<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != 'Store Attendant'&& $_SESSION['sysrole'] != 'Kitchen Exploitation Officer')) {
    header('Location:login.php');
}
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Purchase List- Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            $(".showit").load("listprocess.php", {
                "load_cart": "1"
            });
            $("#stockitemstb").on("submit", ".form-item", function(e) {
                e.preventDefault();
                var form_data = $(this).serialize();
                var button_content = $(this).find('button[type="submit"]');
                button_content.html('Adding...'); //Loading button text 
                $.ajax({ //make ajax request to cart_process.php
                    url: "listprocess.php",
                    type: "POST",
                    dataType: "json", //expect json value from server
                    data: form_data
                }).done(function(data) { //on Ajax success
                    $(".label-info").html(data.items); //total items in cart-info element
                    button_content.html('Add to list'); //reset button text to original text
                    $(".showit").html('   <img src="img/loading2.gif" alt="loading.." style="position: relative;left: 150px;">'); //show loading image
                    $(".showit").load("listprocess.php", {
                        "load_cart": "1"
                    }); //Make ajax request using jQuery Load() & update results

                })
                e.preventDefault();
            });

            //Show Items in Cart

            //Remove items from cart
            $(".showit").on('click', 'a.remove-item', function(e) {
                e.preventDefault();
                var pcode = $(this).attr("data-code"); //get product code
                $(this).parent().fadeOut(); //remove item element from box
                $.getJSON("listprocess.php", {
                    "remove_code": pcode
                }, function(data) { //get Item count from Server
                    $(".label-info").html(data.items); //update Item count in cart-info
                    $(".showit").html('   <img src="img/loading2.gif" alt="loading.." style="position: relative;left: 150px;">');
                    $(".showit").load("listprocess.php", {
                        "load_cart": "1"
                    });
                });
            });


        });
    </script>
    <style>
        .fix-sec {
            position: fixed;
            width: 300px;
            top: 10px;
            width: 430px;
            right: 25px;
        }

        .menu-list {
            clear: both;
            max-height: 400px;
            overflow: hidden;
            overflow-y: scroll;
        }
    </style>
</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/createlist.php';
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
                    <div class="col-lg-10">
                        <h2>Create Purchase List</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="pendinglists">Purchase List</a> </li>
                            <li class="active">
                                <strong>create List</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content">
                    <div class="row">
                        <div class="col-lg-6">


                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Select Item(s) from List</h5>

                                </div>
                                <div class="ibox-content menu-list">
                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>

                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody id="stockitemstb">
                                            <?php
                                            $stock = mysqli_query($con, "SELECT * FROM stock_items ORDER BY stock_item");
                                            while ($row =  mysqli_fetch_array($stock)) {
                                                $stockitem_id = $row['stockitem_id'];
                                                $stockitem = $row['stock_item'];
                                                //  $quantity=$row['quantity'];
                                                $minstock = $row['minstock'];
                                                // $itemcategory_id=$row['itemcategory_id'];
                                                $measurement = $row['measurement'];
                                                $status = $row['status'];
                                                $getmeasure =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
                                                $row2 =  mysqli_fetch_array($getmeasure);
                                                $measurement2 = $row2['measurement']

                                            ?>

                                                <tr>
                                                    <td><?php echo $stockitem . ' (' . $measurement2 . ')'; ?></td>

                                                    <td>
                                                        <form class="form-item">

                                                            <input type="text" class="form-control" name="product_qty" style="width:60px" required="required" placeholder="Qty">
                                                            <input type="text" class="form-control" name="price" style="width:70px" required="required" placeholder="Price">
                                                            <input type="hidden" name="item_id" value="<?php echo $stockitem_id; ?>">
                                                            <button class="btn btn-xs btn-success" type="submit">Add to List</button>
                                                        </form>
                                                    </td>
                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a href="listdetails" class="btn btn-primary">Proceed</a>
                        </div>
                        <div class="col-lg-6 parentdiv">
                            <div class="ibox float-e-margins" id="ordered">
                                <div class="ibox-title">
                                    <h5>Create List</h5>
                                    <label class="label label-info pull-right" id="label-info">
                                        <?php
                                        if (isset($_SESSION["rproducts"])) {
                                            echo count($_SESSION["rproducts"]);
                                        } else {
                                            echo 0;
                                        }
                                        ?>
                                    </label>
                                </div>
                                <div class="ibox-content ">
                                    <div class="showit ">

                                    </div>

                                    <!-- <a href="view_cart" class="btn btn-sm btn-primary">View Order</a>-->
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    <?php } ?>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/chosen/chosen.jquery.js"></script>

    <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>
<script>
    $('.dataTables-example').dataTable();
    $(function() {
        var fixadent2 = $("#ordered"),
            pos = fixadent2.offset();
        $(window).scroll(function() {
            if ($(this).scrollTop() > (pos.top - 0) &&
                fixadent2.css('position') == 'static') {
                fixadent2.addClass('fix-sec');
            } else if ($(this).scrollTop() <= pos.top - 0 && fixadent2.hasClass('fix-sec')) {
                fixadent2.removeClass('fix-sec');
            }
        })
        var new_width = $('.parentdiv').width();
        $('.fix-sec').width(new_width);
    });
</script>

</html>
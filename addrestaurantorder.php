<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != "Bar attendant") && ($_SESSION['sysrole'] != 'Restaurant Attendant')) {
    header('Location:login.php');
}
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Order- Hotel Manager</title>
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

            $(".showit").load("restorderprocess.php", {
                "load_cart": "1"
            });
            $(".form-item").submit(function(e) {
                var form_data = $(this).serialize();
                var button_content = $(this).find('button[type="submit"]');
                button_content.html('Adding...'); //Loading button text 

                $.ajax({ //make ajax request to cart_process.php
                    url: "restorderprocess.php",
                    type: "POST",
                    dataType: "json", //expect json value from server
                    data: form_data
                }).done(function(data) { //on Ajax success
                    $(".label-info").html(data.items); //total items in cart-info element
                    button_content.html('Add'); //reset button text to original text
                    $(".showit").html('   <img src="img/loading2.gif" alt="loading.." style="position: relative;left: 150px;">'); //show loading image
                    $(".showit").load("restorderprocess.php", {
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
                $.getJSON("restorderprocess.php", {
                    "remove_code": pcode
                }, function(data) { //get Item count from Server
                    $(".label-info").html(data.items); //update Item count in cart-info
                    $(".showit").html('   <img src="img/loading2.gif" alt="loading.." style="position: relative;left: 150px;">');
                    $(".showit").load("restorderprocess.php", {
                        "load_cart": "1"
                    });
                });
                //	});
            });



        });
    </script>
    <style>
        .fix-sec {
            position: fixed;
            width: 300px;
            top: 10px;
            width: 500px;
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
        include 'fr/addrestaurantorder.php';
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
                            <li> <a>Restaurant</a> </li>
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
                        <div class="col-lg-6">


                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Select Item(s) from Menu</h5>

                                </div>
                                <div class="ibox-content menu-list">
                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <!--<th>&nbsp;</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $fooditems = mysqli_query($con, "SELECT * FROM menuitems WHERE status='1' ORDER BY menuitem");
                                            while ($row =  mysqli_fetch_array($fooditems)) {
                                                $menuitem_id = $row['menuitem_id'];
                                                $menuitem = $row['menuitem'];
                                                $itemprice = $row['itemprice'];

                                            ?>

                                                <tr>
                                                    <td><?php echo $menuitem; ?></td>
                                                    <td><?php echo $itemprice; ?></td>
                                                    <td>
                                                        <form class="form-item">
                                                            <input type="text" class="form-control" name="product_qty" style="width:40px" required="required">
                                                            <input type="hidden" name="item_id" value="<?php echo $menuitem_id; ?>">
                                                            <button class="btn btn-xs btn-success" type="submit">Add to Order</button>
                                                        </form>

                                                    </td>

                                                </tr>

                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Enter Order Details <small class="text-danger">First Select order items to proceed</small></h5>

                                </div>
                                <div class="ibox-content">

                                    <form method="get" name='form' class="form" action="restorderdetails" enctype="multipart/form-data">

                                        <div class="form-group"><label class="control-label">*Waiter / Waitress</label>
                                            <select name="waiter" class="form-control">
                                                <option value="" selected="selected">Select ...</option>
                                                <?php
                                                $employees =  mysqli_query($con, "SELECT * FROM employees WHERE status='1' AND designation='6'");
                                                while ($row = mysqli_fetch_array($employees)) {
                                                    $employee_id = $row['employee_id'];
                                                    $fullname = $row['fullname'];
                                                    $gender = $row['gender'];
                                                    $design_id = $row['designation'];
                                                    $status = $row['status'];
                                                    $ext = $row['ext'];

                                                ?>
                                                    <option value="<?php echo $fullname; ?>"><?php echo $fullname; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div id='form_waiter_errorloc' class='text-danger'></div>
                                        </div>

                                        <div class="form-group"><label class="control-label">*Table</label>
                                            <select name="rtable" class="form-control">
                                                <option value="" selected="selected">Select Table</option>
                                                <?php
                                                $tables = mysqli_query($con, "SELECT * FROM hoteltables WHERE area='rest' AND status='1'");
                                                while ($row =  mysqli_fetch_array($tables)) {
                                                    $hoteltable_id = $row['hoteltable_id'];
                                                    $table_no = $row['table_no'];
                                                ?>
                                                    <option value="<?php echo $hoteltable_id; ?>"><?php echo $table_no; ?></option>
                                                <?php } ?>
                                            </select>
                                            <!--<div id='form_rtable_errorloc' class='text-danger'></div>-->

                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="linked" id="resident">
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Is Customer a hotel resident?
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group forresidents" style="display:none"><label class="control-label">*Select Resident</label>
                                            <select name="guest" class="form-control">
                                                <option value="0" selected="selected">Select Resident</option>
                                                <?php
                                                $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE status='1'");
                                                while ($row =  mysqli_fetch_array($reservation)) {
                                                    $firstname1 = $row['firstname'];
                                                    $lastname1 = $row['lastname'];
                                                    $room_id = $row['room'];
                                                    $reservation_id = $row['reservation_id'];
                                                    $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                                    $row1 =  mysqli_fetch_array($roomtypes);
                                                    $roomnumber = $row1['roomnumber'];

                                                ?>
                                                    <option value="<?php echo $reservation_id; ?>"><?php echo $firstname1 . ' ' . $lastname1 . ' (' . $roomnumber . ')';  ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                        <!--                              <div class="form-group"><label class="control-label">VAT(%)</label>

                                    <input type="text" class="form-control" name='vat' placeholder="Enter VAT">
                                                                                         </div> -->
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit" name="submit">Proceed</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 parentdiv">
                            <div class="ibox float-e-margins" id="ordered">
                                <div class="ibox-title">
                                    <h5>Guest ordered items</h5>
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

                                    <!--                            <a href="view_cart" class="btn btn-sm btn-primary">View Order</a>-->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    <?php } ?>
    <!-- Mainly scripts -->

    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/chosen/chosen.jquery.js"></script>

    <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>
<script>
    $(document).ready(function() {
        $('.dataTables-example').dataTable();
        $('#resident').click(function() {
            if ($(this).prop("checked") === true) {
                $('.forresidents').show();
            } else {
                $('.forresidents').hide();
            }
        });
    });
    var frmvalidator = new Validator("form");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();
    frmvalidator.addValidation("waiter", "req", "*Enter Waiter  to Proceed");
    //  frmvalidator.addValidation("rtable","req", "*Enter Table  to Proceed");
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
    $('.ordertype').on('change', function() {
        var getselect = $(this).val();
        if (getselect === '') {
            $('.forcustomer').hide();
            $('.notcheckedin').hide();
            $('.hall').hide();
            $('.guest').hide();
        }
        if (getselect === '1') {
            $('.notcheckedin').show();
            $('.forcustomer').hide();
            $('.hall').hide();
            $('.guest').hide();
        }
        if (getselect === '2') {
            $('.forcustomer').show();
            $('.hall').hide();
            $('.guest').hide();
            $('.notcheckedin').hide();
        }
        if (getselect === '3') {
            $('.guest').show();
            $('.forcustomer').hide();
            $('.hall').hide();
            $('.notcheckedin').hide();
        }
        if (getselect === '4') {
            $('.hall').show();
            $('.forcustomer').hide();
            $('.guest').hide();
            $('.notcheckedin').hide();
        }
    });
</script>

</html>
<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
$id = $_GET['id'];

?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Reservation - Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

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
                    <h2>Edit Reservation Details</h2>
                    <ol class="breadcrumb">
                        <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>
                        <li> <a>Reservation</a> </li>
                        <li class="active">
                            <strong>Edit Reservation</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Edit Reservation <small>All fields marked (*) shouldn't be left blank</small></h5>

                            </div>
                            <div class="ibox-content">
                                <?php
                                if (isset(
                                    $_POST['firstname'],
                                    $_POST['lastname'],
                                    $_POST['number'],
                                    $_POST['room'],
                                    $_POST['checkin'],
                                    $_POST['checkout'])){
                                    $fname = mysqli_real_escape_string($con, trim($_POST['firstname']));
                                    $lname = mysqli_real_escape_string($con, trim($_POST['lastname']));
                                    $phone = mysqli_real_escape_string($con, trim($_POST['number']));
                                    $email = mysqli_real_escape_string($con, trim($_POST['email']));
                                    $idnumber = mysqli_real_escape_string($con, trim($_POST['idnumber']));
                                    $occupation = mysqli_real_escape_string($con, trim($_POST['occupation']));
                                    $origin = mysqli_real_escape_string($con, trim($_POST['origin']));
                                    $room = mysqli_real_escape_string($con, trim($_POST['room']));
                                    $checkin = mysqli_real_escape_string($con,  strtotime($_POST['checkin']));
                                    $checkout = mysqli_real_escape_string($con,  strtotime($_POST['checkout']));
                                    $adults = mysqli_real_escape_string($con, trim($_POST['adults']));
                                    $kids = mysqli_real_escape_string($con, trim($_POST['kids']));
                                    $widebed = mysqli_real_escape_string($con, trim($_POST['widebed']));
                                    $arrivaltime = mysqli_real_escape_string($con, trim($_POST['arrivaltime']));
                                    $arrivingfrom = mysqli_real_escape_string($con, trim($_POST['arrivingfrom']));
                                    $departuretime = mysqli_real_escape_string($con, trim($_POST['departuretime']));
                                    // $currency = mysqli_real_escape_string($con, trim($_POST['currency']));
                                    // $fax = mysqli_real_escape_string($con, trim($_POST['fax']));
                                    // $reduction = mysqli_real_escape_string($con, trim($_POST['reduction']));
                                    $business = mysqli_real_escape_string($con, trim($_POST['business']));
                                    $dob = mysqli_real_escape_string($con, trim($_POST['dob']));
                                    $sponsor = isset($_POST['sponsor'])? mysqli_real_escape_string($con, trim($_POST['sponsor'])) : '';
                   
                                    if ($sponsor == 'linked') {
                                    $companyname = mysqli_real_escape_string($con, trim($_POST['companyname']));
                                    
                                    }else{
                                    $companyname = '';
                                    
                                    }
                                    if ( (empty($_POST['firstname'])) || (empty($_POST['lastname'])) || (empty($_POST['number'])) || (!isset($_POST['adults'])) || (empty($_POST['room'])) || (empty($_POST['checkin'])) || (empty($_POST['checkout'])) ) {
                                        $errors[] = 'All Fields Marked with * should be filled';
                                    }
                                    if ($checkin > $checkout) {
                                        $errors[] = 'CheckIn Date Cant be later than CheckOut';
                                    }
                                    if (!empty($errors)) {
                                        foreach ($errors as $error) {
                                ?>
                                            <div class="alert alert-danger"><?php echo $error; ?></div>
                                        <?php
                                        }
                                    } else {
                                        mysqli_query($con, "UPDATE reservations SET firstname='$fname',lastname='$lname',phone='$phone',email='$email',origin='$origin',room='$room',id_number='$idnumber',occupation='$occupation',checkin='$checkin',
                                        checkout='$checkout',adults='$adults',kids='$kids',widebed='$widebed',arrivaltime='$arrivaltime',arrivingfrom='$arrivingfrom',
                                        departuretime='$departuretime', business='$business', dob='$dob' , companyname='$companyname'
                                         WHERE reservation_id='$id'") or die(mysqli_error($con));

                                        ?>
                                        <div class="alert alert-success"><i class="fa fa-check"></i> Reservation Successfully Edited</div>
                                <?php

                                    }
                                }

                                $reservations = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$id'");
                                $row =  mysqli_fetch_array($reservations);
                                $firstname1 = $row['firstname'];
                                $lastname1 = $row['lastname'];
                                $checkin1 = $row['checkin'];
                                $phone1 = $row['phone'];
                                $checkout1 = $row['checkout'];
                                $arrivaltime1 = $row['arrivaltime'];
                                $arrivingfrom1 = $row['arrivingfrom'];
                                $departuretime1 = $row['departuretime'];
                                $room_id1 = $row['room'];
                                $widebed1 = $row['widebed'];
                                $email1 = $row['email'];
                                $adults1 = $row['adults'];
                                $kids1 = $row['kids'];
                                $status1 = $row['status'];
                                $fax1 = $row['fax'];
                                $country1 = $row['origin'];
                                $dob1 = $row['dob'];
                                $idnumber1 = $row['id_number'];
                                $occupation1 = $row['occupation'];
                                $business1 = $row['business'];
                                $reduction1 = $row['reduction'];
                                $currency1 = $row['currency'];
                                $companyname = $row['companyname'];

                                $getnumber = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id1'");
                                $row1 =  mysqli_fetch_array($getnumber);
                                $roomnumber1 = $row1['roomnumber'];
                                $type_id1 = $row1['type'];
                                $roomtypes = mysqli_query($con, "SELECT * FROM roomtypes WHERE roomtype_id='$type_id1'");
                                $row1 =  mysqli_fetch_array($roomtypes);
                                $roomtype1 = $row1['roomtype'];
                                ?>
                                <form method="post" name='form' class="form" action="" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="form-group col-lg-6"><label class="control-label">* First Name</label>
                                            <input type="text" name='firstname' class="form-control" value="<?php echo $firstname1; ?>" placeholder="Enter First Name" required="required">
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">* Last Name</label>
                                            <input type="text" name="lastname" class="form-control" value="<?php echo $lastname1; ?>" placeholder="Enter your last name" required="required">
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">* Adults</label>
                                            <input type="number" name="adults" class="form-control" value="<?php echo $adults1; ?>" placeholder="Enter Adults" required="required">
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">* Number of Children</label>
                                            <input type="number" name="kids" class="form-control" value="<?php echo $kids1; ?>" placeholder="Enter Kids" required="required">
                                        </div>

                                        <div class="form-group col-lg-6" id="data_5">
                                            <label class="control-label">* Room <span id="availability" style="display: none">(<a href="modal" data-toggle="modal" class="availability">Check Room Availability</a>)</span></label>
                                            <select class="form-control" name="room" id="room" required>
                                            <option value="<?php echo $room_id1; ?>"><?php echo $roomnumber1 . ' (' . $roomtype1 . ')'; ?></option>
                                                <?php
                                                $rooms = mysqli_query($con, "SELECT * FROM rooms WHERE status='1' ORDER BY roomnumber");
                                                while ($row =  mysqli_fetch_array($rooms)) {
                                                    $roomnumber = $row['roomnumber'];
                                                    $room_id = $row['room_id'];
                                                    $type = $row['type'];
                                                    $status = $row['status'];
                                                    $creator = $row['creator'];
                                                    $roomtypes = mysqli_query($con, "SELECT * FROM roomtypes  WHERE roomtype_id='$type'");
                                                    $row1 =  mysqli_fetch_array($roomtypes);
                                                    $roomtype = $row1['roomtype'];
                                                    $charge = $row1['charge'];
                                                ?>
                                                    <option value="<?php echo $room_id . '_' . $charge; ?>"><?php echo $roomtype . ' ' . $roomnumber . ' (' . $roomtype . ')'; ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6" id="data_5">
                                            <label class="control-label">Wide Bed</label>
                                            <select class="form-control" name="widebed">
                                                <option value="No" <?php if($widebed1 == "No") echo "selected"; ?>>No</option>
                                                <option value="Yes" <?php if($widebed1 == "Yes") echo "selected"; ?>>Yes</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">Passport/Id Number</label>
                                            <input type="text" name="idnumber" class="form-control" value="<?php echo $idnumber1; ?>" placeholder="Enter Id Number">
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">Place of Origin</label>
                                            <input type="text" name="origin" value="<?php echo $country1; ?>" class="form-control" placeholder="Enter Place">
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">Date of Birth</label>
                                            <input type="date" name="dob" class="form-control" placeholder="Enter Date" value="<?php echo $dob1; ?>">
                                        </div>

                                        <div class="form-group  col-lg-6"><label class="control-label">Occupation</label>
                                            <input type="text" name="occupation" class="form-control" value="<?php echo $occupation1; ?>" placeholder="Enter Occupation">
                                        </div>
                                        <div class="form-group  col-lg-6">
                                            <label class="control-label">Business</label>
                                            <input type="text" name="business" class="form-control" placeholder="Enter Business" value="<?php echo $business1; ?>">
                                        </div>
                                        <!-- <div class="form-group  col-lg-6">
                                            <label class="control-label">Currency</label>
                                            <select name="currency" class="form-control">
                                                <option value="<?php echo $currency1; ?>"><?php echo $currency1; ?></option>
                                                <?php if ($currency1 != "USD"): ?>
                                                    <option value="USD">Dollars</option>
                                                <?php endif; ?>
                                                <?php
                                                $getcurrencies = mysqli_query($con, "SELECT * FROM rates WHERE status='1'");
                                                while ($row = mysqli_fetch_array($getcurrencies)) :
                                                    $currency = $row["currency"];
                                                ?>
                                                    <option value="<?php echo $currency; ?>"><?php echo $currency; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div> -->
                                    </div>
                                    <div class="row">
                                        <div class="form-group  col-lg-4"><label class="control-label">* Arrival Date</label>
                                            <input type="date" name="checkin" class="form-control " placeholder="Enter Date" value="<?php echo date('Y-m-d', $checkin1); ?>" required>
                                        </div>
                                        <div class="form-group  col-lg-4"><label class="control-label">Arrival Time</label>
                                            <input type="time" name="arrivaltime" class="form-control" placeholder="Enter Time" value="<?php echo $arrivaltime1; ?>">
                                        </div>
                                        <div class="form-group  col-lg-4"><label class="control-label">Arriving From</label>
                                            <input type="text" name="arrivingfrom" class="form-control" placeholder="Arriving From" value="<?php echo $arrivingfrom1 ?>">
                                        </div>
                                        <div class="form-group  col-lg-6"><label class="control-label">* Departure Date</label>
                                            <input type="date" name="checkout" class="form-control " placeholder="Enter Date" value="<?php echo date('Y-m-d', $checkout1); ?>" required>
                                        </div>
                                        <div class="form-group  col-lg-6"><label class="control-label">Departure Time</label>
                                            <input type="time" name="departuretime" class="form-control" placeholder="Enter Time" value="<?php echo $departuretime1; ?>">
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">* Telephone</label>
                                            <input type="text" name="number" class="form-control" value="<?php echo $phone1; ?>" placeholder="Enter your contact  Number" required="required">
                                        </div>
                                        <div class="form-group col-lg-6"><label class=" control-label">Email Address</label>
                                            <input type="email" name="email" class="form-control" value="<?php echo $email1; ?>" placeholder="Enter a valid email address">
                                            <div id='form_email_errorloc' class='text-danger'></div>
                                        </div>
                                        <div class="form-group col-lg-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="sponsor" value="linked"
                                                    <?php if($companyname != "") echo "checked"; ?>
                                                     id="resident">
                                                    <label class="form-check-label" for="resident">
                                                        Is Customer Company Sponsored?
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="forcompany " 
                                            <?php if($companyname != "") echo "style='display: block;'"; else echo "style='display: none;'"?>
                                            >
                                                <div class="form-group col-lg-12">
                                                  <label class="control-label">* Company / Organisation Name</label>
                                                <select data-placeholder="Choose Service.." name="companyname" id="company" class="chosen-select" style="width:100%;" tabindex="2">
                                                    <?php
                                                    $sponsors = mysqli_query($con, "SELECT * FROM sponsors WHERE status='1' ORDER BY company_name asc");
                                                    while ($row =  mysqli_fetch_array($sponsors)) {
                                                      $sponsor_id = $row['sponsor_id'];
                                                      $name = $row['company_name'];
                                                      $company_location = $row['company_location'];
                                                      $company_email = $row['company_email'];
                                                      $company_contact = $row['company_contact'];
                                                    ?>
                                                      <option value="<?php echo $sponsor_id; ?>" <?php if ($companyname == $sponsor_id) echo "selected";?>><?php echo $name; ?></option>
                                                    <?php } ?>
                                                  </select>
                                                </div>
                                               
                                            </div>
                                        <!-- <div class="form-group col-lg-6"><label class="control-label">FAX</label>
                                            <input type="text" name="fax" class="form-control" placeholder="Enter Fax" value="<?php echo $fax1; ?>">
                                        </div>
                                        
                                        <div class="form-group  col-lg-6"><label class="control-label">Price Reduction</label>
                                            <input type="number" name="reduction" class="form-control" placeholder="Enter Price Reduction" value="<?php echo $reduction1; ?>">
                                        </div> -->

                                    </div>

                                   
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">Edit Reservation</button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/chosen/chosen.jquery.js"></script>
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

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
    $('.datepick').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy"
    });
    $('#resident').on('click', function() {
    var getselect = $(this).val();
    if ($(this).is(':checked')) {
      $('.forcompany').show();
      // reinitialize the chosen box
      $('#company_chosen').attr("style", "width:100%;");
    }
    else {
      $('.forcompany').hide();
    }
  });
    $('#data_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
    });
</script>
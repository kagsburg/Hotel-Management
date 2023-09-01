<?php
include 'includes/conn.php';
//if($_SESSION['sysrole']!='Receptionist'){
if (!isset($_SESSION['hotelsys'])) {
  header('Location:index');
}
?>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Reservation - Hotel Manager</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
  <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
  <link href="css/animate.css" rel="stylesheet">
  <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
  <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
  <?php
  if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
    include 'fr/addreservation.php';
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
            <h2>Add New Reservation</h2>
            <ol class="breadcrumb">
              <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
              <li> <a href="reservations">Reservation</a> </li>
              <li class="active">
                <strong>Add Reservation</strong>
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
                  <h5>Add New Reservation <small>All fields marked (*) shouldn't be left blank</small></h5>
                </div>
                <div class="ibox-content">
                  <?php
                  if (isset($_POST['submit'])) {
                    $fname = mysqli_real_escape_string($con, trim($_POST['firstname']));
                    $lname = mysqli_real_escape_string($con, trim($_POST['lastname']));
                    $phone = mysqli_real_escape_string($con, trim($_POST['number']));
                    $email = mysqli_real_escape_string($con, trim($_POST['email']));
                    $idnumber = mysqli_real_escape_string($con, trim($_POST['idnumber']));
                    $occupation = mysqli_real_escape_string($con, trim($_POST['occupation']));
                    $business = "";
                    // mysqli_real_escape_string($con, trim($_POST['business']));
                    $adults = mysqli_real_escape_string($con, trim($_POST['adults']));
                    $kids = mysqli_real_escape_string($con, trim($_POST['kids']));
                    $widebed = "";
                    // mysqli_real_escape_string($con, trim($_POST['widebed']));
                    $origin = mysqli_real_escape_string($con, trim($_POST['origin']));
                    $dob = mysqli_real_escape_string($con, trim($_POST['dob']));
                    $room = mysqli_real_escape_string($con, trim($_POST['room']));
                    $checkin = mysqli_real_escape_string($con,  strtotime($_POST['checkin']));
                    $arrivaltime = mysqli_real_escape_string($con, trim($_POST['arrivaltime']));
                    $arrivingfrom = mysqli_real_escape_string($con, trim($_POST['arrivingfrom']));
                    $departuretime = mysqli_real_escape_string($con, trim($_POST['departuretime']));;
                    $fax = '';
                    // mysqli_real_escape_string($con, trim($_POST['fax']));
                    $advance = mysqli_real_escape_string($con, trim($_POST['advance']));
                    $reduction = "";// mysqli_real_escape_string($con, trim($_POST['reduction']));
                    $currency = 'TSHS';
                    $checkout = mysqli_real_escape_string($con,  strtotime($_POST['checkout']));
                    $sponsor = isset($_POST['sponsor'])? mysqli_real_escape_string($con, trim($_POST['sponsor'])) : '';
                   
                    if ($sponsor == 'linked') {
                      $companyname = mysqli_real_escape_string($con, trim($_POST['companyname']));
                      $companycont = mysqli_real_escape_string($con, trim($_POST['companycont']));
                      $companyloc = mysqli_real_escape_string($con, trim($_POST['companyloc']));
                      $companyemail = mysqli_real_escape_string($con, trim($_POST['companyemail']));
                    }else{
                      $companyname = '';
                      $companycont = '';
                      $companyloc = '';
                      $companyemail = '';
                    }
                    if ((empty($fname)) || (empty($lname)) || (empty($phone)) || (empty($room)) || (empty($checkin))
                      || (empty($checkout))
                    ) {
                      $errors[] = 'All Fields Marked with * should be filled';
                    }
                    if ($checkin > $checkout) {
                      $errors[] = 'CheckIn Date Cant be later than CheckOut';
                    }
                    $split = explode('_', $room);
                    $room_id = current($split);
                    $charge = end($split);
                    $x = $checkin;
                    $daterange = array();
                    array_push($daterange, $x);
                    while ($x <= $checkout) {
                      $x = $x + (3600 * 24);
                      array_push($daterange, $x);
                    }
                    $count = 0;
                    $check = mysqli_query($con, "SELECT * FROM reservations WHERE  status IN (0,1) AND room='$room_id'");
                    while ($row2 = mysqli_fetch_array($check)) {
                      $checkin2 = $row2['checkin'];
                      $checkout2 = $row2['checkout'];
                      $i = $checkin2;
                      $daterange2 = array();
                      array_push($daterange2, $i);
                      while ($i <= $checkout2) {
                        $i = $i + (3600 * 24);
                        array_push($daterange2, $i);
                      }
                      $similar = array_intersect($daterange2, $daterange);
                      if (count($similar) > 0) {
                        $count = $count + 1;
                      }
                    }
                    if ($count > 0) {
                      $errors[] = 'Room Selected Not Available';
                    }
                    if (!empty($errors)) {
                      foreach ($errors as $error) {
                  ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                      <?php
                      }
                    } else {
                      mysqli_query($con, "INSERT INTO reservations(firstname,lastname,phone,email,origin,room,charge,adults,kids,widebed,dob,checkin,
                      arrivaltime,arrivingfrom,checkout,actualcheckout,departuretime,usdtariff,fax,id_number,occupation,business,reduction,creator,
                      currency,advance,timestamp,status,companyname,companycont,companyloc,companyemail)  
                      VALUES('$fname','$lname','$phone','$email','$origin','$room_id','$charge','$adults','$kids','$widebed','$dob','$checkin',
                      '$arrivaltime','$arrivingfrom','$checkout','0','$departuretime','','$fax','$idnumber','$occupation','$business','$reduction','"
                        . $_SESSION['emp_id'] . "','$currency','$advance',UNIX_TIMESTAMP(),'0','$companyname','$companycont','$companyloc','$companyemail')") or die(mysqli_error($con));
                      $last_id = mysqli_insert_id($con);
                      if (!empty($advance)) {
                        mysqli_query($con, "INSERT INTO payments(reservation_id,amount,timestamp,status) VALUES('$last_id','$advance','$timenow',1)") or die(mysqli_error($con));
                      }
                      ?>
                      <div class="alert alert-success"><i class="fa fa-check"></i> Reservation Successfully Added</div>
                  <?php
                    }
                  }
                  ?>
                  <form method="post" name='form' class="form" action="" enctype="multipart/form-data">
                    <div class="row">
                      <div class="form-group col-lg-6"><label class="control-label">* First Name</label>
                        <input type="text" name='firstname' class="form-control" placeholder="Enter First Name" required="required">
                      </div>
                      <div class="form-group col-lg-6"><label class="control-label">* Last Name</label>
                        <input type="text" name="lastname" class="form-control" placeholder="Enter your last name" required="required">
                      </div>
                      <div class="form-group col-lg-6"><label class="control-label">* Adults</label>
                        <input type="number" name="adults" class="form-control" placeholder="Enter Adults" required="required">
                      </div>
                      <div class="form-group col-lg-6"><label class="control-label">* Number of Children</label>
                        <input type="number" name="kids" class="form-control" placeholder="Enter Kids" required="required">
                      </div>
                      <div class="form-group  col-lg-4"><label class="control-label">Arrival Date</label>
                        <input type="date" name="checkin" class="form-control" placeholder="Enter Date">
                      </div>
                      <div class="form-group  col-lg-4"><label class="control-label">Arrival Time</label>
                        <input type="time" name="arrivaltime" class="form-control" placeholder="Enter Time">
                      </div>
                      <div class="form-group  col-lg-4"><label class="control-label">Arriving From</label>
                        <input type="text" name="arrivingfrom" class="form-control" placeholder="Arriving From">
                      </div>
                      <div class="form-group  col-lg-6"><label class="control-label">Departure Date</label>
                        <input type="date" name="checkout" class="form-control" placeholder="Enter Date">
                      </div>
                      <div class="form-group  col-lg-6"><label class="control-label">Departure Time</label>
                        <input type="time" name="departuretime" class="form-control" placeholder="Enter Time">
                      </div>
                      <div class="form-group col-lg-6" id="data_5">
                        <label class="control-label">* Room <span id="availability" style="display: none">(<a href="modal" data-toggle="modal" class="availability">Check Room Availability</a>)</span></label>
                        <select class="form-control" name="room" id="room">
                          <option value="" selected="selected">Select Room</option>
                          <?php
                          $id_arr = array();
                          $unbookedrooms = array();
                          $rooms = mysqli_query($con, "SELECT * FROM rooms WHERE status='1' ORDER BY roomnumber");
                          while ($row =  mysqli_fetch_array($rooms)) {
                            $room_id = $row['room_id'];
                            array_push($id_arr, $room_id);
                          }
                          ?>
                          <?php
                          foreach ($id_arr as &$val) {
                            $reservations = mysqli_query($con, "SELECT * FROM reservations WHERE  status IN (0,1)  AND room='$val' ORDER BY checkin");
                            if ($row = mysqli_num_rows($reservations) > 0) {
                              //don't do anything  
                            } else {
                              array_push($unbookedrooms, $val);
                            }
                          }
                          foreach ($unbookedrooms as $id) {
                            $rooms = mysqli_query($con, "SELECT * FROM rooms WHERE status='1' AND room_id='$id' ORDER BY roomnumber");
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
                              <option value="<?php echo $room_id . '_' . $charge; ?>"><?php echo $roomtype . ' ' . $roomnumber . ' (' . $roomtype . ')'; ?>
                              </option>
                            <?php } ?>
                          <?php } ?>
                        </select>
                      </div>
                      <!--<div class="form-group col-lg-6" id="data_5">
                        <label class="control-label">Wide Bed</label>
                        <select class="form-control" name="widebed">
                          <option value="No" selected="selected">No</option>
                          <option value="Yes">Yes</option>
                        </select>
                      </div>-->
                      <div class="form-group col-lg-6"><label class="control-label">Passport/Id Number</label>
                        <input type="text" name="idnumber" class="form-control" placeholder="Enter Id Number">
                      </div>
                      <div class="form-group col-lg-6"><label class="control-label">Place of Origin</label>
                        <input type="text" name="origin" class="form-control" placeholder="Enter Place">
                      </div>
                      <div class="form-group col-lg-6"><label class="control-label">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" placeholder="Enter Date">
                      </div>

                      <div class="form-group  col-lg-6"><label class="control-label">Occupation</label>
                        <input type="text" name="occupation" class="form-control" placeholder="Enter Occupation">
                      </div>
                    <div class="row">
                      <div class="form-group col-lg-6"><label class="control-label">* Telephone</label>
                        <input type="text" name="number" class="form-control" placeholder="Enter your contact  Number" required="required">
                      </div>
                      <div class="form-group col-lg-6"><label class=" control-label">Email Address</label>
                        <input type="email" name="email" class="form-control " placeholder="Enter a valid email address">
                        <div id='form_email_errorloc' class='text-danger'></div>
                      </div>
                      <!--<div class="form-group col-lg-6"><label class="control-label">FAX</label>
                        <input type="text" name="fax" class="form-control" placeholder="Enter Fax">
                      </div>-->
                      <div class="form-group  col-lg-6"><label class="control-label">Advance</label>
                        <input type="number" name="advance" class="form-control" placeholder="Enter Advance Payment">
                      </div>
                      <!-- <div class="form-group  col-lg-6"><label class="control-label">Price Reduction</label>
                        <input type="number" name="reduction" class="form-control" placeholder="Enter Price Reduction">
                      </div> -->
                      <div class="form-group col-lg-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="sponsor" value="linked" id="resident">
                                                    <label class="form-check-label" for="resident">
                                                        Is Customer Company Sponsored?
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="forcompany " style="display: none;">
                                                <div class="form-group col-lg-12"><label class="control-label">* Company / Organisation Name</label>
                                                  <input type="text" name="companyname" class="form-control" placeholder="Enter your Company  Name">
                                                </div>
                                                <div class="form-group col-lg-6"><label class="control-label">* Company / Organisation Contact</label>
                                                  <input type="text" name="companycont" class="form-control" placeholder="Enter your contact  Number">
                                                </div>
                                                <div class="form-group col-lg-6"><label class="control-label">* Company / Organisation Location</label>
                                                  <input type="text" name="companyloc" class="form-control" placeholder="Enter your Location" >
                                                </div>
                                                <div class="form-group col-lg-11"><label class="control-label">Company / Organisation Email Address</label>
                                                  <input type="email" name="companyemail" class="form-control" placeholder="Enter your Email  Address">
                                                </div>
                                            </div>
                      
                    <div class="form-group" style="margin-left: 30px;">
                      <button class="btn btn-primary" type="submit" name="submit">Add Reservation</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    $rooms = mysqli_query($con, "SELECT * FROM rooms WHERE status='1' ORDER BY roomnumber");
    while ($row =  mysqli_fetch_array($rooms)) {
      $roomnumber = $row['roomnumber'];
      $room_id = $row['room_id'];
      $type = $row['type'];
      $creator = $row['creator'];
      $roomtypes = mysqli_query($con, "SELECT * FROM roomtypes  WHERE roomtype_id='$type'");
      $row1 =  mysqli_fetch_array($roomtypes);
      $roomtype = $row1['roomtype'];
      $charge = $row1['charge'];
    ?>
      <div id="modal<?php echo $room_id . '_' . $charge; ?>" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <h3><?php echo $roomtype . ' ' . $roomnumber; ?> Details</h3>
              <?php
              $reservations = mysqli_query($con, "SELECT * FROM reservations WHERE  status IN (0,1)  AND room='$room_id' ORDER BY checkin");
              if ($row = mysqli_num_rows($reservations) > 0) {
              ?>
                <table class="table table-striped table-bordered table-hover dataTables-example">
                  <thead>
                    <tr>
                      <th>Check In</th>
                      <th>Check Out</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($row =  mysqli_fetch_array($reservations)) {
                      $reservation_id = $row['reservation_id'];
                      $firstname = $row['firstname'];
                      $lastname = $row['lastname'];
                      $checkin = $row['checkin'];
                      $phone = $row['phone'];
                      $checkout = $row['checkout'];
                      $room_id = $row['room'];
                      $email = $row['email'];
                      $status = $row['status'];
                      $creator = $row['creator'];
                    ?>
                      <tr class="gradeA">
                        <td><?php echo date('d/m/Y', $checkin); ?></td>
                        <td><?php echo date('d/m/Y', $checkout); ?></td>
                        <td>
                          <div class="text-success">
                            <?php if ($status == 1) {
                              echo 'GUEST IN';
                            } else {
                              echo 'BOOKED';
                            } ?>
                          </div>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              <?php } else { ?>
                <div class="alert alert-danger">No Reservations Made for this room</div>
              <?php } ?>
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
  $('#room').on('change', function() {
    var getroom = $(this).val();
    if (getroom !== '') {
      $('#availability').show();
      $('.availability').attr("href", '#modal' + getroom);
    }
  });
  $('#paymentmode').on('change', function() {
    var getselect = $(this).val();
    if ((getselect === '') || (getselect === 'cash') || (getselect === 'credit card')) {
      $('.forvoucher').hide();
      $('.forother').hide();
    }
    if (getselect === 'voucher') {
      $('.forvoucher').show();
      $('.forother').hide();
    }
    if (getselect === 'other') {
      $('.forvoucher').hide();
      $('.forother').show();
    }
  });
  $('#resident').on('click', function() {
    var getselect = $(this).val();
    if ($(this).is(':checked')) {
      $('.forcompany').show();
    }
    else {
      $('.forcompany').hide();
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
  $('#data_5 .input-daterange').datepicker({
    keyboardNavigation: false,
    forceParse: false,
    autoclose: true
  });
</script>
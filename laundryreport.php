<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login');
}
$stdate = explode('/', $_GET['start']);
$endate = explode('/', $_GET['end']);
$st = $stdate[1].'/'.$stdate[0].'/'. $stdate[2] . ' ' . $_GET['stt'];
$en = $endate[1].'/'.$endate[0].'/'. $endate[2] . ' ' . $_GET['ent'];
$start = strtotime($st);
$end = strtotime($en);

?>
<html>

<head>

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Laundry Report - Hotel Manager</title>
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
   if (false && (isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
      include 'fr/gymreport.php';
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
                  <h2>Laundry Report between <?php echo date('d/m/Y H:i', $start); ?> and <?php echo date('d/m/Y H:i', $end); ?></h2>
                  <ol class="breadcrumb">
                     <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>

                     <li class="active">
                        <strong>Laundry Report</strong>
                     </li>
                  </ol>
               </div>
               <div class="col-lg-2">

               </div>
            </div>
            <div class="wrapper wrapper-content">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="d-flex">
                        <a href="laundryreportprint?start=<?php echo $st; ?>&&end=<?php echo $en; ?>" target="_blank" class="btn btn-success ">Print PDF</a>&nbsp;
                        <a href="laundryreportexcel?start=<?php echo $st; ?>&&end=<?php echo $en; ?>" target="_blank" class="btn btn-success ">Export to Excel</a>
                     </div>
                     <br>
                     <div class="ibox float-e-margins">
                        <div class="ibox-title">
                           <h5>Generated Laundry Report</h5>

                        </div>
                        <div class="ibox-content">
                           <?php
                           if ($start > $end) {
                              $errors[] = 'Start Date Cant be later than End Date';
                           }
                           if (!empty($errors)) {
                              foreach ($errors as $error) {
                           ?>
                                 <div class="alert alert-danger"><?php echo $error; ?></div>
                              <?php
                              }
                           } else {  ?>
                              <h2 class="text-center">LAUNDRY REPORT</h2>
                              <div class="table-responsive m-t">
                                 <?php
                                 $totalcosts = 0;
                                 $laundry = mysqli_query($con, "SELECT * FROM laundry WHERE status IN (1,0) AND timestamp>='$start' AND timestamp<='$end'");
                                 if (mysqli_num_rows($laundry) > 0) {
                                 ?>
                                    <table class="table table-bordered">
                                       <thead>
                                          <tr>
                                             <th>Items</th>
                                             <th>Quantity</th>
                                             <th>Price</th>
                                             <!-- <th>HTVA</th> -->
                                             <th>VAT</th>
                                             <th>Total Price</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php
                                          while ($row =  mysqli_fetch_array($laundry)) {
                                             $vat = 18;
                                             $laundry_id = $row['laundry_id'];
                                             $reserve_id = $row['reserve_id'];
                                             $clothes = $row['clothes'];
                                             $package_id = $row['package_id'];
                                             $charge = $row['charge'];
                                             $customername = $row['customername'];
                                             $phone = $row['phone'];
                                             $timestamp = $row['timestamp'];
                                             $status = $row['status'];
                                             $creator = $row['creator'];
                                             $getyear = date('Y', $timestamp);
                                             $count = 1;
                                             $beforeorders =  mysqli_query($con, "SELECT * FROM laundry WHERE status IN (0,1) AND  laundry_id<'$laundry_id'") or die(mysqli_error($con));
                                             while ($rowb = mysqli_fetch_array($beforeorders)) {
                                                $timestamp2 = $rowb['timestamp'];
                                                $getyear2 = date('Y', $timestamp2);
                                                if ($getyear == $getyear2) {
                                                   $count = $count + 1;
                                                }
                                             }
                                             if (strlen($count) == 1) {
                                                $invoice_no = '000' . $count;
                                             }
                                             if (strlen($count) == 2) {
                                                $invoice_no = '00' . $count;
                                             }
                                             if (strlen($count) == 3) {
                                                $invoice_no = '0' . $count;
                                             }
                                             if (strlen($count) >= 4) {
                                                $invoice_no = $count;
                                             }
                                             $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
                                             if (mysqli_num_rows($reservation) > 0) {

                                                $row2 =  mysqli_fetch_array($reservation);
                                                $firstname = $row2['firstname'];
                                                $lastname = $row2['lastname'];
                                                $room_id = $row2['room'];
                                                $phone = $row2['phone'];
                                                $roomtypes = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                                $row1 =  mysqli_fetch_array($roomtypes);
                                                $roomnumber = $row1['roomnumber'];
                                                $customername = $firstname . ' ' . $lastname . ' (' . $roomnumber . ')';
                                             }
                                             $getpackage = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1' AND laundrypackage_id='$package_id'");
                                             $row3 = mysqli_fetch_array($getpackage);
                                             $laundrypackage = $row3['laundrypackage'];

                                             $totalcharge = $charge * $clothes;

                                             $vatamount = (($totalcharge * $vat) / 100);

                                             $htva = $totalcharge - $vatamount;
                                             $net = $htva + $vatamount;

                                             $totalcosts += $totalcharge;
                                          ?>
                                             <tr>
                                                <!-- <td><?php echo $invoice_no; ?></td> -->
                                                <!-- <td><?php echo $customername; ?></td> -->
                                                <!-- <td><?php echo ($reserve_id > 0) ? 'Yes' : 'No'; ?> </td> -->
                                                <td><?php echo $laundrypackage; ?> </td>
                                                <td><?php echo $clothes; ?> </td>
                                                <td><?php echo number_format($charge); ?></td>
                                                <!-- <td>
                                                   <?php
                                                   $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                                                   $row = mysqli_fetch_array($employee);
                                                   $employee_id = $row['employee_id'];
                                                   $fullname = $row['fullname'];
                                                   echo $fullname;  ?>
                                                </td> -->
                                                <!-- <td><?php echo number_format($htva); ?></td> -->
                                                <td><?php echo number_format($vatamount); ?></td>
                                                <td><?php echo number_format($totalcharge); ?></td>
                                             </tr>
                                          <?php } ?>

                                       </tbody>
                                    </table>
                                 
                              </div><!-- /table-responsive -->

                              <table class="table invoice-total">
                                 <tbody>
                                    <tr>
                                       <td><strong>TOTAL :</strong></td>
                                       <td><strong><?php echo number_format($totalcosts); ?></strong></td>
                                    </tr>
                                 </tbody>
                              </table>
                              <?php } else{?>
                                 <div class="alert  alert-danger">Oops!! No Laundry Added Yet</div>
                                            <?php } ?>
                           <?php
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
   $('#data_5 .input-daterange').datepicker({
      keyboardNavigation: false,
      forceParse: false,
      autoclose: true
   });
</script>
<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login');
}
$stdate = explode('/', $_GET['start']);
$endate = explode('/', $_GET['end']);
$st = $stdate[1] . '/' . $stdate[0] . '/' . $stdate[2] . ' ' . $_GET['stt'];
$en = $endate[1] . '/' . $endate[0] . '/' . $endate[2] . ' ' . $_GET['ent'];
$start = strtotime($st);
$end = strtotime($en);

?>
<html>

<head>

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Gym and Pool Report - Hotel Manager</title>
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
                  <h2>Gym and Pool Report between <?php echo date('d/m/Y H:i', $start); ?> and <?php echo date('d/m/Y H:i', $end); ?></h2>
                  <ol class="breadcrumb">
                     <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>

                     <li class="active">
                        <strong>Gym and Pool Report</strong>
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
                        <a href="poolreportprint?start=<?php echo $st; ?>&&end=<?php echo $en; ?>" target="_blank" class="btn btn-success ">Print PDF</a>&nbsp;
                        <a href="poolreportexcel?start=<?php echo $st; ?>&&end=<?php echo $en; ?>" target="_blank" class="btn btn-success ">Export to Excel</a>
                     </div>
                     <br>
                     <div class="ibox float-e-margins">
                        <div class="ibox-title">
                           <h5>Generated Gym and Pool Report</h5>

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
                              <h2 class="text-center">GYM AND POOL REPORT</h2>
                              <div class="table-responsive m-t">
                                 <?php
                                 $totalcosts = 0;
                                 $total = 0;
                                 $totalred = 0;
                                 $totalvat = 0;
                                 $totalhtva = 0;
                                 $subscriptions = mysqli_query($con, "SELECT * FROM poolsubscriptions WHERE status='1'  AND timestamp>='$start' AND timestamp<='$end'");
                                 if (mysqli_num_rows($subscriptions) > 0) {
                                 ?>
                                    <table class="table table-bordered">
                                       <thead>
                                          <tr>
                                             <th>ID</th>
                                             <th>Client</th>
                                             <th>Start Date</th>
                                             <th>End Date</th>
                                             <th>Created By</th>
                                             <th>Package</th>
                                             <th>Reduction</th>
                                             <th>Charge</th>
                                             <!-- <th>HTVA</th> -->
                                             <th>VAT</th>
                                             <th>NET</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php
                                          $vat = 10;
                                          while ($row =  mysqli_fetch_array($subscriptions)) {
                                             $poolsubscription_id = $row['poolsubscription_id'];
                                             $fullname = $row['firstname'] . " " . $row["lastname"];
                                             $startdate = $row['startdate'];
                                             $enddate = $row['enddate'];
                                             $charge = $row['charge'];
                                             $creator = $row['creator'];
                                             $package = $row['package'];
                                             $reduction = empty($row['reduction']) ? 0 : $row['reduction'];
                                             $getpackage = mysqli_query($con, "SELECT * FROM poolpackages WHERE status='1' AND poolpackage_id='$package'");
                                             $row1 = mysqli_fetch_array($getpackage);
                                             $gymbouquet_id = $row1['poolpackage_id'];
                                             $package = $row1['poolpackage'];
                                             $days = $row1['days'] - 1;
                                             $enddate = strtotime("+{$days} days", $startdate);

                                             if (strlen($poolsubscription_id) == 1) {
                                                $pin = '000' . $poolsubscription_id;
                                             }
                                             if (strlen($poolsubscription_id) == 2) {
                                                $pin = '00' . $poolsubscription_id;
                                             }
                                             if (strlen($poolsubscription_id) == 3) {
                                                $pin = '0' . $poolsubscription_id;
                                             }
                                             if (strlen($poolsubscription_id) >= 4) {
                                                $pin = $poolsubscription_id;
                                             }

                                             $total += $charge;
                                             $totalred += $reduction;

                                             $vatamount = ((($charge - $reduction) * $vat) / 110);

                                             $htva = $charge - $vatamount - $reduction;
                                             $net = $htva + $vatamount;

                                             $totalvat += $vatamount;
                                             $totalhtva += $htva;
                                             $totalcosts += $net;
                                          ?>
                                             <tr>
                                                <td><?php echo $pin; ?></td>
                                                <td><?php echo $fullname; ?></td>
                                                <td><?php echo date('d/m/Y', $startdate); ?></td>
                                                <td><?php echo date('d/m/Y', $enddate); ?></td>
                                                <td>
                                                   <?php
                                                   $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                                                   $row = mysqli_fetch_array($employee);
                                                   $employee_id = $row['employee_id'];
                                                   $fullname = $row['fullname'];
                                                   echo $fullname;  ?>
                                                </td>
                                                <td><?php echo $package; ?></td>
                                                <td><?php echo $reduction; ?></td>
                                                <td><?php echo $charge; ?></td>
                                                <!-- <td><?php echo number_format($htva); ?></td> -->
                                                <td><?php echo number_format($vatamount); ?></td>
                                                <td><?php echo number_format($net); ?></td>
                                             </tr>
                                          <?php } ?>
                                             <tr>
                                                <th colspan="2">TOTAL</th>
                                             
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th><?php echo number_format($totalred); ?></th>
                                                <th><?php echo number_format($total); ?></th>
                                                <!-- <th><?php echo number_format($totalhtva); ?></th> -->
                                                <th><?php echo number_format($totalvat); ?></th>
                                                <th><?php echo number_format($totalcosts); ?></th>
                                             </tr>
                                       </tbody>

                                    </table>
                                 <?php } else { ?>
                                    <div class="alert alert-danger">
                                       <strong>Sorry!</strong> No Records Found.
                                    </div>
                                 <?php } ?>
                              </div><!-- /table-responsive -->

                              <!-- <table class="table invoice-total">
                                 <tbody>
                                    <tr>
                                       <td><strong>TOTAL :</strong></td>
                                       <td><strong><?php echo number_format($total); ?></strong></td>
                                    </tr>
                                    <tr>
                                       <td><strong>REDUCTION :</strong></td>
                                       <td><strong><?php echo number_format($totalred); ?></strong></td>
                                    </tr>
                                    <tr>
                                       <td><strong>TOTAL VAT :</strong></td>
                                       <td><strong><?php echo number_format($totalvat); ?></strong></td>
                                    </tr>
                                    <tr>
                                       <td><strong>NET TOTAL :</strong></td>
                                       <td><strong><?php echo number_format($totalcosts); ?></strong></td>
                                    </tr>
                                 </tbody>
                              </table> -->

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
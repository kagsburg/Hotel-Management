<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login');
}
$st = $_GET['start'];
$en = $_GET['end'];
$start = strtotime($_GET['start']);
$end = strtotime($_GET['end'])
?>
<!DOCTYPE html>
<html>

<head>
   <style type="text/css" media="print">
      @page {
         size: auto;
         /* auto is the initial value */
         margin: 0;
         /* this affects the margin in the printer settings */
      }
   </style>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Laundry Report | Hotel Manager</title>

   <link href="css/bootstrap.min.css" rel="stylesheet">
   <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

   <link href="css/animate.css" rel="stylesheet">
   <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
   <?php
   if (false && (isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
      include 'fr/poolreportprint.php';
   } else {
   ?>
      <div class="wrapper wrapper-content p-xl">
         <div class="ibox-content p-xl">
            <div class="row">
               <div class="col-xs-2"><img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive"></div>


            </div>
            <h1 class="text-center">Laundry between <?php echo date('d/m/Y H:i', $start); ?> and <?php echo date('d/m/Y H:i', $end); ?></h1>


            <div class="table-responsive m-t">
               <?php
               $totalcosts = 0;
               $laundry = mysqli_query($con, "SELECT * FROM laundry WHERE status IN (1) AND timestamp>='$start' AND timestamp<='$end'");
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
                           $vat = 10;
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
                                 <?php /*
                                 $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                                 $row = mysqli_fetch_array($employee);
                                 $employee_id = $row['employee_id'];
                                 $fullname = $row['fullname'];
                                 echo $fullname; */ ?>
                              </td> -->
                              <!-- <td><?php echo number_format($htva); ?></td> -->
                              <td><?php echo number_format($vatamount); ?></td>
                              <td><?php echo number_format($totalcharge); ?></td>
                           </tr>
                        <?php } ?>

                     </tbody>
                  </table>
               <?php } ?>
            </div><!-- /table-responsive -->
            <table class="table invoice-total">
               <tbody>
                  <tr>
                     <td><strong>TOTAL :</strong></td>
                     <td><strong><?php echo number_format($totalcosts); ?></strong></td>
                  </tr>
               </tbody>
            </table>

            <?php
            $name =  mysqli_query($con, "SELECT * FROM users WHERE user_id='" . $_SESSION['hotelsys'] . "'");
            $row =  mysqli_fetch_array($name);
            $employee = $row['employee'];
            $getemployee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$employee'");
            $roww = mysqli_fetch_array($getemployee);
            $fullname = $roww['fullname'];
            ?>
            <table class="table invoice-total">
               <tbody>
                  <tr>
                     <td style="padding-bottom: 50px;"><strong>Created by <?php echo $fullname; ?></strong></td>
                  </tr>
               </tbody>
            </table>
         </div>

      </div>
   <?php } ?>
   <!-- Mainly scripts -->
   <script src="js/jquery-1.10.2.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

   <!-- Custom and plugin javascript -->
   <script src="js/inspinia.js"></script>

   <script type="text/javascript">
      window.print();
   </script>

</body>

</html>
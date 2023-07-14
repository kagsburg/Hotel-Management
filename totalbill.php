<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login');
}
$id = $_GET['id'];
if (isset($_POST['bill'])) {
   $getbill = $_POST['bill'];
   if (empty($getbill)) {
      echo 'Select Bill To proceed';
   } else {

      function getForexConvertedAmount($rate, $amount)
      {
         return intval($amount) * floatval($rate);
      }

?>
      <!DOCTYPE html>
      <html>

      <head>

         <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0">

         <title><?php echo $getbill; ?> Bill | Hotel Manager</title>

         <link href="css/bootstrap.min.css" rel="stylesheet">
         <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

         <link href="css/animate.css" rel="stylesheet">
         <link href="css/style.css" rel="stylesheet">

      </head>

      <body>
         <?php
         if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
            include 'fr/totalbill.php';
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
                     <div class="col-lg-8">
                        <h2><?php echo $getbill; ?> Total Bill</h2>
                        <ol class="breadcrumb">
                           <li>
                              <a href="index">Home</a>
                           </li>
                          <!-- <li>
                              <a href="getbill">Get Bill</a>
                           </li>
                           <li class="active">
                              <strong>Bill</strong>
                           </li>-->
                        </ol>
                     </div>
                     <div class="col-lg-4">
                        <div class="title-action">
                           <!--                        <a href="#" class="btn btn-white"><i class="fa fa-pencil"></i> Edit </a>
                        <a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save </a>-->
                           <a href="totalbill_print?id=<?php echo $id . '&&bill=' . $getbill; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Bill </a>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="wrapper wrapper-content animated fadeInRight">
                           <div class="ibox-content p-xl">
                              <div class="row">
                                 <div class="col-sm-2">
                                    <img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive">
                                 </div>
                                 <div class="col-sm-9 pull-right">
                                    <h2 class="text-center mb-4"><strong>CHATO BEACH RESORT</strong></h2>
                                    <div class="d-flex" style="justify-content: space-between;">
                                            <span></span>
                                            <span>Chato Beach Resort Company Limited</span>
                                        </div>
                                        <div class="d-flex" style="justify-content: space-between;">
                                            <span></span>
                                            <span>TIN: 136073761</span>
                                        </div>
                                        <div class="d-flex" style="justify-content: space-between;">
                                            <span></span>
                                            <span>P.O Box 54 Chato, Geita</span>
                                        </div>
                                        <div class="d-flex" style="justify-content: space-between;">
                                            <span></span>
                                            <span>Tel: +255758301785</span>
                                        </div>
                                        <div class="d-flex" style="justify-content: space-between;">
                                            <span></span>
                                        </div>
                                        <div class="d-flex" style="justify-content: space-between;">
                                            <span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 12px;">
                                    <div class="col-sm-6">
                                        <span>
                                            <strong>
                                                Guest Information <br>
                                                Full Names:
                                            </strong>
                                       <?php
                                       $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$id'");
                                       $row =  mysqli_fetch_array($reservation);
                                       $firstname1 = $row['firstname'];
                                       $lastname1 = $row['lastname'];
                                       $room = $row['room'];
                                       $getnumber = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room'");
                                       $row1 =  mysqli_fetch_array($getnumber);
                                       $roomnumber = $row1['roomnumber'];
                                       echo $firstname1 . ' ' . $lastname1;

                                       ?>
                                    </span><br />
                                    <!--<span><strong>NIF:</strong></span><br>-->
                                        <span><strong>Room No:</strong> <?php echo $roomnumber; ?></span><br>
                                        <!--<span><strong>Assujetti à la TVA:</strong> Oui Non</span><br>-->
                                        <!--<span><strong>Doit pour ce qui suit:</strong></span><br>-->
                                        <address>
                                            <span><strong>Date:</strong> <?php echo date('d/m/Y', $timenow); ?></span><br />
                                        </address>


                                 </div>

                              </div>
                              <?php
                              $reservations = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$id'");
                              $row =  mysqli_fetch_array($reservations);
                              $reservation_id = $row['reservation_id'];
                              $firstname = $row['firstname'];
                              $lastname = $row['lastname'];
                              $checkin = $row['checkin'];
                              $phone = $row['phone'];
                              //$id_number=$row['id_number'];
                              $checkout = $row['checkout'];
                              $actualcheckout = $row['actualcheckout'];
                              $room_id = $row['room'];
                              $email = $row['email'];
                              $adults = $row['adults'];
                              $status = $row['status'];
                              $reduction = $row['reduction'] ?? 0;
                              $creator = $row['creator'];
                              $currency = $row['currency'];
                              $advance = $row['advance'];
                              $currencyrate = 1;
                              $getcurrencies = mysqli_query($con, "SELECT * FROM rates WHERE currency='TSHS' AND status='1'");
                              $curow = mysqli_fetch_array($getcurrencies);
                              $TSHSrate = $curow["rate"];

                              if (!empty($currency) && $currency !== "USD") {
                                 $getcurrencies = mysqli_query($con, "SELECT * FROM rates WHERE currency='$currency' AND status='1'");
                                 $curow = mysqli_fetch_array($getcurrencies);
                                 $currencyrate = $curow["rate"];
                              }

                              if ($getbill == 'accomodation' || $getbill == 'all') {
                                 $invoice_no = 23 * $id;
                                 if ($status == 2) {
                                    $nights = round(($actualcheckout - $checkin) / (3600 * 24));
                                 } else {
                                    $nights =  round(($checkout - $checkin) / (3600 * 24));
                                 }

                                 $totalreduction =intval( $reduction) * $nights;
                                 $advance = empty($advance) ? 0 : $advance;
                              ?>
                                 <h2 class="text-center">ACCOMODATION BILL</h2>
                                 <div class="table-responsive m-t">
                                    <table class="table invoice-table">
                                       <thead>
                                          <tr>
                                             <th>Room Number</th>
                                             <th>Type</th>
                                             <th>Checkin</th>
                                             <th>Checkout</th>
                                             <th>Nights</th>
                                             <th>Reduction</th>
                                             <th>Unit Charge</th>

                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr>
                                             <td>
                                                <div>
                                                   <strong>
                                                      <?php
                                                      $getnumber = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                                                      $row1 =  mysqli_fetch_array($getnumber);
                                                      $roomnumber = $row1['roomnumber'];
                                                      $type_id = $row1['type'];

                                                      echo $roomnumber; ?>
                                                   </strong>
                                                </div>
                                             </td>
                                             <td>
                                                <?php
                                                $roomtypes = mysqli_query($con, "SELECT * FROM roomtypes WHERE roomtype_id='$type_id'");
                                                $row1 =  mysqli_fetch_array($roomtypes);
                                                $roomtype = $row1['roomtype'];
                                                $sharecharge = $row1["sharecharge"];
                                                $charge = ($adults > 1 && isset($sharecharge)) ? $sharecharge : $row1['charge'];
                                                $charge =  $charge;
                                                $totalcharge = $charge * $nights;
                                                $totalcharge -= $totalreduction;
                                                $vat = 10;
                                                $vatamount = ($totalcharge * 0.18);
                                                echo $roomtype;
                                                ?>
                                             </td>
                                             <td><?php echo date('d/m/Y', $checkin); ?></td>
                                             <td><?php
                                                   if ($status == 2) {
                                                      echo date('d/m/Y', $actualcheckout);
                                                   } else {
                                                      echo date('d/m/Y', $checkout);
                                                   }
                                                   ?></td>
                                             <td><?php echo $nights; ?></td>
                                             <td><?php echo number_format($totalreduction); ?></td>
                                             <td><?php echo number_format($charge); ?></td>

                                          </tr>


                                       </tbody>
                                    </table>
                                 </div><!-- /table-responsive -->

                                 <table class="table invoice-total">
                                    <tbody>
                                       <tr>
                                          <td><strong>SUB TOTAL :</strong></td>
                                          <td><strong><?php
                                                       $totalcharge = $totalcharge - $vatamount;
                                                      echo number_format($totalcharge) . ' ' . $currency; ?></strong></td>
                                       </tr>
                                       <tr>
                                          <td><strong>VAT :</strong></td>
                                          <td><strong><?php
                                                     
                                                      echo number_format($vatamount) . ' ' . $currency; ?></strong></td>
                                       </tr>
                                       <tr>
                                          <td><strong>TOTAL :</strong></td>
                                          <td><strong><?php
                                                     $total= $totalcharge + $vatamount;
                                                      echo number_format($total) . ' ' . $currency; ?></strong></td>
                                       </tr>
                                        <tr>
                                            <td>BALANCE :</td>
                                            <td><strong><?php echo number_format($total - $advance ); ?></strong></td>
                                        </tr>
                                    </tbody>
                                 </table>
                                 <?php
                              }
                              if ($getbill == 'other' || $getbill == 'all') {
                                 $totalotherservices = 0;
                                 $getotherservices = mysqli_query($con, "SELECT * FROM otherservices WHERE reservation_id='$id' AND status=1") or die(mysqli_error($con));
                                 if (mysqli_num_rows($getotherservices) > 0) {
                                 ?>
                                    <h2 class="text-center">OTHER SERVICES</h2>
                                    <div class="table-responsive m-t">
                                       <table class="table invoice-table">
                                          <thead>
                                             <tr>
                                                <th>Date</th>
                                                <th>Service</th>
                                                <th>Charge</th>
                                                <th>Reduction</th>
                                                <th>Sub Total</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php

                                             while ($row3 = mysqli_fetch_array($getotherservices)) {
                                                $otherservice_id = $row3['otherservice_id'];
                                                $otherservice = $row3['otherservice'];
                                                $currency = $row3['currency'];
                                                if ($currency == 'USD') {
                                                   $rate = $usdtariff;
                                                } else {
                                                   $rate = 1;
                                                }
                                                $reduction = intval($row3['reduction']) * $rate;
                                                $price = intval($row3['price']) * $rate;
                                                $timestamp = $row3['timestamp'];
                                                $subtotal = $price - $reduction;
                                                $totalotherservices = $totalotherservices + $subtotal;
                                             ?>
                                                <tr>
                                                   <td><?php echo date('d/m/Y', $timestamp); ?></td>
                                                   <td><?php echo $otherservice;  ?></td>
                                                   <td><?php echo $price;  ?></td>
                                                   <td><?php echo $reduction;  ?></td>
                                                   <td><?php echo $subtotal;  ?></td>
                                                </tr>
                                             <?php } ?>

                                          </tbody>
                                       </table>
                                    </div><!-- /table-responsive -->

                                    <table class="table invoice-total">
                                       <tbody>
                                          <tr>
                                             <td><strong>TOTAL :</strong></td>
                                             <td><strong><?php
                                                         echo number_format($totalotherservices); ?> TSHS</strong></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 <?php
                                 }

                                 ?>

                                 <?php
                              }
                              if ($getbill == 'restaurant' || $getbill == 'all') {


                                 $restbill = 0;
                                 $restorder = mysqli_query($con, "SELECT * FROM orders WHERE guest='$id' AND status IN(1,2)");
                                 if (mysqli_num_rows($restorder) > 0) {
                                 ?>
                                    <h2 class="text-center">RESTAURANT ORDERS</h2>
                                    <?php


                                    while ($row =  mysqli_fetch_array($restorder)) {
                                       $order_id = $row['order_id'];
                                       $guest = $row['guest'];
                                       $timestamp = $row['timestamp'];
                                    ?>
                                       <div class="table-responsive m-t">

                                          <h3><i>Order Taken on <?php echo date('d/m/Y', $timestamp); ?></i></h3>
                                          <table class="table invoice-table">
                                             <thead>
                                                <tr>
                                                   <th>Food Name</th>
                                                   <th>Items</th>
                                                   <th>Unit Charge</th>
                                                   <th>Total Charge</th>

                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php
                                                $totalrestcosts = 0;
                                                $foodsordered =  mysqli_query($con, "SELECT * FROM restaurantorders WHERE order_id='$order_id'");
                                                while ($row3 =  mysqli_fetch_array($foodsordered)) {
                                                   $restorder_id = $row3['restorder_id'];
                                                   $food_id = $row3['food_id'];
                                                   $price = getForexConvertedAmount(1, $row3['foodprice']);
                                                   $quantity = $row3['quantity'];
                                                   $resttotal = $price * $quantity;
                                                   $totalrestcosts += $resttotal;
                                                   //                      $type=$row3['type'];

                                                ?>
                                                   <tr>
                                                      <td>
                                                         <div><strong>
                                                               <?php

                                                               $foodmenu = mysqli_query($con, "SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                                                               $row =  mysqli_fetch_array($foodmenu);
                                                               $menuitem_id = $row['menuitem_id'];
                                                               $menuitem = $row['menuitem'];

                                                               echo $menuitem;

                                                               ?>
                                                            </strong></div>
                                                      </td>
                                                      <td> <?php echo $quantity; ?></td>

                                                      <td><?php echo number_format($price); ?></td>
                                                      <td><?php echo number_format($resttotal); ?></td>
                                                   </tr>
                                                <?php } ?>

                                             </tbody>
                                          </table>
                                       </div><!-- /table-responsive -->

                                       <table class="table invoice-total">
                                          <tbody>
                                             <tr>
                                                <?php
                                                $totalcharges = mysqli_query($con, "SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                                                $row =  mysqli_fetch_array($totalcharges);
                                                $totalrestcosts = getForexConvertedAmount(1, $row['totalcosts']);
                                                $restbill = $totalrestcosts + $restbill;
                                                ?>
                                                <td><strong>TOTAL :</strong></td>
                                                <td><strong><?php echo number_format($totalrestcosts); ?> TSHS</strong></td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    <?php
                                    }
                                 }
                              }
                              if ($getbill == 'laundry' || $getbill == 'all') {

                                 $totallaundry = 0;
                                 $laundry = mysqli_query($con, "SELECT * FROM laundry WHERE status='1' AND reserve_id='$id' Group BY timestamp");
                                 if (mysqli_num_rows($laundry)) {
                                    ?>
                                    <h2 class="text-center">LAUNDRY WORK</h2>
                                    <?php

                                    while ($row =  mysqli_fetch_array($laundry)) {
                                       $laundry_id = $row['laundry_id'];
                                       $reserve_id = $row['reserve_id'];
                                      
                                       $timestamp = $row['timestamp'];
                                       $status = $row['status'];
                                       $creator = $row['creator'];
                                       $invoice_no = 23 * $id;
                                       $charge = getForexConvertedAmount(1, $row['charge']);
                                       $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
                                       $row2 =  mysqli_fetch_array($reservation);
                                       $firstname = $row2['firstname'];
                                       $lastname = $row2['lastname'];
                                       $room_id = $row2['room'];
                                       $phone = $row2['phone'];
                                       
                                       //get all laundry per timestamp
                                       $getlaundry = mysqli_query($con, "SELECT * FROM laundry WHERE status='1' AND reserve_id='$id' AND timestamp='$timestamp'");
                                      
                                      
                                    ?>
                                       <div class="table-responsive m-t">
                                          <h3><i>Laundry Work on <?php echo date('d/m/Y', $timestamp); ?></i></h3>
                                          <table class="table invoice-table">
                                             <thead>
                                                <tr>
                                                   <th>Item Type</th>
                                                   <th>Package</th>
                                                   <th>Quantity</th>
                                                   <th>Unit Price</th>
                                                   <th>Date</th>
                                                   <th>Charge</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                              
                                                   <?php
                                                   while($row4=  mysqli_fetch_array($getlaundry)) {
                                                      $clothes = $row4['clothes'];
                                                      $package_id = $row4['package_id'];
                                                      $charge = getForexConvertedAmount(1, $row4['charge']);
                                                      $laundrycharge = $charge * $clothes;
                                                      $totallaundry = $totallaundry + $laundrycharge;
                                                      $getpackage = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1' AND laundrypackage_id='$package_id'");
                                                      $row3 = mysqli_fetch_array($getpackage);
                                                      $laundrypackage = $row3['laundrypackage'];

                                                   ?>
                                                     <tr>
                                                   <td>
                                                      <div><strong>
                                                            Laundry Work
                                                         </strong></div>
                                                   </td>
                                                   <td><?php echo $laundrypackage; ?></td>
                                                   <td><?php echo $clothes;  ?></td>
                                                   <td><?php echo number_format($charge); ?></td>
                                                   <td><?php echo date('d/m/Y', $timestamp); ?></td>
                                                   <td><?php echo number_format($laundrycharge); ?></td>
                                                </tr>
                                                   <?php } ?>
                                             </tbody>
                                          </table>
                                       </div><!-- /table-responsive -->

                                    <?php }   ?>
                                    <table class="table invoice-total">
                                       <tbody>
                                          <tr>
                                             <td><strong>TOTAL :</strong></td>
                                             <td><strong><?php echo number_format($totallaundry); ?> TSHS</strong></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 <?php
                                 }
                              }
                              if ($getbill == 'gym' || $getbill == 'all') {

                                 $totalgym = 0;
                                 $gym = mysqli_query($con, "SELECT * FROM poolsubscriptions WHERE status='1' AND reserve_id='$id' ORDER BY timestamp");
                                 if (mysqli_num_rows($gym)) {
                                 ?>
                                    <h2 class="text-center">GYM AND SWIMMING POOL SUBSCRIPTIONS</h2>
                                    <?php

                                    while ($row =  mysqli_fetch_array($gym)) {
                                       $gym_id = $row['poolsubscription_id'];
                                       $reserve_id = $row['reserve_id'];
                                       $package_id = $row['package'];
                                       $timestamp = $row['timestamp'];
                                       $status = $row['status'];
                                       $creator = $row['creator'];
                                       $invoice_no = 23 * $id;
                                       $charge = getForexConvertedAmount(1, $row['charge']);
                                       $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
                                       $row2 =  mysqli_fetch_array($reservation);
                                       $firstname = $row2['firstname'];
                                       $lastname = $row2['lastname'];
                                       $room_id = $row2['room'];
                                       $phone = $row2['phone'];
                                       $getpackage = mysqli_query($con, "SELECT * FROM poolpackages WHERE status='1' AND poolpackage_id='$package_id'");
                                       $row3 = mysqli_fetch_array($getpackage);
                                       $gympackage = $row3['poolpackage'];
                                       $gymcharge = $charge;
                                       $totalgym = $totalgym + $gymcharge;
                                    ?>
                                       <div class="table-responsive m-t">
                                          <h3><i>Pool Subscription on <?php echo date('d/m/Y', $timestamp); ?></i></h3>
                                          <table class="table invoice-table">
                                             <thead>
                                                <tr>
                                                   <th>Item Type</th>

                                                   <th>Date</th>
                                                   <th>Charge</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <tr>
                                                   <td>
                                                      <div>
                                                         <strong>
                                                            <?php echo $gympackage; ?>
                                                         </strong>
                                                      </div>
                                                   </td>

                                                   <td><?php echo date('d/m/Y', $timestamp); ?></td>
                                                   <td><?php echo number_format($gymcharge); ?></td>
                                                </tr>

                                             </tbody>
                                          </table>
                                       </div><!-- /table-responsive -->

                                    <?php }   ?>
                                    <table class="table invoice-total">
                                       <tbody>
                                          <tr>
                                             <td><strong>TOTAL :</strong></td>
                                             <td><strong><?php echo number_format($totalgym); ?> TSHS</strong></td>
                                          </tr>
                                       </tbody>
                                    </table>

                              <?php }
                              } ?>

                              <div class="well m-t text-center">
                                 <h3 style="font-style: italic">Thank you for Spending time at Our Hotel</h3>
                              </div>

                              <div class="d-flex">
                                 <div class="ml-auto">
                                    <p class="fs-16">
                                       Created By:
                                       <?php
                                       $empid = $_SESSION['emp_id'];
                                       $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$empid'");
                                       $row = mysqli_fetch_array($employee);
                                       // $employee_id = $row['employee_id'];
                                       $fullname = $row['fullname'] ?? "";
                                       echo $fullname;
                                       ?>
                                    </p>
                                 </div>
                              </div>

                           </div>
                        </div>
                     </div>
                  </div>

               </div>
               <div class="big-footer">
                  <div class="footer-text__block text-center">
                     <span>Chato, Geita Tanzania• Tel (255) 0758301785 • VAT NO: 400297540</span> <br>
                    <span>Email: info@chatobeachresort.com• Website: www.chatobeachresort.com</span>
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


      </body>

      </html>
<?php }
} ?>
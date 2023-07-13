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
                <div class="col-lg-8">
                    <h2><?php echo $getbill; ?> Total Bill</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index">Home</a>
                        </li>
                        <li>
                            <a href="getbill">Get Bill</a>
                        </li>
                        <li class="active">
                            <strong>Bill</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
<!--                        <a href="#" class="btn btn-white"><i class="fa fa-pencil"></i> Edit </a>
                        <a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save </a>-->
                        <a href="totalbill_print?id=<?php echo $id.'&&bill='.$getbill; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Bill </a>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInRight">
                     <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-2"><img src="assets/demo/pearllogo.png" class="img img-responsive"></div>
                                <div class="col-sm-4">
                                                                                                      
                                </div>

                                <div class="col-sm-6 text-right">
                                    <h4>Invoice No.</h4>
                                    <h4 class="text-navy"><?php echo $id*23; ?></h4>
                                                                    
                                     <span><strong>Guest Name:</strong>   <?php
                         $reservation=mysqli_query($con,"SELECT * FROM reservations WHERE reservation_id='$id'");
$row=  mysqli_fetch_array($reservation);
 $firstname1=$row['firstname'];
$lastname1=$row['lastname'];
              echo $firstname1.' '.$lastname1;
                            
                            ?></span><br/>
                                     
                                    <address>
                                            <span><strong>Invoice Date:</strong> <?php echo date('d/m/Y',$timenow); ?></span><br/>
                                    </address>
                              
                                 
                                </div>
                                
                            </div>
                      <?php
                      if($getbill=='accomodation'){
                      $reservations=mysqli_query($con,"SELECT * FROM reservations WHERE reservation_id='$id'");
$row=  mysqli_fetch_array($reservations);
  $reservation_id=$row['reservation_id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
//$id_number=$row['id_number'];
$checkout=$row['checkout'];
$actualcheckout=$row['actualcheckout'];
$room_id=$row['room'];
  $email=$row['email'];
  $status=$row['status'];
//  $country=$row['country'];
  $creator=$row['creator'];
 $invoice_no=23*$id;
 if($status==2){
   $nights= round(($actualcheckout-$checkin)/(3600*24))+1;
 }  else {
  $nights=  round(($checkout-$checkin)/(3600*24))+1;   
 }
   
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
                                          <th>Unit Charge</th>
                                    
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><div><strong>
                                                       <?php 
                                            $getnumber=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($getnumber);
                                            $roomnumber=$row1['roomnumber'];
                                            $type_id=$row1['type'];
                       echo $roomnumber; ?>
                                                </strong></div>
                                            </td>
                                        <td>  <?php 
                                            $roomtypes=mysqli_query($con,"SELECT * FROM roomtypes WHERE roomtype_id='$type_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row1['roomtype'];
                                            $charge=$row1['charge'];
                                       echo $roomtype; 
                       ?></td>
                                        <td><?php echo date('d/m/Y',$checkin); ?></td>
                                        <td><?php 
                                        if($status==2){
                                        echo date('d/m/Y',$actualcheckout);
                                        }  else {
                                                echo date('d/m/Y',$checkout);
                                        }
                                        ?></td>
                                        <td><?php echo number_format($charge);?></td>
                                    </tr>
                                    

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>
                                                                <tr>
                                    <td><strong>TOTAL :</strong></td>
                                    <td><strong><?php 
                                    $totalcharge=$charge*$nights;
                                    echo number_format($totalcharge);?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                            <?php 
                      } elseif ($getbill=='restaurant') {
            
        
                              $restbill=0;
                             $restorder=mysqli_query($con,"SELECT * FROM orders WHERE guest='$id' AND status IN(1,2)");
                             if(mysqli_num_rows($restorder)>0){
                            ?>
                         <h2 class="text-center">RESTAURANT ORDERS</h2>
 <?php 
                             
                         
        while ($row=  mysqli_fetch_array($restorder)){
  $order_id=$row['order_id'];
  $guest=$row['guest'];
  $timestamp=$row['timestamp'];
                              ?>
                            <div class="table-responsive m-t">
                               
                                <h3><i>Order Taken on <?php echo date('d/m/Y',$timestamp); ?></i></h3>
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
                                           $foodsordered=  mysqli_query($con,"SELECT * FROM restaurantorders WHERE order_id='$order_id'");
      while ($row3=  mysqli_fetch_array($foodsordered)){
                      $restorder_id=$row3['restorder_id'];
                      $food_id=$row3['food_id'];
                      $price=$row3['foodprice'];
                      $quantity=$row3['quantity'];
//                      $type=$row3['type'];
                    
 ?>
                                    <tr>
                                        <td><div><strong>
                                                   <?php 
                  
                    $foodmenu=mysqli_query($con,"SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                    $row=  mysqli_fetch_array($foodmenu);
                    $menuitem_id=$row['menuitem_id'];
                            $menuitem=$row['menuitem'];
 
                            echo $menuitem;
         
                                                   ?>
                                                </strong></div>
                                            </td>
                                        <td> <?php echo $quantity; ?></td>
                                       
                                        <td><?php echo number_format($price);?></td>
                                        <td><?php echo number_format($price*$quantity);?></td>
                                    </tr>
                                      <?php }?>

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>
                                                                <tr>
                                                                    <?php
                                              $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                            $row=  mysqli_fetch_array($totalcharges);
                            $totalrestcosts=$row['totalcosts'];
                            $restbill=$totalrestcosts+$restbill;
                                                                                             ?>
                                    <td><strong>TOTAL :</strong></td>
                                    <td><strong><?php    echo number_format($restbill); ?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                             <?php
}}}elseif ($getbill=='laundry') {
                                        
                $totallaundry=0;
                               $laundry=mysqli_query($con,"SELECT * FROM laundry WHERE status='1' AND reserve_id='$id' ORDER BY timestamp");
                               if(mysqli_num_rows($laundry)){
                             ?>
                               <h2 class="text-center">LAUNDRY WORK</h2>
                            <?php
                          
         while($row=  mysqli_fetch_array($laundry)){
        $laundry_id=$row['laundry_id'];
           $reserve_id=$row['reserve_id'];
           $clothes=$row['clothes'];
           $package_id=$row['package_id'];
           $timestamp=$row['timestamp'];
           $status=$row['status'];
           $creator=$row['creator'];
            $invoice_no=23*$id;
        $charge=$row['charge'];
           $reservation=mysqli_query($con,"SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
           $row2=  mysqli_fetch_array($reservation);
 $firstname=$row2['firstname'];
$lastname=$row2['lastname'];
$room_id=$row2['room'];
$phone=$row2['phone'];
$country=$row2['country'];
      $getpackage=mysqli_query($con,"SELECT * FROM laundrypackages WHERE status='1' AND laundrypackage_id='$package_id'");
                                                    $row3 = mysqli_fetch_array($getpackage);
                                                    $laundrypackage=$row3['laundrypackage'];
             $totallaundry=$totallaundry+$charge;
                                                    ?>
                                  <div class="table-responsive m-t">
                                         <h3><i>Laundry Work  on <?php echo date('d/m/Y',$timestamp); ?></i></h3>
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                           <th>Item Type</th>
                                        <th>Number of Clothes</th>
                                        <th>Date</th>
                                        <th>Charge</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><div><strong>
                                                   Laundry Work
                                                </strong></div>
                                            </td>
                                                                              <td><?php  echo $clothes;  ?></td>
                                                                              <td><?php echo date('d/m/Y',$timestamp); ?></td>
                                        <td><?php echo number_format($charge);?></td>
                                    </tr>
                                    
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

<?php }   ?>
                              <table class="table invoice-total">
                                <tbody>
                                                                <tr>
                                    <td><strong>TOTAL :</strong></td>
                                    <td><strong><?php echo number_format($totallaundry);?></strong></td>
                                </tr>
                                </tbody>
                            </table>
  <?php } }
 echo '  <div class="well m-t text-center"> <h3 style="font-style: italic">Thank you for Spending time at Our Hotel</h3></div>';
                           ?>

                         
                        </div>
                </div>
            </div>
        </div>

        </div>
    </div>

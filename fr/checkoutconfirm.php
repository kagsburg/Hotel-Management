
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
                    <h2>Checking Out Guest</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                             <a href="reservation?id=<?php echo $id; ?>">Reservation</a>
                        </li>
                        <li class="active">
                            <strong>Enter Actual Checkout date</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                
                             <?php
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
  $country=$row['country'];
  $creator=$row['creator'];
 $invoice_no=23*$id;
 if($status==2){
   $nights= round(($actualcheckout-$checkin)/(3600*24))+1;
 }  else {
  $nights=  round(($checkout-$checkin)/(3600*24))+1;   
 }
                                                     $getnumber=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($getnumber);
                                            $roomnumber=$row1['roomnumber'];
                                            $type_id=$row1['type'];
                                            $roomtypes=mysqli_query($con,"SELECT * FROM roomtypes WHERE roomtype_id='$type_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row1['roomtype'];
                                            $charge=$row1['charge'];
                                              
                                                                ?>
                      
                <div class="col-lg-3">
                <div class="widget style1 red-bg">
                    <div class="row">
                      <div class="col-xs-10">
                            <span>Restaurant bill</span>
                            <h2 class="font-bold">
                             <?php
                                                      $restbill=0;
                             $restorder=mysqli_query($con,"SELECT * FROM orders WHERE guest='$id' AND status='1'");
                                                       while ($row=  mysqli_fetch_array($restorder)){
  $order_id=$row['order_id'];
  $guest=$row['guest'];
  $timestamp=$row['timestamp'];
                                                  
                                           $foodsordered=  mysqli_query($con,"SELECT * FROM restaurantorders WHERE order_id='$order_id'");
      while ($row3=  mysqli_fetch_array($foodsordered)){
                      $restorder_id=$row3['restorder_id'];
                      $food_id=$row3['food_id'];
                      $price=$row3['foodprice'];
                      $quantity=$row3['quantity'];
                      $type=$row3['type'];
 
                                                   if($type=='drink'){
                      $drinks=mysqli_query($con,"SELECT * FROM drinks WHERE drink_id='$food_id'");
   $row2=  mysqli_fetch_array($drinks);
  $drinkname=$row2['drinkname'];
  $drinkquantity=$row2['quantity'];   
                   
                      }else{
                    $foodmenu=mysqli_query($con,"SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                    $row=  mysqli_fetch_array($foodmenu);
                    $menuitem_id=$row['menuitem_id'];
                            $menuitem=$row['menuitem'];
                   }
                                   
                                      }
                                              $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                            $row=  mysqli_fetch_array($totalcharges);
                            $totalrestcosts=$row['totalcosts'];
                            $restbill=$totalrestcosts+$restbill;
                                                                    
                             }
                               echo number_format($restbill); 
                             
                            ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                 <div class="col-lg-3">
                <div class="widget style1 yellow-bg">
                    <div class="row">
                      <div class="col-xs-10">
                            <span>Bar bill</span>
                            <h2 class="font-bold">
                             <?php
                          $totalbarbill=0;
                             $barorder=mysqli_query($con,"SELECT * FROM barorders WHERE guest='$id' AND status='1'");
                    
                              while ($row=  mysqli_fetch_array($barorder)){
  $border_id=$row['barorder_id'];
  $guest=$row['guest'];
  $timestamp=$row['timestamp'];
                                           $getdrinks=  mysqli_query($con,"SELECT * FROM barorder_drinks WHERE barorder_id='$border_id'");
                        while($row=  mysqli_fetch_array($getdrinks)){ 
                                          $drink_id=$row['drink_id'];
                                          $charge=$row['charge'];
                                          $items=$row['items'];
                                          $drinkorder_id=$row['drinkorder_id'];
                                          $getdrink=mysqli_query($con,"SELECT * FROM drinks WHERE drink_id='$drink_id'");
                                            $row2=  mysqli_fetch_array($getdrink);
                                                  $drink=$row2['drinkname'];
                                                  $quantity=$row2['quantity'];
                                              $drinktotal=$charge*$items;   
                                              $totalbarbill=$totalbarbill+$drinktotal;
                                    
                                   }
                                                $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(charge*items), 0) AS totalcosts FROM barorder_drinks WHERE barorder_id='$border_id'");
                            $row=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row['totalcosts'];
                            $totalbarbill=$totalcosts+$totalbarbill;
                              }
                                     echo number_format($totalbarbill); 
                                     ?>
                            
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                    <div class="col-lg-3">
                <div class="widget style1 blue-bg">
                    <div class="row">
                      <div class="col-xs-10">
                            <span>Laundry bill</span>
                            <h2 class="font-bold">
                             <?php
                               $laundrycharge=0;
                               $laundry=mysqli_query($con,"SELECT * FROM laundry WHERE status='1' AND reserve_id='$id' ORDER BY timestamp");
                            
         while($row=  mysqli_fetch_array($laundry)){
           $laundry_id=$row['laundry_id'];
           $reserve_id=$row['reserve_id'];
           $clothes=$row['clothes'];
           $charge=$row['charge'];
           $timestamp=$row['timestamp'];
           $status=$row['status'];
           $creator=$row['creator'];
           $laundrycharge=$laundrycharge+$charge;
            $invoice_no=23*$id;
           $reservation=mysqli_query($con,"SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
           $row2=  mysqli_fetch_array($reservation);
 $firstname=$row2['firstname'];
$lastname=$row2['lastname'];
$room_id=$row2['room'];
$phone=$row2['phone'];
$country=$row2['country'];
         }  
                                     echo number_format($laundrycharge);
                
                                     ?>
                        
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                 <div class="col-lg-3">
                <div class="widget style1 navy-bg">
                    <div class="row">
                      <div class="col-xs-10">
                            <span>Hall Reservation bill</span>
                            <h2 class="font-bold">
                             <?php
                           $hreservation=mysqli_query($con,"SELECT * FROM hallreservations WHERE  guest='$id' AND status='3'");
$row=  mysqli_fetch_array($hreservation);
  $hallreservation_id=$row['hallreservation_id'];
$fullname=$row['fullname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
$checkout=$row['checkout'];
  $status=$row['status'];
  $purpose=$row['purpose'];
  $people=$row['people'];
  $country=$row['country'];
  $creator=$row['creator'];
 $invoice_no=23*$id;
  $days=($checkout-$checkin)/(3600*24)+1;
   $purposes=mysqli_query($con,"SELECT * FROM hallpurposes WHERE hallpurpose_id='$purpose'");
                                                     $row3 = mysqli_fetch_array($purposes);
                                                     $hallpurpose_id=$row3['hallpurpose_id'];
                                                     $hallpurpose=$row3['hallpurpose']; 
                                                     $charge=$row3['charge']; 
                  $totalhallcharge=$charge*$days;
                                    echo number_format($totalhallcharge);
                                     ?>
                        
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                </div>
             <div class="row">
                <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Guest Details</h5>
                       
                    </div>
                    <div class="ibox-content">
<?php
$reservations=mysqli_query($con,"SELECT * FROM reservations WHERE reservation_id='$id'");
$row=  mysqli_fetch_array($reservations);
  $reservation_id=$row['reservation_id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
//$id_number=$row['id_number'];
$checkout=$row['checkout'];
$room_id=$row['room'];
  $email=$row['email'];
  $status=$row['status'];
  $guests=$row['guests'];
  $country=$row['country'];
  $creator=$row['creator'];
  $paidby=$row['paidby'];
  $orgname=$row['orgname'];
  $orgcontact=$row['orgcontact'];
  
              ?>
     <div>
                                <div class="feed-activity-list">

                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Guest Name</strong>. : <?php echo $firstname.' '.$lastname; ?> <br>
                                             </div>
                                    </div>
                                         <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Country</strong>. : <?php echo $country; ?> <br>
                                             </div>
                                    </div>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Phone Number</strong>. : <?php echo $phone; ?> <br>
                                             </div>
                                    </div>
                                  
                                      <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Check In</strong>  : <?php echo date('d/m/Y',$checkin); ?> <br>
                                             </div>
                                    </div>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Expected Check Out</strong>  : <?php echo date('d/m/Y',$checkout); ?> <br>
                                             </div>
                                    </div>
                                             <div class="feed-element">
                                                                              <div class="media-body ">
                                                     <strong>Room Number: </strong>
                                                     <?php 
                                            $getnumber=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($getnumber);
                                            $roomnumber=$row1['roomnumber'];
                                            $type_id=$row1['type'];
                       echo $roomnumber; ?>
                                                     . <br>
                                                                                                                              </div>
                                    </div>                     
                                                                  
                                                                                                 
                                             </div>
                            </div>
                    </div>
                </div>
            </div>
                <div class="col-lg-6">
                       <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Add Checkout Details</h5>
                          
                        </div>
                        <div class="ibox-content">
                            <?php
                            if(isset($_POST['bill'],$_POST['actualcheckout'])){
                                $bill=  mysqli_real_escape_string($con,trim($_POST['bill']));
                               $actualcheckout=  mysqli_real_escape_string($con,strtotime($_POST['actualcheckout']));
                                if((empty($actualcheckout))||(empty($bill))){
                                   $errors[]='All Fileds required';
                                }
                                         if(is_numeric($bill)==FALSE){
                                   $errors[]='Bill Amount must be in figures';
                            }                               
                                 if($actualcheckout>$timenow){
                                $errors[]='Actual Checkout Date Cant be later than Current Date'; }
                                if(!empty($errors)){
foreach($errors as $error){ 
 ?>
 <div class="alert alert-danger"><?php echo $error; ?></div>
<?php 
}         }else{
     $nights= round(($actualcheckout-$checkin)/(3600*24))+1;
     $totalcharge=$charge*$nights;
        $totalbill=$totalcharge+$restbill+$totalbarbill+$laundrycharge+$totalhallcharge;
                            $update=  mysqli_query($con,"UPDATE reservations SET status='2',actualcheckout='$actualcheckout',creator='".$_SESSION['emp_id']."' WHERE reservation_id='$id'");
                           $adddetails=  mysqli_query($con,"INSERT INTO checkoutdetails VALUES('','$id','$bill','$totalbill',UNIX_TIMESTAMP())");   
                            $lastid=  mysqli_insert_id($con);
                              $addpayments=  mysqli_query($con,"INSERT INTO  checkoutpayments VALUES('','$lastid','$bill','$actualcheckout')"); 
                            ?>
                            <div class="alert alert-success">Guest checkout Successfully Updated <a href="<?php echo 'getbill?id='.$id.'&&n='.$firstname.' '.$lastname; ?>">Click Here</a> to View Bills</div>
                            <?php 
                                                        }
                                                        }
                            ?>
 <form role="form" method="POST" action="" enctype="multipart/form-data">
                                                          <div class="form-group">
                                <label class="font-noraml">Add  Bill Payment</label>                                
                                   <input type="text"  name="bill" class="form-control">
                                                           </div>
    
         <div class="form-group" id="data_1">
                                <label class="font-noraml">Select Actual Checkout Date</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text"  name="actualcheckout" class="form-control" required="required">
                                </div>
                            </div>
                                                            <button class="btn btn-sm btn-info pull-right m-t-n-xs" type="submit"><strong>Confirm checkout</strong></button>
                                                                                                                
                                                    </form>
                            <div style="clear:both"></div>
                                    </div>
                       </div>
                 
            </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>

   
                        </div>

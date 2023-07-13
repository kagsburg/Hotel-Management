    <div id="wrapper">

        <?php include 'nav.php'; ?>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
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
                <div class="col-lg-9">
                    <h2>Dashboard</h2>
                 <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Checkout Stats</a>                    </li>
                        
                    </ol>
                </div>
                           </div>
            <div class="wrapper wrapper-content animated fadeInRight">
           
                <div class="row">
                 <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Checkout Information</h5>
                  
                    </div>
                    <div class="ibox-content">
                       
                     <div class="panel blank-panel">

                        <div class="panel-heading">
                                                     <div class="panel-options">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-1">Guests Checking out in next 7 days</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-2">Guest Checkouts in Past 7 days</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-3">Guest Checkouts in Past 30 days</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">

                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
                                      <?php
$reservations=mysqli_query($con,"SELECT * FROM reservations WHERE  round((checkout-$timenow)/(3600*24))<7 AND round((checkout-$timenow)/(3600*24))>=0 AND status='1' ORDER BY checkout");
if(mysqli_num_rows($reservations)>0){
 
 ?>
                                  <table class="table table-striped">
                            <thead>
                             <tr>
                          <th>Guest</th>
                        <th>Room Number</th>
                           <th>Check In</th>
                        <th>Check Out</th>
                         <th>Action</th>
                        <!--<th>Action</th>-->
                    </tr>
                            </thead>
                            <tbody>
                                 <?php
               while($row=  mysqli_fetch_array($reservations)){
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
  $nationality=$row['nationality'];
  $creator=$row['creator'];
  
              ?>
                                <tr class="gradeA">
                    <td><?php echo $firstname.' '.$lastname; ?></td>
                     
                         <td class="center">
                                         <?php 
                                            $roomtypes=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row1['roomnumber'];
                       echo $roomtype; ?>
                        </td>
                        <td><?php echo date('d/m/Y',$checkin); ?></td>
                        <td><?php echo date('d/m/Y',$checkout); ?></td>
                    
                       <td><a href="reservation?id=<?php echo $reservation_id;?>" class="btn btn-xs btn-info">Details</a></td>
      
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }else{?>
                        <div class="alert  alert-danger">Oops!! No Guests Are Checking out in Next 7 Days</div>
 <?php }?>

                                </div>

                                <div id="tab-2" class="tab-pane">
                                      <?php
$reservations=mysqli_query($con,"SELECT * FROM reservations WHERE  round(($timenow-checkout)/(3600*24))<=7 AND round(($timenow-checkout)/(3600*24))>0  AND status='2' ORDER BY checkout DESC");
if(mysqli_num_rows($reservations)>0){
 
 ?>
                                  <table class="table table-striped">
                            <thead>
                             <tr>
                          <th>Guest</th>
                        <th>Room Number</th>
                           <th>Check In</th>
                        <th>Check Out</th>
                         <th>Action</th>
                        <!--<th>Action</th>-->
                    </tr>
                            </thead>
                            <tbody>
                                 <?php
               while($row=  mysqli_fetch_array($reservations)){
  $reservation_id=$row['reservation_id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
$checkout=$row['checkout'];
$room_id=$row['room'];
  $email=$row['email'];
  $status=$row['status'];
   $creator=$row['creator'];
  
              ?>
                                <tr class="gradeA">
                    <td><?php echo $firstname.' '.$lastname; ?></td>
                     
                         <td class="center">
                                         <?php 
                                            $roomtypes=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row1['roomnumber'];
                       echo $roomtype; ?>
                        </td>
                        <td><?php echo date('d/m/Y',$checkin); ?></td>
                        <td><?php echo date('d/m/Y',$checkout); ?></td>
                    
                       <td><a href="reservation?id=<?php echo $reservation_id;?>" class="btn btn-xs btn-info">Details</a></td>
      
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }else{?>
                        <div class="alert  alert-danger">Oops!! No Guests Have Checked out in Past 7  Days</div>
 <?php }?>

                                </div>
                                  <div id="tab-3" class="tab-pane">
                                                         <?php
$reservations=mysqli_query($con,"SELECT * FROM reservations WHERE  round(($timenow-checkout)/(3600*24))<=30 AND round(($timenow-checkout)/(3600*24))>0  AND status='2'  ORDER BY checkout DESC");
if(mysqli_num_rows($reservations)>0){
 
 ?>
                                  <table class="table table-striped">
                            <thead>
                             <tr>
                          <th>Guest</th>
                        <th>Room Number</th>
                           <th>Check In</th>
                        <th>Check Out</th>
                         <th>Action</th>
                        <!--<th>Action</th>-->
                    </tr>
                            </thead>
                            <tbody>
                                 <?php
               while($row=  mysqli_fetch_array($reservations)){
  $reservation_id=$row['reservation_id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
$id_number=$row['id_number'];
$checkout=$row['checkout'];
$room_id=$row['room'];
  $email=$row['email'];
  $status=$row['status'];
  $creator=$row['creator'];
  
              ?>
                                <tr class="gradeA">
                    <td><?php echo $firstname.' '.$lastname; ?></td>
                     
                         <td class="center">
                                         <?php 
                                            $roomtypes=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row1['roomnumber'];
                       echo $roomtype; ?>
                        </td>
                        <td><?php echo date('d/m/Y',$checkin); ?></td>
                        <td><?php echo date('d/m/Y',$checkout); ?></td>
                    
                       <td><a href="reservation?id=<?php echo $reservation_id;?>" class="btn btn-xs btn-info">Details</a></td>
      
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }else{?>
                        <div class="alert  alert-danger">Oops!! No Guests Have Checked out in Past  30 Days</div>
 <?php }?>

                                </div>
                            </div>

                        </div>

                    </div>
                    </div>
                </div>
            </div>

                                   </div>
                   </div>
    </div>

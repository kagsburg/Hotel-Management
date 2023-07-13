              <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                              <div class="row">
                                <div class="col-xs-2"><img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive"></div>
                                <div class="col-xs-4">
                                </div>
   </div>
                 <h1 class="text-center">All Stock Items</h1>
                            <div class="table-responsive m-t">
                            
                                <table class="table invoice-table">
                                    <thead>
                                     <tr>
                       <th>Guest</th>
                        <th>Room Number</th>
                           <th>Check In</th>
                        <th>Check Out</th>
                    
                        
                    </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $reservations=mysqli_query($con,"SELECT * FROM reservations WHERE status='0' ORDER BY reservation_id DESC");
                          while($row=  mysqli_fetch_array($reservations)){
  $reservation_id=$row['reservation_id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
$checkout=$row['checkout'];
$room_id=$row['room'];
$country=$row['country'];
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
                      
                    </tr>
                 <?php }?>
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                        
                            
                            <div class="well m-t">
                                <strong style="font-style: italic">@<?php echo date('Y',$timenow);?> All Rights Reserved</strong>
                            </div>
                        </div>

    </div>


                <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-2"><img src="assets/demo/graceland-logo.png" class="img img-responsive"></div>
                                <div class="col-sm-4">
                                                                       <address>
                                                                           <h3></h3>
                                        <strong>Graceland Hotel</strong><br>
                                        Mbela Misugwi<br>
                                        Mwanza, Tanzania<br>
                                        <strong>P : </strong> 0769657573 , 0767747515<br/>
                                        www.gracelandhotel.com<br/>
                                            
                                    </address>
                                 
                                </div>

                              
                                
                            </div>
                 <h1 class="text-center">All Guests Out</h1>
                            <div class="table-responsive m-t">
                            
                                <table class="table invoice-table">
                                    <thead>
                                     <tr>
                       <th>Guest</th>
                        <th>Room Number</th>
                           <th>Check In</th>
                        <th>Check Out</th>
                        <th>Adults</th>
                        <th>Children</th>
                        
                    </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $reservations=mysqli_query($con,"SELECT * FROM reservations WHERE checkout<'$timenow' AND status='2' ORDER BY reservation_id DESC");
                          while($row=  mysqli_fetch_array($reservations)){
  $reservation_id=$row['reservation_id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
$checkout=$row['checkout'];
$room_id=$row['room'];
  $adults=$row['adults'];
  $country=$row['country'];
  $children=$row['children'];
  
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
                        <td class="center">           <?php echo $adults;?> </td>
                          <td>  <?php echo $children;?>             
                        </td>
                      
      
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

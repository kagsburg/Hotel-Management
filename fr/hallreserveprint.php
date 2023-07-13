                <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-xs-2"><img src="assets/demo/pearllogo.png" class="img img-responsive"></div>
                                <div class="col-xs-4">
                                </div>

                              
                                
                            </div>
                 <h1 class="text-center">All Hall Reservations</h1>
                            <div class="table-responsive m-t">
                            
                                <table class="table invoice-table">
                                    <thead>
                                   <tr>
                      <th>Guest</th>
                        <th>phone</th>
                        <th> Email</th>
                        <th>Country</th>
                          <th>Check In</th>
                        <th>Check Out</th>
                      
                    </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                   $reservations=mysqli_query($con,"SELECT * FROM hallreservations WHERE status='1' ORDER BY hallreservation_id DESC");
              while($row=  mysqli_fetch_array($reservations)){
  $hallreservation_id=$row['hallreservation_id'];
$fullname=$row['fullname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
$checkout=$row['checkout'];
  $email=$row['email'];
  $status=$row['status'];
  $country=$row['country'];
  $creator=$row['creator'];
  
              ?>
               
                    <tr class="gradeA">
                    <td><?php echo $fullname; ?></td>
                        <td><?php echo $phone; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $country; ?></td>
                               <td><?php echo date('d/m/Y',$checkin); ?></td>
                        <td><?php echo date('d/m/Y',$checkout); ?></td>
                                          
      
                    </tr>
                 <?php }?>

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                        
                            
                            <div class="well m-t">
                                <strong style="font-style: italic">@<?php echo date('Y',$timenow);?> All Rights Reserved To Hotel Graceland<strong>
                            </div>
                        </div>

    </div>

 
                  <div class="wrapper wrapper-content p-xl">
               <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-xs-2"><img src="assets/demo/pearllogo.png" class="img img-responsive"></div>
                                <div class="col-xs-4"></div>
<?php
$laundry=mysqli_query($con,"SELECT * FROM laundry WHERE status='1' AND laundry_id='$id'");
         $row=  mysqli_fetch_array($laundry);
             $laundry_id=$row['laundry_id'];
           $reserve_id=$row['reserve_id'];
           $clothes=$row['clothes'];
           $package_id=$row['package_id'];
           $timestamp=$row['timestamp'];
           $status=$row['status'];
           $charge=$row['charge'];
           $creator=$row['creator'];
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
//                                                    $charge=$row3['charge'];
$invoice_no=$id*23;
              ?>
                                <div class="col-xs-6 text-right">
                                    <h4>Invoice No.</h4>
                                    <h4 class="text-navy"><?php echo $invoice_no; ?></h4>
                                    <span>To:</span>
                                    <address>
                                        <strong><?php echo $firstname.' '.$lastname; ?></strong><br>
                                         <strong>P:</strong> <?php echo $phone; ?><br/>
                                         <strong>Country:</strong><?php echo $country; ?><br/>
                                          <span><strong>Invoice Date:</strong> <?php echo date('d/m/Y',$timenow); ?></span><br/>
                                    </address>
                                     
                                       
                                 
                                </div>
                                
                            </div>

                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                           <th>Package</th>
                                        <th>Number of Clothes</th>
                                        <th>Date</th>
                                        <th>Charge</th>
                                    
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><div><strong>
                                             <?php echo $laundrypackage; ?>
                                                </strong></div>
                                            </td>
                                                                              <td><?php  echo $clothes;  ?></td>
                                                                              <td><?php echo date('d/m/Y',$timestamp); ?></td>
                                        <td><?php echo number_format($charge);?></td>
                                    </tr>
                                    

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>
                                                                <tr>
                                    <td><strong>TOTAL :</strong></td>
                                    <td><strong><?php echo number_format($charge);?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                            
                            <div class="well m-t">
                                <strong style="font-style: italic">Thanks for Visiting our Hotel <strong>
                            </div>
                        </div>
                </div>
          
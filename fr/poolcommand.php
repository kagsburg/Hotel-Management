                  <div class="wrapper wrapper-content p-xl">
               <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-xs-2"><img src="assets/demo/pearllogo.png" class="img img-responsive"></div>
                                <div class="col-xs-4"> </div>
<?php
    $commands= mysqli_query($con, "SELECT * FROM poolcommands WHERE status=1 AND poolcommand_id='$id'") or die(mysqli_error($con));
          $row=  mysqli_fetch_array($commands);
  $poolcommand_id=$row['poolcommand_id'];
  $firstname=$row['firstname'];
  $lastname=$row['lastname'];
$contact=$row['contact'];
  $charge=$row['charge'];
  $status=$row['status'];
  $admin_id=$row['admin_id'];
     $package=$row['package_id'];
     $timestamp=$row['timestamp'];
   $getpackage=mysqli_query($con,"SELECT * FROM poolpackages WHERE status='1' AND poolpackage_id='$package'");
   $row1 = mysqli_fetch_array($getpackage);
     $poolpackage=$row1['poolpackage'];
        if(strlen($poolcommand_id)==1){
      $pin='000'.$poolcommand_id;
     }
       if(strlen($poolcommand_id)==2){
      $pin='00'.$poolcommand_id;
     }
        if(strlen($poolcommand_id)==3){
      $pin='0'.$poolcommand_id;
     }
  if(strlen($poolcommand_id)>=4){
      $pin=$poolcommand_id;
     }      
$invoice_no=$id*23;
              ?>
                                <div class="col-xs-6 text-right">
                                    <h4>Invoice No.</h4>
                                    <h4 class="text-navy"><?php echo $invoice_no; ?></h4>
                                    <span>To:</span>
                                    <address>
                                        <strong><?php echo $firstname.' '.$lastname; ?></strong><br>
                                            <span><strong>Date:</strong> <?php echo date('d/m/Y',$timestamp); ?></span><br/>
                                    </address>
                                     
                                       
                                 
                                </div>
                                
                            </div>
    <h2 style="text-align:center;width: 100%;margin: auto;font-weight: bold">SWIMMING POOL INVOICE</h2> 
                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                             <th>Package</th>
                        <th>Contact</th>
                   
                        <th>Charge</th>
                                    
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><div><strong>
                                             <?php echo $poolpackage; ?>
                                                </strong></div>
                                            </td>
                                      
                        <td><?php echo $contact; ?></td>
                        <td><?php echo $poolpackage; ?></td>
                        <td><?php echo $charge; ?></td>
                                    </tr>
                                    

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>
                                    
                                          <tr>
                                    <td><strong>NET TOTAL :</strong></td>
                                    <td><strong><?php echo number_format($charge);?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                            
                            <div class="well m-t">
                                <strong style="font-style: italic">Thanks for Visiting our Hotel <strong>
                            </div>
                        </div>
                </div>
          
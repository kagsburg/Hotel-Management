   
            <div class="wrapper wrapper-content p-xl">
               <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-xs-2">
                        <img src="assets/demo/pearllogo.png" class="img img-responsive">
                    </div>
                    <div class="col-xs-4">
                         </div>
                             <?php
                                $subscriptions=mysqli_query($con,"SELECT * FROM poolsubscriptions WHERE poolsubscription_id='$id'");
                                    $row=  mysqli_fetch_array($subscriptions);
                                    $poolsubscription_id=$row['poolsubscription_id'];
                                    $firstname=$row['firstname'];
                                    $lastname=$row['lastname'];
                                    $startdate=$row['startdate'];
                                    $enddate=$row['enddate'];
                                    $reduction=$row['reduction'];
                                    $charge=$row['charge'];
                                    $creator=$row['creator'];
                                    $package=$row['package'];
                                    $getpackage=mysqli_query($con,"SELECT * FROM poolpackages WHERE status='1' AND poolpackage_id='$package'");
                                    $row1 = mysqli_fetch_array($getpackage);
                                    $poolpackage=$row1['poolpackage'];
                                        if(strlen($poolsubscription_id)==1){
                                    $pin='000'.$poolsubscription_id;
                                    }
                                    if(strlen($poolsubscription_id)==2){
                                    $pin='00'.$poolsubscription_id;
                                    }
                                        if(strlen($poolsubscription_id)==3){
                                    $pin='0'.$poolsubscription_id;
                                    }
                                    if(strlen($poolsubscription_id)>=4){
                                        $pin=$poolsubscription_id;
                                    }      
                                    $invoice_no=$id*23;
                                    ?>
                                <div class="col-xs-6 text-right">
                                    <h4>Card No.</h4><h4 class="text-navy">
                                        <?php /* echo $invoice_no; */ ?>
                                    </h4>
                                    <span>To:</span>
                                    <address>
                                        <strong><?php echo $firstname.' '.$lastname; ?></strong><br>
                                        <span><strong>Creation Date:</strong> <?php echo date('d/m/Y',$timenow); ?></span><br/>
                                    </address>
                                </div>                                
                            </div>
                            <h2 style="text-align:center;width: 100%;margin: auto;font-weight: bold">POOL SUBSCRIPTION CARD</h2> 
                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                        <tr>
                                            <th>Package</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Charge</th>                                    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong><?php echo $poolpackage; ?></strong>
                                                </div>
                                            </td>
                                            <td><?php echo date('d/m/Y',$startdate); ?></td>
                                            <td><?php echo date('d/m/Y',$enddate); ?></td>
                                            <td><?php echo number_format($charge);?></td>
                                        </tr>                                  
                                    </tbody>
                                </table>
                            </div>
                            <table class="table invoice-total">
                                <tbody>
                                    <?php if(!empty($reduction)){ ?>
                                    <tr>
                                        <td><strong>Reduction :</strong></td>
                                        <td><strong><?php echo number_format($reduction);?></strong></td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                        <td>
                                            <strong>NET TOTAL :</strong>
                                        </td>
                                        <td>
                                            <strong><?php echo number_format($charge-$reduction);?></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>                            
                            <div class="well m-t">
                                <strong style="font-style: italic">Thanks for Visiting our Hotel <strong>
                            </div>
                        </div>
                </div>
          
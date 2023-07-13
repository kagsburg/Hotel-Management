
                <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-xs-2"><img src="assets/demo/pearllogo.png" class="img img-responsive"></div>
                                                      
                                
                            </div>
                 <h1 class="text-center">Rapport de gym entre entre<?php echo date('d/m/Y', $start); ?> et 
                 <?php echo date('d/m/Y', $end); ?></h1>
                     
  
    <div class="table-responsive m-t">
        <?php
                    $totalcosts=0;
                 $subscriptions=mysqli_query($con, "SELECT * FROM gymsubscriptions WHERE status='1'  AND timestamp>='$start' AND timestamp<='$end'");
                 if (mysqli_num_rows($subscriptions)>0) {
                     ?>
                                  <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                <th>ID</th>
                                <th>Client</th>
                        <th>Téléphone</th>
                          <th>Date de commencement</th>
                        <th>  Date de fin</th>
                        <th>Bouquet</th>
                        <th>Charge</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                         <?php
               while ($row=  mysqli_fetch_array($subscriptions)) {
                   $gymsubscription_id=$row['gymsubscription_id'];
                   $fullname=$row['fullname'];
                   $startdate=$row['startdate'];
                   $enddate=$row['enddate'];
                   $phone=$row['phone'];
                   $charge=$row['charge'];
                   $creator=$row['creator'];
                   $bouquet=$row['bouquet'];
                   $getbouquet=mysqli_query($con, "SELECT * FROM gymbouquets WHERE status='1' AND gymbouquet_id='$bouquet'");
                   $row1 = mysqli_fetch_array($getbouquet);
                   $gymbouquet_id=$row1['gymbouquet_id'];
                   $gymbouquet=$row1['gymbouquet'];
                   if (strlen($gymsubscription_id)==1) {
                       $pin='000'.$gymsubscription_id;
                   }
                   if (strlen($gymsubscription_id)==2) {
                       $pin='00'.$gymsubscription_id;
                   }
                   if (strlen($gymsubscription_id)==3) {
                       $pin='0'.$gymsubscription_id;
                   }
                   if (strlen($gymsubscription_id)>=4) {
                       $pin=$gymsubscription_id;
                   }
                   $totalcosts=$charge+$totalcosts;
                   ?>
                                    <tr>
                           <td><?php echo $pin; ?></td>
                    <td><?php echo $fullname; ?></td>
                        <td><?php echo $phone; ?></td>
                          <td><?php echo date('d/m/Y', $startdate); ?></td>
                               <td><?php echo date('d/m/Y', $enddate); ?></td>
                        <td><?php     echo $gymbouquet; ?></td>
                        <td><?php     echo $charge; ?></td>
                                    </tr>
                <?php } ?>

                                    </tbody>
                                </table>
                            <?php } ?>
                            </div><!-- /table-responsive -->
                               <table class="table invoice-total">
                                <tbody>
                                                               <tr>
                                    <td><strong>TOTALE :</strong></td>
                                    <td><strong><?php echo number_format($totalcosts);?></strong></td>
                                </tr>
                                </tbody>
                            </table>
     </div>

    </div>

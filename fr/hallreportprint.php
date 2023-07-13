                <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                            <div class="row">
                   <div class="col-xs-2"><img src="assets/demo/pearllogo.png" class="img img-responsive"></div>
                       </div>
                 <h1 class="text-center">Rapport de salle de conférence entre entre<?php echo date('d/m/Y', $start); ?> et
                  <?php echo date('d/m/Y', $end); ?></h1>
                     
  
    <div class="table-responsive m-t">
    <?php
                       $totalcosts=0;
                 $reservations=mysqli_query($con, "SELECT * FROM hallreservations WHERE status IN(1,2) AND timestamp>='$start' AND timestamp<='$end'");
                 if (mysqli_num_rows($reservations)>0) {
                     ?>
                                <table class="table table-bordered">
                                    <thead>
                                  <tr>
                          <th>Client</th>
                           <th>Personnel</th>
                          <th>Dates</th>
                        <th>Objectif</th>
                         <th>Status</th>
                         <th>Charge</th>
                    </tr>
                                    </thead>
                                    <tbody>
                                         <?php
              while ($row=  mysqli_fetch_array($reservations)) {
                  $hallreservation_id=$row['hallreservation_id'];
                  $fullname=$row['fullname'];
                  $checkin=$row['checkin'];
                  $phone=$row['phone'];
                  $checkout=$row['checkout'];
                  $status=$row['status'];
                  $people=$row['people'];
                  $purpose=$row['purpose'];
                  $description=$row['description'];
                  $country=$row['country'];
                  $charge=$row['charge'];
                  $creator=$row['creator'];
                  $getdays=(($checkout-$checkin)/(24*3600))+1;
                  $totalcosts=$totalcosts+($charge*$getdays);
                  ?>
     <tr>
                            <td><?php echo $fullname; ?></td>
                                     <td><?php
                                                       echo $people;
                  ?></td>
                               <td><?php echo date('d/m/Y', $checkin).' to '.date('d/m/Y', $checkout);
                               ; ?></td>
                        <td><?php
                          $purposes=mysqli_query($con, "SELECT * FROM hallpurposes WHERE hallpurpose_id='$purpose'");
                  $row3 = mysqli_fetch_array($purposes);
                  $hallpurpose_id=$row3['hallpurpose_id'];
                  $hallpurpose=$row3['hallpurpose'];
                  echo $hallpurpose; ?></td>
                   
                           <td><?php
                     if ($status==1) {
                         echo 'BOOKED';
                     } elseif ($status==2) {
                         echo 'CHECKED IN';
                     }
                  ?></td>
                           <td><?php  echo $charge*$getdays;   ?></td>
                                    </tr>
                <?php } ?>

                                    </tbody>
                                </table>
                                                    </div><!-- /table-responsive -->
<table class="table invoice-total">
                                <tbody>
                                                               <tr>
                                    <td><strong>TOTALE :</strong></td>
                                    <td><strong><?php echo number_format($totalcosts);?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                         
    <?php
                 }

                 ?>
                            </div><!-- /table-responsive -->
                            
     </div>

    </div>

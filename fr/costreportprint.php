  <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-xs-2"><img src="assets/demo/pearllogo.png" class="img img-responsive"></div>                                                     
                                
                            </div>
                 <h1 class="text-center">Note de frais entre <?php echo date('d/m/Y', $start); ?> et <?php echo date('d/m/Y', $end); ?></h1>
                     
  
    <div class="table-responsive m-t">
        <?php
                       $totalcosts=0;
                 $costs= mysqli_query($con, "SELECT * FROM costs WHERE status='1' AND date>='$start' AND date<='$end'") or die(mysqli_errno($con));
                 if (mysqli_num_rows($costs)>0) {
                     ?>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                              <th>Date</th>
                                           <th>Dépenses</th>
                                     <th>Prix</th>
                                    
                                    </tr>
                                    </thead>
                                    <tbody>
                                         <?php
                while ($row = mysqli_fetch_array($costs)) {
                    $cost_id=$row['cost_id'];
                    $cost_item=$row['cost_item'];
                    $amount=$row['amount'];
                    $date=$row['date'];
                    $creator=$row['creator'];
                    $totalcosts=$amount+$totalcosts;
                    ?>
                                    <tr>
                                   <td>  <?php echo date('d/m/Y', $date); ?>            </td>
                                        <td>
                                                   <?php echo $cost_item; ?>
                                                
                                            </td>
                                                                                                                                                          
                                        <td><?php echo number_format($amount);?></td>
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

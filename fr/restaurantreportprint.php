               <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                            <div class="row">
                   <div class="col-xs-2"><img src="assets/demo/pearllogo.png" class="img img-responsive"></div>
                       </div>
                 <h1 class="text-center">Rapport Bar & Restaurant entre <?php echo date('d/m/Y', $start); ?> et <?php echo date('d/m/Y', $end); ?></h1>
    <div class="table-responsive m-t">
    <?php
                       $totalcosts=0;
                 $reservations=mysqli_query($con, "SELECT * FROM hallreservations WHERE status IN(1,2) AND timestamp>='$start' AND timestamp<='$end'");
                 if (mysqli_num_rows($reservations)>0) {
                     ?>
                                   <?php
                       $totalbill=0;
                     $restorders=mysqli_query($con, "SELECT * FROM orders WHERE status IN(1,2)  AND timestamp>='$start' AND timestamp<='$end' ORDER BY order_id");
                     if (mysqli_num_rows($restorders)>0) {
                         ?>
                                <table class="table table-bordered">
                                    <thead>
                                 <th>N° de commande</th>
                                   <th>Date</th>
                         <th>Commandes</th>
                       <th>Table</th>
                           <th>Serveur</th>
                         <th>Type de client</th>
                             <th>Prix Total</th>
                                     </thead>
                                    <tbody>
                                         <?php
             while ($row=  mysqli_fetch_array($restorders)) {
                 $order_id=$row['order_id'];
                 $guest=$row['guest'];
                 $rtable=$row['rtable'];
                 $discount=$row['discount'];
                 $waiter=$row['waiter'];
                 $status=$row['status'];
                 $timestamp=$row['timestamp'];
                 $foodsordered=  mysqli_query($con, "SELECT * FROM restaurantorders WHERE order_id='$order_id'");
                 ?>
     <tr>
                             <td><?php echo 23*$order_id; ?></td>
                                     <td><?php echo date('d/m/Y', $timestamp);?></td> 
                      <td><?php
                                while ($row3=  mysqli_fetch_array($foodsordered)) {
                                    $restorder_id=$row3['restorder_id'];
                                    $food_id=$row3['food_id'];
                                    $price=$row3['foodprice'];
                                    $quantity=$row3['quantity'];

                                    $foodmenu=mysqli_query($con, "SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                                    $row=  mysqli_fetch_array($foodmenu);
                                    $menuitem_id=$row['menuitem_id'];
                                    $menuitem=$row['menuitem'];
                                    echo $quantity.' '.$menuitem.'<br/>';
                                }
                 ?></td>
                      
                      
                                            <td> <?php   echo $rtable;  ?></td>
                      <td><?php  echo $waiter;  ?></td>
                   <td><?php if ($guest>0) {
                       echo 'RESIDENT';
                   } else {
                       echo 'NON RESIDENT';
                   }  ?></td>   
                   <td class="center">
                                        <?php
                                               $totalcharges=mysqli_query($con, "SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                 $row=  mysqli_fetch_array($totalcharges);
                 $totalcosts=$row['totalcosts'];
                 $net=$totalcosts-(($discount/100)*$totalcosts);
                 echo number_format($net);
                 $totalbill=$totalbill+$net;
                 ?>
                        </td>
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
                                    <td><strong><?php echo number_format($totalbill);?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                         
    <?php
                 }

                 ?>
                            </div><!-- /table-responsive -->
                            
     </div>

    </div>

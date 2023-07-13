                <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                            <div class="row">
                               <div class="col-sm-2"><img src="assets/demo/logo.jpg" class="img img-responsive"></div>
                                <div class="col-sm-4">
                                                                       <address>
                                                                           <h3></h3>
                                         <strong>HOTEL NAME</strong><br>
                                         7, Avenue de la J.R.R <br/>
                                          Bujumbura BP 381,<br>
                                        Burundi<br>
                                        <strong>Tel : </strong>(+257) 22 27 85 82<br/>
                                       Email: info@hotel.com<br/>
                                        
                                    </address>
                                 
                                </div>

                                
                            </div>
                 <h1 class="text-center">All Restaurant Orders between <?php echo date('d/m/Y',$start); ?> and <?php echo date('d/m/Y',$end); ?></h1>
                            <div class="table-responsive m-t">
                           <?php
                           if($start>$end){
   $errors[]='Start Date Cant be later than End Date'; 
}

if(!empty($errors)){
foreach($errors as $error){ 
?>
                                 <div class="alert alert-danger"><?php echo $error; ?></div>
<?php 
}         }else{ ?>
                                <table class="table invoice-table table-responsive">
                                    <thead>
                                     <tr>
                     <tr>
                       
                         <th>Order items</th>
                              <th>Total Bill</th>
                                <th>Date</th>
                                        </tr>
                        
                    </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                             $restorders=mysqli_query($con,"SELECT * FROM orders WHERE status='1'  AND  timestamp>='$start' AND timestamp<='$end'  ORDER BY order_id DESC");               
               while($row=  mysqli_fetch_array($restorders)){
  $order_id=$row['order_id'];
  $creator=$row['creator'];
  $timestamp=$row['timestamp'];
  $foodsordered=  mysqli_query($con,"SELECT * FROM restaurantorders WHERE order_id='$order_id'");
                ?>
                                
                    <tr class="gradeA">
                                          <td><?php 
                  while ($row3=  mysqli_fetch_array($foodsordered)){
                      $restorder_id=$row3['restorder_id'];
                      $food_id=$row3['food_id'];
                      $price=$row3['foodprice'];
                      $quantity=$row3['quantity'];
                               
                    $foodmenu=mysqli_query($con,"SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                    $row=  mysqli_fetch_array($foodmenu);
                    $menuitem_id=$row['menuitem_id'];
                            $menuitem=$row['menuitem'];
 
                            echo $quantity.' '.$menuitem.'<br/>';
                  }
                      ?></td>
                         <td class="center">
                                        <?php
                                               $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                            $row=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row['totalcosts'];
                            echo number_format($totalcosts);
                                                                    ?>
                        </td>
                      
                   
                           <td><?php echo date('d/m/Y',$timestamp);?></td>    
                                      
                      </tr>
                 <?php }?>
                                    </tbody>
                                </table>
<?php } ?>
                            </div><!-- /table-responsive -->

                        
                            
                            <div class="well m-t">
                                <strong style="font-style: italic">@<?php echo date('Y',$timenow);?> All Rights Reserved</strong>
                            </div>
                        </div>

    </div>

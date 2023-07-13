    <div class="wrapper wrapper-content p-xl" style="padding:0px;max-width: 600px;margin: 0px auto">
                          <div class="col-sm-12">
                   <div class="ibox-content p-xl">
                            <div class="row">
                             
                                <div class="col-sm-4" style="font-size:20px;font-family: times new roman">
                                    <img src="assets/demo/pearllogo.png" class="img img-responsive" width="80">
                                                          <h4 class="text-navy"># <?php echo $order_id*23; ?></h4>
                                      <?php 
                                     if($customer==3){ ?>
                                     <span><strong>Guest Name:</strong>   <?php
                                                                                   $reservation=mysqli_query($con,"SELECT * FROM reservations WHERE reservation_id='$guest'");
$row=  mysqli_fetch_array($reservation);
 $firstname1=$row['firstname'];
$lastname1=$row['lastname'];
              echo $firstname1.' '.$lastname1;
                            
                            ?></span><br/>
                                      <?php }
                                   if($customer==2){ ?>
                                     <span><strong>Customer Name:</strong>   <?php
                                                                                   $customers= mysqli_query($con,"SELECT * FROM customers WHERE status='1' AND customer_id='$guest'") or die(mysqli_errno($con));
                         $row = mysqli_fetch_array($customers);                        
                                          
                         $customername=$row['customername'];                              
                        echo $customername;
          
                            
                            ?></span><br/>
                                      <?php }?> 
                           
                            <address>                                       
                                          <span><strong>Invoice Date:</strong> <?php echo date('d/m/Y',$timenow); ?></span><br/>
                                     <span><strong>Table:</strong> <?php echo $rtable; ?></span>
                              
                                   <?php 
                            if(!empty($mode)){
                            ?>
                                  
                               <span><strong>Payment:</strong> <?php echo $mode; ?></span>
                                      </address> 
                            <?php }?>                                              
                                       
                                 
                                </div>

                                <div class="col-sm-6 text-right">
                           
                                 
                                </div>
                                
                            </div>

                            <div class="table-responsive m-t">
                              
                                <table class="table invoice-table" style="font-size:20px; font-family:times new roman">
                                    <thead>
                                    <tr>
                                        <th>Food Name</th>
                                        <th>Items</th>
                                                       <th>Subtotal</th>
                                                                           
                                    </tr>
                                    </thead>
                                    <tbody>
                                          <?php
                                           $foodsordered=  mysqli_query($con,"SELECT * FROM restaurantorders WHERE order_id='$order_id'");
      while ($row3=  mysqli_fetch_array($foodsordered)){
                      $restorder_id=$row3['restorder_id'];
                      $food_id=$row3['food_id'];
                      $price=$row3['foodprice'];
                      $quantity=$row3['quantity'];
               
                    
 ?>
                                    <tr>
                                        <td><div><strong>
                                                   <?php 
                                                 
                    $foodmenu=mysqli_query($con,"SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                    $row=  mysqli_fetch_array($foodmenu);
                    $menuitem_id=$row['menuitem_id'];
                            $menuitem=$row['menuitem']; 
                            echo $menuitem;
                                     ?>
                                                </strong></div>
                                            </td>
                                        <td> <?php echo $quantity; ?></td>
                                       
                                                                     <td><?php echo number_format($price*$quantity);?></td>
                                    </tr>
                                      <?php } ?>

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                         <table class="table invoice-total">
                                <tbody>
                         
                                 <?php
                              $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                            $row=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row['totalcosts'];
                             $fordiscounts=($totalcosts*100)/110;
                             $vat=($fordiscounts*10)/100;
//                             $discountamount=($discount/100)*$totalcosts;
                             $net=($totalcosts+$vat);
                                   ?>
                                           <tr>
                                    <td><strong>VAT :</strong></td>
                                    <td><strong><?php    echo number_format($vat); ?></strong></td>
                                </tr>
                                <tr>
                                        <td><strong>TOTAL :</strong></td>
                                    <td><strong><?php    echo number_format($totalcosts); ?></strong></td>
                                </tr>
                            
                                 <tr>
                                    <td><strong>NET :</strong></td>
                                    <td><strong><?php    echo  number_format($net); ?></strong></td>
                                </tr>
                              
                                </tbody>
                            </table>
                            <?php
                                 if($guest==0){
                            ?>
                                <table class="table invoice-total">
                                <tbody>
                                                                <tr>
                                                                    <?php
                                              $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                            $row=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row['totalcosts'];
                               $totalpaid=mysqli_query($con,"SELECT COALESCE(SUM(amount), 0) AS totalpaid FROM restpayments WHERE order_id='$order_id'");
                            $row=  mysqli_fetch_array($totalpaid);
                            $paidtotal=$row['totalpaid'];
                           
                            $balance=$net-$paidtotal;
                       
                                                                                             ?>
<!--                                    <td><strong>AMOUNT PAID :</strong></td>
                                    <td><strong><?php     //echo number_format($paidtotal); ?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                              <table class="table invoice-total">
                                <tbody>
                                                                <tr>                                                             
                                    <td><strong>BALANCE :</strong></td>
                                    <td><strong><?php   //  echo number_format($balance); ?></strong></td>
                                </tr>
                                </tbody>
                            </table>-->
                            <?php }?>
                            <div class="well m-t">
                                <strong style="font-style: italic;font-size: 20px">Thanks for Spending Time at our Restaurant</strong>
                            </div>
                        </div>
                        </div>
    </div>

                <div class="wrapper wrapper-content p-xl col-lg-offset-2 col-lg-8">
                   <div class="ibox-content p-xl">
                            <div class="row">
                              <div class="col-sm-2"><img src="assets/demo/logo.jpg" class="img img-responsive"></div>
                                <div class="col-sm-4">                                                                        <address>
                                                                           <h3></h3>
                                         <strong>LE PANORAMIQUE</strong><br>
                                         7, Avenue de la J.R.R <br/>
                                          Bujumbura BP 381, Burundi<br>
                                        Burundi<br>
                                        <strong>Tel : </strong>(+257) 22 27 85 82<br/>
                                       Email: info@celexonhotel.com<br/>
                                        
                                    </address>
                                 
                                </div>

                                <div class="col-sm-6 text-right">
                                    <h4>Order No.</h4>
                                    <h4 class="text-navy"><?php echo $id*23; ?></h4>
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
                                     <span><strong>Customer Name:</strong> 
  <?php
                                                                                   $customers= mysqli_query($con,"SELECT * FROM customers WHERE status='1' AND customer_id='$guest'") or die(mysqli_errno($con));
                         $row = mysqli_fetch_array($customers);                        
                                          
                         $customername=$row['customername'];                              
                        echo $customername;
          
                            
                            ?></span><br/>
                                      <?php }?> 
                                     
                                                     <span><strong>Waiter/Waitress:</strong>   <?php
                                   echo $waiter;
                            
                            ?></span><br/>
                                                                        <address>
                                       
                                          <span><strong>Order Date:</strong> <?php echo date('d/m/Y',$timenow); ?></span><br/>
                                    </address>
                                     
                                       
                                 
                                </div>
                                
                            </div>

                            <div class="table-responsive m-t">
                              
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Food Name</th>
                                        <th>Items</th>
                                                    </tr>
                                    </thead>
                                    <tbody>
                                          <?php
                                           $foodsordered=  mysqli_query($con,"SELECT * FROM restaurantorders WHERE restround_id='$id'");
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
                                       
                                                                           </tr>
                                      <?php }?>

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                                     <?php if($instructions!=''){ ?>                 
                            <div class="well m-t">
                                <strong style="font-style: italic">INSTRUCTIONS : </strong><?php echo $instructions;?>
                            </div>
                                     <?php }?>
                        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>

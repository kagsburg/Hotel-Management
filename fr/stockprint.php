                <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                      <div class="row">
                                <div class="col-xs-2"><img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive"></div>
                                <div class="col-xs-4">
                                </div>

                              
                                
                            </div>
                 <h1 class="text-center">All Stock Items</h1>
                            <div class="table-responsive m-t">
                            
                                <table class="table invoice-table">
                                   <thead>
                    <tr>
                        <th>ID</th>
                        <th>Stock Item</th>
                        <th>Min Stock</th>
                        <th>Unit</th>
                        <th>Category</th>
                                          </tr>
                    </thead>
                    <tbody>
              <?php
             $stock=mysqli_query($con,"SELECT * FROM stock_items WHERE status=1");
               while($row=  mysqli_fetch_array($stock)){
  $stockitem_id=$row['stockitem_id'];
  $cat_id=$row['category_id'];
$stockitem=$row['stock_item'];
  $minstock=$row['minstock'];
  $measurement=$row['measurement'];
  $status=$row['status'];
               ?>
               
                    <tr class="gradeA">
                    <td><?php echo $stockitem_id; ?></td>
                        <td><?php echo $stockitem; ?></td>
                        <td><?php echo $minstock; ?></td>
                                             <td> <div class="tooltip-demo">
                                      <?php 
                                              $getmeasure=  mysqli_query($con,"SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");  
                                             $row2=  mysqli_fetch_array($getmeasure);
                                              $measurement2=$row2['measurement'];
                                             echo $measurement2; ?> </div></td>
     <td><?php  
     $getcat=  mysqli_query($con,"SELECT * FROM categories WHERE status=1 AND category_id='$cat_id'");
                            $row1=  mysqli_fetch_array($getcat);
                            $category_id=$row1['category_id'];
                           $category=$row1['category']; 
                           echo $category;
                           ?></td>                   

                    </tr>
                 <?php }?>
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                        
                            
                            <div class="well m-t">
                                <strong style="font-style: italic">@<?php echo date('Y',$timenow);?> All Rights Reserved To <?php echo $hotelname; ?><strong>
                            </div>
                        </div>

    </div>

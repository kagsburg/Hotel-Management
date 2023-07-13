                <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-2"><img src="assets/demo/pearllogo.png" class="img img-responsive"></div>
                              
                              
                                
                            </div>
                 <h1 class="text-center">All Hotel costs</h1>
                            <div class="table-responsive m-t">
                            
                                <table class="table invoice-table">
                                    <thead>
                                   <tr>
                        <th>Item</th>
                        <th>Cost</th>
                        <th>Date</th>
                      
                    </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                     $totalcosts=0;
                                      $costs= mysqli_query($con,"SELECT * FROM costs") or die(mysqli_errno($con));
                while ($row = mysqli_fetch_array($costs)) {
                         $cost_id=$row['cost_id'];                              
                         $cost_item=$row['cost_item'];                              
                         $amount=$row['amount'];                              
                         $date=$row['date'];                              
                         $creator=$row['creator'];                              
                         $totalcosts=$totalcosts+$amount;                           
                        ?>
                    <tr class="gradeA">
                        <td><?php echo $cost_item; ?></td>
                        <td><?php echo $amount;?> </td>
                        <td><?php echo date('d/m/Y',$date);?> </td>
                                           
                    </tr>   <?php } ?>
                          
                                     </tbody>
                                     <tfoot><tr></tr></tfoot>
                                </table>
                            </div><!-- /table-responsive -->

                        
                            
                            <div class="well m-t">
                                <strong style="font-style: italic">@<?php echo date('Y',$timenow);?> All Rights Reserved To Kings Conference</strong>
                            </div>
                        </div>

    </div>

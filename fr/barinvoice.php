
    <div id="wrapper">
<?php include 'nav.php'; ?>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
          
        </div>
            <ul class="nav navbar-top-links navbar-right">
               
                
                <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
            <li><a href="switchlanguage?lan=en">English</a> </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-8">
                    <h2>Bar Order Invoice</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index">Home</a>
                        </li>
                        <li>
                           Bar
                        </li>
                        <li class="active">
                            <strong>Invoice</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
<!--                        <a href="#" class="btn btn-white"><i class="fa fa-pencil"></i> Edit </a>
                        <a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save </a>-->
                        <a href="barinvoice_print?id=<?php echo $order_id; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInRight">
                     <div class="ibox-content p-xl">
                            <div class="row">                             
                                <div class="col-sm-4">
                                    <img src="assets/demo/logo.jpg" class="img img-responsive">
                                                               
                                    <h4 class="text-navy">#<?php echo $order_id*23; ?></h4>                                   
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
                                    </address>
                                           <address>                                       
                                          <span><strong>Table:</strong> <?php echo $table; ?></span><br/>
                                    </address>
                                       
                                </div>
                                
                            </div>

                            <div class="table-responsive m-t">
                              
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Drink Name</th>
                                        <th>Items</th>
                                     
                                        <th>Total Charge</th>
                                                                           
                                    </tr>
                                    </thead>
                                    <tbody>
                                          <?php
     $getdrinks=  mysqli_query($con,"SELECT * FROM barorder_drinks WHERE barorder_id='$order_id'");
                                      while($row=  mysqli_fetch_array($getdrinks)){ 
                                          $drink_id=$row['drink_id'];
                                          $charge=$row['charge'];
                                          $items=$row['items'];
                                          $drinkorder_id=$row['drinkorder_id'];
                                          $getdrink=mysqli_query($con,"SELECT * FROM drinks WHERE drink_id='$drink_id'");
                                            $row2=  mysqli_fetch_array($getdrink);
                                                  $drink=$row2['drinkname'];
                                                  $quantity=$row2['quantity'];
                                              $drinktotal=$charge*$items;   
 ?>
                                    <tr>
                                        <td><div><strong>
                                                   <?php echo $drink.' ('.$quantity.')'; ?>
                                                </strong></div>
                                            </td>
                                        <td> <?php echo $items; ?></td>
                                   
                                        <td><?php echo number_format($drinktotal);?></td>
                                    </tr>
                                      <?php }?>

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>
                                                                <tr>
                                                                    <?php
                                               $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(charge*items), 0) AS totalcosts FROM barorder_drinks WHERE barorder_id='$order_id'");
                            $row=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row['totalcosts'];
                                                                    ?>
                                    <td><strong>TOTAL :</strong></td>
                                    <td><strong><?php echo number_format($totalcosts); ?></strong></td>
                                </tr>
                                         <?php 
                                   if(($customer==2)&&($discount>0)){
                                ?>
                                 <tr>
                                    <td><strong>DISCOUNT (%) :</strong></td>
                                    <td><strong><?php    echo $discount; ?></strong></td>
                                </tr>
                                    
                                 <tr>
                                    <td><strong>NET :</strong></td>
                                    <td><strong><?php    echo  number_format($totalcosts-(($discount/100)*$totalcosts)); ?></strong></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <?php
                                 if($guest==0){
                            ?>
                                <table class="table invoice-total">
                                <tbody>
                                                                <tr>
                                                                    <?php
                                                   $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(charge*items), 0) AS totalcosts FROM barorder_drinks WHERE barorder_id='$order_id'");
                            $row=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row['totalcosts'];
                             $totalpaid=mysqli_query($con,"SELECT COALESCE(SUM(amount), 0) AS totalpaid FROM barpayments WHERE order_id='$order_id'");
                            $row=  mysqli_fetch_array($totalpaid);
                            $paidtotal=$row['totalpaid'];
                          
                            $balance=$totalcosts-$paidtotal;
                       
                                                                                             ?>
                                    <td><strong>AMOUNT PAID :</strong></td>
                                    <td><strong><?php     echo number_format($paidtotal); ?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                              <table class="table invoice-total">
                                <tbody>
                                                                <tr>                                                             
                                    <td><strong>BALANCE :</strong></td>
                                    <td><strong><?php     echo number_format($balance); ?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                            <?php }?>
                            <div class="well m-t">
                                <strong style="font-style: italic">Thanks for Spending Time at Our Hotel <strong>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        </div>
    </div>

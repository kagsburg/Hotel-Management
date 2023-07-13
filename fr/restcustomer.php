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
                <div class="col-lg-10">
                    <h2>Restaurant Customer Details</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a href="barcustomers">Restaurant customers</a>                       </li>
                        <li class="active">
                            <strong>Details</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                                          <div class="col-lg-4">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-cutlery  fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Orders</span>
                            <h2 class="font-bold">
                              <?php
                      $getorders=  mysqli_query($con,"SELECT * FROM orders WHERE guest='$id' AND customer=2 AND status=1");
                                     echo mysqli_num_rows($getorders);
                            ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                             <div class="col-lg-4">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-cutlery fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Total Bill</span>
                            <h2 class="font-bold">
                              <?php
                                  $totalbill=0;
                         while ($roww = mysqli_fetch_array($getorders)) {
                             $order_id=$roww['order_id'];
                             $discount=$roww['discount'];
                                $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                            $row4=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row4['totalcosts'];
                            $nettotal=$totalcosts-(($discount/100)*$totalcosts);
                            $totalbill=$totalbill+$nettotal;                            
                         }
                         echo number_format($totalbill);
                            ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                             <div class="col-lg-4">
                <div class="widget style1 red-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-cutlery  fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Amount Paid</span>
                            <h2 class="font-bold">
                              <?php
                           $getpayments=  mysqli_query($con,"SELECT SUM(amount) as totalpayments FROM customerpayments WHERE customer_id='$id'");
                         $row2= mysqli_fetch_array($getpayments);
                         $totalpayments=$row2['totalpayments'];
                         echo number_format($totalpayments);
                            ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-4">
                                          
                      <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Customer Details</h5>
                           
                        </div>
                        <div class="ibox-content">
                 <div class="feed-activity-list">
     <?php
             
                          $customers= mysqli_query($con,"SELECT * FROM customers WHERE status='1' AND customer_id='$id'") or die(mysqli_errno($con));
                         $row = mysqli_fetch_array($customers);                         
                         $customer_id=$row['customer_id'];                              
                         $customername=$row['customername'];                              
                         $customercompany=$row['customercompany'];                              
                         $customerphone=$row['customerphone'];                              
                         $customeremail=$row['customeremail'];                              
                         $passport_id=$row['passport_id'];       
                                                                                                                                                 ?>
                       <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Customer Name</strong> : <?php echo $customername; ?> <br>
                                             </div>
                                    </div>
                         <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Company</strong> : <?php echo $customercompany; ?> <br>
                                             </div>
                                    </div>
                     <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Email</strong>: <?php echo $customeremail; ?> <br>
                                             </div>
                                    </div>
                     <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Passport</strong> : <?php echo $passport_id; ?> <br>
                                             </div>
                                    </div>
               
                
                                    </div>
                             </div>
                      </div>
                 
                </div>                                   
                                                    <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Customer orders</h5>
                            <a href="addrestpayment?id=<?php echo $id; ?>" class="btn btn-xs btn-success pull-right">Add Payment</a>
                        </div>
                        <div class="ibox-content ">
                                    <table class="table table-striped table-bordered table-hover dataTables-example"  id="datatable">
   
                    <thead>
                 <tr>
                       
                         <th>Order items</th>
                           <th>Discount (%)</th>
                               <th>Date</th>
                           <th>Action</th>
                    
                        </tr>
                    </thead>
                    <tbody>
              <?php
              $restorders=mysqli_query($con,"SELECT * FROM orders WHERE status='1' AND customer='2' AND guest='$id' ORDER BY order_id DESC");
               while($row=  mysqli_fetch_array($restorders)){
  $order_id=$row['order_id'];
  $guest=$row['guest'];
  $discount=$row['discount'];
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
                         <td> <?php echo $discount; ?></td>
                           <td><?php echo date('d/m/Y',$timestamp);?></td>    
                           <td>
                               <a href="restorders?id=<?php echo $order_id; ?>" target="_blank" class="btn btn-xs btn-info">Details</a>
                          
                               <a href="restinvoice?id=<?php echo $order_id; ?>" class="btn btn-xs btn-warning">Invoice</a>
                         
                           </td>       
                                              
                      </tr>
                 <?php }?>
                    </tbody>
                                    </table> 
                        </div>
                        
                        </div>
                </div>
            </div>
        </div>
        </div>


    </div>

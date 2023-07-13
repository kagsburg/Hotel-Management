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
                    <h2>Bar Customer Details</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a href="barcustomers">Bar customers</a>                       </li>
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
                            <i class="fa fa-glass  fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Orders</span>
                            <h2 class="font-bold">
                              <?php
                      $getorders=  mysqli_query($con,"SELECT * FROM barorders WHERE guest='$id' AND customer=2 AND status=1");
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
                            <i class="fa fa-glass fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Total Bill</span>
                            <h2 class="font-bold">
                              <?php
                                  $totalbill=0;
                         while ($roww = mysqli_fetch_array($getorders)) {
                             $order_id=$roww['barorder_id'];
                                $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(charge*items), 0) AS totalcosts FROM barorder_drinks WHERE barorder_id='$order_id'");
                            $row4=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row4['totalcosts'];
                            $totalbill=$totalbill+$totalcosts; 
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
                            <i class="fa fa-glass fa-5x"></i>
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
                <div class="col-lg-5">
                                          
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
                                                    <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Customer orders</h5>
                            <a href="addbarpayment?id=<?php echo $id; ?>" class="btn btn-xs btn-success pull-right">Add Payment</a>
                        </div>
                        <div class="ibox-content ">
            <?php
   $barorders=  mysqli_query($con,"SELECT * FROM barorders WHERE status='1' AND guest='$id' AND customer=2 AND status=1");
   if(mysqli_num_rows($barorders)>0){
 ?>
                                               
                        <table class="table table-striped table-bordered table-hover dataTables-example"  id="datatable">
                    <thead>
                    <tr>
                         <th>Order Id</th>
                        <th>Ordered Drinks</th>
                        <th>Total charge</th>
                              <th>Date</th>
                        <th>Action</th>
                         
                          </tr>
                    </thead>
                    <tbody>
              <?php
           
               while($row=  mysqli_fetch_array($barorders)){
    $order_id=$row['barorder_id'];
      $guest=$row['guest'];
  $creator=$row['creator'];
   $timestamp=$row['timestamp'];
   $getdrinks=  mysqli_query($con,"SELECT * FROM barorder_drinks WHERE barorder_id='$order_id'");
                                     
  
              ?>
               
                    <tr class="gradeA">
                      <td><?php echo 23*$order_id; ?></td>
                         <td class="center">
                                          <?php
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
                                          echo $items.' '.$drink.' ('.$quantity.')<br/>'; 
                                           }
                                          ?>
                        </td>
                          <td class="center">
                                      <?php
                                               $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(charge*items), 0) AS totalcosts FROM barorder_drinks WHERE barorder_id='$order_id'");
                            $row=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row['totalcosts'];
                            echo number_format($totalcosts);
                                                                    ?>
                        </td>
                                             
                     
                                   
                       <td><?php echo date('d/m/Y',$timestamp);?></td>               
                       <td>
                           <a href="barorders?id=<?php echo $order_id; ?>" class="btn btn-xs btn-info" target="_blank">Details</a>
                 
                           <a href="barinvoice?id=<?php echo $order_id; ?>" class="btn btn-xs btn-warning">Invoice</a>
                    
                       </td>               
    
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }else{?>
                        <div class="alert alert-danger">No Drink Orders Added Yet</div>
 <?php }?>
                        </div>
                        
                        </div>
                </div>
            </div>
        </div>
        </div>


    </div>

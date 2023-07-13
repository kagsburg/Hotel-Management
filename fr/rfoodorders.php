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
                <div class="col-lg-12">
                    <h2>Hotel Orders From Registered Customers</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                            <a>Menu</a>
                        </li>
                        <li class="active">
                            <strong>Restaurant Orders</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                           <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Orders <small>Sort, search</small></h5>
                        
                    </div>
                    <div class="ibox-content">
<?php
$restorders=mysqli_query($con,"SELECT * FROM orders WHERE status='1' AND customer='2' ORDER BY order_id DESC");
if(mysqli_num_rows($restorders)>0){
 
 ?>
                       <form action="archiverestaurant" method="post"> 
                                            <table class="table table-striped table-bordered table-hover dataTables-example"  id="datatable">
   
                    <thead>
                 <tr>
                         <th>Order Id</th>
                         <th>Order items</th>
                           <th>Charge</th>
                           <th>Customer Name</th>
                           <th>Phone Number</th>
                              <th>Table</th>
                           <th>Date</th>
                           <th>Action</th>
                    
                        </tr>
                    </thead>
                    <tbody>
              <?php
               while($row=  mysqli_fetch_array($restorders)){
  $order_id=$row['order_id'];
  $guest=$row['guest'];
   $creator=$row['creator'];
  $timestamp=$row['timestamp'];
      $rtable=$row['rtable'];
  $foodsordered=  mysqli_query($con,"SELECT * FROM restaurantorders WHERE order_id='$order_id'");
                ?>
               
                      
                                              
                    <tr class="gradeA">
                        <td><?php echo 23*$order_id; ?></td>
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
                        <td>
                            <?php
                             $customers= mysqli_query($con,"SELECT * FROM customers WHERE status='1' AND customer_id='$guest'") or die(mysqli_errno($con));
                         $row = mysqli_fetch_array($customers);                         
                         $customer_id=$row['customer_id'];                              
                         $customername=$row['customername'];                              
                         $customercompany=$row['customercompany'];                              
                         $customerphone=$row['customerphone'];                              
                         $customeremail=$row['customeremail'];                              
                         $passport_id=$row['passport_id'];      
                         echo $customername;
                         
                            ?>
                        </td>
                        <td><?php echo $customerphone;?></td>
                                                                  <td> <?php   echo $rtable;    ?></td>
                           <td><?php echo date('d/m/Y',$timestamp);?></td>    
                           <td>
                               <a href="restorders?id=<?php echo $order_id; ?>" target="_blank" class="btn btn-xs btn-info">View Details</a>
                                   <a href="addrestpayment?id=<?php echo $customer_id;?>" class="btn btn-xs btn-success"><i class="fa fa-plus"></i>Add Payment</a>  
                                 <a href="addmoreitems?id=<?php echo $order_id; ?>" class="btn btn-xs btn-primary">Add more Items</a>
                               <a href="restinvoice?id=<?php echo $order_id; ?>" class="btn btn-xs btn-success">View Invoice</a>
                              <a href="hiderestorder?id=<?php echo $order_id;?>" class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $order_id; ?>()">Cancel</a>
                            
                                 <script type="text/javascript">
function confirm_delete<?php echo $order_id; ?>() {
  return confirm('You are about To Remove this Order. Are you sure you want to proceed?');
}
</script>                 
                           </td>       
                                              
                      </tr>
                 <?php }?>
                    </tbody>
                                    </table> </form>
 <?php }else{?>
                        <div class="alert alert-danger">No Restaurant Orders Added Yet</div>
 <?php }?>
                    </div>
                </div>
            </div>
                
            </div>
          
        </div>
        </div>


    </div>

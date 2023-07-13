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
                    <h2>Registered  Customers</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index.php"><i class="fa fa-home"></i> Home</a>                    </li>
                   
                        <li class="active">
                            <strong>Restaurant  Customers</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
  
                           <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">                            
                            <h5>Restaurant Customers</h5>
                                                 </div>
                        <div class="ibox-content">
                            <?php 
                            $customers= mysqli_query($con,"SELECT * FROM customers WHERE status='1' AND type='rest'") or die(mysqli_errno($con));
                            if(mysqli_num_rows($customers)>0){
                            ?>
                              <form action="archivecosts" method="post"> 
                                               <table class="table table-striped table-bordered table-hover dataTables-example" id="datatable" >
                    <thead>
                     
                    <tr>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Phone</th>
                      <th>Orders</th>
                     <th>Bill</th>
                              <th>Amount Paid</th>
                        <th>Action</th>
                         </tr>                                                 
                    </thead>
                    <tbody>
                     <?php
                while ($row = mysqli_fetch_array($customers)) {
                         $customer_id=$row['customer_id'];                              
                         $customername=$row['customername'];                              
                         $customercompany=$row['customercompany'];                              
                         $customerphone=$row['customerphone'];                              
                         $customeremail=$row['customeremail'];                              
                         $passport_id=$row['passport_id'];         
                            $getorders=  mysqli_query($con,"SELECT * FROM orders WHERE guest='$customer_id' AND customer=2 AND status=1");
                         $getpayments=  mysqli_query($con,"SELECT SUM(amount) as totalpayments FROM customerpayments WHERE customer_id='$customer_id'");
                         $row2= mysqli_fetch_array($getpayments);
                         $totalpayments=$row2['totalpayments'];
                         $totalbill=0;
                         while ($roww = mysqli_fetch_array($getorders)) {
                             $order_id=$roww['order_id'];
                                $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                            $row4=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row4['totalcosts'];
                            $totalbill=$totalbill+$totalcosts; 
                         }
                        ?>
                    <tr class="gradeA">
                        <td><?php echo $customername; ?></td>
                        <td><?php echo $customercompany;?> </td>
                        <td><?php echo $customerphone;?> </td>
                        <td><?php echo mysqli_num_rows($getorders);?> </td>  
                            <td><?php echo number_format($totalbill);?> </td>  
                        <td><?php echo number_format($totalpayments);?> </td>                    
                                        
                        <td>                           
                           <a href="restcustomer?id=<?php echo $customer_id;?>" class="btn btn-xs btn-info"><i class="fa fa-user"></i> View Details</a>      
                              <a href="addrestpayment?id=<?php echo $customer_id;?>" class="btn btn-xs btn-danger"><i class="fa fa-plus"></i> Add Payment</a>      
                        </td>                  
                    </tr>   <?php } ?>
                    </tbody>
                             </table>  </form>
                            <?php }else{ ?>
                            <div class="alert alert-danger">No Customers Added  yet</div>
                            <?php }?>
                        </div>
                    </div>
                    </div>




    </div>

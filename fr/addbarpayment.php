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
                    <h2>Add Bar Customer Payment</h2>
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
                               
                <div class="col-lg-6">
                                          
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
                         <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Orders</strong> :    <?php
                      $getorders=  mysqli_query($con,"SELECT * FROM barorders WHERE guest='$id' AND customer=2 AND status=1");
                                     echo mysqli_num_rows($getorders);
                            ?><br>
                                             </div>
                                    </div>
                     <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Total Bill</strong> :     <?php
                                  $totalbill=0;
                         while ($roww = mysqli_fetch_array($getorders)) {
                             $order_id=$roww['barorder_id'];
                                $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(charge*items), 0) AS totalcosts FROM barorder_drinks WHERE barorder_id='$order_id'");
                            $row4=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row4['totalcosts'];
                            $totalbill=$totalbill+$totalcosts; 
                         }
                         echo number_format($totalbill);
                            ?><br>
                                             </div>
                                    </div>
                     <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Amount Paid</strong> :     <?php
                           $getpayments=  mysqli_query($con,"SELECT SUM(amount) as totalpayments FROM customerpayments WHERE customer_id='$id'");
                         $row2= mysqli_fetch_array($getpayments);
                         $totalpayments=$row2['totalpayments'];
                         echo number_format($totalpayments);
                            ?><br>
                                             </div>
                                    </div>
              
                
                                    </div>
                             </div>
                      </div>
                 
                </div>                                   
                                                    <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Add Payment</h5>
                     
                        </div>
                        <div class="ibox-content ">
                  <?php
 if(isset($_POST['amount'],$_POST['paymentdate'])){
                                $amount= mysqli_real_escape_string($con,trim($_POST['amount']));
                                  $paymentdate=  mysqli_real_escape_string($con,strtotime($_POST['paymentdate']));
                                   if($paymentdate>$timenow){
                                   $errors[]='Payment Date Cant be later than current date';
                            }             
 if((empty($amount))||(empty($paymentdate))){
                                   $errors[]='Enter Fields to Proceed';
                                }
                                         if(is_numeric($amount)==FALSE){
                                   $errors[]='Bill Amount must be in figures';
                            }                     
    if(!empty($errors)){
foreach($errors as $error){ 
 ?>
 <div class="alert alert-danger"><?php echo $error; ?></div>
<?php 
}         }else{
                    $addpayment=  mysqli_query($con,"INSERT INTO customerpayments(customer_id,amount,creator,date,status) VALUES('$id','$amount','".$_SESSION['emp_id']."','$paymentdate','1')")
             ?>
  
 <div class="alert alert-success"><i class="fa fa-check"></i> Bar Order Payment Successfully Added</div>
    <?php

    }
     }
?>
                        
     <form method="post" name='form' class="form" action=""  enctype="multipart/form-data">
                              
                           <div class="form-group " id="data_1">
                               <label class="control-label">*Select Payment Date</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text"  name="paymentdate" class="form-control" required="required">
                                </div>
                            </div>
                              <div class="form-group"><label class="control-label">*Add Payment</label>
                               
                                        <input type="text" class="form-control" name='amount' placeholder="Enter Amount in figures" required='required'>
                                       <div class="hr-line-dashed"></div>
                                
                                </div>
                                                                              
                                                        
                                <div class="form-group">
                                                   
                                        <button class="btn btn-primary" type="submit" name="submit">Submit</button>
             
                                </div>
                            </form>
                        </div>
                        
                        </div>
                </div>
            </div>
        </div>
        </div>


    </div>

  
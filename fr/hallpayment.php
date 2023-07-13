
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
                    <h2>Checking Out Hall Guests</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                             <a href="halluncleared.php">Checked out with debt</a>
                        </li>
                        <li class="active">
                            <strong>Enter Payment</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                   <div class="row">
                <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Guest Details</h5>
                       
                    </div>
                    <div class="ibox-content">
<?php
$reservations=mysqli_query($con,"SELECT * FROM hallreservations WHERE hallreservation_id='$id'");
    $row=  mysqli_fetch_array($reservations);
  $hallreservation_id1=$row['hallreservation_id'];
$fullname1=$row['fullname'];
$checkin1=$row['checkin'];
$phone1=$row['phone'];
$checkout1=$row['checkout'];
   $status1=$row['status'];
   $people1=$row['people'];
   $purpose1=$row['purpose'];
   $description1=$row['description'];
  $country1=$row['country'];  
              ?>
     <div>
                                <div class="feed-activity-list">

                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Full Name</strong>. : <?php echo $fullname1; ?> <br>
                                             </div>
                                    </div>
                                         <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Country</strong>. : <?php echo $country1; ?> <br>
                                             </div>
                                    </div>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Phone Number</strong>. : <?php echo $phone1; ?> <br>
                                             </div>
                                    </div>
                                  
                                      <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Check In</strong>  : <?php echo date('d/m/Y',$checkin1); ?> <br>
                                             </div>
                                    </div>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Check Out</strong>  : <?php echo date('d/m/Y',$checkout1); ?> <br>
                                             </div>
                                    </div>
                                            
                                      <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>People</strong>  : <?php echo $people1; ?> <br>
                                             </div>
                                    </div>      
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Purpose</strong>  : <?php 
                                                     $purposes=mysqli_query($con,"SELECT * FROM hallpurposes WHERE hallpurpose_id='$purpose1'");
                                                     $row3 = mysqli_fetch_array($purposes);
                                                     $hallpurpose_id=$row3['hallpurpose_id'];
                                                     $hallpurpose=$row3['hallpurpose']; 
                                                     $charge=$row3['charge']; 
                                                     echo  $hallpurpose; ?> <br>
                                             </div>
                                    </div>     
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Description</strong>  : <?php echo $description1; ?> <br>
                                             </div>
                                    </div>      
                                                                                                 
                                             </div>
                            </div>
                    </div>
                </div>
            </div>
                <div class="col-lg-6">
                       <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Add Checkout Details</h5>
                                                   </div>
                        <div class="ibox-content">
                          <?php
                            if(isset($_POST['amount'],$_POST['paymentdate'])){
                                    $paymentdate=  mysqli_real_escape_string($con,strtotime($_POST['paymentdate']));
                                    $amount=  mysqli_real_escape_string($con,trim($_POST['amount']));
                                if(empty($paymentdate)){
                                   $errors[]='Select Date to Proceed';
                                }               
                                if(!empty($amount)){
                                    if(is_numeric($amount)==FALSE){
                                     $errors[]='Amount should be an integer';    
                                    }
                                }
                                                               if(!empty($errors)){
foreach($errors as $error){ 
 ?>
 <div class="alert alert-danger"><?php echo $error; ?></div>
<?php 
}         }else{
                       $addpayment=  mysqli_query($con,"INSERT INTO hallpayments VALUES('','$id','$amount','".$_SESSION['emp_id']."',UNIX_TIMESTAMP())");     
             
                 ?>
 <div class="alert alert-success">Hall Bill Payment Successfully Updated <a href="<?php echo 'hallinvoice?id='.$id; ?>" target="_blank">Click Here</a> to View Invoice</div>
                            <?php 
                                                        }
                                                        }
                            ?>
 <form role="form" method="POST" action="" enctype="multipart/form-data">
                                                                  <div class="form-group" id="data_1">
                                <label class="font-noraml">Select Payment Date</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text"  name="paymentdate" class="form-control" placeholder="Select payment Date"  required="required">
                                </div>
                            </div>
                                 <div class="form-group"><label class="col-sm-8 control-label"> Add Payment</label>
                                     <div class="col-sm-10">
                                         <input type="text" class="form-control" name='amount' placeholder="Enter Amount in figures" required="required">
                                       <div class="hr-line-dashed"></div>
                                    </div>
                                </div>
                                                            <button class="btn btn-sm btn-info pull-right m-t-n-xs" type="submit"><strong>Add Payment</strong></button>
                                                                                                                
                                                    </form>
                            <div style="clear:both"></div>
                                    </div>
                       </div>
                 
            </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>

   
                        </div>
   
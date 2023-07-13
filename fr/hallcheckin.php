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
                    <h2>Checking in Hall Guest</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                             <a href="hallbookings">Reservation</a>
                        </li>
                        <li class="active">
                            <strong>Checkin Confirm</strong>
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
                        <h5>Reservation Details</h5>
                       
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
                                                                                  <strong>Expected Check Out</strong>  : <?php echo date('d/m/Y',$checkout1); ?> <br>
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
                            <h5>Add Check In Details</h5>
                                                   </div>
                        <div class="ibox-content">
                            <?php
                            if(isset($_POST['amount'],$_POST['actualcheckin'])){
                                    $actualcheckin=  mysqli_real_escape_string($con,strtotime($_POST['actualcheckin']));
                                    $amount=  mysqli_real_escape_string($con,trim($_POST['amount']));
                                if(empty($actualcheckin)){
                                   $errors[]='Select Date to Proceed';
                                }               
                                if(!empty($amount)){
                                    if(is_numeric($amount)==FALSE){
                                     $errors[]='Amount should be an integer';    
                                    }
                                }
                                 if($actualcheckin>$timenow){
                                $errors[]='Actual Checkin Date Cant be later than Current Date'; }
                                if(!empty($errors)){
foreach($errors as $error){ 
 ?>
 <div class="alert alert-danger"><?php echo $error; ?></div>
<?php 
}         }else{
             $update=  mysqli_query($con,"UPDATE hallreservations SET status='2',checkin='$actualcheckin',creator='".$_SESSION['emp_id']."' WHERE hallreservation_id='$id'");
             if(!empty($amount)){
             $addpayment=  mysqli_query($con,"INSERT INTO hallpayments(hallbooking_id,amount,creator,timestamp)  VALUES('$id','$amount','".$_SESSION['emp_id']."',UNIX_TIMESTAMP())");     
             }
                 ?>
                            <div class="alert alert-success">Hall checkin Successfully Updated <a href="<?php echo 'hallinvoice_print?id='.$id; ?>">Click Here</a> to View Invoice</div>
                            <?php 
                                                        }
                                                        }
                            ?>
 <form role="form" method="POST" action="" enctype="multipart/form-data">
                                                                  <div class="form-group" id="data_1">
                                <label class="font-noraml">Select Actual Checkin Date</label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text"  name="actualcheckin" class="form-control" required="required">
                                </div>
                            </div>
     <div class="form-group"><label class="col-sm-8 control-label"> Any Advance Payment if guest not reserved</label>
                                     <div class="col-sm-10">
                                        <input type="text" class="form-control" name='amount' placeholder="Enter Amount in figures">
                                       <div class="hr-line-dashed"></div>
                                    </div>
                                </div>
                                                            <button class="btn btn-sm btn-info pull-right m-t-n-xs" type="submit"><strong>Confirm checkin</strong></button>
                                                                                                                
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
  
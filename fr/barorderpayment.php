<?php 
include 'includes/conn.php';
 if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
   }
   $order_id=$_GET['id'];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>Add Bar Order Payment- Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
      <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <?php include 'nav.php'; ?>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
          
        </div>
            <ul class="nav navbar-top-links navbar-right">
               
                <li>
                    <a href="logout">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Add Bar order Payment</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a href="bar">Bar</a>                       </li>
                        <li class="active">
                            <strong>Add Order Payment</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                                                                <div class="col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Order Details</h5>                          
                        </div>
                        <div class="ibox-content">
                             <?php
                           $restorder=mysqli_query($con,"SELECT * FROM barorders WHERE barorder_id='$order_id'");
          $row=  mysqli_fetch_array($restorder);
  $barorder_id=$row['barorder_id'];
  $guest=$row['guest'];
  $timestamp=$row['timestamp'];
        $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(charge*items), 0) AS totalcosts FROM barorder_drinks WHERE barorder_id='$order_id'");
                            $row=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row['totalcosts'];
                             $totalpaid=mysqli_query($con,"SELECT COALESCE(SUM(amount), 0) AS totalpaid FROM barpayments WHERE order_id='$order_id'");
                            $row=  mysqli_fetch_array($totalpaid);
                            $paidtotal=$row['totalpaid'];
                          
                            $balance=$totalcosts-$paidtotal;
                           ?>
                                                                                  
                                                             <address>
                                            <span><strong>Order Date:</strong> <?php echo date('d/m/Y',$timestamp); ?></span><br/>
                                    </address>
                              
                                    <address>
                             
                                            <span><strong>Total Bill : </strong> <?php   echo number_format($totalcosts); ?></span><br/>
                                    </address>
                               <address>
                                            <span><strong>Paid Amount: </strong> <?php   echo number_format($paidtotal); ?></span><br/>
                                    </address>
                        </div>
                        </div>
                        </div>
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Add Payment</h5>
                           <label class="label label-danger pull-right" style="font-size: 14px">Balance :<?php echo number_format($balance); ?></label>
                        </div>
                        <div class="ibox-content">
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
                    $addpayment=  mysqli_query($con,"INSERT INTO barpayments(order_id,amount,creator,timestamp) VALUES('$order_id','$amount','".$_SESSION['emp_id']."','$paymentdate')")
             ?>
  
 <div class="alert alert-success"><i class="fa fa-check"></i> Bar Order Payment Successfully Added.Click <a href="bar">Here</a> to go back to orders </div>
    <?php

    }
     }
?>
                        
     <form method="post" name='form' class="form" action=""  enctype="multipart/form-data">
                              
                           <div class="form-group " id="data_1">
                               <label class="col-sm-8 control-label">*Select Payment Date</label>
                                <div class="input-group date col-sm-10">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text"  name="paymentdate" class="form-control" required="required">
                                </div>
                            </div>
                              <div class="form-group"><label class="col-sm-8 control-label">*Add Payment</label>
                                     <div class="col-sm-10">
                                        <input type="text" class="form-control" name='amount' placeholder="Enter Amount in figures" required='required'>
                                       <div class="hr-line-dashed"></div>
                                    </div>
                                </div>
                                                                              
                                                        
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
  <div style="clear:both"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
  <script src="js/plugins/chosen/chosen.jquery.js"></script>
  <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <!-- iCheck -->
   <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>

</html>
 <script type="text/javascript">
     
                $(document).ready(function() {
            $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });


        });

    
</script>
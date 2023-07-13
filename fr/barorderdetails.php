<?php 
include 'includes/conn.php';
   if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!="Bar attendant")){   
header('Location:login.php');
   }
      $waiter=$_GET['waiter'];
   $instructions=$_GET['instructions'];
   $guest=$_GET['guest'];
     $hall=$_GET['hall'];
     $customer=$_GET['customer'];
      $discount=$_GET['discount'];
     $ordertype=$_GET['ordertype'];
     $btable=$_GET['btable'];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>Add Bar Order- Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
      <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
   <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
  
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
                    <h2>Bar Order Details</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a href="bar">Bar</a>                       </li>
                        <li class="active">
                            <strong>Order Details</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-5">
                                          
                      <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Order Details</h5>
                           
                        </div>
                        <div class="ibox-content">
                 <div class="feed-activity-list">
     <?php
               if($ordertype==3){
                       if(empty($guest)){
                                                                                                        echo '<div class="alert alert-danger">Customer name Required</div>';                           
                                                                                                                                }  else {
                                                                                        ?>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                             
                                                                                  <strong>Guest Name</strong>. :      <?php
                                                                                   
$reservations=mysqli_query($con,"SELECT * FROM reservations WHERE  reservation_id='$guest'");
 $row=  mysqli_fetch_array($reservations);
  $reservation_id=$row['reservation_id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$room_id=$row['room'];
 $roomtypes=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row1['roomnumber'];
                                            echo $firstname.' '.$lastname;

 ?> <br>
                                             </div>
                                    </div>
               <?php } }
                                                                            if($ordertype==4){ ?>
                     
                                                               <div class="feed-element">
                                                                              <div class="media-body ">     
                                                                                  <?php if(empty($hall)){ 
     echo '<div class="alert alert-danger">Select Hall Reservation to proceed</div>';
                                                                                  }else{
?>
                                                                                  <strong>Full Name</strong>  :      
                                                                                      <?php
                                                                                   
$reservations=mysqli_query($con,"SELECT * FROM hallreservations WHERE hallreservation_id='$hall'");
    $row=  mysqli_fetch_array($reservations);
   $hallreservation_id=$row['hallreservation_id'];
$fullname=$row['fullname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
$charge=$row['charge'];
$checkout=$row['checkout'];
   $status=$row['status'];
   $purpose=$row['purpose'];
   $type_id=$row['type'];
   $country=$row['country'];
  $creator=$row['creator'];
   $days=($checkout-$checkin)/(3600*24)+1;   
     $purposes=mysqli_query($con,"SELECT * FROM hallpurposes WHERE hallpurpose_id='$type_id'");
                                                     $row3 = mysqli_fetch_array($purposes);
                                                     $type=$row3['type']; 
                                                    echo $fullname;

 ?> <br>
 <strong>Package</strong> : <?php echo $type; ?><br>
                                             </div>
                                    </div>                                             
                                                                                                                                                <?php
                                                                            }                                                          
                                                                                  }
                                                                                                                            if($ordertype==2){
                                                                                                                                if(empty($customer)){
                                                                                                        echo '<div class="alert alert-danger">Customer name Required</div>';                           
                                                                                                                                }  else {  
                          $customers= mysqli_query($con,"SELECT * FROM customers WHERE status='1' AND customer_id='$customer'") or die(mysqli_errno($con));
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
                                                                                  <strong>Discount </strong> : <?php echo $discount; ?>% <br>
                                             </div>
                                    </div>
                                                                                                                            <?php } } ?>
                       
                         <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Attendant</strong>  : <?php echo $waiter; ?> <br>
                                             </div>
                                    </div>
                        <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Table</strong>  : <?php echo $btable; ?> <br>
                                             </div>
                                    </div>
                         <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Instructions</strong>  : <?php echo $instructions; ?> <br>
                                             </div>
                                    </div>
                                    </div>
                             </div>
                      </div>
                    <a href="cancelbarorder" class="btn btn-danger"><i class="fa fa-trash"></i> Cancel</a>
                    <a href="addborder?guest=<?php echo $guest;?>&&waiter=<?php echo $waiter; ?>&&instructions=<?php echo $instructions;?>&&hall=<?php echo $hall; ?>&&ordertype=<?php echo $ordertype; ?>&&customer=<?php echo $customer; ?>&&discount=<?php echo $discount; ?>&&btable=<?php echo $btable; ?>" class="btn btn-success"><i class="fa fa-save"></i> Save Order</a>                                
                </div>                                   
                                                    <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Guest ordered items</h5>
                            <label class="label label-info pull-right" id="label-info">
                           <?php
if(isset($_SESSION["bproducts"])){
    echo count($_SESSION["bproducts"]);
}else{
    echo 0;
}
?>
                                </label>
                        </div>
                        <div class="ibox-content ">
                      <?php
	
	if(isset($_SESSION["bproducts"]) && count($_SESSION["bproducts"])>0){ //if we have session variable
//		$cart_box = '<ul class="cart-products-loaded">';
		$total = 0;
	
		
                ?>

                            <div class="table-responsive m-t">
                              
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                       <th>Charge</th>
                                   
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($_SESSION["bproducts"] as $product){ //loop though items and prepare html content
			
			//set variables to use them in HTML content below
			$menuitem = $product["menuitem"]; 
			$itemprice = $product["itemprice"];
			$item_id = $product["item_id"];
			$product_qty = $product["product_qty"];						
			
			$subtotal = ($itemprice * $product_qty);
			$total = ($total + $subtotal);
                                    ?>
                                    <tr>
                                        <td><div><strong>
                                                   <?php echo $menuitem; ?>
                                                </strong></div>
                                            </td>
                                        <td> <?php echo $product_qty; ?></td>
                                                      <td><?php echo $subtotal; ?></td>
                                                                                       </tr>
                                      <?php }?>

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>
                                                                <tr>
                                                                
                                    <td><strong>TOTAL :</strong></td>
                                    <td><strong><?php echo number_format($total); ?></strong></td>
                                </tr>
                                </tbody>
                            </table>
			<?php
        
                }else{
	echo "<div class='alert alert-danger'>No Ordered items added yet</div>"; //we have empty cart
	}
?>
                        </div>
                        
                        </div>
                </div>
            </div>
        </div>
        </div>


    </div>

    <!-- Mainly scripts -->

    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
  <script src="js/plugins/chosen/chosen.jquery.js"></script>
    <!-- iCheck -->
   <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>

</html>
 

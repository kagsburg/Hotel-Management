<?php 
include 'includes/conn.php';
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!='Restaurant Attendant')){
header('Location:login.php');
   }
      $waiter=$_GET['waiter'];
   $instructions=$_GET['instructions'];
   $order_id=$_GET['tx'];
  ?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>Add Restaurant Order- Hotel Manager</title>
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
                    <h2>Restaurant Order Details</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a href="addrestaurantorder">Add</a>                       </li>
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
 
                       
                         <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Attendant</strong>. : <?php echo $waiter; ?> <br>
                                             </div>
                                    </div>
                      <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Order Id</strong>. : <?php echo $order_id*23; ?> <br>
                                             </div>
                                    </div>
                         <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Instructions</strong>. : <?php echo $instructions; ?> <br>
                                             </div>
                                    </div>
                                    </div>
                             </div>
                      </div>
                    <a href="cancelrestorder" class="btn btn-danger"><i class="fa fa-trash"></i> Cancel</a>
                    <a href="addmorerestorder?id=<?php echo $order_id; ?>&&waiter=<?php echo $waiter; ?>&&instructions=<?php echo $instructions;?>" class="btn btn-success"><i class="fa fa-save"></i> Save Order</a>
                                 </div>
                                   
                                                    <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Guest ordered items</h5>
                            <label class="label label-info pull-right" id="label-info">
                           <?php
if(isset($_SESSION["rproducts"])){
    echo count($_SESSION["rproducts"]);
}else{
    echo 0;
}
?>
                                </label>
                        </div>
                        <div class="ibox-content ">
                      <?php
	
	if(isset($_SESSION["rproducts"]) && count($_SESSION["rproducts"])>0){ //if we have session variable
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
                                    foreach($_SESSION["rproducts"] as $product){ //loop though items and prepare html content
			
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
	echo "<div class='alert alert-danger'>No Ordered items added yet</div>"; 
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
 

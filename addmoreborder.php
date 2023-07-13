<?php 
include 'includes/conn.php';
   if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!="Bar attendant")){
header('Location:login.php');
   }
        $waiter=$_GET['waiter'];
   $instructions=$_GET['instructions'];
   $order_id=$_GET['id'];
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
                    <h2>Add New Bar order</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a>Bar</a>                       </li>
                        <li class="active">
                            <strong>Add Order</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-10">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Add More Order Items</h5>
                           
                        </div>
                        <div class="ibox-content">
                             <?php
     if ((empty($waiter))&&(empty($id))){
echo '<div class="alert alert-danger">Attendant  and ORder Required</div>';
    }

else{
    if(isset($_SESSION["bproducts"]) && count($_SESSION["bproducts"])>0){ //if we have session variable
//		$cart_box = '<ul class="cart-products-loaded">';
    
                       $addrestround=  mysqli_query($con, "INSERT INTO barounds(order_id,instructions,attendant,timestamp) VALUES('$order_id','$instructions','$waiter','$timenow')") or die(mysqli_error($con));
               $baround_id= mysqli_insert_id($con);
	  foreach($_SESSION["bproducts"] as $product){ //loop though items and prepare html content			
			$menuitem = $product["menuitem"]; 
			$itemprice = $product["itemprice"];
			$item_id = $product["item_id"];
			$product_qty = $product["product_qty"];                                   
        mysqli_query($con,"INSERT INTO barorder_drinks(barorder_id,drink_id,charge,items,baround_id) VALUES('$order_id','$item_id','$itemprice','$product_qty','$baround_id')") or die(mysqli_error($con));
         unset($_SESSION["bproducts"]);
                                 }

?>
  
                            <div class="col-sm-2"></div><div class="col-sm-10"><div class="alert alert-success"><i class="fa fa-check"></i> Order Items Successfully Added.Click <strong>
                                        <a href="barorder?id=<?php echo $baround_id;?>"  target="_blank">Here</a></strong> To view Order</div></div>
    <?php
     }
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
    <script src="js/jquery-1.10.2.js"></script>
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
 <script type="text/javascript">
     
                    var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }


</script>
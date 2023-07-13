<?php 
include 'includes/conn.php';
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!='Bar attendant')){

header('Location:index.php');
   }
   $order_id=$_GET['id'];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>Add More Bar Order Items- Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
      <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
 <script>
    $(document).ready(function() {           
     
    $(".showit" ).load( "barorderprocess.php", {"load_cart":"1"}); 
		$(".form-item").submit(function(e){
			var form_data = $(this).serialize();
			var button_content = $(this).find('button[type="submit"]');
			button_content.html('Adding...'); //Loading button text 

			$.ajax({ //make ajax request to cart_process.php
				url: "barorderprocess.php",
				type: "POST",
				dataType:"json", //expect json value from server
				data: form_data
			}).done(function(data){ //on Ajax success
				$(".label-info").html(data.items); //total items in cart-info element
				button_content.html('Add to Order'); //reset button text to original text
			$(".showit").html('   <img src="img/loading2.gif" alt="loading.." style="position: relative;left: 150px;">'); //show loading image
		$(".showit" ).load( "barorderprocess.php", {"load_cart":"1"}); //Make ajax request using jQuery Load() & update results
		
			})
			e.preventDefault();
		});

	//Show Items in Cart
	
	//Remove items from cart
	$(".showit").on('click', 'a.remove-item', function(e) {
		e.preventDefault(); 
		var pcode = $(this).attr("data-code"); //get product code
		$(this).parent().fadeOut(); //remove item element from box
		$.getJSON( "barorderprocess.php", {"remove_code":pcode} , function(data){ //get Item count from Server
			$(".label-info").html(data.items); //update Item count in cart-info
            $(".showit").html('   <img src="img/loading2.gif" alt="loading.." style="position: relative;left: 150px;">');
			$(".showit" ).load( "barorderprocess.php", {"load_cart":"1"});
		});
	});
        
 
});
</script>
<style>
.fix-sec{position:fixed;width:300px;top: 10px;width: 430px;right: 25px;}
.menu-list { clear: both; max-height: 400px;  overflow: hidden;  overflow-y: scroll;}
</style>
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
                    <h2>Add More Bar order items</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a href="bar">Bar</a>                       </li>
                        <li class="active">
                            <strong>Add More Order Items</strong>
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
                            <h5>Add to Order</h5>                          
                        </div>
                        <div class="ibox-content menu-list">
                             <?php
                           $restorder=mysqli_query($con,"SELECT * FROM barorders WHERE barorder_id='$order_id'");
          $row=  mysqli_fetch_array($restorder);
  $barorder_id=$row['barorder_id'];
  $guest=$row['guest'];
  $guest=$row['customer'];
     $timestamp=$row['timestamp'];
                      ?>
                                                                                   
                             <address>
                                            <span><strong>Order Id:</strong> <?php echo 23*$order_id; ?></span><br/>
                                    </address>
                                                             <address>
                                            <span><strong>Order Date:</strong> <?php echo date('d/m/Y',$timestamp); ?></span><br/>
                                    </address>
                            <table class="table table-striped table-bordered table-hover dataTables-example"  id="datatable"> 
                                      <thead>
                                    <tr>
                                        <th>Drink Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>&nbsp;</th>
                                                    </tr>
                                    </thead>
                                     <tbody>
                                <?php
$drinks=mysqli_query($con,"SELECT * FROM drinks WHERE status='1' AND type='bar' ORDER BY drinkname");
 while($row=  mysqli_fetch_array($drinks)){     
  $drink=$row['drinkname'];
  $drink_id=$row['drink_id'];
$quantity=$row['quantity'];
  $drinkprice=$row['drinkprice'];
  $type=$row['type'];
  $status=$row['status'];
  $creator=$row['creator'];
 
 ?>
                                         <form class="form-item">
                                   <tr><td><?php echo $drink.'('.$quantity.')'; ?></td><td><?php echo $drinkprice; ?></td>
                                       <td>
                                          
                  <input type="text" class="form-control" name="product_qty" style="width:40px" required="required"> 
                                       </td>
    <td>
              <input type="hidden" name="item_id" value="<?php echo $drink_id; ?>">
        <button class="btn btn-xs btn-success" type="submit">Add to Order</button></td>
                                        </tr>
                                                     </form>   
 <?php }?>
                                        </tbody>
                                 </table> 
                        </div>
                        </div>
                                                                     <div class="ibox float-e-margins">
                        <div class="ibox-title">
                          <h5>Enter Order Details <small class="text-danger">First Select order items to proceed</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                                 
                            <form method="get" name='form' class="form" action="morebarorderdetails"  enctype="multipart/form-data">
                              
                                                                                           
                                       <div class="form-group"><label class="control-label">*Attendant</label>
                                           <input type="hidden" class="form-control" name='tx' value="<?php echo $order_id; ?>">
                                    <input type="text" class="form-control" name='waiter' placeholder="Enter person who brought the order">
                                                             <div id='form_waiter_errorloc' class='text-danger'></div>
                                                          </div>
                                                   
                                        
                                                   <div class="form-group"><label class=" control-label">Additional Instructions</label>

                                  <textarea class="form-control" name="instructions"></textarea>
                                </div>
                                                                                                          
                                <div class="form-group">
                                                                    
                                        <button class="btn btn-primary" type="submit" name="submit">Proceed</button>
                                                                    </div>
                            </form>
                        </div>
                    </div>
                        </div>
                <div class="col-lg-6 parentdiv">
                    <div class="ibox float-e-margins" id="ordered">
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
                        <div class="showit ">
                     
                        </div>
                         
<!--                            <a href="view_cart" class="btn btn-sm btn-primary">View Order</a>-->
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
 <script type="text/javascript">
     var frmvalidator  = new Validator("form");
 frmvalidator.EnableOnPageErrorDisplay();
 frmvalidator.EnableMsgsTogether();           
 frmvalidator.addValidation("waiter","req", "*Enter Waiter  to Proceed");
    
</script>
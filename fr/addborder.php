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
                            <h5>Add New Bar Order<small>All  fields marked (*) shouldn't be left blank</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                             <?php
     if ((empty($waiter))){
echo '<div class="alert alert-danger">Attendant Required</div>';
    }
else{
        if(isset($_SESSION["bproducts"]) && count($_SESSION["bproducts"])>0){ //if we have session variable
//		$cart_box = '<ul class="cart-products-loaded">';
          if($ordertype==2){
    mysqli_query($con,"INSERT INTO barorders(customer,guest,bartable,discount,timestamp,creator,status) VALUES('$ordertype','$customer','$btable','$discount','$timenow','".$_SESSION['emp_id']."','1')") or die(mysqli_error($con));
          }
          else if($ordertype==4){
                 mysqli_query($con,"INSERT INTO barorders(customer,guest,bartable,discount,timestamp,creator,status) VALUES('$ordertype','$hall','$btable','$discount','$timenow','".$_SESSION['emp_id']."','1')") or die(mysqli_error($con));
          }
                 else if (($ordertype==1)||($ordertype==3)) {
                     if($guest==''){
                         $guest=0;
                     }
    mysqli_query($con,"INSERT INTO barorders(customer,guest,bartable,discount,timestamp,creator,status) VALUES('$ordertype','$guest','$btable','$discount','$timenow','".$_SESSION['emp_id']."','1')") or die(mysqli_error($con));
          }
                  $order_id=mysqli_insert_id($con);
                       $addrestround=  mysqli_query($con, "INSERT INTO barounds(order_id,instructions,attendant,timestamp) VALUES('$order_id','$instructions','$waiter','$timenow')");
               $baround_id= mysqli_insert_id($con);
	  foreach($_SESSION["bproducts"] as $product){ //loop though items and prepare html content			
			$menuitem = $product["menuitem"]; 
			$itemprice = $product["itemprice"];
			$item_id = $product["item_id"];
			$product_qty = $product["product_qty"];                                   
        mysqli_query($con,"INSERT INTO barorder_drinks(barorder_id,drink_id,charge,items,baround_id) VALUES('$order_id','$item_id','$itemprice','$product_qty','$baround_id')") or die(mysqli_errno($con));
         unset($_SESSION["bproducts"]);
                                 }
?>
  
                            <div class="col-sm-2"></div><div class="col-sm-10"><div class="alert alert-success"><i class="fa fa-check"></i> Order Items Successfully Added.Click <strong>
                                        <a href="barinvoice?id=<?php echo $order_id;?>"  target="_blank">Here</a></strong> To view Order</div></div>
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

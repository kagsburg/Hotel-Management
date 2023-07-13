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
                    <h2>Add New Restaurant order</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a>Restaurant</a>                       </li>
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
                            <h5>Add New Restaurant Order </h5>
                           
                        </div>
                        <div class="ibox-content">
                             <?php
     if ((empty($waiter))){
echo '<div class="alert alert-danger">Waiter/ Waitress Required</div>';
    }

else{
    if(isset($_SESSION["rproducts"]) && count($_SESSION["rproducts"])>0){ //if we have session variable
//		$cart_box = '<ul class="cart-products-loaded">';
  
                       $addrestround=  mysqli_query($con, "INSERT INTO restrounds(order_id,instructions,waiter,timestamp) VALUES('$order_id','$instructions','$waiter','$timenow')") or die(mysqli_error($con));
               $restround_id= mysqli_insert_id($con);
	  foreach($_SESSION["rproducts"] as $product){ //loop though items and prepare html content			
			$menuitem = $product["menuitem"]; 
			$itemprice = $product["itemprice"];
			$item_id = $product["item_id"];
			$product_qty = $product["product_qty"];                                   
        mysqli_query($con,"INSERT INTO restaurantorders(food_id,foodprice,quantity,order_id,restround_id) VALUES('$item_id','$itemprice','$product_qty','$order_id','$restround_id')") or die(mysqli_error($con));
         unset($_SESSION["rproducts"]);
                                 }

?>
  
                            <div class="col-sm-2"></div><div class="col-sm-10"><div class="alert alert-success"><i class="fa fa-check"></i> Order Items Successfully Added.Click <strong>
                                        <a href="restorder?id=<?php echo $restround_id;?>"  target="_blank">Here</a></strong> To view Order</div></div>
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

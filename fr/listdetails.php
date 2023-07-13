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
                    <h2>Selected Items List</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a href="createlist">List</a>                       </li>
                        <li class="active">
                            <strong>Selected Items</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                                         
                                                    <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Items Selected for Purchase</h5>
                            <label class="label label-info pull-right" id="label-info">
                           <?php
if(isset($_SESSION["iproducts"])){
    echo count($_SESSION["iproducts"]);
}else{
    echo 0;
}
?>
                                </label>
                        </div>
                        <div class="ibox-content ">
                      <?php
	
	if(isset($_SESSION["iproducts"]) && count($_SESSION["iproducts"])>0){ //if we have session variable
//		$cart_box = '<ul class="cart-products-loaded">';
		$total = 0;
	
		
                ?>

                            <div class="table-responsive m-t">
                              
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                       <th>Unit Price</th>
                                       <th>Subtotal</th>
                                   
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($_SESSION["iproducts"] as $product){ //loop though items and prepare html content
			
			//set variables to use them in HTML content below
			$menuitem = $product["menuitem"]; 
			$price = $product["price"];
			$item_id = $product["item_id"];
			$product_qty = $product["product_qty"];						
			
			$subtotal = ($price * $product_qty);
			$total = ($total + $subtotal);
                                    ?>
                                    <tr>
                                        <td><div><strong>
                                                   <?php echo $menuitem; ?>
                                                </strong></div>
                                            </td>
                                        <td> <?php echo $product_qty; ?></td>
                                        <td> <?php echo number_format($price); ?></td>
                                                      <td><?php echo number_format($subtotal); ?></td>
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
	echo "<div class='alert alert-danger'>No  items added yet</div>"; //we have empty cart
	}
?>
                        </div>
                        
                        </div>
                         <a href="createlist" class="btn btn-warning"><i class="fa fa-reply"></i> Back</a>                                 
                    <a href="cancellist" class="btn btn-danger" onclick="return confirm_cancel()"><i class="fa fa-trash"></i> Cancel</a>
                    <a href="savelist" class="btn btn-success" onclick="return confirm_save()"><i class="fa fa-save"></i> Submit</a>   
                       <script type="text/javascript">
function confirm_save() {
  return confirm('You are about To Submit this list. Are you sure you want to proceed?');
}
function confirm_cancel() {
  return confirm('You are about To Cancel this list. Are you sure you want to proceed?');
}
</script>                 
                </div>
            </div>
        </div>
        </div>


    </div>

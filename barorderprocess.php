<?php
include "includes/conn.php"; //include config file
if(isset($_POST['item_id'])){
      $pquantity=$_POST['product_qty'];
    if(empty($pquantity)){
        $error='Enter Quantity to proceed';
        die(json_encode(array('items'=>$error))); 
    }
    else if (is_numeric($pquantity)==FALSE) {
        $error='Quantity should be numeric';
        die(json_encode(array('items'=>$error))); 
}else{
foreach($_POST as $key => $value){
		$new_product[$key] = filter_var($value, FILTER_SANITIZE_STRING); //create a new product array 
	}
	  $id1= $new_product['item_id'];
                           
                                $statement= $con->prepare("SELECT drinkname,drinkprice,quantity FROM drinks WHERE drink_id=? LIMIT 1");
	$statement->bind_param('s',$id1);
	$statement->execute();
	$statement->bind_result($drinkname, $drinkprice,$drinkquantity);                                      
	while($statement->fetch()){ 
                                       
                                              $new_product["menuitem"] =$drinkname.'('.$drinkquantity.')'; //fetch product name from database
                                              $new_product["itemprice"] = $drinkprice;  //fetch product price from database
                                          
		if(isset($_SESSION["bproducts"])){  //if session var already exist
			if(isset($_SESSION["bproducts"][$new_product['item_id']])) //check item exist in products array
			{
		                    unset($_SESSION["bproducts"][$new_product['item_id']]); //unset old item
			}			
		}
		
		$_SESSION["bproducts"][$new_product['item_id']] = $new_product;	//update products with new item array	
	}
	
 	$total_items = count($_SESSION["bproducts"]); //count total items
	die(json_encode(array('items'=>$total_items))); //output json 
} }
################## list products in cart ###################
if(isset($_POST["load_cart"]) && $_POST["load_cart"]==1)
{

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
                                       <th>&nbsp;</th>
                                                                           
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
                                                      <td><a href="#" class="remove-item" data-code="<?php echo $item_id; ?>"><i class="fa fa-trash-o"></i></a></td>
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
		die("No items added yet"); //we have empty cart
	}
}

################# remove item from shopping cart ################
if(isset($_GET["remove_code"]) && isset($_SESSION["bproducts"]))
{
	$item_id   = filter_var($_GET["remove_code"], FILTER_SANITIZE_STRING); //get the product code to remove

	if(isset($_SESSION["bproducts"][$item_id]))
	{
		unset($_SESSION["bproducts"][$item_id]);
	}
	
 	$total_items = count($_SESSION["bproducts"]);
	die(json_encode(array('items'=>$total_items)));
}

	
    <link href="css/bootstrap.min.css" rel="stylesheet">
<?php 
include 'includes/conn.php';
   if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!="Store Attendant")){
header('Location:login.php');
   }
       if(isset($_SESSION["iproducts"]) && count($_SESSION["iproducts"])>0){ 
           mysqli_query($con, "INSERT INTO purchaselists(creator,timestamp,status) VALUES('".$_SESSION['emp_id']."','$timenow','0')");
           $purchaselist_id=  mysqli_insert_id($con);
      foreach($_SESSION["iproducts"] as $product){ //loop though items and prepare html content			
			$menuitem = $product["menuitem"]; 
			$price = $product["price"];
			$item_id = $product["item_id"];
			$product_qty = $product["product_qty"];                                   
        mysqli_query($con,"INSERT INTO purchaseditems(purchaselist_id,item_id,price,quantity) VALUES('$purchaselist_id','$item_id','$price','$product_qty')") or die(mysqli_error($con));
         unset($_SESSION["iproducts"]);
                                 }

?>
  
                            <div class="col-sm-2"></div><div class="col-sm-10"><div class="alert alert-success"><i class="fa fa-check"></i> List Successfully Added.Click <strong>
                                        <a href="createlist">Here</a></strong> To go back</div></div>
    <?php
     }
     
?>
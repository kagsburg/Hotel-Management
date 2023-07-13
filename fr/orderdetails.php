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
                    <h2>Order Details</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a>Restaurant</a>                       </li>
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
                                                                                                                                                 if(!empty($guest)){
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
                                                                                                                                                 <?php } ?>
                        <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Table</strong>. : <?php echo $table; ?> <br>
                                             </div>
                                    </div>
                         <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Waiter/Waitress</strong>. : <?php echo $waiter; ?> <br>
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
                    <a href="addrestorder?table=<?php echo $table; ?>&&guest=<?php echo $guest;?>&&waiter=<?php echo $waiter; ?>&&instructions=<?php echo $instructions;?>" class="btn btn-success"><i class="fa fa-save"></i> Save Order</a>
                                 </div>
                                   
                                                    <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Guest ordered items</h5>
                            <label class="label label-info pull-right" id="label-info">
                           <?php
if(isset($_SESSION["products"])){
    echo count($_SESSION["products"]);
}else{
    echo 0;
}
?>
                                </label>
                        </div>
                        <div class="ibox-content ">
                      <?php
	
	if(isset($_SESSION["products"]) && count($_SESSION["products"])>0){ //if we have session variable
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
                                    foreach($_SESSION["products"] as $product){ //loop though items and prepare html content
			
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

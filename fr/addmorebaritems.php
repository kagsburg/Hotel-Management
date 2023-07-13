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

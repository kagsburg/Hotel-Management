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
                <div class="col-lg-6">
           
                  
                      <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Select Item(s) from drinks</h5>
                           
                        </div>
                        <div class="ibox-content menu-list">
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
                             </div></div>
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                          <h5>Enter Order Details <small class="text-danger">First Select order items to proceed</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                                 
                            <form method="get" name='form' class="form" action="barorderdetails">
                            <div class="form-group">
                            <label class="control-label">*Select Order Type</label>
   <select class="form-control ordertypee" name="ordertype">
                                                     <option value="" selected="selected">Select  order type</option>
                                                  <option value="1">Guest Not Checked in (pays immediately)</option>
                                                  <option value="2">Guest Not Checked in (pays later)</option>
                                                  <option value="3">From Guest checked in</option>
                                                   <option value="4">Conference Hall Order</option>
                                                                          </select>
                                                             <div id='form_ordertype_errorloc' class='text-danger'></div>
                                                          </div>                                                   
                                         <div class="form-group guest"  style="display: none">
                               <label class=" control-label">Select Guest if Checked in</label>
                                                           <select class="form-control" name="guest">
                                      <option value="" selected="selected">Select if person checked in</option>
                                      <?php
$reservations=mysqli_query($con,"SELECT * FROM reservations WHERE status='1' ORDER BY reservation_id DESC");
 while($row=  mysqli_fetch_array($reservations)){
  $reservation_id=$row['reservation_id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$room_id=$row['room'];
 $roomtypes=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row1['roomnumber'];
 ?>
                                      <option value="<?php echo $reservation_id; ?>"><?php echo $firstname.' '.$lastname.'('.$roomtype.')'; ?></option>
<?php }?>
                                      </select>
                                                               </div>
                                <div class="form-group hall" style="display: none">
                               <label class=" control-label">Select if is conference Hall Order</label>
                                                           <select class="form-control" name="hall">
                                      <option value=""  selected="selected">Select ....</option>
                                      <?php
$reservations=mysqli_query($con,"SELECT * FROM hallreservations WHERE status='1' OR status='2' ORDER BY hallreservation_id DESC");
   while($row=  mysqli_fetch_array($reservations)){
  $hallreservation_id=$row['hallreservation_id'];
$fullname=$row['fullname'];

 ?>
                                      <option value="<?php echo $hallreservation_id; ?>"><?php echo $fullname; ?></option>
<?php }?>
                                      </select>
                                                               </div>
                                  <div class="form-group"><label class="control-label">*Attendant</label>

                                    <input type="text" class="form-control" name='waiter' placeholder="Enter person who brought the order">
                                                             <div id='form_waiter_errorloc' class='text-danger'></div>
                                                          </div>
                                      <div class="form-group"><label class="control-label">*Table</label>

                                    <input type="text" class="form-control" name='btable' placeholder="Enter Table that made the  order">
                                                             <div id='form_btable_errorloc' class='text-danger'></div>
                                                          </div>
                                <div class="forcustomer" style="display:none">
                                 <div class="form-group">
                                     <label class="control-label">*Customer Name (Passport)</label>
                                      <select class="form-control" name="customer">
                                      <option value=""  selected="selected">Select ....</option>
                                      <?php
$customers=mysqli_query($con,"SELECT * FROM customers WHERE status='1' AND type='bar' ORDER BY customername");
   while($row=  mysqli_fetch_array($customers)){
  $customer_id=$row['customer_id'];
$customername=$row['customername'];
$passport_id=$row['passport_id'];

 ?>
                                      <option value="<?php echo $customer_id; ?>"><?php echo $customername.' ('.$passport_id.')'; ?></option>
<?php }?>
                                      </select>
                                                                                                                  </div>
                              
                                      <div class="form-group">
                                     <label class="control-label">Discount (%) in figures</label>
                                    <input type="text" class="form-control" name='discount' placeholder="Enter Discount">
                                                                                                                  </div>
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

   
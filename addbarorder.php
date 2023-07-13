<?php 
include 'includes/conn.php';
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!="Bar attendant")){
header('Location:login.php');
   }
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
.fix-sec{position:fixed;width:300px;top: 10px;width: 450px;right: 25px;}
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

    <!-- Mainly scripts -->

    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
  <script src="js/plugins/chosen/chosen.jquery.js"></script>
   
   <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>
<script>
 
var frmvalidator  = new Validator("form");
 frmvalidator.EnableOnPageErrorDisplay();
 frmvalidator.EnableMsgsTogether();           
 frmvalidator.addValidation("waiter","req", "*Enter Waiter  to Proceed");
 frmvalidator.addValidation("btable","req", "*Enter Table  to Proceed");
 frmvalidator.addValidation("ordertype","req", "*Select  Order Type  to Proceed");
              $(function() {
    var fixadent2= $("#ordered"), pos = fixadent2.offset();
    $(window).scroll(function() {
    if($(this).scrollTop() > (pos.top-0) &&
    fixadent2.css('position') == 'static') { fixadent2.addClass('fix-sec'); }
    else if($(this).scrollTop() <= pos.top-0&& fixadent2.hasClass('fix-sec')){ fixadent2.removeClass('fix-sec'); }
    })
    var new_width = $('.parentdiv').width();
$('.fix-sec').width(new_width);
        });
        $('.ordertypee').on('change', function() {
               var getselect=$(this).val();
                 if((getselect==='1')||(getselect==='')){
         $('.forcustomer').hide();
         $('.hall').hide();
         $('.guest').hide();
         }
  if(getselect==='2'){
         $('.forcustomer').show();
         $('.hall').hide();
         $('.guest').hide();
         }
         if(getselect==='3'){
                 $('.guest').show();
         $('.forcustomer').hide();
         $('.hall').hide();     
  }
   if(getselect==='4'){ 
       $('.hall').show();       
         $('.forcustomer').hide();       
         $('.guest').hide();
  }
});

</script>
</html>
 

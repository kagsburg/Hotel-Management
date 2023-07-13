<?php 
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login');
}
$id=$_GET['id'];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>Edit Restaurant Order - Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
      <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
       <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
 <?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/editrestorder.php';                     
                                       }else{
          ?>                               
  
    <div id="wrapper">

     <?php
     include 'nav.php';
              ?>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
         
        </div>
             
        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Edit Order</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a href="foodorders">Orders</a>                       </li>
                        <li class="active">
                            <strong>Edit Order</strong>
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
                            <h5>Edit Order<small>All  fields marked (*) shouldn't be left blank</small></h5>
                    </div>
                        <div class="ibox-content">
                             <?php
if(isset($_POST['submit'])){
    $waiter= mysqli_real_escape_string($con, trim($_POST['waiter']));
    $rtable= mysqli_real_escape_string($con, trim($_POST['rtable']));
    if(isset($_POST['isguest'])){
    $guest=$_POST['guest'];
    }else{
     $guest=0;
    }
    $items=$_POST['items'];
    $quantity=$_POST['quantity'];
    if((empty($rtable))){
        $errors[]='Some Fields are empty';
    }
    if(!empty($errors)){
    foreach ($errors as $error) {
    echo '<div class="alert alert-danger">'.$error.'</div>';
  }
    }else{
       mysqli_query($con,"UPDATE orders SET guest='$guest',rtable='$rtable',waiter='$waiter' WHERE order_id='$id'") or die(mysqli_error($con));
       $allitems= sizeof($items);
       mysqli_query($con,"DELETE FROM restaurantorders WHERE order_id='$id'");
      for($i=0;$i<$allitems;$i++){
       $splititems= explode('_', $items[$i]);
       $item_id=$splititems[0];
       $itemprice=$splititems[1];                 
         $getfooditem=mysqli_query($con,"SELECT * FROM menuitems WHERE status='1' AND menuitem_id='$item_id'");
     $row=  mysqli_fetch_array($getfooditem);
     $taxed=$row['taxed'];
     if($taxed=='yes'){
         $tax=1;
     }else{
         $tax=0;  
     }
     $getrestround=  mysqli_query($con, "SELECT * FROM restrounds WHERE order_id='$id'") or die(mysqli_error($con));
     $rowr= mysqli_fetch_array($getrestround);
     $restround_id=$rowr['restround_id'];
       mysqli_query($con,"INSERT INTO restaurantorders(food_id,foodprice,quantity,order_id,tax,restround_id) VALUES('$item_id','$itemprice','$quantity[$i]','$id','$tax','$restround_id')") or die(mysqli_error($con));
      }
        ?>
<div class="alert alert-success"><i class="fa fa-check"></i>Restaurant Order Successfully Edited. Click <a href="restinvoice_print?id=<?php echo $id; ?>">Here</a> To View Invoice</div>
    <?php
         }
     }
  $order_id=$_GET['id'];
$restorder=mysqli_query($con,"SELECT * FROM orders WHERE  order_id='$order_id'");
 $row=  mysqli_fetch_array($restorder);
  $order_id=$row['order_id'];
  $guest=$row['guest'];
  $mode=$row['mode'];
  $rtable=$row['rtable'];
  $vat=$row['vat'];
  $customer=$row['customer'];
    $waiter=$row['waiter'];
   $timestamp=$row['timestamp'];
  $getyear=date('Y',$timestamp);
       $count=1;
   $beforeorders=  mysqli_query($con, "SELECT * FROM orders WHERE status IN (1,2) AND  order_id<'$order_id'") or die(mysqli_error($con));
                     while ($rowb = mysqli_fetch_array($beforeorders)) {
                      $timestamp2=$rowb['timestamp']; 
                     $getyear2=date('Y',$timestamp2);
                      if($getyear==$getyear2){
                          $count=$count+1;
                      }
                     }
         $gettable=mysqli_query($con,"SELECT * FROM hoteltables WHERE hoteltable_id='$rtable'");
     $rowt= mysqli_fetch_array($gettable);
    $table_no=$rowt['table_no'];          
?>
                        
     <form method="post" name='form' class="form" action=""  enctype="multipart/form-data">
         <div class="form-group"><label class="control-label">*Waiter / Waitress</label>
    <select name="waiter" class="form-control">
       <option value="<?php echo $waiter; ?>"><?php echo $waiter; ?></option>
               <?php
$employees=  mysqli_query($con,"SELECT * FROM employees WHERE status='1' AND designation='6'");
            while ($row = mysqli_fetch_array($employees)) {
                                          $employee_id=$row['employee_id'];
                                           $fullname=$row['fullname'];
                                          $gender=$row['gender'];
                                          $design_id=$row['designation'];
                                            $status=$row['status'];
                                            $ext=$row['ext'];											

 ?>
                       <option value="<?php echo $fullname; ?>"><?php echo $fullname; ?></option>
<?php }?>
    </select>
              <div id='form_waiter_errorloc' class='text-danger'></div>
                                                          </div> 
                   <div class="form-group"><label class="control-label">*Table</label>
                                                                    <select name="rtable" class="form-control">
                                                              <option value="<?php echo $rtable; ?>"><?php echo $table_no; ?></option>
                                                     <?php
$tables=mysqli_query($con,"SELECT * FROM hoteltables WHERE area='rest' AND status='1'");
        while($row=  mysqli_fetch_array($tables)){
  $hoteltable_id=$row['hoteltable_id'];
  $table_no=$row['table_no'];
 ?>
                       <option value="<?php echo $hoteltable_id; ?>"><?php echo $table_no; ?></option>
<?php }?>
                                                                    </select>
                            <!--<div id='form_rtable_errorloc' class='text-danger'></div>-->
                                                            
                                                          </div>     
           <div class="form-group">
              <div class="form-check">
                  <?php
                  if($guest>0){
                  ?>
                  <input class="form-check-input" name="isguest" type="checkbox" value="linked" id="resident" checked="checked">
                  <?php }else{?>
      <input class="form-check-input" name="isguest"  type="checkbox" value="linked" id="resident">
                  <?php }?>
  <label class="form-check-label" for="defaultCheck1">
Is Customer a hotel resident?
  </label>
</div>    
</div>   
                                <div class="form-group forresidents"   <?php if($guest<1){?> style="display:none" <?php }?>>
                                    <label class="control-label">*Select Resident</label>
                                                        <select name="guest" class="form-control">
                                      <?php    if($guest>0){ 
                         $reservation=mysqli_query($con,"SELECT * FROM reservations WHERE reservation_id='$guest'");
$row=  mysqli_fetch_array($reservation);
 $firstname1=$row['firstname'];
$lastname1=$row['lastname'];                   
                                          ?>
                                    <option value="<?php echo $guest; ?>" selected="selected"><?php echo $firstname1.' '.$lastname1; ?></option>
                              <?php }else{ ?>
              <option value="0" selected="selected">Select Guest...</option>
                     <?php } ?>
                                                     <?php
   $reservation=mysqli_query($con,"SELECT * FROM reservations WHERE status='1'");
while($row=  mysqli_fetch_array($reservation)){
 $firstname1=$row['firstname'];
$lastname1=$row['lastname'];
            $room_id=$row['room'];
            $reservation_id=$row['reservation_id'];
       $roomtypes=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomnumber=$row1['roomnumber'];
                
 ?>
                       <option value="<?php echo $reservation_id; ?>"><?php echo $firstname1.' '.$lastname1 .' ('.$roomnumber.')';  ?></option>
<?php }?>
                                                                    </select>
                                                                                   
                                                          </div> 
             <div class='buffetsec'>
                     <h3>ORDERED ITEMS</h3>
                 <?php
            $count=-1;
    $foodsordered=  mysqli_query($con,"SELECT * FROM restaurantorders WHERE order_id='$id'");
      while ($row3=  mysqli_fetch_array($foodsordered)){
                      $restorder_id=$row3['restorder_id'];
                      $food_id=$row3['food_id'];
                      $price=$row3['foodprice'];
                      $quantity=$row3['quantity'];
   ?>
          <div class="row">      
              <div class="col-lg-12"><hr style="border-top: dashed 1px #b7b9cc;"></div>
              <div class="col-lg-11"><div class="row">  <div class="form-group col-lg-6"> 
                          <label class="control-label">* Item</label> 
                              <select data-placeholder="Choose item..." name="items[]" class="chosen-select items"    style="width:100%;">
        <?php     
             $fooditems=mysqli_query($con,"SELECT * FROM menuitems WHERE status='1' ORDER BY menuitem");  
             while($row=  mysqli_fetch_array($fooditems)){  
                 $menuitem_id=$row['menuitem_id']; 
             $menuitem=preg_replace('/[^a-zA-Z0-9\-]/', ' ',$row['menuitem']); 
             $itemprice=$row['itemprice'];   
             if($menuitem_id==$food_id){
             ?> 
                                  <option value="<?php echo $food_id.'_'.$price; ?>" selected="selected"><?php echo $menuitem.' ('.$price.')'; ?></option>     
             <?php }else{?>
             <option value="<?php echo $menuitem_id.'_'.$itemprice; ?>"><?php echo $menuitem.' ('.$itemprice.')'; ?></option>     
             <?php }}?>  
                          </select>  
                      </div>     
                  <div class="form-group col-lg-6"> 
                      <label class="control-label">Quantity</label> 
                      <input class="form-control" name="quantity[]" placeholder="Quantity" value="<?php echo $quantity; ?>">      
                  </div> 
                                            </div> </div>
                      <button class="remove_buffet  btn btn-danger" style="height:30px;margin-top:22px"><i class="fa fa-minus"></i></button></div>
      <?php } ?>
           <a href='#' class="buffet_button btn btn-success">Add More items</a>
                    
                   
                                   </div> 
                           
                 <div class="form-group">
                     <button class="btn btn-primary" type="submit" name="submit">Edit</button>
                            
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </div>
    
                                       <?php }?>
    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
  <script src="js/plugins/chosen/chosen.jquery.js"></script>
  <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- iCheck -->
   <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>

</html>
 <script type="text/javascript">
      $('#resident').click(function(){
    if($(this).prop("checked")=== true){
       $('.forresidents').show();    
            }else{
     $('.forresidents').hide();                 
            }
    } );

                          var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
       
    
            $('.buffet_button').click(function(e){ //on add input button click
        e.preventDefault();  
          $('.buffetsec').append('<div class="row"><div class="col-lg-12"><hr style="border-top: dashed 1px #b7b9cc;"></div><div class="col-lg-11"><div class="row">  <div class="form-group col-lg-7"><label class="control-label">Menu Itemm (price)</label> <select data-placeholder="Choose items..." name="items[]" class="chosen-select items" style="width:100%">    <?php        $fooditems=mysqli_query($con,"SELECT * FROM menuitems WHERE status='1' ORDER BY menuitem");  while($row=  mysqli_fetch_array($fooditems)){   $menuitem_id=$row['menuitem_id']; $menuitem=preg_replace('/[^a-zA-Z0-9\-]/', ' ',$row['menuitem']);   $itemprice=$row['itemprice'];      ?> <option value="<?php echo $menuitem_id.'_'.$itemprice; ?>"><?php echo $menuitem.' ('.$itemprice.')'; ?></option>               <?php }?>   </select>                    </div>      <div class="form-group col-lg-5"> <label class="control-label">Quantity</label> <input type="number" min="1" class="form-control" name="quantity[]" placeholder="Enter quantity">  </div> </div> </div> <button class="remove_buffet  btn btn-danger" style="height:30px;margin-top:22px"><i class="fa fa-minus"></i></button></div>'); //add input box
                           var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }
                for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
          
          });
          $('.buffetsec').on("click",".remove_buffet", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    });
 $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });
 
    
</script>
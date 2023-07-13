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
                    <h2>Add  More Restaurant order Items</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a href="foodorders">Restaurant Orders</a>                       </li>
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
                                    <div class="col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Order Details</h5>                          
                        </div>
                        <div class="ibox-content">
                             <?php
                           $restorder=mysqli_query($con,"SELECT * FROM orders WHERE order_id='$order_id'");
          $row=  mysqli_fetch_array($restorder);
  $order_id=$row['order_id'];
  $guest=$row['guest'];
   $table=$row['table'];
   $timestamp=$row['timestamp'];
                           ?>
                                                                                    <?php if($guest!=0){ ?>
                                     <span><strong>Guest Name:</strong>   <?php
                                                                                   $reservation=mysqli_query($con,"SELECT * FROM reservations WHERE reservation_id='$guest'");
$row=  mysqli_fetch_array($reservation);
 $firstname1=$row['firstname'];
$lastname1=$row['lastname'];
              echo $firstname1.' '.$lastname1;
                            
                            ?></span><br/>
                                      <?php }?> 
                             <span> <strong>Table:</strong><?php echo $table; ?></span><br/>
                                    <address>
                                            <span><strong>Order Date:</strong> <?php echo date('d/m/Y',$timestamp); ?></span><br/>
                                    </address>
                        </div>
                        </div>
                        </div>
                <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Add More Restaurant Order Items <small>All  fields marked (*) shouldn't be left blank</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                             <?php
if(isset($_POST['item1'],$_POST['item2'],$_POST['drink'],$_POST['instructions'],$_POST['waiter'])){
     $item1=$_POST['item1'];
     $item2=$_POST['item2'];
     $drink=$_POST['drink'];
     $instructions=  mysqli_real_escape_string($con,trim($_POST['instructions']));
     $waiter=  mysqli_real_escape_string($con,trim($_POST['waiter']));
       if ((empty($item1))&&(empty($item2))&&(empty($drink))&&(empty($waiter))){
echo '<div class="alert alert-danger">Select Food items To Continue</div>';
    }

else{
                  $addrestround=  mysqli_query($con, "INSERT INTO restrounds VALUES('','$order_id','$instructions','$waiter',UNIX_TIMESTAMP())");
               $restround_id= mysqli_insert_id($con);
	 foreach ($item1 as $item1){
                $split1= explode('-',$item1);
                                    $id1=  current($split1);
                                      $price1=end($split1);
                                    mysqli_query($con,"INSERT INTO restaurantorders VALUES('','$id1','$price1','0','food','$order_id','$restround_id')") or die(mysqli_errno($con));
                                 
                                 }
                                    mysqli_query($con, "DELETE FROM restaurantorders WHERE food_id='0'");
                                  foreach ($item2 as $item2){
                $split2= explode('-',$item2);
                                    $id2=  current($split2);
                                      $price2=end($split2);
                                    mysqli_query($con,"INSERT INTO restaurantorders VALUES('','$id2','$price2','0','food','$order_id','$restround_id')") or die(mysqli_errno($con));
         
                                 }
                                    mysqli_query($con, "DELETE FROM restaurantorders WHERE food_id='0'");
                                  foreach ($drink as $drink){
                $split3= explode('-',$drink);
                                    $id3=  current($split3);
                                      $price3=end($split3);
                                    mysqli_query($con,"INSERT INTO restaurantorders VALUES('','$id3','$price3','0','drink','$order_id','$restround_id')") or die(mysqli_errno($con));
         
                                 }
                                  mysqli_query($con, "DELETE FROM restaurantorders WHERE food_id='0'");
                                 

?>
  
                            <div class="col-sm-2"></div><div class="col-sm-10"><div class="alert alert-success"><i class="fa fa-check"></i>Restaurant Order Successfully Added.Click 
                                    <strong><a href="addrestquantities?id=<?php echo $restround_id; ?>">Here</a> </strong> To Add Number of Items</div></div>
    <?php

    }
     }
?>
                        
     <form method="post" name='form' class="form" action=""  enctype="multipart/form-data">
                              
                                  
                                <div class="form-group">
                                <label class="col-sm-8 control-label">Select Item(s) from main menu</label>
                                <div class="col-sm-10">
                                <select data-placeholder="Choose menu items..." class="chosen-select" name='item1[]' multiple style="width:100%;" tabindex="4">
                                    <option value="0-0" selected="selected"></option>
                                <?php
$fooditems=mysqli_query($con,"SELECT * FROM menuitems WHERE status='1' AND menu='1' ORDER BY menuitem");
 while($row=  mysqli_fetch_array($fooditems)){
     $menuitem_id1=$row['menuitem_id'];
$menuitem1=$row['menuitem'];
  $itemprice1=$row['itemprice'];
 
 ?>
                                                        <option value="<?php echo $menuitem_id1.'-'.$itemprice1;?>"><?php echo $menuitem1;?></option>
 <?php }?>
                                               </select>  
                                     <div class="hr-line-dashed"></div>
                                </div>
                            </div>
                                      
                             <div class="form-group">
                                <label class="col-sm-8 control-label">Select Item(s) from Secondary menu</label>
                                <div class="col-sm-10">
                                <select data-placeholder="Choose menu items..." class="chosen-select" name='item2[]' multiple style="width:100%;" tabindex="4">
                                   <option value="0-0" selected="selected"></option>
                                <?php
$fooditems=mysqli_query($con,"SELECT * FROM menuitems WHERE status='1' AND menu='2' ORDER BY menuitem");
 while($row=  mysqli_fetch_array($fooditems)){
     $menuitem_id2=$row['menuitem_id'];
$menuitem2=$row['menuitem'];
  $itemprice2=$row['itemprice'];
 
 ?>
                                                        <option value="<?php echo $menuitem_id2.'-'.$itemprice2;?>"><?php echo $menuitem2;?></option>
 <?php }?>                                               </select>     
                                     <div class="hr-line-dashed"></div>
                                </div>
                            </div>
            
          <div class="form-group">
                                <label class="col-sm-8 control-label">Select Item(s) from drinks</label>
                                <div class="col-sm-10">
                                <select data-placeholder="Choose drink items..." class="chosen-select" name='drink[]' multiple style="width:100%;" tabindex="4">
                                    <option value="0-0" selected="selected"></option>
      
                                                         <?php
$drinks=mysqli_query($con,"SELECT * FROM drinks WHERE status='1' AND type='rest' ORDER BY drinkname");
 while($row=  mysqli_fetch_array($drinks)){     
  $drink=$row['drinkname'];
  $drink_id=$row['drink_id'];
$quantity=$row['quantity'];
  $drinkprice=$row['drinkprice'];
  $type=$row['type'];
  $status=$row['status'];
  $creator=$row['creator'];
 
 ?>
                                                        <option value="<?php echo $drink_id.'-'.$drinkprice;?>"><?php echo $drink.'('.$quantity.')';?></option>
                                                        <?php }?>
                                               </select>  
                                       <div class="hr-line-dashed"></div>
                                </div>
                            </div>                                               
                                                                      
                              
                              <div class="form-group"><label class="col-sm-8 control-label">*Waiter/Waitress</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name='waiter' placeholder="Enter person who brought the order" required='required'>
                                                                            
                                       <div class="hr-line-dashed"></div>
                                    </div>
                                </div>
                                                   
                              <div class="form-group"><label class="col-sm-8 control-label">Additional Instructions</label>

                                  <div class="col-sm-10"><textarea class="form-control" name="instructions"></textarea>
                                    <div class="hr-line-dashed"></div>  
                                  </div>
                                </div>
                                                      
                                                        
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-primary" type="submit" name="submit">Proceed</button>
                                    </div>
                                </div>
                            </form>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </div>

   
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
                <div class="col-lg-12">
                    <h2>Add Hotel Restaurant Order</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                            <a>Menu</a>
                        </li>
                        <li class="active">
                            <strong>Add Restaurant Order</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">                
                                                           <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add New Food Order</h5>
                       
                    </div>
                    <div class="ibox-content">
                                                              <?php
//                            include_once 'includes/thumbs3.php';
                            if(isset($_POST['food'],$_POST['plates'])){
                                  $food=  mysqli_real_escape_string($con,trim($_POST['food']));
                                  $plates=  mysqli_real_escape_string($con,trim($_POST['plates']));
                                    $splitfood= explode('-',$food);
                                    $food_id=  current($splitfood);
                                      $foodprice=end($splitfood);
                                      $totalcharge=$foodprice*$plates;
                                if((empty($food))||(empty($plates))){
                                    echo  '<div class="alert alert-danger"><i class="fa fa-warning"></i> All Fields Required</div>';
                                }
                             else if(is_numeric($plates)==FALSE){
                                     echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Plates Should Be An Integer</div>';
                                }
                                else{
                                                              
                                
             mysqli_query($con,"INSERT INTO restaurantorders(food_id,foodprice,quantity,order_id,restround_id) VALUES('$food_id','$totalcharge','$plates','food',UNIX_TIMESTAMP(),'".$_SESSION['emp_id']."','1')") or die(mysqli_errno($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Food Order Successfully added</div>';
                                 }
                            }
                                                
	
	
                           ?>
  
                        <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                
          <div class="form-group"><label class="col-sm-2 control-label">Food Item</label>

                                    <div class="col-sm-10">
                                            <select data-placeholder="Choose Menu Item..." class="chosen-select" name='[]' multiple style="width:100%;" tabindex="4">
                                      <option value="">Choose Menu Item  ...</option>
                                                        <?php
$fooditems=mysqli_query($con,"SELECT * FROM menuitems WHERE status='1' ORDER BY menuitem");
 while($row=  mysqli_fetch_array($fooditems)){
     $menuitem_id=$row['menuitem_id'];
$menuitem=$row['menuitem'];
  $itemprice=$row['itemprice'];
 
 ?>
                                                        <option value="<?php echo $menuitem_id.'-'.$itemprice;?>"><?php echo $menuitem;?></option>
 <?php }?>
                                               </select>   
                                                                                      
                                    </div>
                                </div>
      <div class="form-group"><label class="col-sm-2 control-label">Plates</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name='plates' placeholder="Enter Number of Plates" required='required'></div>
                                </div>
                             
                               
                                                                                                                                  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-primary" name="submit" type="submit">Add Food Order</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                    </div>
                    <div class="row">
                        
                    <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add New Drink Order <small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
                                                              <?php
//                            include_once 'includes/thumbs3.php';
                            if(isset($_POST['drink'],$_POST['quantity'])){
                                  $drink=  mysqli_real_escape_string($con,trim($_POST['drink']));
                                  $quantity=  mysqli_real_escape_string($con,trim($_POST['quantity']));
                                    $splitdrink= explode('-',$drink);
                                    $id=  current($splitdrink);
                                      $price=end($splitdrink);
                                      $totalcharge2=$price*$quantity;
                                if((empty($drink))||(empty($quantity))){
                                    echo  '<div class="alert alert-danger"><i class="fa fa-warning"></i> All Fields Required</div>';
                                }
                             else if(is_numeric($quantity)==FALSE){
                                     echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Quantity Should Be An Integer</div>';
                                }
                                else{
                                                              
                                
             mysqli_query($con,"INSERT INTO restaurantorders VALUES('','$drink','$totalcharge2','$quantity','drink',UNIX_TIMESTAMP(),'".$_SESSION['hotelsys']."','1')") or die(mysqli_errno($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Drink Order Successfully added</div>';
                                 }
                            }
                                                
	
	
                           ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                
          <div class="form-group"><label class="col-sm-2 control-label">Drink</label>

                                    <div class="col-sm-10">
                                        <select  data-placeholder="Choose a Country..." class="chosen-select" style="width:240px;" tabindex="2" name="drink">
                                                        <option value="" selected="selected">Choose Drink ...</option>
                                                        <?php
$drinks=mysqli_query($con,"SELECT * FROM drinks WHERE status='1' AND type='beverage' ORDER BY drinkname");
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
                                              
                                    </div>
                                </div>
      <div class="form-group"><label class="col-sm-2 control-label">Quantity</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name='quantity' placeholder="Enter Quantity" required='required'></div>
                                </div>
                             
                               
                                                                                                                                  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-warning" name="submit" type="submit">Add  Drink Order</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
              
                
            </div>
          
        </div>
        </div>


    </div>

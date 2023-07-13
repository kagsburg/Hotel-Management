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
                    <h2>Add Meal plan</h2>
                    <ol class="breadcrumb">
                         <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                         <li>              <a href="mealplans">Meal Plans</a>                    </li>
                      
                        <li class="active">
                            <strong>Meal Plans</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
 
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Add Meal Plan <small>Ensure to fill all necessary fields</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                                                    if(isset($_POST['mealplan'],$_POST['price'])){
                                     $mealplan=  mysqli_real_escape_string($con,trim($_POST['mealplan']));
                                     $price=  mysqli_real_escape_string($con,trim($_POST['price']));
                                        $item=$_POST['item'];
          $quantity=$_POST['quantity'];
                                      if((empty($mealplan))||(empty($price))){
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                                }                               
                                else{          
              mysqli_query($con,"INSERT INTO mealplans(mealplan,price,status) VALUES('$mealplan','$price','1')") or die(mysqli_error($con));
               $last_id=mysqli_insert_id($con);    
              $allitems= sizeof($item);
   for($i=0;$i<$allitems;$i++){        
   mysqli_query($con,"INSERT INTO mealplanitems(item_id,quantity,mealplan_id,status) VALUES('$item[$i]','$quantity[$i]','$last_id',1)");
   }
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Meal Plan  successfully added</div>';
                                 }
                            }
                                                
	
	
                           ?>
  <form method="post" class="form" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">Meal Plan</label>

                             <input type="text" class="form-control" name='mealplan' placeholder="Enter Meal Plan" required='required'>
                                </div>
                     <div class="form-group"><label class="control-label">Price</label>
     <input type="text" class="form-control" name='price' placeholder="Enter Meal Plan Price" required='required'>
                                </div>                   
                              <div class='subobj'>
                          <div class='row'>
                                  <div class="form-group col-lg-6"><label class="control-label">* Product </label>
                                         <select data-placeholder="Choose item..." name="item[]" class="chosen-select" style="width:100%;" tabindex="2">
                                    <option value="" selected="selected">choose item..</option>
                                        <?php
           $fooditems=mysqli_query($con,"SELECT * FROM menuitems WHERE status='1' ORDER BY menuitem");
 while($row=  mysqli_fetch_array($fooditems)){
     $menuitem_id=$row['menuitem_id'];
$menuitem=$row['menuitem'];
  $itemprice=$row['itemprice'];
               ?>
                                    <option value="<?php echo $menuitem_id; ?>"><?php echo $menuitem; ?></option>
               <?php }?>
                                         </select>
                                                                                                        </div>
                                  <div class="form-group col-lg-5"><label class="control-label">Quantity</label>
                                    <input type="text" name='quantity[]' class="form-control" placeholder="Enter Quantity">
                                                                                                        </div>
                        
                               <div class="form-group col-lg-1">
                                                         <a href='#' class="subobj_button btn btn-success" style="margin-top:25px">+</a>                                              
                                            </div> 
                           
                          
                                  </div>
                                                                                                        </div>                     
              <div class="form-group">
                                                                                                          <button class="btn btn-primary btn-sm" name="submit" type="submit">Add Meal Plan</button>
                                 
                                </div>
                            </form>
                                                 

                    </div>

                  
                </div>
             
                    </div>
                
               
    </div>

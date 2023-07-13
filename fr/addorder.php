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
                    <h2>Hotel Menu Drinks</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                            <a>Menu</a>
                        </li>
                        <li class="active">
                            <strong>View Drinks</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                 <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add New Drink <small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
                                                              <?php
//                            include_once 'includes/thumbs3.php';
                            if(isset($_POST['item'],$_POST['quantity'])){
                                  $item=  mysqli_real_escape_string($con,trim($_POST['item']));
                                     $quantity=  mysqli_real_escape_string($con,trim($_POST['quantity']));
                                if((empty($item))||(empty($quantity))){
                                    echo  '<div class="alert alert-danger"><i class="fa fa-warning"></i> All Fields Required</div>';
                                }
                             else if(is_numeric($quantity)==FALSE){
                                     echo '<div class="alert alert-danger"><i class="fa fa-warning"></i>Quantity Should Be An Integer</div>';
                                }
                                else{
                    mysqli_query($con,"INSERT INTO drinks VALUES('','$drink','$price','$quantity','".$_SESSION['emp_id']."','1')") or die(mysqli_errno($con));
                   echo '<div class="alert alert-success"><i class="fa fa-check"></i>Drink successfully added</div>';
                                 }
                            }                                             
	         ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                             <div class="form-group"><label class="col-sm-2 control-label">Menu Items</label>

                                    <div class="col-sm-10">
                                        <select class="form-control" name="item">
                                                        <option value="" selected="selected">Choose menu item...</option>
                                                        <?php
$menu=mysqli_query($con,"SELECT * FROM menuitems WHERE status='1' ORDER BY menuitem");
   while($row=  mysqli_fetch_array($menu)){
  $menuitem_id=$row['menuitem_id'];
$menuitem=$row['menuitem'];
$itemprice=$row['itemprice'];
  ?>
                                                        <option value="<?php echo $menuitem_id.'-'.$itemprice; ?>"><?php echo $menuitem; ?></option>
<?php } ?>
                                                                                                 </select>
                                              
                                    </div>
                                </div>
                                       
        <div class="form-group"><label class="col-sm-2 control-label">Quantity</label>

            <div class="col-sm-10"><input type="text" class="form-control" name='drik' placeholder="Enter Quantity"  required='required'></div>
                                </div>
                                       
                        
                                                                                                                                  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-primary" name="submit" type="submit">Add food item</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                    </div>
                    </div>
                <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Menu Items <small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
<?php
$drinks=mysqli_query($con,"SELECT * FROM drinks ORDER BY drinkname");
if(mysqli_num_rows($drinks)>0){
 
 ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                         <th>Drink Name</th>
                        <th>Price(shs)</th>
                        <th>Quantity</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
               while($row=  mysqli_fetch_array($drinks)){
  $drink=$row['drinkname'];
  $drink_id=$row['drink_id'];
$quantity=$row['quantity'];
  $drinkprice=$row['drinkprice'];
  $status=$row['status'];
  $creator=$row['creator'];
  
              ?>
               
                    <tr class="gradeA">
                      <td><?php echo $drink; ?></td>
                         <td class="center">
                                        <?php  echo $drinkprice; ?>
                        </td>
                          <td class="center">
                                        <?php  echo $quantity; ?>
                        </td>
                       <td> <div class="tooltip-demo">
                               
                            <a href="profile?id=<?php echo $creator; ?>" data-original-title="View admin profile"  data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php 
                                              $getname=  mysqli_query($con,"SELECT * FROM users WHERE user_id='$creator'");  
                                             $row2=  mysqli_fetch_array($getname);
                                              $fullname=$row2['fullname'];
                                             echo $fullname; ?></a> </div></td>
                     
                                               
  <td class="center"> 
         <?php
         if(($creator==$_SESSION['hotelsys'])||($_SESSION['hotelsyslevel']==1)){ 
                            
                                                        if($status=='1'){ 
                             
                                    ?>
                                            <a href="hidedrink.php?id=<?php echo $drink_id.'&&status='.$status; ?>" class="btn btn-danger btn-xs">unpublish <i class="fa fa-arrow-down"></i></a> 
                                                
                            <?php } else{ ?>
                             <a href="hidedrink.php?id=<?php echo $drink_id.'&&status='.$status; ?>"  class="btn btn-primary  btn-xs">publish <i class="fa fa-arrow-up"></i></a>
                                 <?php }
               }
                                 ?>
  </td>
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }else{?>
                        <div class="alert alert-danger">No Menu Items Added Yet</div>
 <?php }?>
                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>

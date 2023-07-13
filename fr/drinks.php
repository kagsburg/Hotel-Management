
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
                    <h2>Hotel Bar Drinks</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                            <a>Menu</a>
                        </li>
                        <li class="active">
                            <strong>View Bar Drinks</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                 
                 <div class="col-lg-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add New Drink <small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
                                                              <?php
//                            include_once 'includes/thumbs3.php';
                            if(isset($_POST['drink'],$_POST['price'],$_POST['quantity'])){
                                  $drink=  mysqli_real_escape_string($con,trim($_POST['drink']));
                                         $price=  mysqli_real_escape_string($con,trim($_POST['price']));
                                    $quantity=  mysqli_real_escape_string($con,trim($_POST['quantity']));
                                      $drink2=$drink.' ('.$quantity.')';
                                if((empty($_POST['drink']))||(empty($_POST['price']))||(empty($_POST['quantity']))){
                                    echo  '<div class="alert alert-danger"><i class="fa fa-warning"></i> All Fields Required</div>';
                                }
                             else if(is_numeric($price)==FALSE){
                                     echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Price Should Be An Integer</div>';
                                }
                                else{                                                              
             mysqli_query($con,"INSERT INTO menuitems(menuitem,itemprice,type,creator,status) VALUES('$drink2','$price','drink','".$_SESSION['emp_id']."','1')") or die(mysqli_error($con));
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Drink successfully added</div>';
                                 }
                            }
                                                
	
	
                           ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Drink</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name='drink' placeholder="Enter Drink Name" required='required'></div>
                                </div>
                                   
       <div class="form-group"><label class="col-sm-2 control-label">Price</label>

                                    <div class="col-sm-10">
                                        <div class="input-group m-b"><span class="input-group-addon">shs</span> <input name="price" class="form-control" placeholder="Enter item price" type="text"></div>
                                    </div>
                                </div>
       <div class="form-group"><label class="col-sm-2 control-label">Quantity</label>

                                    <div class="col-sm-10">
                                        <select class="form-control" name="quantity">
                                                        <option value="" selected="selected">Choose quantity...</option>
                                                        <?php
$quantities=mysqli_query($con,"SELECT * FROM drinkquantities WHERE  status='1'");
     while($row=  mysqli_fetch_array($quantities)){
  $quantity_id=$row['quantity_id'];
   $quantity=$row['quantity'];
  $status=$row['status'];
  $creator=$row['creator'];
 
 ?>
                                                        <option value="<?php echo $quantity; ?>"><?php echo $quantity; ?></option>
     <?php } ?>
                                                      
                                            </select>
                                              
                                    </div>
                                </div>
   
                        
                                                                                                                                  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-primary" name="submit" type="submit">Add Drink</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                    </div>
                    </div>
                <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Menu Items <small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
<?php
$menu=mysqli_query($con,"SELECT * FROM menuitems WHERE status=1 AND type='drink' ORDER BY menuitem");
if(mysqli_num_rows($menu)>0){ 
 ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                   <tr>
                         <th>Menu Item</th>
                        <th>Price(shs)</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
             while($row=  mysqli_fetch_array($menu)){
  $menuitem_id=$row['menuitem_id'];
$menuitem=$row['menuitem'];
  $itemprice=$row['itemprice'];
  $status=$row['status'];
  $creator=$row['creator'];
  
              ?>
                   <tr class="gradeA">
                      <td><?php echo $menuitem; ?></td>
                         <td class="center">
                                        <?php  echo $itemprice; ?>
                        </td>
                        <td> <div class="tooltip-demo">
                               
                                <a href="employee?id=<?php echo $creator; ?>" data-original-title="View admin profile"  data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php 
                                        $employee=  mysqli_query($con,"SELECT * FROM employees WHERE employee_id='$creator'");
                                         $row = mysqli_fetch_array($employee);
                                          $employee_id=$row['employee_id'];
                                           $fullname=$row['fullname'];
                                             echo $fullname; ?></a> </div> </td>
                                               
  <td class="center"> 
              <a href="hideitem.php?id=<?php echo $menuitem_id.'&&status='.$status; ?>"  class="btn btn-danger  btn-xs"  onclick="return confirm_delete<?php echo $menuitem_id; ?>()">Remove <i class="fa fa-arrow-up"></i></a>                      
              <a href="editdrink.php?id=<?php echo $menuitem_id;?>" class="btn btn-info btn-xs">Edit <i class="fa fa-edit"></i></a> 
 <script type="text/javascript">
function confirm_delete<?php echo $menuitem_id; ?>() {
  return confirm('You are about To Remove this Item. Are you sure you want to proceed?');
}
</script>                 
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

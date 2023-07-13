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
                    <h2>Drink Quantities</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                       
                     
                        <li class="active">
                            <strong>Quantities</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                 <div class="col-lg-5">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add New Drink Quantity <small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
                                                              <?php
//                            include_once 'includes/thumbs3.php';
                            if(isset($_POST['quantity'])){
                                  $quantity=  mysqli_real_escape_string($con,trim($_POST['quantity']));
                                   if(empty($quantity)){
                                    echo  '<div class="alert alert-danger"><i class="fa fa-warning"></i> All Fields Required</div>';
                                }
                                                        else{
                                                              
                                
             mysqli_query($con,"INSERT INTO drinkquantities(quantity,creator,status)  VALUES('$quantity','".$_SESSION['emp_id']."','1')") or die(mysqli_errno($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Quantity successfully added</div>';
                                 }
                            }
                                                
	
	
                           ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Quantity</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name='quantity' placeholder="Enter Quantity Name" required='required'></div>
                                </div>
      
                             
                              
                                                                                                                                  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-primary btn-sm" name="submit" type="submit">Add Quantity</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                    </div>
                    </div>
                <div class="col-lg-7">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Drink Quantities <small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
<?php
$quantities=mysqli_query($con,"SELECT * FROM drinkquantities WHERE  status='1'");
if(mysqli_num_rows($quantities)>0){
 
 ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                         
                        <th>ID</th>
                         <th>Quantity</th>
                          <th>Added By</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
               while($row=  mysqli_fetch_array($quantities)){
  $quantity_id=$row['quantity_id'];
   $quantity=$row['quantity'];
  $status=$row['status'];
  $creator=$row['creator'];
  
              ?>
               
                    <tr class="gradeA">
                      <td><?php echo $quantity_id; ?></td>
                         <td class="center">
                                        <?php  echo $quantity; ?>
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
                     <a href="hidequantity.php?id=<?php echo $quantity_id; ?>"  class="btn btn-danger  btn-xs" onclick="return confirm_delete<?php echo $quantity_id;?>()">Remove <i class="fa fa-arrow-down"></i></a>
   <script type="text/javascript">
function confirm_delete<?php echo $quantity_id; ?>() {
  return confirm('You are about To Remove this item. Are you sure you want to proceed?');
}
</script>   
     <a href="editquantity?id=<?php echo $quantity_id; ?>"  class="btn btn-info  btn-xs">Edit <i class="fa fa-edit"></i></a>
                     
  </td>
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }else{?>
                        <div class="alert alert-danger">No Quantities Added Yet</div>
 <?php }?>
                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>

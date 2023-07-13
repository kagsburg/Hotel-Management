<?php
include 'includes/conn.php';

   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
   }
 
   ?>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laundry Packages | Hotel Manager</title>
<script src="ckeditor/ckeditor.js"></script>
  <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    

    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">

  

    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">

   
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
<?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/laundrytypes.php';                     
                                       }else{
          ?>          
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
                    <h2>Laundry Packages </h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                                             <li class="active">
                            <strong>Laundry Packages</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
                   <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Add Laundry Package<small>Ensure to fill all necessary fields</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                                                 if(isset($_POST['package'],$_POST['charge'])){
                                     $package=  mysqli_real_escape_string($con,trim($_POST['package']));
                                    $charge=  mysqli_real_escape_string($con,trim($_POST['charge']));
                                 if((empty($package)||(empty($charge)))){
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                                }
                                if(is_numeric($charge)==FALSE){
                                     echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Charge should be An Integer</div>';
                                }
                                else{
                                                          
              mysqli_query($con,"INSERT INTO laundrypackages(laundrypackage,charge,creator,status) VALUES('$package','$charge','".$_SESSION['emp_id']."','1')") or die(mysqli_error($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Laundry Package successfully added</div>';
                                 }
                            }
                                      ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Package</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name='package' placeholder="Enter Package" required='required'></div>
                                </div>
        <div class="form-group"><label class="col-sm-2 control-label">Charge</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name='charge' placeholder="Enter  Charge" required='required'></div>
                                </div>
                                                 <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-success btn-sm" name="submit" type="submit">Add Package</button>
                                    </div>
                                </div>
                            </form>
                                                 

                    </div>

                  
                </div>
             
                    </div>
                                 <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Packages</h5>
                        
                        </div>
                        <div class="ibox-content">
                             <table class="table table-striped  table-hover">
                    <thead>
                    <tr>
                      <th>Package</th>
                        <th>Charge</th>
                        <th>Added by</th>
                       <th>&nbsp;</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                        <tr>     <?php
                            $getpackages=mysqli_query($con,"SELECT * FROM laundrypackages WHERE status='1'");
                            if(mysqli_num_rows($getpackages)>0){
                                while ($row = mysqli_fetch_array($getpackages)) {
                                                     $laundrypackage_id=$row['laundrypackage_id'];
                                                     $laundrypackage=$row['laundrypackage'];
                                                     $charge=$row['charge'];
                                                     $creator=$row['creator'];
                                                              $status=$row['status'];
                                                                         ?>
                                     
                       <tr>
                                      <td><?php echo $laundrypackage; ?></td>
                                   <td><?php echo $charge; ?></td>
                                                                  
                                    <td> <div class="tooltip-demo">
                               
                               <a href="employee?id=<?php echo $creator; ?>" data-original-title="View admin profile"  data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php 
                                            $employee=  mysqli_query($con,"SELECT * FROM employees WHERE employee_id='$creator'");
                                         $row2 = mysqli_fetch_array($employee);
                                          $employee_id=$row2['employee_id'];
                                           $fullname=$row2['fullname'];
                                             echo $fullname;  ?></a> </div></td>
                                                         <td>
                                        <?php
                                            if(($_SESSION['hotelsyslevel']==1)){ 
                                        ?>
                                        <a href="editlaundrypackage?id=<?php echo $laundrypackage_id;?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
                 <a href="hidelaundrypackage?id=<?php echo $laundrypackage_id;?>" onclick="return cdelete<?php echo $laundrypackage_id;?>()" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Remove</a>
                       <script type="text/javascript">
                         function cdelete<?php echo $laundrypackage_id; ?>() {
  return confirm('You are about To Delete a Package. Do you want to proceed?');
}
</script>                 
                                            <?php } ?>
                                    </td>
                       </tr>
                       
                                    <?php
                                }
                            }  else {
echo "<div class='alert alert-danger'>No Packages Added Yet</div>";                             
}
                            ?>
                    
                    </tbody>
                             </table>
                        </div>
                    </div>
                    </div>




    </div>
                                       <?php }?>
    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Chosen -->
    <script src="js/plugins/chosen/chosen.jquery.js"></script>

   <!-- Input Mask-->
    <!--<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>-->

   <!-- Data picker -->
   <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

  
    <!-- iCheck -->
    <!--<script src="js/plugins/iCheck/icheck.min.js"></script>-->

    <!-- MENU -->
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

   
 
</body>


</html>

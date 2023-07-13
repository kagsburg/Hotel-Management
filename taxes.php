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

    <title>Taxes | Hotel Manager</title>
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
                                           include 'fr/taxes.php';                     
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
                    <h2>Taxes</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                                               <li class="active">
                            <strong>Taxes</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
   <?php
                                            if(($_SESSION['hotelsyslevel']==1)){ 
                                        ?>
                <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Add Tax <small>Ensure to fill all necessary fields</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                                   if(isset($_POST['tax'],$_POST['rate'])){
                                     $tax=  mysqli_real_escape_string($con,trim($_POST['tax']));
                                    $rate=  mysqli_real_escape_string($con,trim($_POST['rate']));
                                 if((empty($tax)||(empty($rate)))){
                                   $errors[]='Enter All Fields To Proceed';
                                }
                                if(is_numeric($rate)==FALSE){
                                $errors[]='Room Charge should be An Integer';
                                }
                               if(!empty($errors)){
                                   foreach ($errors as $error) {
                                       echo '<div class="alert alert-danger">'.$error.'</div>';       
                                   }
                               }
                                else{
              mysqli_query($con,"INSERT INTO taxes(tax,rate,status) VALUES('$tax','$rate','1')") or die(mysqli_error($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Tax successfully added</div>';
                                 }
                            }
                                                
	
	
                           ?>
  <form method="post" class="form" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">Tax Name</label>
<input type="text" class="form-control" name='tax' placeholder="Enter Tax Name" required='required'>
                                </div>                               
        <div class="form-group"><label class="control-label">Rate (%)</label>
<input type="text" class="form-control" name='rate' placeholder="Enter Tax Rate" required='required'></div>
                                 
                               <div class="form-group">
                         <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                               
                                </div>
                            </form>
                                                 

                    </div>

                  
                </div>
             
                    </div>
                           <?php } ?>
                           <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Tax Rates</h5>
                        
                        </div>
                        <div class="ibox-content">
                             <table class="table table-striped  table-hover">
                    <thead>
                    <tr>
                      <th>Tax Name</th>
                        <th>Rate (%)</th>
                     <th>&nbsp;</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                        <tr>     <?php
                            $taxes=mysqli_query($con,"SELECT * FROM taxes WHERE status=1");
                            if(mysqli_num_rows($taxes)>0){
                                while ($row = mysqli_fetch_array($taxes)) {
                                    $tax_id=$row['tax_id'];
                                    $tax=$row['tax'];
                                    $rate=$row['rate'];
                                           ?>
                       <tr>
                                   <td><?php echo $tax; ?></td>
                                   <td><?php echo $rate; ?></td>
                                           <td>
                                        <?php
                                            if(($_SESSION['hotelsyslevel']==1)){ 
                                        ?>
                                               <a data-toggle="modal" class="btn btn-info btn-xs" href="#modal-form<?php echo $tax_id; ?>"><i class="fa fa-edit"></i> Edit</a>
                                  
                                    <a href="hidetax?id=<?php echo $tax_id;?>" class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $tax_id;?>()"><i class="fa fa-arrow-down"></i>Remove</a>
              <script type="text/javascript">
function confirm_delete<?php echo $tax_id; ?>() {
  return confirm('You are about To Perform  this Action. Are you sure you want to proceed?');
}
</script>                                       
      <?php }?>
                                    </td>
                       </tr>
                    
                                    <?php
                                }
                            }  else {
echo "<div class='alert alert-danger'>No Taxes Added Yet</div>";                             
}
                            ?>
                    
                    </tbody>
                             </table>
                        </div>
                    </div>
                    </div>
 </div>
 </div>
 </div>
 </div>
 
             <?php
                            $taxes=mysqli_query($con,"SELECT * FROM taxes WHERE status=1");
                            while ($row = mysqli_fetch_array($taxes)) {
                                    $tax_id=$row['tax_id'];
                                    $tax=$row['tax'];
                                    $rate=$row['rate'];
                                           ?>
   <div id="modal-form<?php echo $tax_id; ?>" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form method="post" class="form" action='edittax?id=<?php echo $tax_id; ?>'  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">Tax Name</label>
                                    <input type="text" class="form-control" name='tax' placeholder="Enter Tax Name" required='required' value="<?php echo $tax; ?>">
                                </div>                               
        <div class="form-group"><label class="control-label">Rate (%)</label>
            <input type="text" class="form-control" name='rate' placeholder="Enter Tax Rate" required='required' value="<?php echo $rate; ?>"></div>
                               
                               <div class="form-group">
                         <button class="btn btn-primary" name="submit" type="submit">Submit</button>
                               
                                </div>
                            </form>
                                                </div>
                                                </div>
                                                </div>
                                                </div>
                                       <?php }}?>
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

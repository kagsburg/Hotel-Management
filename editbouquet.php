<?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
   }
     $id=$_GET['id'];
   ?>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Bouquet | Hotel Manager</title>
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
                                           include 'fr/editbouquet.php';                     
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
                    <h2>Edit Gym Bouquet</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>
                            <a href="gymbouquets">Gym Bouquets </a>
                        </li>
                        <li class="active">
                            <strong>Edit Bouquet</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
                   <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Edit Gym Bouquet<small>Ensure to fill all necessary fields</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                                                 if(isset($_POST['bouquet'],$_POST['charge'],$_POST['days'])){
                                          $bouquet=mysqli_real_escape_string($con,trim($_POST['bouquet']));
                                    $charge=  mysqli_real_escape_string($con,trim($_POST['charge']));
                                    $days=  mysqli_real_escape_string($con,trim($_POST['days']));
                                 if((empty($bouquet))||(empty($charge))||(empty($days))){
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                                }
                                if(is_numeric($charge)==FALSE){
                                     echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Charge should be An Integer</div>';
                                }
                                else{
                                                          
              mysqli_query($con,"UPDATE gymbouquets  SET gymbouquet='$bouquet',days='$days',charge='$charge' WHERE gymbouquet_id='$id'") or die(mysqli_errno($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Bouquet successfully Edited</div>';
                                 }
                            }
                                            $gymbouquets=mysqli_query($con,"SELECT * FROM gymbouquets WHERE status='1' AND gymbouquet_id='$id'");
                                          $row = mysqli_fetch_array($gymbouquets);
                                                     $gymbouquet_id=$row['gymbouquet_id'];
                                                     $gymbouquet=$row['gymbouquet'];
                                                     $charge=$row['charge'];
                                                     $days=$row['days'];
                                                     $creator=$row['creator'];
                                                     $timestamp=$row['timestamp'];
                                                     $status=$row['status'];
                                      ?>
  <form method="post" class="form" action=''  name="form" enctype="multipart/form-data">
                               <div class="form-group"><label class="control-label">Bouquet Name</label>
                                   <input type="text" class="form-control" name='bouquet' placeholder="Enter Bouquet" required='required' value="<?php echo $gymbouquet; ?>"></div>
                                
        <div class="form-group"><label class="control-label">Number of Days</label>
 <input type="number" class="form-control" name="days" placeholder="Enter Days " required='required' value="<?php echo $days; ?>"></div>
                              
                          <div class="form-group"><label class="control-label">Charge</label>
<input type="text" class="form-control" name='charge' placeholder="Enter  Charge" required='required' value="<?php echo $charge; ?>"></div>
                          <div class="form-group">
                   
                                                                           <button class="btn btn-success btn-sm" name="submit" type="submit">Edit</button>
                        
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

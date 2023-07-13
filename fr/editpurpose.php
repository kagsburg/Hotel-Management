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

    <title>Edit Hall Purpose | Hotel Manager</title>
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
                    <h2>Edit Hall  Purpose</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>
                            <a href="hallpurposes">Hall Purposes </a>
                        </li>
                        <li class="active">
                            <strong>Edit  Purpose</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
                   <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Edit Reservation Purpose <small>Ensure to fill all necessary fields</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                                                 if(isset($_POST['purpose'],$_POST['charge'])){
                                     $purpose=  mysqli_real_escape_string($con,trim($_POST['purpose']));
                                    $charge=  mysqli_real_escape_string($con,trim($_POST['charge']));
                                 if((empty($purpose)||(empty($charge)))){
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                                }
                                if(is_numeric($charge)==FALSE){
                                     echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Purpose Charge should be An Integer</div>';
                                }
                                else{
                                                          
              mysqli_query($con,"UPDATE hallpurposes  SET hallpurpose='$purpose',charge='$charge' WHERE hallpurpose_id='$id'") or die(mysqli_errno($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Reservation Purpose successfully Edited</div>';
                                 }
                            }
                                          $purposes=mysqli_query($con,"SELECT * FROM hallpurposes WHERE hallpurpose_id='$id'");
                                          $row = mysqli_fetch_array($purposes);
                                                     $hallpurpose1=$row['hallpurpose'];
                                                     $charge1=$row['charge'];
                                                     $creator1=$row['creator'];
                                              $employee1=  mysqli_query($con,"SELECT * FROM employees WHERE employee_id='$creator1'");
                                         $row2 = mysqli_fetch_array($employee1);
                                          $employee_id1=$row2['employee_id'];
                                           $fullname1=$row2['fullname'];
                                      ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Purpose</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name='purpose' placeholder="Enter Purpose" value="<?php echo $hallpurpose1; ?>" required='required'></div>
                                </div>
        <div class="form-group"><label class="col-sm-2 control-label">Charge</label>

            <div class="col-sm-10"><input type="text" class="form-control" name='charge' value="<?php echo $charge1; ?>" placeholder="Enter  Charge" required='required'></div>
                                </div>
                             
                        
                                                                                                                                  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-success btn-sm" name="submit" type="submit">Edit Purpose</button>
                                    </div>
                                </div>
                            </form>
                                                 

                    </div>

                  
                </div>
             
                    </div>
                

    </div>

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

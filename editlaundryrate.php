<?php
include 'includes/conn.php';
 if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!='Laundry Attendant')){
header('Location:login.php');
   }
   $id=$_GET['id'];
   ?>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Laundry Rate | Hotel Manager</title>
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
                    <h2>Edit Laundry Rate</h2>
                    <ol class="breadcrumb">
                         <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>
                            <a href="laundryrates">Laundry Rates</a>
                        </li>
                        <li class="active">
                            <strong>Edit Laundry Rate</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">

                <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Edit Laundry  Rate <small>Ensure to fill all necessary fields</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                            include_once 'includes/thumbs3.php';
                            if(isset($_POST['type'],$_POST['rate'])){
                                     $type=  mysqli_real_escape_string($con,trim($_POST['type']));
                                    $rate=  mysqli_real_escape_string($con,trim($_POST['rate']));
									
                                 if((empty($type))||(empty($rate))){
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                                }
                                if(is_numeric($rate)==FALSE){
                                     echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Rate should be An Integer</div>';
                                }
                                else{
                                                          
              mysqli_query($con,"UPDATE laundryrates SET type='$type',laundryrate='$rate' WHERE laundryrate_id='$id'") or die(mysqli_errno($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Laundry Rates successfully Edited</div>';
                                 }
                            }
                   
                            $laundryrates=mysqli_query($con,"SELECT * FROM laundryrates WHERE laundryrate_id='$id'");
                          
                          $row = mysqli_fetch_array($laundryrates);
                                    $laundryrate1=$row['laundryrate'];
                                    $laundryrate_id1=$row['laundryrate_id'];
                                    $type1=$row['type'];									
                                    $status1=$row['status'];                                    
                                      ?>
  <form method="post" class="form" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">Clothing Type</label>

                                    <input name="type" class="form-control" type="text" required='required' value="<?php echo $type1; ?>">
									
                                </div>
      
                                <div class="form-group"><label class="control-label">Charge (BIF)</label>

                                    <input name="rate" class="form-control" type="text" required='required' value="<?php echo $laundryrate1; ?>">
                                                      
									</div>
                                
                             
                        
                                                                                                                                  <div class="form-group">
                                   
                                                                           <button class="btn btn-primary" name="submit" type="submit">Edit Rate</button>
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

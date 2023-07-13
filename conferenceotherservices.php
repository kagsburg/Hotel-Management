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

    <title>Conference Other Services | Hotel Manager</title>
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
                                           include 'fr/conferenceotherservices.php';                     
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
                    <h2>Conference Other Services</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Home</a></li>
                                  
                        <li class="active">
                            <strong> Other Services</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
                   <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Add Other Service <small>Ensure to fill all necessary fields</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                                                 if(isset($_POST['service'],$_POST['charge'])){
                                     $service=  mysqli_real_escape_string($con,trim($_POST['service']));
                                    $charge=  mysqli_real_escape_string($con,trim($_POST['charge']));
                                
                                 if((empty($service)||(empty($charge)))){
                                  $errors[]='Enter All Fields To Proceed';
                                }
                                if(is_numeric($charge)==FALSE){
                                 $errors[]='Charge should be An Integer';
                                }
                           
                                if(!empty($errors)){
                                    foreach ($errors as $error) {
                                        echo '<div class="alert alert-danger">'.$error.'</div>';          
                                    }
                                }
                                else{                                                          
              mysqli_query($con,"INSERT INTO conferenceotherservices(service,charge,creator,timestamp,status) VALUES('$service','$charge','".$_SESSION['emp_id']."',UNIX_TIMESTAMP(),'1')") or die(mysqli_error($con));
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Other Service successfully added</div>';
                                 }
                            }
                                      ?>
  <form method="post" class="form" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">*Service Name</label>
<input type="text" class="form-control" name='service' placeholder="Enter service" required='required'>
                                </div>
      
        <div class="form-group"><label class="control-label">*Charge</label>
<input type="number" class="form-control" name='charge' placeholder="Enter  Charge" required='required'>
                                </div>
        
                      <div class="form-group">
                <button class="btn btn-success btn-sm" name="submit" type="submit">Submit</button>
                                                         </div>
                            </form>
                                                 

                    </div>

                  
                </div>
             
                    </div>
                                 <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Other Services</h5>
                        
                        </div>
                        <div class="ibox-content">
                             <table class="table table-striped  table-hover table-bordered">
                    <thead>
                    <tr>
                    <th>Service</th>
                             <th>Charge</th>
                        <th>Status</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                        <tr>     <?php
                            $services=mysqli_query($con,"SELECT * FROM conferenceotherservices WHERE status='1'");
                            if(mysqli_num_rows($services)>0){
                                while ($row = mysqli_fetch_array($services)) {
                                          $conferenceotherservice_id=$row['conferenceotherservice_id'];
                                                     $service=$row['service'];
                                                     $charge=$row['charge'];
                                                     $creator=$row['creator'];
                                                     $timestamp=$row['timestamp'];
                                               
                                                                         ?>
                                     
                       <tr>
                          <td><?php echo $service; ?></td>
                            <td><?php echo $charge; ?></td>
                                                      
                                    <td>
                                        <?php
                                            if(($_SESSION['hotelsyslevel']==1)){ 
                                        ?>
                                        <a data-toggle="modal"  href="#modal-form<?php echo $conferenceotherservice_id; ?>" class="btn btn-xs btn-info">Edit</a>
                                        <a href="removeconferenceotherservice?id=<?php echo $conferenceotherservice_id;?>" onclick="return cdelete<?php echo $conferenceotherservice_id;?>()" class="btn btn-xs btn-danger">Remove</a>
                       <script type="text/javascript">
                         function cdelete<?php echo $conferenceotherservice_id; ?>() {
  return confirm('You are about To Delete this item. Do you want to proceed?');
}
</script>                 
                                            <?php } ?>
                                    </td>
                       </tr>
                       
                                    <?php
                                }
                            }  else {
echo "<div class='alert alert-danger'>No Services Added Yet</div>";                             
}
                            ?>
                    
                    </tbody>
                             </table>
                        </div>
                    </div>
                    </div>
  </div>
             
                                </div>
          <?php 
                   $services=mysqli_query($con,"SELECT * FROM conferenceotherservices WHERE status='1'");
                                         while ($row = mysqli_fetch_array($services)) {
                                          $conferenceotherservice_id=$row['conferenceotherservice_id'];
                                                     $service=$row['service'];
                                                     $charge=$row['charge'];
                                                     $creator=$row['creator'];
                                                     $timestamp=$row['timestamp'];
                                               
                                      ?>
        <div id="modal-form<?php echo $conferenceotherservice_id; ?>" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                         <h3 class="m-t-none m-b">Edit Service</h3>
                       <form role="form" method="POST" action="editconferenceotherservice?id=<?php echo $conferenceotherservice_id; ?>" enctype="multipart/form-data">
                                                          <div class="form-group"><label class="control-label">*Service Name</label>
<input type="text" class="form-control" name='service' placeholder="Enter service" required='required' value="<?php echo $service; ?>">
                                </div>
      
        <div class="form-group"><label class="control-label">*Charge</label>
<input type="number" class="form-control" name='charge' placeholder="Enter  Charge" required='required' value="<?php echo $charge; ?>">
                                </div>
        
                      <div class="form-group">
                <button class="btn btn-success btn-sm" name="submit" type="submit">Edit</button>
                                                         </div>
                                                            </form>
                                
                                                
                                        </div>
                                    </div>
                                    </div>
                                </div>
                <?php }?>  
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

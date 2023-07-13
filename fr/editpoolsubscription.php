<?php 
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login');
}
$id=$_GET['id'];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Edit Pool Subscription - Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
      <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
       <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
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
                    <h2>Edit Swimming Pool Subscription</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>   <a href="poolsubscriptions">Subscriptions</a>                       </li>
                        <li class="active">
                            <strong>Edit Subscription</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-10">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Edit Subscription <small>All  fields marked (*) shouldn't be left blank</small></h5>
                       </div>
                        <div class="ibox-content">
                             <?php
if(isset($_POST['firstname'],$_POST['lastname'],$_POST['package'],$_POST['startdate'])){
   $firstname=mysqli_real_escape_string($con,trim( $_POST['firstname'])); 
   $lastname=mysqli_real_escape_string($con,trim( $_POST['lastname'])); 
    $startdate=mysqli_real_escape_string($con,  strtotime( $_POST['startdate'])); 
    $enddate=mysqli_real_escape_string($con,  strtotime( $_POST['enddate'])); 
   $package=mysqli_real_escape_string($con,trim( $_POST['package'])); 
   $reduction=mysqli_real_escape_string($con,trim( $_POST['reduction'])); 
   if((empty($firstname))||(empty($lastname))||(empty($enddate))||(empty($startdate))||(empty($package))){
        $errors[]='All Fields Marked * shouldnt be blank';
   }
    $split= explode('_', $package);
    $package_id=$split[0];
      $charge=$split[1];
if(!empty($errors)){
foreach($errors as $error){ 
 ?>
 <div class="alert alert-danger"><?php echo $error; ?></div>
<?php 
}         }else{    
    mysqli_query($con,"UPDATE poolsubscriptions SET firstname='$firstname',lastname='$lastname',package='$package_id',charge='$charge',startdate='$startdate',enddate='$enddate',reduction='$reduction' WHERE poolsubscription_id='$id'") or die(mysqli_error($con));
        ?>
 ><div class="alert alert-success"><i class="fa fa-check"></i>Pool Subscription Successfully Added. </div>
    <?php
         }
     }
   $subscriptions=mysqli_query($con,"SELECT * FROM poolsubscriptions WHERE poolsubscription_id='$id'");
    $row=  mysqli_fetch_array($subscriptions);
  $poolsubscription_id=$row['poolsubscription_id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$startdate=$row['enddate'];
$enddate=$row['enddate'];
$reduction=$row['reduction'];
$charge=$row['charge'];
 $creator=$row['creator'];
 $package=$row['package'];
   $getpackage=mysqli_query($con,"SELECT * FROM poolpackages WHERE status='1' AND poolpackage_id='$package'");
   $row1 = mysqli_fetch_array($getpackage);
     $poolpackage=$row1['poolpackage'];
        if(strlen($poolsubscription_id)==1){
      $pin='000'.$poolsubscription_id;
     }
       if(strlen($poolsubscription_id)==2){
      $pin='00'.$poolsubscription_id;
     }
        if(strlen($poolsubscription_id)==3){
      $pin='0'.$poolsubscription_id;
     }
  if(strlen($poolsubscription_id)>=4){
      $pin=$poolsubscription_id;
     }      
?>
                        
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">* First Name</label>
                                    <div class="col-sm-10"><input type="text" name='firstname' class="form-control" placeholder="Enter First Name" required="required" value="<?php echo $firstname; ?>">
                                                                            </div>
                                </div>                                                                
                              <div class="form-group"><label class="col-sm-2 control-label">* Last Name</label>
   <div class="col-sm-10"><input type="text" name='lastname' class="form-control" placeholder="Enter last Name" required="required" value="<?php echo $lastname; ?>">
                                                                            </div>
                                </div>      
                                
                                            <div class="form-group">
                                <label class="col-sm-2 control-label">* Select Package</label>
                                <div class="col-sm-10" style="">
                                     <select class="form-control" name='package'>
                                   <option value="<?php echo $package.'_'.$charge; ?>" selected="selected"><?php echo $poolpackage; ?></option>
                                 <?php
                     $getpackages=mysqli_query($con,"SELECT * FROM poolpackages WHERE status='1'");
                                         while ($row = mysqli_fetch_array($getpackages)) {
                                                     $poolpackage_id=$row['poolpackage_id'];
                                                     $poolpackage=$row['poolpackage'];
                                                     $charge=$row['charge'];
                                                     $creator=$row['creator'];
                                                              $status=$row['status'];
                                                         ?>
                                    <option value="<?php echo $poolpackage_id.'_'.$charge; ?>"><?php echo $poolpackage; ?></option>
                                <?php } ?>
                                      </select>   
                                                      
                                </div>
                                                            
                            </div>                              
                       <div class="form-group"><label class="col-sm-2 control-label">Reduction</label>
    <div class="col-sm-10"><input type="text" name='reduction' class="form-control" placeholder="Enter Reduction" value="<?php echo $reduction; ?>">
                          </div>
                                </div>             
                             
             <div class="form-group"><label class="col-sm-2 control-label">Start Date</label>

                                    <div class="col-sm-10">
                                        <input type="date" name='startdate' class="form-control" placeholder="Enter Date" value="<?php echo date('Y-m-d',$startdate); ?>">
                                                                            </div>
                                </div>       
                      <div class="form-group"><label class="col-sm-2 control-label">End Date</label>

                                    <div class="col-sm-10">
                                        <input type="date" name='enddate' class="form-control" placeholder="Enter Date" value="<?php echo date('Y-m-d',$enddate); ?>">
                                                                            </div>
                                </div>       
                      <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-primary" type="submit">Edit Subscription</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
  <script src="js/plugins/chosen/chosen.jquery.js"></script>
  <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- iCheck -->
   <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>

</html>
 <script type="text/javascript">
     
                    var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
 $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });
 
    
</script>
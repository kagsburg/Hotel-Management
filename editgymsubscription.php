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

     <title>Edit Gym Subscription - Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
      <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
       <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
<?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/editgymsubscription.php';                     
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
            
        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Edit Gym Subscription</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>   <a href="gymsubscriptions">Subscriptions</a>                       </li>
                        <li class="active">
                            <strong>Add Subscription</strong>
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
if(isset($_POST['fullname'],$_POST['number'],$_POST['bouquet'],$_POST['startdate'])){
   $fullname=mysqli_real_escape_string($con,trim( $_POST['fullname'])); 
   $phone=mysqli_real_escape_string($con,trim( $_POST['number'])); 
    $startdate=mysqli_real_escape_string($con,  strtotime( $_POST['startdate'])); 
   $bouquet=mysqli_real_escape_string($con,trim( $_POST['bouquet'])); 
   if((empty($fullname))||(empty($phone))||(empty($startdate))||(empty($bouquet))){
        $errors[]='All Fields Marked * shouldnt be blank';
   }
    $split= explode('_', $bouquet);
    $bouquet_id=$split[0];
    $days=($split[1])-1;
    $charge=$split[2];
   $enddate=$startdate+(24*3600*$days);
if(!empty($errors)){
foreach($errors as $error){ 
 ?>
 <div class="alert alert-danger"><?php echo $error; ?></div>
<?php 
}         }else{
    
    mysqli_query($con,"UPDATE gymsubscriptions SET fullname='$fullname',phone='$phone',bouquet='$bouquet_id',charge='$charge',startdate='$startdate',enddate='$enddate'  WHERE  gymsubscription_id='$id'") or die(mysqli_error($con));
        ?>
 ><div class="alert alert-success"><i class="fa fa-check"></i>Gym Subscription Successfully Added. </div>
    <?php
         }
     }
 $subscriptions=mysqli_query($con,"SELECT * FROM gymsubscriptions WHERE gymsubscription_id='$id'");
      $row=  mysqli_fetch_array($subscriptions);
  $gymsubscription_id=$row['gymsubscription_id'];
$fullname=$row['fullname'];
$startdate=$row['startdate'];
$enddate=$row['enddate'];
$phone=$row['phone'];
$charge=$row['charge'];
 $creator=$row['creator'];
 $bouquet=$row['bouquet'];
 $days=(($enddate-$startdate)/(24*3600))+1;
   $getbouquet=mysqli_query($con,"SELECT * FROM gymbouquets WHERE status='1' AND gymbouquet_id='$bouquet'");
                                          $row1 = mysqli_fetch_array($getbouquet);
                                            $gymbouquet_id=$row1['gymbouquet_id'];
                                            $gymbouquet=$row1['gymbouquet'];
?>
                        
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">* Full Name</label>

                                    <div class="col-sm-10"><input type="text" name='fullname' class="form-control" placeholder="Enter Full Name" required="required" value="<?php echo $fullname; ?>">
                                                                            </div>
                                </div>                                                                
                             
                                        <div class="hr-line-dashed"></div>
                                           <div class="form-group"><label class="col-sm-2 control-label">* Contact Number</label>

                                               <div class="col-sm-10"><input type="text" name="number" class="form-control" placeholder="Enter your contact  Number" required="required" value="<?php echo $phone; ?>">
                                                                        </div>
                                </div>
                                          <div class="hr-line-dashed"></div>
                     
                                            <div class="form-group">
                                <label class="col-sm-2 control-label">* Select Bouquet</label>
                                <div class="col-sm-10" style="">
                                     <select class="form-control" name='bouquet'>
                                         <option value="<?php echo $gymbouquet_id.'_'.$days.'_'.$charge; ?>" selected=""><?php echo $gymbouquet; ?></option>
                                 <?php
                       $gymbouquets=mysqli_query($con,"SELECT * FROM gymbouquets WHERE status='1'");
                                          while($row = mysqli_fetch_array($gymbouquets)){
                                                     $gymbouquet_id=$row['gymbouquet_id'];
                                                     $gymbouquet=$row['gymbouquet'];
                                                     $charge=$row['charge'];
                                                     $days=$row['days'];
                                                         ?>
                                    <option value="<?php echo $gymbouquet_id.'_'.$days.'_'.$charge; ?>"><?php echo $gymbouquet; ?></option>
                                <?php } ?>
                                      </select>   
                                                      
                                </div>
                                                            
                            </div>                              
                           
                                  <div class="hr-line-dashed"></div>
             <div class="form-group"><label class="col-sm-2 control-label">Start Date</label>

                                    <div class="col-sm-10">
                                        <input type="date" name='startdate' class="form-control" placeholder="Enter Date" value="<?php echo date('Y-m-d',$startdate); ?>">
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
                                       <?php }?>
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
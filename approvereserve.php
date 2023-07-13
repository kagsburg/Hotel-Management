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

     <title>Approve Website Reservation - Hotel Manager</title>
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
                                           include 'fr/approvereserve.php';                     
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
                    <h2>Approve Online Booking</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a href="websitereservations">Online Bokings</a>                       </li>
                        <li class="active">
                            <strong>Approve Reservation</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                                    <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Reservation Details</h5>
                           
                        </div>
                        <div class="ibox-content">
                            <?php
                            $reservations=mysqli_query($con,"SELECT * FROM sitereserves WHERE reserve_id='$id'");
                            $row=  mysqli_fetch_array($reservations);
  $reserve_id=$row['reserve_id'];
$firstname=$row['fname'];
$lastname=$row['lname'];
$checkin=$row['checkin'];
$phone=$row['number'];
$checkout=$row['checkout'];
$type_id=$row['type'];
  $email=$row['email'];
  $status=$row['status'];
  $country=$row['country'];
  
                            ?>
                                <div class="feed-activity-list">

                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Guest Name</strong>. : <?php echo $firstname.' '.$lastname; ?> <br>
                                             </div>
                                    </div>
                                         <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Country</strong>. : <?php echo $country; ?> <br>
                                             </div>
                                    </div>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Phone Number</strong>. : <?php echo $phone; ?> <br>
                                             </div>
                                    </div>
                                    <?php if(!empty($email)){ ?>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Email</strong>. : <?php echo $email; ?> <br>
                                             </div>
                                    </div>
                                    <?php } ?>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                     <strong>Room Type: </strong>
                                                     <?php 
                                            $roomtypes=mysqli_query($con,"SELECT * FROM roomtypes WHERE roomtype_id='$type_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row1['roomtype'];
                       echo $roomtype; ?>
                                                     . <br>
                                                                                                                              </div>
                                    </div>
                                      <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Check In</strong>  : <?php echo date('d/m/Y',$checkin); ?> <br>
                                             </div>
                                    </div>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Check Out</strong>  : <?php echo date('d/m/Y',$checkout); ?> <br>
                                             </div>
                                    </div>
                                    
                                    
                                    
                                                                                                 
                                             </div>
                                                    </div>
                                                    </div>
                                                    </div>
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Assign Room Number<small>All  fields marked (*) shouldn't be left blank</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                             <?php
if(isset($_POST['room'])){
 
   $room=mysqli_real_escape_string($con,trim( $_POST['room'])); 
   $change=  mysqli_query($con,"UPDATE sitereserves SET status='1' WHERE reserve_id='$id'");
          
//   $children=mysqli_real_escape_string($con,trim( $_POST['children'])); 
    mysqli_query($con,"INSERT INTO reservations VALUES('','$firstname','$lastname','$phone','$email','$country','$room','$checkin','$checkout','".$_SESSION['hotelsys']."',UNIX_TIMESTAMP(),'1')") or die(mysqli_errno($con));
            
?>
  
     <div class="col-sm-2"></div><div class="col-sm-10"><div class="alert alert-success"><i class="fa fa-check"></i> Reservation Successfully Added</div></div>
    <?php
             }
?>
                        
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                              
                              
                                          <div class="hr-line-dashed"></div>
                                         <div class="form-group" id="data_5">
                               <label class="col-sm-2 control-label">* Room Number</label>
                              <div class="col-sm-10">  
                                  <select class="form-control" name="room">
                                      <option value="" selected="selected">Select Room</option>
                                      <?php
                                      $rooms=mysqli_query($con,"SELECT * FROM rooms WHERE status='1' AND type='$type_id' ORDER BY roomnumber");
 while($row=  mysqli_fetch_array($rooms)){
  $roomnumber=$row['roomnumber'];
$room_id=$row['room_id'];
  $type=$row['type'];
  $status=$row['status'];
  $creator=$row['creator'];
           $check=  mysqli_query($con,"SELECT * FROM reservations WHERE  checkout>'$timenow'");
           $row2= mysqli_fetch_array($check);
           $room2=$row2['room'];
      $roomtypes=mysqli_query($con,"SELECT * FROM roomtypes  WHERE roomtype_id='$type'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row1['roomtype'];
                                            if($room_id!=$room2){
 ?>
                                      <option value="<?php echo $room_id; ?>"><?php echo $roomnumber.' ('.$roomtype.')'; ?></option>
 <?php }} ?>
    
                                  </select>
                                </div>
                            </div>
                                          
                                                        <div class="hr-line-dashed"></div>
                            
                                                                                                  
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-primary" type="submit">Assign Room</button>
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
                                       <?php } ?>
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
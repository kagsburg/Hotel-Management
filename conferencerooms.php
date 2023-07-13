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

    <title>Conference Rooms | Hotel Manager</title>
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
                                           include 'fr/conferencerooms.php';                     
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
                    <h2>Conference Rooms</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                  
                        <li class="active">
                            <strong>Conference Rooms</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
                   <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Conference Rooms <small>Ensure to fill all necessary fields</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                                                 if(isset($_POST['room'],$_POST['people'],$_POST['charge'])){
                                     $room=  mysqli_real_escape_string($con,trim($_POST['room']));
                                     $people=  mysqli_real_escape_string($con,trim($_POST['people']));
                                    $charge=  mysqli_real_escape_string($con,trim($_POST['charge']));
                                 if((empty($room)||(empty($charge)))||(empty($people))){
                                      $errors[]='Enter All Fields To Proceed';
                                }
                                if(is_numeric($charge)==FALSE){
                                 $errors[]='Charge should be An Integer';
                                }
                                    if(is_numeric($people)==FALSE){
                                 $errors[]='People should be An Integer';
                                }
                                if(!empty($errors)){
                                    foreach ($errors as $error) {
                                        echo '<div class="alert alert-danger">'.$error.'</div>';          
                                    }
                                }
                                else{                                                           
              mysqli_query($con,"INSERT INTO conferencerooms(room,people,charge,creator,timestamp,status) VALUES('$room','$people','$charge','".$_SESSION['emp_id']."',UNIX_TIMESTAMP(),'1')") or die(mysqli_errno($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i> Room successfully added</div>';
                                 }
                            }
                                      ?>
  <form method="post" class="form" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">*Room Name</label>
<input type="text" class="form-control" name='room' placeholder="Enter Room" required='required'>
                                </div>
        <div class="form-group"><label class="control-label">*Maximum Number of People</label>
<input type="number" class="form-control" name='people' placeholder="Enter  Number" required='required'>
                                </div>
        <div class="form-group"><label class="control-label">*Charge per day</label>
<input type="number" class="form-control" name='charge' placeholder="Enter  Charge" required='required'>
                                </div>
                        <div class="form-group">
                <button class="btn btn-success btn-sm" name="submit" type="submit">Add Room</button>
                                                         </div>
                            </form>
                                                 

                    </div>

                  
                </div>
             
                    </div>
                                 <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Rooms</h5>
                        
                        </div>
                        <div class="ibox-content">
                             <table class="table table-striped  table-hover">
                    <thead>
                    <tr>
                    <th>Room</th>
                        <th>People(Max)</th>
                        <th>Charge/Days</th>                      
                        <th>Status</th>                      
                        <th>&nbsp;</th>
                   </tr>
                    </thead>
                    <tbody>
                        <tr> 
    <?php
                            $conferencerooms=mysqli_query($con,"SELECT * FROM conferencerooms WHERE status='1'");
                                   while ($row = mysqli_fetch_array($conferencerooms)) {
                                                     $conferenceroom_id=$row['conferenceroom_id'];
                                                     $room=$row['room'];
                                                     $charge=$row['charge'];
                                                     $people=$row['people'];
                                                     $creator=$row['creator'];
                                                     $timestamp=$row['timestamp'];
                                                
                                $reservations=mysqli_query($con,"SELECT * FROM hallreservations WHERE status IN (1,2)  AND room_id='$conferenceroom_id'");
                                if(mysqli_num_rows($reservations)>0){
                                    $row2=  mysqli_fetch_array($reservations);
                                $status=$row2['status'];
                                 if($status==1){
                                     $st='BOOKED';
                                      }
                     if ($status==2) {
                                $st='CHECKED IN';
                                 }
                                }   else{
                                    $st='UNOCCUPIED';
                                }                                    
                                ?>
                                     
                       <tr>
                                      <td><?php echo $room; ?></td>
                                      <td><?php echo $people; ?></td>
                                   <td><?php echo $charge; ?></td>
                                   <td><?php echo $st; ?></td>
                                                                  
                                    <td>
                                        <?php
                                            if(($_SESSION['hotelsyslevel']==1)){ 
                                        ?>
                                        <a data-toggle="modal"  href="#modal-form<?php echo $conferenceroom_id; ?>" class="btn btn-xs btn-info">Edit</a>
                                        <a href="removeconferenceroom?id=<?php echo $conferenceroom_id;?>" onclick="return cdelete<?php echo $conferenceroom_id;?>()" class="btn btn-xs btn-danger">Remove</a>
                       <script type="text/javascript">
                         function cdelete<?php echo $conferenceroom_id; ?>() {
  return confirm('You are about To Delete a Purpose. Do you want to proceed?');
}
</script>                 
                                            <?php } ?>
                                    </td>
                       </tr>
                       
                                    <?php
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
                      $conferencerooms=mysqli_query($con,"SELECT * FROM conferencerooms WHERE status='1'");
                                   while ($row = mysqli_fetch_array($conferencerooms)) {
                                                     $conferenceroom_id=$row['conferenceroom_id'];
                                                     $room=$row['room'];
                                                     $charge=$row['charge'];
                                                     $people=$row['people'];
                                                     $creator=$row['creator'];
                                                     $timestamp=$row['timestamp'];
                                                     $status=$row['status'];
                                      ?>
        <div id="modal-form<?php echo $conferenceroom_id; ?>" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                         <h3 class="m-t-none m-b">Edit Room</h3>
                       <form role="form" method="POST" action="editconferenceroom?id=<?php echo $conferenceroom_id; ?>">
                                                               <div class="form-group"><label class="control-label">*Room Name</label>
                                                                   <input type="text" class="form-control" name='room' placeholder="Enter Room" required='required' value="<?php echo $room; ?>">
                                </div>
        <div class="form-group"><label class="control-label">*Maximum Number of People</label>
<input type="number" class="form-control" name='people' placeholder="Enter  Number" required='required' value="<?php echo $people; ?>">
                                </div>
        <div class="form-group"><label class="control-label">*Charge per day</label>
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

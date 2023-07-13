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

    <title>Pool Commands | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
<?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/poolcommands.php';                     
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
                    <h2>Pool Commands</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                       
                                   <li class="active">
                            <strong>Pool Commands</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                   <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add Package</h5>
                       
                    </div>
                    <div class="ibox-content">
                        <?php
                        if(isset($_POST['submit'])){
                   $firstname=mysqli_real_escape_string($con,trim( $_POST['firstname'])); 
                     $reserve_id=mysqli_real_escape_string($con,trim( $_POST['reserve'])); 
   $lastname=mysqli_real_escape_string($con,trim( $_POST['lastname'])); 
   $package=mysqli_real_escape_string($con,trim( $_POST['package'])); 
   $contact=mysqli_real_escape_string($con,trim( $_POST['contact'])); 
     if((empty($package))){
        $errors[]='All Fields Marked * shouldnt be blank';
   }
    $split= explode('_', $package);
    $package_id=$split[0];
      $charge=$split[1];
if(!empty($errors)){
foreach($errors as $error){ 
    echo '<div class="alert alert-danger">'.$error.'</div>';
}
}else{
    mysqli_query($con,"INSERT INTO poolcommands(reserve_id,firstname,lastname,contact,package_id,charge,admin_id,timestamp,status) VALUES('$reserve_id','$firstname','$lastname','$contact','$package_id','$charge','".$_SESSION['emp_id']."',UNIX_TIMESTAMP(),'1')") or die(mysqli_error($con));
    echo '<div class="alert alert-success">Pool Command Successfully Added</div>';
}
                        }
                        ?>
                        <form method="post" name='form' class="form" action=""  enctype="multipart/form-data">
                              <div class="form-group">
              <div class="form-check">
      <input class="form-check-input" type="checkbox" value="linked" id="resident">
  <label class="form-check-label" for="defaultCheck1">
Is Customer a hotel resident?
  </label>
</div>    
</div>   
                            <div class="row">
                                <div class="nonresidents">
              <div class="form-group col-lg-6"><label class="control-label">* First Name</label>
 <input type="text" name='firstname' class="form-control" placeholder="Enter First Name">
                                                                                      </div>                                                                
                               <div class="form-group col-lg-6"><label class="control-label">* Last Name</label>
   <input type="text" name='lastname' class="form-control" placeholder="Enter last Name">
                                                                                     </div>    
              <div class="form-group col-lg-6"><label class="control-label">* Contact</label>
   <input type="text" name='contact' class="form-control" placeholder="Enter Contact">
                                                                                     </div>  
                  </div>
         <div class="form-group col-lg-6 forresidents" style="display:none"><label class="control-label">*Select Resident</label>
                                                                    <select name="reserve" class="form-control">
                                                                        <option value="0" selected="selected">Select Resident</option>
                                                     <?php
   $reservation=mysqli_query($con,"SELECT * FROM reservations WHERE status='1' ORDER BY firstname");
while($row=  mysqli_fetch_array($reservation)){
 $firstname1=$row['firstname'];
$lastname1=$row['lastname'];
            $room_id=$row['room'];
            $reservation_id=$row['reservation_id'];
       $roomtypes=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomnumber=$row1['roomnumber'];
                
 ?>
                       <option value="<?php echo $reservation_id; ?>"><?php echo $firstname1.' '.$lastname1 .' ('.$roomnumber.')';  ?></option>
<?php }?>
                                                                    </select>
                                                                                   
                                                          </div> 
                                                
                       <div class="form-group col-lg-6">
                                <label class="control-label">* Select Package</label>
                                  <select class="form-control" name='package'>
                                    <option value="" selected="selected">Select Package</option>
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
                                <div class="form-group">
                         <button class="btn btn-primary" type="submit" name="submit">Add</button>           
                                </div>
                    
                        </form>
                    </div>
                    </div>
                    </div>
                                           <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Commands <small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
                   <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                       <th>#</th>
                       <th>Customer</th>
                        <th>Contact</th>
                        <th>Package</th>
                        <th>Charge</th>
                        <th>Resident</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
             $commands= mysqli_query($con, "SELECT * FROM poolcommands WHERE status=1") or die(mysqli_error($con));
               while($row=  mysqli_fetch_array($commands)){
  $poolcommand_id=$row['poolcommand_id'];
  $firstname=$row['firstname'];
  $lastname=$row['lastname'];
$contact=$row['contact'];
  $charge=$row['charge'];
  $status=$row['status'];
  $admin_id=$row['admin_id'];
   $reserve_id=$row['reserve_id'];
 $timestamp=$row['timestamp'];
  $getyear=date('Y',$timestamp);
     $package=$row['package_id'];
     $customername=$firstname.' '.$lastname;
   $reservation=mysqli_query($con,"SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
      if(mysqli_num_rows($reservation)>0){
   $row2=  mysqli_fetch_array($reservation);
 $firstname=$row2['firstname'];
$lastname=$row2['lastname'];
$room_id=$row2['room'];
$contact=$row2['phone'];
   $roomtypes=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomnumber=$row1['roomnumber'];
$customername=$firstname.' '.$lastname.' ('.$roomnumber.')';
      }
     $count=1;
   $beforeorders=  mysqli_query($con, "SELECT * FROM poolcommands WHERE status=1  AND  poolcommand_id<'$poolcommand_id'") or die(mysqli_error($con));
                     while ($rowb = mysqli_fetch_array($beforeorders)) {
                      $timestamp2=$rowb['timestamp']; 
                     $getyear2=date('Y',$timestamp2);
                      if($getyear==$getyear2){
                          $count=$count+1;
                      }
                     }
                      if(strlen($count)==1){
    $invoice_no='000'.$count;
     }
       if(strlen($count)==2){
      $invoice_no='00'.$count;
     }      
          if(strlen($count)==3){
      $invoice_no='0'.$count;
     }      
  if(strlen($count)>=4){
      $invoice_no=$count;
     }       
     
   $getpackage=mysqli_query($con,"SELECT * FROM poolpackages WHERE status='1' AND poolpackage_id='$package'");
   $row1 = mysqli_fetch_array($getpackage);
     $poolpackage=$row1['poolpackage'];
              ?>
               
                    <tr class="gradeA">
                    <td><?php echo $invoice_no; ?></td>
                    <td><?php echo $customername; ?></td>
                        <td><?php echo $contact; ?></td>
                        <td><?php echo $poolpackage; ?></td>
                        <td><?php echo $charge; ?></td>
                   
                    <td>  <?php  if($reserve_id>0){echo 'Yes';}else{echo 'No';} ?>   </td>          
                                        
                     <td><?php echo date('d/m/Y',$timestamp); ?></td>                           
  <td class="center"> 
      <a href="poolcommand?id=<?php echo $poolcommand_id; ?>" class="btn btn-primary btn-xs" target="_blank">Print</a> 
   
         <?php
         if(($creator==$_SESSION['hotelsys'])||($_SESSION['hotelsyslevel']==1)){ 
                                                                ?>
     <a href="hidecommand.php?id=<?php echo $poolcommand_id; ?>" class="btn btn-danger btn-xs" onclick="return confirm_delete<?php echo $poolcommand_id;?>()">Remove <i class="fa fa-arrow-down"></i></a> 
     <script type="text/javascript">
function confirm_delete<?php echo $poolcommand_id; ?>() {
  return confirm('You are about To Remove this item. Are you sure you want to proceed?');
}
</script>                                             
  <?php 
               }
                                 ?>
  </td>
                    </tr>
                                            <?php }?>
                    </tbody>
                                    </table>

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

    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
          $(document).ready(function() { 
         
       $('#resident').click(function(){
    if($(this).prop("checked")=== true){
       $('.forresidents').show();    
       $('.nonresidents').hide();    
            }else{
     $('.forresidents').hide();       
       $('.nonresidents').show(); 
            }
    } );
    } );
        $(document).ready(function() {
            $('.dataTables-example').dataTable();

            /* Init DataTables */
            var oTable = $('#editable').dataTable();

            /* Apply the jEditable handlers to the table */
            oTable.$('td').editable( 'http://webapplayers.com/example_ajax.php', {
                "callback": function( sValue, y ) {
                    var aPos = oTable.fnGetPosition( this );
                    oTable.fnUpdate( sValue, aPos[0], aPos[1] );
                },
                "submitdata": function ( value, settings ) {
                    return {
                        "row_id": this.parentNode.getAttribute('id'),
                        "column": oTable.fnGetPosition( this )[2]
                    };
                },

                "width": "90%"
            } );


        });

        function fnClickAddRow() {
            $('#editable').dataTable().fnAddData( [
                "Custom row",
                "New row",
                "New row",
                "New row",
                "New row" ] );

        }
    </script>
</body>
</html>
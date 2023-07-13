<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}
?><html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hall Reservation Purposes - Hotel Manager</title>
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
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/hallpurposes.php';
    } else {
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
    <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
    <li><a href="switchlanguage?lan=en">English</a> </li>
</ul>
 </nav>
 </div>
     <div class="row wrapper border-bottom white-bg page-heading">
         <div class="col-lg-10">
             <h2>Hall Reservation Purposes</h2>
             <ol class="breadcrumb">
                  <li><a href=""><i class="fa fa-home"></i> Home</a></li>
                 <li>
                     <a href="hallbookings">Reservations</a>
                 </li>
                 <li class="active">
                     <strong>Reservation Purposes</strong>
                 </li>
             </ol>
         </div>      
     </div>
 <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
            <div class="col-lg-5">
             <div class="ibox float-e-margins">
                 <div class="ibox-title">                     
                     <h5>Add Reservation Purposes<small>Ensure to fill all necessary fields</small></h5>                 
                 </div>
                 <div class="ibox-content">
                                        <?php
                                              if (isset($_POST['purpose'],$_POST['charge'])) {
                                                  $purpose=  mysqli_real_escape_string($con, trim($_POST['purpose']));
                                                  $charge=  mysqli_real_escape_string($con, trim($_POST['charge']));
                                                  if ((empty($purpose)||(empty($charge)))) {
                                                      echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                                                  }
                                                  if (is_numeric($charge)==false) {
                                                      echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Purpose Charge should be An Integer</div>';
                                                  } else {
                                                      mysqli_query($con, "INSERT INTO hallpurposes(hallpurpose,charge,creator,timestamp,status) VALUES('$purpose','$charge',
                                                  '".$_SESSION['emp_id']."',UNIX_TIMESTAMP(),'1')") or die(mysqli_errno($con));
                                                      echo '<div class="alert alert-success"><i class="fa fa-check"></i>Reservation Purpose successfully added</div>';
                                                  }
                                              }
        ?>
<form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
    <div class="form-group"><label class="col-sm-2 control-label">Purpose</label>
        <div class="col-sm-10"><input type="text" class="form-control" name='purpose' placeholder="Enter Purpose" required='required'></div>
    </div>
 <div class="form-group"><label class="col-sm-2 control-label">Charge</label>

                             <div class="col-sm-10"><input type="text" class="form-control" name='charge' placeholder="Enter  Charge" required='required'></div>
                         </div>
                          <div class="form-group">
                             <div class="col-sm-4 col-sm-offset-2">
                              <button class="btn btn-success btn-sm" name="submit" type="submit">Add Purpose</button>
                             </div>
                         </div>
                     </form>  
                 </div>           
         </div>      
             </div>
             <div class="col-lg-7">
             <div class="ibox float-e-margins">
                 <div class="ibox-title">                     
                     <h5>Purposes</h5>                 
                 </div>
                 <div class="ibox-content">
                      <table class="table table-striped  table-hover">
             <thead>
             <tr>                
                 <th>Purpose</th>
                 <th>Charge</th>
                 <th>Added by</th>
                 <th>Added on</th>
                 <th>&nbsp;</th>
                
             </tr>
             </thead>
             <tbody>
                 <tr>     <?php
                             $purposes=mysqli_query($con, "SELECT * FROM hallpurposes WHERE status='1'");
        if (mysqli_num_rows($purposes)>0) {
            while ($row = mysqli_fetch_array($purposes)) {
                $hallpurpose_id=$row['hallpurpose_id'];
                $hallpurpose=$row['hallpurpose'];
                $charge=$row['charge'];
                $creator=$row['creator'];
                $timestamp=$row['timestamp'];
                $status=$row['status'];
                ?>
                                                    
                                        <tr>
                               <td><?php echo $hallpurpose; ?></td>
                            <td><?php echo $charge; ?></td>                                                           
                             <td> <div class="tooltip-demo">                        
                        <a href="employee?id=<?php echo $creator; ?>" data-original-title="View admin profile"  data-toggle="tooltip" data-placement="bottom" title="">
                                      <?php
                     $employee=  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                $row2 = mysqli_fetch_array($employee);
                $employee_id=$row2['employee_id'];
                $fullname=$row2['fullname'];
                echo $fullname;  ?></a> </div></td>
                             <td><?php echo date('d/m/Y', $timestamp); ?></td>
                             <td>
                                 <?php
                     if (($_SESSION['hotelsyslevel']==1)) {
                         ?>
                                 <a href="editpurpose?id=<?php echo $hallpurpose_id;?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
          <a href="hidehallpurpose?id=<?php echo $hallpurpose_id;?>" onclick="return cdelete<?php echo $hallpurpose_id;?>()" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Remove</a>
                <script type="text/javascript">
                  function cdelete<?php echo $hallpurpose_id; ?>() {
return confirm('You are about To Delete a Purpose. Do you want to proceed?');
}
</script>                 
                                     <?php } ?>
                             </td>
                </tr>
                
                             <?php
            }
        } else {
            echo "<div class='alert alert-danger'>No Purpose Added Yet</div>";
        }
        ?>
             
             </tbody>
                      </table>
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
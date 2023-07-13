<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login.php');
}
$id=$_GET['id'];
?>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Modifier le type de chambre | Hotel Manager</title>
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
                    <h2>type de chambre</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                       <li>
                            <a href="rooms">Chambres</a>
                        </li>
                        <li class="active">
                            <strong>Modifier le type de chambre</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">

                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Modifier le type de chambre <small>Veillez Remplir tout les champs nécéssaires</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                         include_once 'includes/thumbs3.php';
if (isset($_POST['type'],$_POST['charge'])) {
    $type=  mysqli_real_escape_string($con, trim($_POST['type']));
    $charge=  mysqli_real_escape_string($con, trim($_POST['charge']));
    if ((empty($type)||(empty($charge)))) {
        echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
    }
    if (is_numeric($charge)==false) {
        echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Room Charge should be An Integer</div>';
    } else {
        mysqli_query($con, "UPDATE roomtypes SET  roomtype='$type',charge='$charge' WHERE roomtype_id='$id'") or die(mysqli_errno($con));

        echo '<div class="alert alert-success"><i class="fa fa-check"></i>Room type successfully Edited</div>';
    }
}

$roomtypes=mysqli_query($con, "SELECT * FROM roomtypes WHERE roomtype_id='$id'");

$row = mysqli_fetch_array($roomtypes);
$roomtype1=$row['roomtype'];
$charge1=$row['charge'];

?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Modifier le nom</label>

                                    <div class="col-sm-10"><input type="text" class="form-control"
                                     name='type' value="<?php echo $roomtype1; ?>" placeholder="Enter Room Type" required='required'></div>
                                </div>
        <div class="form-group"><label class="col-sm-2 control-label">Modifier les frais</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" 
                                    value="<?php echo $charge1; ?>" name='charge' placeholder="Entrer le prix de la chambre" required='required'></div>
                                </div>
                             
                        
                                                                                                                                  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                 <button class="btn btn-primary" name="submit" type="submit">Modifier le type de chambre</button>
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

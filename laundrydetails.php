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

     <title>View Laundry Details </title>
     <script language="JavaScript" src="../js/gen_validatorv4.js" type="text/javascript"></script>
<link rel="stylesheet" href="ckeditor/samples/sample.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
     <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
 <?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/editroom.php';                     
                                       }else{
          ?>                               
  
    <div id="wrapper">

     <?php
     include 'nav.php';
              ?>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
         
        </div>
             <ul class="nav navbar-top-links navbar-right">
           <li><a href="logout">Logout</a> </li>
            </ul>

        </nav>
        </div>
        <?php
          $laundry = mysqli_query($con, "SELECT * FROM laundry WHERE status IN (0,1) AND laundry_id='$id'");
          
          $row =  mysqli_fetch_array($laundry);
          $laundry_id = $row['laundry_id'];
          $reserve_id = $row['reserve_id'];
          $clothes = $row['clothes'];
          $package_id = $row['package_id'];
          $timestamp = $row['timestamp'];
          $customername = $row['customername'];
          $phone = $row['phone'];
          $status = $row['status'];
          $charge = $row['charge'];
          $creator = $row['creator'];
          $getyear = date('Y', $timestamp);
          $count = 1;

        ?>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>View Laundry Details</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>   <a href="laundrywork">Laundry</a>            </li>
                        <li class="active">
                            <strong>View  Details</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        
                        <div class="ibox-content">
                        <h2 style="text-align:center;width: 100%;margin: auto;font-weight: bold">LAUNDRY DETAILS</h2>
                <div class="table-responsive m-t">
                    <table class="table invoice-table" style="width:100%;font-size:14px;font-family:times new roman">
                        <thead>
                            <tr>
                                <th>Package</th>
                                <th>Clothes</th>
                                <th>Date</th>
                                <th>Unit Charge</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            <?php
                            if ($reserve_id != 0) {
                                $laundry2 = mysqli_query($con, "SELECT * FROM laundry WHERE reserve_id='$reserve_id' AND timestamp='$timestamp' ");
                            } else {
                                $laundry2 = mysqli_query($con, "SELECT * FROM laundry WHERE customername='$customername' AND timestamp='$timestamp' ");
                            }
                            // $laundry2 = mysqli_query($con, "SELECT * FROM laundry WHERE status='1' AND timestamp='$id'");
                              while ($row4 =  mysqli_fetch_array($laundry2)) {
                                $clothe= $row4['clothes'];
                                $time = $row4['timestamp'];
                                $charges= $row4['charge'];
                                $package = $row4['package_id'];
                                $getpackage = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1' AND laundrypackage_id='$package'");
                                $row3 = mysqli_fetch_array($getpackage);
                                $laundrypackages = $row3['laundrypackage'];
                                ?>
                                 <tr>
                                    <td>
                                        <div><strong>
                                                <?php echo $laundrypackages; ?>
                                            </strong></div>
                                    </td>
                                    <td><?php echo $clothe;  ?></td>
                                    <td><?php echo date('d/m/Y', $time); ?></td>
                                    <td><?php echo number_format($charges); ?></td>
                                </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </div>
                                       <?php }?>
     <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
 <script src="js/plugins/chosen/chosen.jquery.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
        <script>
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
        </script>
</body>
</html>
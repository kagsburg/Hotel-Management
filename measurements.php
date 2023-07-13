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

    <title>Stock Measurement | Hotel Manager</title>
<script src="ckeditor/ckeditor.js"></script>
  <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    

    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">

  

    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
   
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
<?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/measurements.php';                     
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
                    <h2> Stock Measurements</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>
                            <a>Stock</a>
                        </li>
                        <li class="active">
                            <strong>Hotel Stock measurements</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">

                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Add Stock  Measurements<small> Ensure to fill all necessary fields</small></h5>
                                                </div>
                        <div class="ibox-content">
                                               <?php
                                 if(isset($_POST['measurement'])){
                                if(empty($_POST['measurement'])){
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Fill The Field To Proceed</div>';
                                }else{
                               $measurement=  mysqli_real_escape_string($con,trim($_POST['measurement']));
                                                          
              mysqli_query($con,"INSERT INTO stockmeasurements(measurement,status) VALUES('$measurement',1)") or die(mysqli_errno($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Measurement successfully added</div>';
                                 }
                            }
                 ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-3 control-label">Measurement</label>

                                    <div class="col-sm-9"><input type="text" class="form-control" name='measurement' placeholder="Enter item" required='required'></div>
                                </div>
                             
                                                                                                                                  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-primary" name="submit" type="submit">Add Measurement</button>
                                    </div>
                                </div>
                            </form>
                                                 

                    </div>

                  
                </div>
             
                    </div>
                       <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Measurements</h5>
                                                </div>
                        <div class="ibox-content">
                            <?php 
                            $measurements=  mysqli_query($con,"SELECT * FROM stockmeasurements WHERE status=1");
                            if(mysqli_num_rows($measurements)>0){
                            ?>
                              <table class="table table-striped  table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Measurement</th>                                            
                        <th>Action</th>                                            
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                      while ($row = mysqli_fetch_array($measurements)) {
                                           $measure_id=$row['measurement_id'];            
                                           $measure=$row['measurement'];            
                                                    
                        ?>
                        <tr><td><?php echo $measure_id;?></td>
                            <td><?php echo $measure; ?></td>
                            <td>
                                <a href="editmeasurement?id=<?php echo $measure_id; ?>" class="btn btn-success btn-xs">Edit</a>
                                <a href="removemeasurement?id=<?php echo $measure_id; ?>" class="btn btn-danger btn-xs" onclick="return confirm_delete<?php echo $measure_id;?>()">Remove</a>
                                 <script type="text/javascript">
function confirm_delete<?php echo $measure_id; ?>() {
  return confirm('You are about To Remove this item. Are you sure you want to proceed?');
}
</script>
                            </td>
                        </tr>    
                                                    <?php } ?>
                    </tbody>    
                    </table>    
                            <?php }else{ ?>
                            <div class="alert alert-danger">Oops No measurements Added Yet</div>
                            <?php } ?>
                                                                                </div>  
                                                    </div>  
                                                    </div>  

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

  <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <!-- iCheck -->
    <!--<script src="js/plugins/iCheck/icheck.min.js"></script>-->

    <!-- MENU -->
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
 <script>
        $(document).ready(function(){

            $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "dd/mm/yyyy",
            });
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
   </script>
 
</body>


</html>

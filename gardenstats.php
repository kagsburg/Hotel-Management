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

    <title>Garden Reservations | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

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
                    <h2>Garden Reservations</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                            <a>Garden Reservations</a>
                        </li>
                        <li class="active">
                            <strong>View Garden Reservations in Past 30 Days</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Garden Reservations in Past 30 days<small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
<?php
$reservations=mysqli_query($con,"SELECT * FROM gardenreservations WHERE round(($timenow-timestamp)/(3600*24))<=7 ORDER BY timestamp DESC");
if(mysqli_num_rows($reservations)>0){
 
 ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                          <th>Guest</th>
                        <th>Phone</th>
                        <th> Email</th>
                        <th>Country</th>
                        <th>Id Number</th>
                         <th>Check In</th>
                 
                    </tr>
                    </thead>
                    <tbody>
              <?php
               while($row=  mysqli_fetch_array($reservations)){
  $gardenreservation_id=$row['gardenreservation_id'];
$fullname=$row['fullname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
$id_number=$row['id_number'];
  $email=$row['email'];
  $status=$row['status'];
  $country=$row['country'];
   
              ?>
               
                    <tr class="gradeA">
                    <td><?php echo $fullname; ?></td>
                        <td><?php echo $phone; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $country; ?></td>
                        <td><?php echo $id_number; ?></td>
                      
                        <td><?php echo date('d/m/Y',$checkin); ?></td>
                  
                     
                                               
<!--  <td class="center"> 
         <?php
//         if(($creator==$_SESSION['hotelsys'])||($_SESSION['hotelsyslevel']==1)){ 
//                            
//                                                        if($status=='1'){ 
                             
                                    ?>
                                            <a href="hideroom.php?id=<?php //echo $room_id.'&&status='.$status; ?>" class="btn btn-danger btn-xs">unpublish <i class="fa fa-arrow-down"></i></a> 
                                                
                            <?php// } else{ ?>
                             <a href="hideroom.php?id=<?php //echo $room_id.'&&status='.$status; ?>"  class="btn btn-primary  btn-xs">publish <i class="fa fa-arrow-up"></i></a>
                                 <?php
//                                 }
//               }
                                 ?>
  </td>-->
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }  else { ?>
    <div class="alert alert-danger"> No Garden Reservations Added Yet</div>
  <?php }?>
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


<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/table_data_tables.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:38:48 GMT -->
</html>
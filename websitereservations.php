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

    <title>Website Bookings | Hotel Manager</title>

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
                                           include 'fr/websitereservations.php';                     
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
                    <h2>Bookings Made From Website</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                            <a>Bookings</a>
                        </li>
                        <li class="active">
                            <strong>View Bookings from Website</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                 <div class="col-lg-4">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-home fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Bookings Today</span>
                            <h2 class="font-bold"><?php
                            $today=mysqli_query($con,"SELECT * FROM sitereserves WHERE round(($timenow-timestamp)/(3600*24))+1=1");
                            echo mysqli_num_rows($today);
                            ?></h2>
                        </div>
                    </div>
                </div>
                </div>
                 <div class="col-lg-4">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-home fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Bookings In Past 7 Days</span>
                            <h2 class="font-bold">
                              <?php
                            $week=mysqli_query($con,"SELECT * FROM sitereserves WHERE round(($timenow-timestamp)/(3600*24))<=7");
                            echo mysqli_num_rows($week);
                            ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
               
                 <div class="col-lg-4">
                <div class="widget style1 red-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-home fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Bookings In Past 30 Days</span>
                            <h2 class="font-bold">   <?php
                            $month=mysqli_query($con,"SELECT * FROM sitereserves WHERE round(($timenow-timestamp)/(3600*24))<=30");
                            echo mysqli_num_rows($month);
                            ?></h2>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Bookings <small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
<?php
$reservations=mysqli_query($con,"SELECT * FROM sitereserves WHERE status='0' ORDER BY reserve_id DESC");
if(mysqli_num_rows($reservations)>0){
 
 ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                          <th>Guest</th>
                          <th>Room</th>
                          <th>Phone</th>
                          <th>Country</th>
                          <th>Email</th>
                           <th>Check In</th>
                        <th>Check Out</th>
                        <th>Status</th>
                         <th>Action</th>
                        <!--<th>Action</th>-->
                    </tr>
                    </thead>
                    <tbody>
              <?php
               while($row=  mysqli_fetch_array($reservations)){
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
               
                    <tr class="gradeA">
                    <td><?php echo $firstname.' '.$lastname; ?></td>
                       
                         <td class="center">
                                         <?php 
                                            $roomtypes=mysqli_query($con,"SELECT * FROM roomtypes  WHERE roomtype_id='$type_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row1['roomtype'];
                       echo $roomtype; ?>
                        </td>
                        <td><?php echo $phone; ?></td>
                                              <td><?php echo $country; ?></td>
                                              <td><?php echo $email; ?></td>
                        <td><?php echo date('d/m/Y',$checkin); ?></td>
                        <td><?php echo date('d/m/Y',$checkout); ?></td>
                        <td>
                            <div class="text-info">Pending</div>
                        </td>
                       
                       <td><a href="approvereserve?id=<?php echo $reserve_id;?>" class="btn btn-xs btn-info">Approve</a>
                     
                       </td>
      
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }else{?>
                        <div class="alert  alert-danger">Oops!! No New Reservations Made Yet</div>
 <?php }?>
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
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

    <title>Low Stock Items | Hotel Manager</title>

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
                    <h2>Stock Items</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                       
                                               <li class="active">
                            <strong>View Stock Items</strong>
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
                        <h5>All Stock ITems <small>Sort, search</small></h5>
                        <a href="stockprint" target="_blank" class="btn btn-sm btn-warning pull-right"><i class="fa fa-print"></i> Print PDF</a>
                    </div>
                    <div class="ibox-content">
<?php
$stock=mysqli_query($con,"SELECT * FROM stock_items WHERE status=1");
if(mysqli_num_rows($stock)>0){
?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Stock Item</th>
                        <th>Min Stock</th>
                        <th>Unit</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
               while($row=  mysqli_fetch_array($stock)){
  $stockitem_id=$row['stockitem_id'];
  $cat_id=$row['category_id'];
$stockitem=$row['stock_item'];
  $minstock=$row['minstock'];
  $measurement=$row['measurement'];
  $status=$row['status'];
               ?>
               
                    <tr class="gradeA">
                    <td><?php echo $stockitem_id; ?></td>
                        <td><?php echo $stockitem; ?></td>
                        <td><?php echo $minstock; ?></td>
                                             <td> <div class="tooltip-demo">
                                      <?php 
                                              $getmeasure=  mysqli_query($con,"SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");  
                                             $row2=  mysqli_fetch_array($getmeasure);
                                              $measurement2=$row2['measurement'];
                                             echo $measurement2; ?> </div></td>
     <td><?php  
     $getcat=  mysqli_query($con,"SELECT * FROM categories WHERE status=1 AND category_id='$cat_id'");
                            $row1=  mysqli_fetch_array($getcat);
                            $category_id=$row1['category_id'];
                           $category=$row1['category']; 
                           echo $category;
                           ?></td>                   
                                               
  <td class="center"> 
       <a href="itemdetails?id=<?php echo $stockitem_id; ?>" class="btn btn-info btn-xs"><i class="fa fa-plus"></i> Item Details</a> 
                                                
                            </td>
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
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


</html>
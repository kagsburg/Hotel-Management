<?php
include 'includes/conn.php';
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!='Restaurant Attendant')){
header('Location:login.php');
   }
   ?>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Conference Orders | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
<?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/hfoodorders.php';                     
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
                <div class="col-lg-12">
                    <h2>Conference  Orders</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                            <a>Menu</a>
                        </li>
                        <li class="active">
                            <strong>Orders</strong>
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
                        <h5>All Orders <small>Sort, search</small></h5>
                        
                    </div>
                    <div class="ibox-content">
<?php
$restorders=mysqli_query($con,"SELECT * FROM orders WHERE status='1' AND customer='4' ORDER BY order_id DESC");
if(mysqli_num_rows($restorders)>0){
 
 ?>
                       <form action="archiverestaurant" method="post"> 
                                            <table class="table table-striped table-bordered table-hover dataTables-example"  id="datatable">
   
                    <thead>
                 <tr>
                         <th>Order Id</th>
                         <th>Order items</th>
                           <th>Charge</th>
                           <th>Guest Name</th>
                           <th>Hall Package</th>
                              <th>Tables</th>
                           <th>Date</th>
                           <th>Action</th>
                    
                        </tr>
                    </thead>
                    <tbody>
              <?php
               while($row=  mysqli_fetch_array($restorders)){
  $order_id=$row['order_id'];
  $guest=$row['guest'];
   $creator=$row['creator'];
  $timestamp=$row['timestamp'];
    $rtable=$row['rtable'];
  $foodsordered=  mysqli_query($con,"SELECT * FROM restaurantorders WHERE order_id='$order_id'");
                ?>
               
                      
                                              
                    <tr class="gradeA">
                        <td><?php echo 23*$order_id; ?></td>
                      <td><?php 
                  while ($row3=  mysqli_fetch_array($foodsordered)){
                      $restorder_id=$row3['restorder_id'];
                      $food_id=$row3['food_id'];
                      $price=$row3['foodprice'];
                      $quantity=$row3['quantity'];
                     
                    $foodmenu=mysqli_query($con,"SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                    $row=  mysqli_fetch_array($foodmenu);
                    $menuitem_id=$row['menuitem_id'];
                            $menuitem=$row['menuitem'];
 
                            echo $quantity.' '.$menuitem.'<br/>';
                  }
                      ?></td>
                         <td class="center">
                                        <?php
                                               $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                            $row=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row['totalcosts'];
                            echo number_format($totalcosts);
                                                                    ?>
                        </td>
                        <td>
                            <?php
                           $reservations=mysqli_query($con,"SELECT * FROM hallreservations WHERE  hallreservation_id='$guest'");
$row=  mysqli_fetch_array($reservations);
 $fullname=$row['fullname'];    
   $type_id=$row['type'];
echo $fullname;                     
        $purposes=mysqli_query($con,"SELECT * FROM hallpurposes WHERE hallpurpose_id='$type_id'");
                                                     $row3 = mysqli_fetch_array($purposes);
                                                     $type=$row3['type']; 
                         
                            ?>
                        </td>
                        <td><?php echo $type;?></td>
                                                                 <td> <?php   echo $rtable;    ?></td>
                           <td><?php echo date('d/m/Y',$timestamp);?></td>    
                           <td>
                               <a href="restorders?id=<?php echo $order_id; ?>" target="_blank" class="btn btn-xs btn-info">View Details</a>                
                               <a href="addmoreitems?id=<?php echo $order_id; ?>" class="btn btn-xs btn-primary">Add more Items</a>
                               <a href="restinvoice?id=<?php echo $order_id; ?>" class="btn btn-xs btn-success">View Invoice</a>  
                                   <a href="restorderpayment?id=<?php echo $order_id; ?>" class="btn btn-xs btn-danger">Add Payment</a>
                                <a href="hiderestorder?id=<?php echo $order_id;?>" class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $order_id; ?>()">Cancel</a>
                            
                                 <script type="text/javascript">
function confirm_delete<?php echo $order_id; ?>() {
  return confirm('You are about To Remove this Order. Are you sure you want to proceed?');
}
</script>                 
                           </td>       
                                              
                      </tr>
                 <?php }?>
                    </tbody>
                                    </table> </form>
 <?php }else{?>
                        <div class="alert alert-danger">No Restaurant Orders Added Yet</div>
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
<script src="js/plugins/chosen/chosen.jquery.js"></script>
    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Page-Level Scripts -->
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
         <script>
        var checkboxe = $("#datatable input[type='checkbox']"),
    submitButt= $("#hid");

checkboxe.click(function() {
    submitButt.attr("disabled", !checkboxe.is(":checked"));
});</script>
</body>

</html>
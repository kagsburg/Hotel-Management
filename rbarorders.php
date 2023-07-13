<?php
include 'includes/conn.php';
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!='Bar attendant')){
header('Location:login.php');
   }
   ?>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Bar Orders | Hotel Manager</title>

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
                                           include 'fr/rbarorders.php';                     
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
                    <h2>Hotel  Bar Orders From Registered Customers</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                            <a>Menu</a>
                        </li>
                        <li class="active">
                            <strong>View Orders</strong>
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
                        <h5 class="pull-left">All Orders <small>Sort, search</small></h5>
                                             <div style="clear:both"></div>
                    </div>
                    <div class="ibox-content">
<?php
   $barorders=  mysqli_query($con,"SELECT * FROM barorders WHERE status='1' AND customer='2' ORDER by barorder_id");
   if(mysqli_num_rows($barorders)>0){
 ?>
                                               
                        <table class="table table-striped table-bordered table-hover dataTables-example"  id="datatable">
                    <thead>
                    <tr>
                         <th>Order Id</th>
                        <th>Ordered Drinks</th>
                        <th>Total charge</th>
                            <th>Customer Name</th>
                            <th>Tel</th>
                              <th>Table</th>
                        <th>Date</th>
                        <th>Action</th>
                         
                          </tr>
                    </thead>
                    <tbody>
              <?php
           
               while($row=  mysqli_fetch_array($barorders)){
    $order_id=$row['barorder_id'];
      $guest=$row['guest'];
  $creator=$row['creator'];
     $table=$row['bartable'];
   $timestamp=$row['timestamp'];
   $getdrinks=  mysqli_query($con,"SELECT * FROM barorder_drinks WHERE barorder_id='$order_id'");                                    
                ?>
               
                    <tr class="gradeA">
                      <td><?php echo 23*$order_id; ?></td>
                         <td class="center">
                                          <?php
                                           while($row=  mysqli_fetch_array($getdrinks)){ 
                                          $drink_id=$row['drink_id'];
                                          $charge=$row['charge'];
                                          $items=$row['items'];
                                          $drinkorder_id=$row['drinkorder_id'];
                                          $getdrink=mysqli_query($con,"SELECT * FROM drinks WHERE drink_id='$drink_id'");
                                            $row2=  mysqli_fetch_array($getdrink);
                                                  $drink=$row2['drinkname'];
                                                  $quantity=$row2['quantity'];
                                              $drinktotal=$charge*$items;   
                                          echo $items.' '.$drink.' ('.$quantity.')<br/>'; 
                                           }
                                          ?>
                        </td>
                          <td class="center">
                                      <?php
                                               $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(charge*items), 0) AS totalcosts FROM barorder_drinks WHERE barorder_id='$order_id'");
                            $row=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row['totalcosts'];
                            echo number_format($totalcosts);
                                                                    ?>
                        </td>
                          <td>
                            <?php
                                $customers= mysqli_query($con,"SELECT * FROM customers WHERE status='1' AND customer_id='$guest'") or die(mysqli_errno($con));
                         $row = mysqli_fetch_array($customers);                         
                         $customer_id=$row['customer_id'];                              
                         $customername=$row['customername'];                              
                         $customercompany=$row['customercompany'];                              
                         $customerphone=$row['customerphone'];                              
                         $customeremail=$row['customeremail'];                              
                         $passport_id=$row['passport_id'];      
                         echo $customername;
 ?>
                       
                        </td>
              
                           
                           
                        </td>
                           <td><?php echo $customerphone;?></td>
                                                <td>                             
                                             <?php                
                                             echo $table;
                                             ?> </td>
                     
                     
                                   
                       <td><?php echo date('d/m/Y',$timestamp);?></td>               
                       <td>
                           <a href="barorders?id=<?php echo $order_id; ?>" class="btn btn-xs btn-info" target="_blank">View Details</a>
                 
                           <a href="addmorebaritems?id=<?php echo $order_id; ?>" class="btn btn-xs btn-primary">Add More Items</a>
                           <a href="barinvoice?id=<?php echo $order_id; ?>" class="btn btn-xs btn-success">View Invoice</a>
                        <a href="hidebarorder?id=<?php echo $order_id;?>" class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $order_id; ?>()">Cancel</a>                            
                                 <script type="text/javascript">
function confirm_delete<?php echo $order_id; ?>() {
  return confirm('You are about To Remove this Order. Are you sure you want to proceed?');
}
</script>                 
                       </td>               
    
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }else{?>
                        <div class="alert alert-danger">No Drink Orders Added Yet</div>
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
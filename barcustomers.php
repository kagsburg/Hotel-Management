<?php
include 'includes/conn.php';
   if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!="Bar attendant")){   
header('Location:login.php');
   }
   ?>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Bar Customers | Hotel Manager</title>
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
                    <h2>Registered Bar Customers</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index.php"><i class="fa fa-home"></i> Home</a>                    </li>
                   
                        <li class="active">
                            <strong>Bar Customers</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
  
                           <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">                            
                            <h5>Bar Customers</h5>
                                                 </div>
                        <div class="ibox-content">
                            <?php 
                            $customers= mysqli_query($con,"SELECT * FROM customers WHERE status='1' AND type='bar'") or die(mysqli_errno($con));
                            if(mysqli_num_rows($customers)>0){
                            ?>
                              <form action="archivecosts" method="post"> 
                                               <table class="table table-striped table-bordered table-hover dataTables-example" id="datatable" >
                    <thead>
                     
                    <tr>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Phone</th>
                        <th>Orders</th>                  
                        <th>Bill</th>
                              <th>Amount Paid</th>
                        <th>Action</th>
                         </tr>                                                 
                    </thead>
                    <tbody>
                     <?php
                while ($row = mysqli_fetch_array($customers)) {
                         $customer_id=$row['customer_id'];                              
                         $customername=$row['customername'];                              
                         $customercompany=$row['customercompany'];                              
                         $customerphone=$row['customerphone'];                              
                         $customeremail=$row['customeremail'];                              
                         $passport_id=$row['passport_id'];            
                         $getorders=  mysqli_query($con,"SELECT * FROM barorders WHERE guest='$customer_id' AND customer=2 AND status=1");
                         $getpayments=  mysqli_query($con,"SELECT SUM(amount) as totalpayments FROM customerpayments WHERE customer_id='$customer_id'");
                         $row2= mysqli_fetch_array($getpayments);
                         $totalpayments=$row2['totalpayments'];
                         $totalbill=0;
                         while ($roww = mysqli_fetch_array($getorders)) {
                             $order_id=$roww['barorder_id'];
                                $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(charge*items), 0) AS totalcosts FROM barorder_drinks WHERE barorder_id='$order_id'");
                            $row4=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row4['totalcosts'];
                            $totalbill=$totalbill+$totalcosts; 
                         }
                        ?>
                    <tr class="gradeA">
                        <td><?php echo $customername; ?></td>
                        <td><?php echo $customercompany;?> </td>
                        <td><?php echo $customerphone;?> </td>
                        <td><?php echo mysqli_num_rows($getorders);?> </td>                     
                                       
                        <td><?php echo number_format($totalbill);?> </td>        
                           <td><?php echo number_format($totalpayments);?> </td>   
                        <td>                           
                           <a href="barcustomer?id=<?php echo $customer_id;?>" class="btn btn-xs btn-info"><i class="fa fa-user"></i> View Details</a>                           
                           <a href="addbarpayment?id=<?php echo $customer_id;?>" class="btn btn-xs btn-danger"><i class="fa fa-plus"></i> Add Payment</a>                           
                        </td>                  
                    </tr>   <?php } ?>
                    </tbody>
                             </table>  </form>
                            <?php }else{ ?>
                            <div class="alert alert-danger">No Customers Added  yet</div>
                            <?php }?>
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
                autoclose: true
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
      <script>
        var checkboxe = $("#datatable input[type='checkbox']"),
    submitButt= $("#hid");

checkboxe.click(function() {
    submitButt.attr("disabled", !checkboxe.is(":checked"));
});</script>
</body>


</html>

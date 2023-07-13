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

    <title>Suppliers </title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
   <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
</head>

<body>
<?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/suppliers.php';                     
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
                    <h2>Suppliers</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                                          <li class="active">
                            <strong>View Suppliers</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <a href="addsupplier" class="btn btn-info">Add Supplier</a>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Suppliers <small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
         
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                           <th scope="col">Supplier Name</th>
                            
                           <th scope="col">Phone</th>    
                          <th scope="col">Address</th>   
                          <th scope="col">Email</th>   
                          <th scope="col">Products</th>   
                        
                          <th scope="col">&nbsp;</th>
                   
                        </tr>
                      </thead>
                      <tbody>
                  <?php
                   $suppliers=  mysqli_query($con, "SELECT * FROM suppliers WHERE status=1") or die(mysqli_error($con));
                   while($row=  mysqli_fetch_array($suppliers)){
                       $supplier_id=$row['supplier_id'];
                       $suppliername=$row['suppliername'];
                     $email=$row['email'];
               
                       $phone=$row['phone'];
                       $address=$row['address'];               
                  ?>
                        <tr>
                          <td><?php echo $suppliername;?></td>
                          
                            <td><?php echo $phone;?></td>
                          <td><?php echo $address;?></td>
                          <td><?php echo $email;?></td>
                          <td><?php 
                          $productarray=array();
                              $getsupplierproducts= mysqli_query($con,"SELECT * FROM supplierproducts WHERE supplier_id='$supplier_id'");
                   while($row1= mysqli_fetch_array($getsupplierproducts)){
                   $product_id=$row1['product_id'];
                   $getproduct=  mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$product_id' AND status=1") or die(mysqli_error($con));
                   $row2=  mysqli_fetch_array($getproduct);
                  $stockitem=$row2['stock_item'];
                  array_push($productarray,$stockitem);
                   }
                   $List = implode(', ', $productarray);   
print_r($List);
                          ?></td>
                    
                        <td>
                            <button  data-toggle="modal" data-target="#supplier<?php echo $supplier_id; ?>"  class="btn btn-xs btn-info">Edit</button>
                            <a href="removesupplier?id=<?php echo $supplier_id; ?>" class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $supplier_id;?>()">Remove</a>
                        <script type="text/javascript">
function confirm_delete<?php echo $supplier_id; ?>() {
  return confirm('You are about To Remove this item. Are you sure you want to proceed?');
}
</script>
                        </td>
                                          
                                    </tr>
               
                   <?php }?>
                    </tbody>
                
                    </table>

                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>
      <?php
                   $suppliers=  mysqli_query($con, "SELECT * FROM suppliers WHERE status=1") or die(mysqli_error($con));
                   while($row=  mysqli_fetch_array($suppliers)){
                       $supplier_id=$row['supplier_id'];
                       $suppliername=$row['suppliername'];
                     $email=$row['email'];
               
                       $phone=$row['phone'];
                       $address=$row['address'];               
                  ?>
       <div id="supplier<?php echo $supplier_id; ?>" class="modal fade" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                           <div class="modal-body">
                                  <form action="editsupplier?id=<?php echo $supplier_id; ?>" method="POST">
                                 <div class="form-group">
                                        <label>Supplier Name *</label>
                                        <input type="text" class="form-control" name="suppliername" required="required" value="<?php echo $suppliername; ?>">
	                    </div>
                                   
                                   <div class="form-group">
                                        <label>Address *</label>
                                        <input type="text" class="form-control" name="address" required="required" value="<?php echo $address; ?>">
	                    </div>
                                                        <div class="form-group">
                                        <label>Phone*</label>
                                        <input type="text" class="form-control" name="phone" required="required" value="<?php echo $phone; ?>">
	                    </div>
                                     <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
	                    </div>   
                                       <div class="form-group">
                      <label>Products Supplied</label>
                      <select class="form-control select2" name="products[]" multiple style="width:100%">
                        <?php
                   $stock=mysqli_query($con,"SELECT * FROM stock_items WHERE status=1");
               while($row=  mysqli_fetch_array($stock)){
  $stockitem_id=$row['stockitem_id'];
  $cat_id=$row['category_id'];
$stockitem=$row['stock_item'];
  $minstock=$row['minstock'];
  $measurement=$row['measurement'];
  $status=$row['status'];
               
                     $getsupplierproducts= mysqli_query($con,"SELECT * FROM supplierproducts WHERE supplier_id='$supplier_id' AND product_id='$stockitem_id'");
                 if(mysqli_num_rows($getsupplierproducts)>0){
                    ?>
                          <option value="<?php echo $stockitem_id; ?>" selected="selected"><?php echo $stockitem; ?></option>
                   <?php }else{ ?>
                     <option value="<?php echo $stockitem_id; ?>"><?php echo $stockitem; ?></option>      
               <?php    }} ?>
                      </select>
                    </div>
                            <div class="form-group">
                          <button class="btn btn-primary" type="submit">Submit</button>
                      </div>           
                          </form>
              </div>
           
            </div>
          </div>
        </div>
                                       <?php }}?>
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
 <script src="js/plugins/chosen/chosen.jquery.js"></script>   
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

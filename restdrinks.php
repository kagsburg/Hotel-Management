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

    <title>RestaurantDrinks | Hotel Manager</title>

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
                <div class="col-lg-12">
                    <h2>Restaurant  Drinks</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                             <a href="foodmenu">Menu</a>
                        </li>
                        <li class="active">
                            <strong>View Restaurant Drinks</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                 <div class="col-lg-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add New Drink <small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
                                                              <?php
//                            include_once 'includes/thumbs3.php';
                            if(isset($_POST['drink'],$_POST['price'],$_POST['quantity'])){
                                  $drink=  mysqli_real_escape_string($con,trim($_POST['drink']));
                                    $price=  mysqli_real_escape_string($con,trim($_POST['price']));
                                    $quantity=  mysqli_real_escape_string($con,trim($_POST['quantity']));
                                if((empty($_POST['drink']))||(empty($_POST['price']))||(empty($_POST['quantity']))){
                                    echo  '<div class="alert alert-danger"><i class="fa fa-warning"></i> All Fields Required</div>';
                                }
                             else if(is_numeric($price)==FALSE){
                                     echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Price Should Be An Integer</div>';
                                }
                                else{
                                                              
                                
             mysqli_query($con,"INSERT INTO drinks VALUES('','$drink','$price','$quantity','rest','".$_SESSION['emp_id']."','1')") or die(mysqli_errno($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Drink successfully added</div>';
                                 }
                            }
                                                
	
	
                           ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Drink</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name='drink' placeholder="Enter Drink Name" required='required'></div>
                                </div>
      
                             
       <div class="form-group"><label class="col-sm-2 control-label">Price</label>

                                    <div class="col-sm-10">
                                        <div class="input-group m-b"><span class="input-group-addon">shs</span> <input name="price" class="form-control" placeholder="Enter item price" type="text"></div>
                                    </div>
                                </div>
       <div class="form-group"><label class="col-sm-2 control-label">Quantity</label>

                                    <div class="col-sm-10">
                                        <select class="form-control" name="quantity">
                                                        <option value="" selected="selected">Choose quantity...</option>
                                                        <option value="glass">glass</option>
                                                        <option value="100ml">100ml</option>
                                                        <option value="200ml">200ml</option>
                                                        <option value="300ml">300ml</option>
                                                        <option value="500ml">500ml</option>
                                                        <option value="750ml">750ml</option>
                                                        <option value="1 litre">1 litre</option>
                                                        <option value="1.5 litres">1.5 litres</option>
                                            </select>
                                              
                                    </div>
                                </div>
   
                        
                                                                                                                                  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-primary" name="submit" type="submit">Add Drink</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                    </div>
                    </div>
                <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Drinks <small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
<?php
$drinks=mysqli_query($con,"SELECT * FROM drinks WHERE type='rest' ORDER BY drinkname");
if(mysqli_num_rows($drinks)>0){
 
 ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                         <th>Drink Name</th>
                        <th>Price(shs)</th>
                        <th>Quantity</th>
                        <th>Type</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
               while($row=  mysqli_fetch_array($drinks)){
  $drink=$row['drinkname'];
  $drink_id=$row['drink_id'];
$quantity=$row['quantity'];
  $drinkprice=$row['drinkprice'];
  $type=$row['type'];
  $status=$row['status'];
  $creator=$row['creator'];
  
              ?>
               
                    <tr class="gradeA">
                      <td><?php echo $drink; ?></td>
                         <td class="center">
                                        <?php  echo $drinkprice; ?>
                        </td>
                          <td class="center">
                                        <?php  echo $quantity; ?>
                        </td>
                           <td class="center">
                                        <?php  echo $type; ?>
                        </td>
                       <td> <div class="tooltip-demo">
                               
                            <a href="profile?id=<?php echo $creator; ?>" data-original-title="View admin profile"  data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php 
                                $employee=  mysqli_query($con,"SELECT * FROM employees WHERE employee_id='$creator'");
                                         $row = mysqli_fetch_array($employee);
                                          $employee_id=$row['employee_id'];
                                           $fullname=$row['fullname'];
                                             echo $fullname;
                                         
                                             echo $fullname; ?></a> </div></td>
                     
                                               
  <td class="center"> 
         <?php
         if(($creator==$_SESSION['hotelsys'])||($_SESSION['hotelsyslevel']==1)){ 
                            
                                                        if($status=='1'){ 
                             
                                    ?>
                                            <a href="hidedrink.php?id=<?php echo $drink_id.'&&status='.$status; ?>" class="btn btn-danger btn-xs">unpublish <i class="fa fa-arrow-down"></i></a> 
                                                
                            <?php } else{ ?>
                             <a href="hidedrink.php?id=<?php echo $drink_id.'&&status='.$status; ?>"  class="btn btn-primary  btn-xs">publish <i class="fa fa-arrow-up"></i></a>
                                 <?php }
               }
                                 ?>
                                <a href="editdrink.php?id=<?php echo $drink_id;?>" class="btn btn-info btn-xs">Edit <i class="fa fa-edit"></i></a> 
  </td>
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }else{?>
                        <div class="alert alert-danger">No Drinks Added Yet</div>
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
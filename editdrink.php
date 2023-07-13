<?php
include 'includes/conn.php';
  if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!="Bar attendant")&&($_SESSION['sysrole']!='Restaurant Attendant')){
header('Location:login.php');
   }
   $id=$_GET['id'];
   ?>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Drink | Hotel Manager</title>

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
                    <h2>Edit Hotel  Drink Details</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                            <a>Menu</a>
                        </li>
                        <li class="active">
                            <strong>Edit Drink</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                 <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Edit  Drink Details</h5>
                       
                    </div>
                    <div class="ibox-content">
                                                              <?php
//                            include_once 'includes/thumbs3.php';
                            if(isset($_POST['drink'],$_POST['price'],$_POST['quantity'])){
                                  $drink=  mysqli_real_escape_string($con,trim($_POST['drink']));
                                                            $price=  mysqli_real_escape_string($con,trim($_POST['price']));
                                    $quantity=  mysqli_real_escape_string($con,trim($_POST['quantity']));
                                       $drink2=$drink.' ('.$quantity.')';
                                if((empty($_POST['drink']))||(empty($_POST['price']))||(empty($_POST['quantity']))){
                                    echo  '<div class="alert alert-danger"><i class="fa fa-warning"></i> All Fields Required</div>';
                                }
                             else if(is_numeric($price)==FALSE){
                                     echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Price Should Be An Integer</div>';
                                }
                                else{
                                    
                                       mysqli_query($con,"UPDATE menuitems SET menuitem='$drink2',itemprice='$price' WHERE menuitem_id='$id'") or die(mysqli_errno($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Drink successfully Edited</div>';
                                 }
                            }
     $menu=mysqli_query($con,"SELECT * FROM menuitems WHERE menuitem_id='$id' AND type='drink' ORDER BY menuitem");
 $row=  mysqli_fetch_array($menu);
  $menuitem_id=$row['menuitem_id'];
$menuitem=$row['menuitem'];
  $itemprice=$row['itemprice'];
  $status=$row['status'];
  $drink2=  explode('(', $menuitem);
  $drinkname=  current($drink2);
                           ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Drink</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name='drink' value="<?php echo $drinkname; ?>" placeholder="Enter Drink Name" required='required'></div>
                                </div>
                                    
       <div class="form-group"><label class="col-sm-2 control-label">Price</label>

                                    <div class="col-sm-10">
                                        <div class="input-group m-b"><span class="input-group-addon">shs</span> <input name="price" class="form-control" placeholder="Enter item price" type="text" value="<?php echo $itemprice; ?>"></div>
                                    </div>
                                </div>
       <div class="form-group"><label class="col-sm-2 control-label">Select Quantity</label>

                                    <div class="col-sm-10">
                                        <select class="form-control" name="quantity">
                                            <option value="" selected="selected">Select quantity...</option>
                                                         <?php
$quantities=mysqli_query($con,"SELECT * FROM drinkquantities WHERE  status='1'");
     while($row=  mysqli_fetch_array($quantities)){
  $quantity_id=$row['quantity_id'];
   $quantity=$row['quantity'];
  $status=$row['status'];
  $creator=$row['creator'];
 
 ?>
                                                        <option value="<?php echo $quantity; ?>"><?php echo $quantity; ?></option>
     <?php } ?>
                                            </select>
                                              
                                    </div>
                                </div>
   
                        
                                                                                                                                  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-primary" name="submit" type="submit">Edit Drink</button>
                                    </div>
                                </div>
                            </form>
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
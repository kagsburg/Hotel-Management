<?php
include 'includes/conn.php';
 if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
   }
   $id=$_GET['id'];
   ?>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Menu ITem | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
 <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
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
                    <h2>Edit Hotel Food Menu Item</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                             <a href="foodmenu">Menu</a>
                        </li>
                        <li class="active">
                            <strong>Edit  Menu Item</strong>
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
                        <h5>Edit Menu Item</h5>
                       
                    </div>
                    <div class="ibox-content">
                                                              <?php
//                            include_once 'includes/thumbs3.php';
                            if(isset($_POST['item'],$_POST['price'])){
                                  $item=  mysqli_real_escape_string($con,trim($_POST['item']));
                                    $price=  mysqli_real_escape_string($con,trim($_POST['price']));
                                if((empty($_POST['item']))||(empty($_POST['price']))){
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Enter Menu Item To Proceed</div>';
                                }
                              else  if(is_numeric($price)==FALSE){
                                     echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Price Should Be An Integer</div>';
                                }
                                else{
                            
                                  
                                
              mysqli_query($con,"UPDATE menuitems SET menuitem='$item',itemprice='$price' WHERE menuitem_id='$id'") or die(mysqli_errno($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Menu Item successfully Edited</div>';
                                 }
                            }
                                                
	$menuitem=mysqli_query($con,"SELECT * FROM menuitems WHERE menuitem_id='$id'");
           $row=  mysqli_fetch_array($menuitem);
 $menuitem1=$row['menuitem'];
  $itemprice1=$row['itemprice'];
                             ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Item</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name='item' placeholder="Enter item name" value="<?php echo $menuitem1; ?>" required='required'></div>
                                </div>
       <div class="form-group"><label class="col-sm-2 control-label">Price</label>

                                    <div class="col-sm-10">
                                   <input name="price" value="<?php echo $itemprice1; ?>" class="form-control" placeholder="Enter item price" type="text"></div>
                                 
                                </div>
                             
                        
                                                                                                                                  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-primary" name="submit" type="submit">Edit menu item</button>
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
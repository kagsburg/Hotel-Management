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

    <title>Gas Cylinder Sales | Hotel Manager</title>

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
                    <h2>Gas Cylinder Sales</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                            <a>Gas Point</a>
                        </li>
                        <li class="active">
                            <strong>View Cylinder Sales</strong>
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
                        <h5>Add New Cylinder Sale</h5>
                       
                    </div>
                    <div class="ibox-content">
                                                              <?php
//                            include_once 'includes/thumbs3.php';
                            if(isset($_POST['ctype'])){
                                  $ctype=  mysqli_real_escape_string($con,trim($_POST['ctype']));
                                   $splitctype= explode('-',$ctype);
                                    $cprice=  current($splitctype);
                                       $c_id=end($splitctype);
                                  if(empty($_POST['ctype'])){
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Enter  All FieldsTo Proceed</div>';
                                }
                                               else{
                            
                                  
                                
              mysqli_query($con,"INSERT INTO cylindersales  VALUES('','$c_id','$cprice','".$_SESSION['hotelsys']."',UNIX_TIMESTAMP(),'0')") or die(mysqli_errno($con));
             $last_id=mysqli_insert_id($con);
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Cylinder Sale successfully Added, Click <strong><a href="cylinderinvoice?id='.$last_id.'">here</a></strong> to complete Purchase</div>';
                                 }
                            }
                                                
	
	
                           ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                              
       <div class="form-group"><label class="col-sm-2 control-label">Select Type</label>

                                    <div class="col-sm-10">
                                        <select class="form-control" name="ctype">
                                            <option value="" selected="selected">Select cylinder....</option>
                                            <?php
                                            $types=mysqli_query($con,"SELECT * FROM cylinders");
                                            while ($row = mysqli_fetch_array($types)) {
                                                  $cylinder_id=$row['cylinder_id'];
$cylinder_type=$row['cylinder_type'];
$cylinder_price=$row['price'];
                                                ?>
                                            
                                            <option value="<?php echo $cylinder_price.'-'.$cylinder_id;?>"><?php echo $cylinder_type; ?></option>
                                        <?php    }
                                            ?>
                                           
                                        </select>
                                    </div>
                                </div>
                             
                        
                                                                                                                                  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-danger" name="submit" type="submit">Add Sale</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                    </div>
                    </div>
                <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Cylinder Sales <small>Sort, search</small></h5>
                        <a href="cylindersalesprint" target="_blank" class="btn btn-sm btn-warning pull-right"><i class="fa fa-print"></i> Print PDF</a>
                    </div>
                    <div class="ibox-content">
<?php
$sales=mysqli_query($con,"SELECT * FROM cylindersales WHERE status='1'");
if(mysqli_num_rows($sales)>0){
 
 ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                         <th>Cylinder</th>
                        <th>Price(shs)</th>
                        <th>Added By</th>
                        <th>Date</th>
                        
                    </tr>
                    </thead>
                    <tbody>
              <?php
               while($row=  mysqli_fetch_array($sales)){
  $cylindersale_id=$row['cylinder_id'];
  $cylinder_id=$row['cylinder_id'];
   $price=$row['price'];
   $timestamp=$row['timestamp'];
   $creator=$row['creator'];
   $gettype=  mysqli_query($con, "SELECT * FROM cylinders WHERE cylinder_id='$cylinder_id'");
   $row2=  mysqli_fetch_array($gettype);
$cylinder_type=$row2['cylinder_type'];
     
              ?>
               
                    <tr class="gradeA">
                      <td><?php echo $cylinder_type; ?></td>
                         <td class="center">
                                        <?php  echo $price; ?>
                        </td>
                                     <td> <div class="tooltip-demo">
                               
                            <a href="profile?id=<?php echo $creator; ?>" data-original-title="View admin profile"  data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php 
                                              $getname=  mysqli_query($con,"SELECT * FROM users WHERE user_id='$creator'");  
                                             $row2=  mysqli_fetch_array($getname);
                                              $fullname=$row2['fullname'];
                                             echo $fullname; ?></a> </div></td>                     
  <td class="center"> 
           <?php  echo date('d/m/Y',$timestamp); ?>
                              
  </td>
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }else{?>
                        <div class="alert alert-danger">No Cylinder Type Added Yet</div>
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
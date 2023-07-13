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

    <title>Restaurant Tables | Hotel Manager</title>

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
                                           include 'fr/rtables.php';                     
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
                    <h2>Restaurant  Tables</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                             <a href="foodmenu">Menu</a>
                        </li>
                        <li class="active">
                            <strong>View Restaurant Tables</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                 <div class="col-lg-5">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add New Table <small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
                                                              <?php
//                            include_once 'includes/thumbs3.php';
                            if(isset($_POST['table'])){
                                  $table=  mysqli_real_escape_string($con,trim($_POST['table']));
                                   if(empty($table)){
                                     $errors[]='Table Name is required';
                                   }
                                   $check=mysqli_query($con,"SELECT * FROM hoteltables WHERE table_no='$table' AND area='rest' AND status='1'");
                          if(mysqli_num_rows($check)>0){
                                $errors[]='Table Name already Added';
                          }
                        if(!empty($errors)){
                        foreach ($errors as $error) {
                        echo '<div class="alert alert-danger">'.$error.'</div>';
                            }
                        }
                    else{                                                              
                                
             mysqli_query($con,"INSERT INTO hoteltables(table_no,creator,area,status) VALUES('$table','".$_SESSION['emp_id']."','rest','1')") or die(mysqli_error($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Table successfully added</div>';
                                 }
                            }
                                                
	
	
                           ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Table Number</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name='table' placeholder="Enter Table Name" required='required'></div>
                                </div>
      
                             
                              
                                                                                                                                  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-primary btn-sm" name="submit" type="submit">Add Table</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                    </div>
                    </div>
                <div class="col-lg-7">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All tables<small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
<?php
$tables=mysqli_query($con,"SELECT * FROM hoteltables WHERE area='rest' AND status='1'");
if(mysqli_num_rows($tables)>0){
 
 ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                         
                        <th>ID</th>
                         <th>Table Name</th>
                          <th>Added By</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
               while($row=  mysqli_fetch_array($tables)){
  $hoteltable_id=$row['hoteltable_id'];
  $table_no=$row['table_no'];
   $area=$row['area'];
  $status=$row['status'];
  $creator=$row['creator'];
  
              ?>
               
                    <tr class="gradeA">
                      <td><?php echo $hoteltable_id; ?></td>
                         <td class="center">
                                        <?php  echo $table_no; ?>
                        </td>
                      
                     <td> <div class="tooltip-demo">
                               
                                <a href="employee?id=<?php echo $creator; ?>" data-original-title="View admin profile"  data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php 
                                        $employee=  mysqli_query($con,"SELECT * FROM employees WHERE employee_id='$creator'");
                                         $row = mysqli_fetch_array($employee);
                                          $employee_id=$row['employee_id'];
                                           $fullname=$row['fullname'];
                                             echo $fullname; ?></a> </div> </td>
                                        
                                               
  <td class="center"> 
                                    
                     <a href="hidetable.php?id=<?php echo $hoteltable_id; ?>"  class="btn btn-danger  btn-xs" onclick="return confirm_delete<?php echo $hoteltable_id;?>()">Remove <i class="fa fa-arrow-down"></i></a>
                                    <script type="text/javascript">
function confirm_delete<?php echo $hoteltable_id; ?>() {
  return confirm('You are about To Remove this table. Are you sure you want to proceed?');
}
</script>                                             
  </td>
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }else{?>
                        <div class="alert alert-danger">No Tables Added Yet</div>
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
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

    <title>Leaves History | Hotel Manager</title>

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
                                           include 'fr/leaveshistory.php';                     
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
                    <h2>Leaves History</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                       
                      
                        <li class="active">
                            <strong>View Leaves</strong>
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
                        <h5>Leave History<small>Sort, search</small></h5>
                                          </div>
                    <div class="ibox-content">
<?php
$leaves=mysqli_query($con,"SELECT * FROM leaves  WHERE status='1'  AND returndate!='' ORDER BY startdate");
?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                          <th> Employee No</th>
                          <th>Employee</th>
                        <th>Designation</th>
                          <th>Date of Request</th>
                        <th>Start Leave Date</th>
                        <th>Return Date</th>
                         <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
    while($row=  mysqli_fetch_array($leaves)){
  $leave_id=$row['leave_id'];

$startdate=$row['startdate'];
$enddate=$row['enddate'];
$returndate=$row['returndate'];
$employee_id=$row['employee_id'];
$creator=$row['creator'];
 $timestamp=$row['timestamp'];
   $employee=  mysqli_query($con,"SELECT * FROM employees WHERE employee_id='$employee_id'");
               $row1 = mysqli_fetch_array($employee);
                                           $fullname=$row1['fullname'];
                                              $design_id=$row1['designation'];
                                                          $employeenumber=$row1['employeenumber'];
                      $dept2=  mysqli_query($con,"SELECT * FROM designations WHERE designation_id='$design_id'");
                                     $row2=  mysqli_fetch_array($dept2);
                                     $dept_id=$row2['department_id'];
                                    $design=$row2['designation'];
                                          $dept_id=$row2['department_id'];
                                    $dept=  mysqli_query($con,"SELECT * FROM departments WHERE department_id='$dept_id'");
                                   $row2 = mysqli_fetch_array($dept);
                                     $dept_name=$row2['department'];
    ?>
            <tr class="gradeA">
                    <td><?php echo $employeenumber; ?></td>
                    <td><?php echo $fullname; ?></td>
                        <td><?php echo $design.'('.$dept_name.')'; ?></td>
                          <td><?php echo date('d/m/Y',$timestamp); ?></td>
                          <td><?php echo date('d/m/Y',$startdate); ?></td>
                          <td><?php echo date('d/m/Y',$returndate); ?></td>
                   <td>
            <a href="removeleave?id=<?php echo $leave_id;?>" class="btn btn-xs btn-danger" onclick="return cdelete<?php echo $leave_id;?>()">Remove</a>
                          <script type="text/javascript">
                                            
                         function cdelete<?php echo $leave_id; ?>() {
  return confirm('You are about To Approve this leave. Do you want to proceed?');
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
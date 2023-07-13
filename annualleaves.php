<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login.php');
}

$getsettings = mysqli_query($con, "SELECT * FROM settings");
$row = mysqli_fetch_array($getsettings);
$annual_leave = $row['annual_leave'];

$first = strtotime('1 January');
$last = strtotime('1 January next year');

?>
<html>

<head>

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Employee Annual Leaves | Hotel Manager</title>

   <link href="css/bootstrap.min.css" rel="stylesheet">
   <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

   <!-- Data Tables -->
   <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

   <link href="css/animate.css" rel="stylesheet">
   <link href="css/style.css" rel="stylesheet">

</head>

<body>
   <?php
   if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
      include 'fr/employee.php';
   } else {
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
                  <h2>Employees Annual Leaves</h2>
                  <ol class="breadcrumb">
                     <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>


                     <li class="active">
                        <strong>View Employee Annual Leaves</strong>
                     </li>
                  </ol>
               </div>
               <div class="col-lg-2">

               </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
               <div class="row">
                  <?php
                  $employees =  mysqli_query($con, "SELECT * FROM employees WHERE status='1'");
                  ?>


                  <div class="col-lg-12">
                     <!-- <a href="employeesprint" class="btn btn-success mb-2" target="_blank">EXPORT TO PDF</a>
                            <a href="employeesexcel" class="btn btn-primary mb-2" target="_blank">EXPORT TO EXCEL</a> -->
                     <div class="ibox float-e-margins">
                        <div class="ibox-title">
                           <h5>All Employees<small>Sort, search</small></h5>

                        </div>
                        <div class="ibox-content">
                           <?php

                           if (mysqli_num_rows($employees) > 0) {

                           ?>
                              <table class="table table-striped table-bordered table-hover dataTables-example">
                                 <thead>
                                    <tr>
                                       <th>Image</th>
                                       <th>Full Names</th>
                                       <th>Designation</th>
                                       <th>Department</th>
                                       <th>Remaining Days Off</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php

                                    while ($row = mysqli_fetch_array($employees)) {
                                       $employee_id = $row['employee_id'];
                                       $fullname = $row['fullname'];
                                       $gender = $row['gender'];
                                       $design_id = $row['designation'];
                                       $status = $row['status'];
                                       $ext = $row['ext'];
                                       $dept2 =  mysqli_query($con, "SELECT * FROM designations WHERE designation_id='$design_id'");
                                       $row2 =  mysqli_fetch_array($dept2);
                                       $dept_id = $row2['department_id'];
                                       $design = $row2['designation'];
                                       $dept =  mysqli_query($con, "SELECT * FROM departments WHERE department_id='$dept_id'");
                                       $row2 = mysqli_fetch_array($dept);
                                       $dept_name = $row2['department'];
                                    ?>

                                       <tr class="gradeA">
                                          <td>
                                             <?php
                                             if (empty($ext)) {
                                             ?>
                                                <img src="img/employees/thumbs/<?php echo md5($employee_id) . '.' . $ext; ?>" width="60">
                                             <?php } else { ?>
                                                <img src="img/avatar.png" width="60">
                                             <?php } ?>
                                          </td>
                                          <td><?php echo $fullname; ?></td>
                                          <td><?php echo $design; ?></td>
                                          <td><?php echo $dept_name; ?></td>

                                          <td>
                                             <?php

                                             $query = "SELECT SUM(DATEDIFF(FROM_UNIXTIME(enddate),FROM_UNIXTIME(startdate))) AS days FROM leaves WHERE startdate >= '$first' AND startdate < '$last' AND employee_id='$employee_id' AND status='1'";
                                             $getleaves = mysqli_query($con, $query) or die($query);
                                             $row = mysqli_fetch_array($getleaves);
                                             $days_used = $row["days"];

                                             echo ($annual_leave - $days_used);

                                             ?>
                                          </td>
                                       </tr>
                                    <?php } ?>
                                 </tbody>
                              </table>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
               </div>

            </div>
         </div>


      </div>
   <?php } ?>
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
         oTable.$('td').editable('http://webapplayers.com/example_ajax.php', {
            "callback": function(sValue, y) {
               var aPos = oTable.fnGetPosition(this);
               oTable.fnUpdate(sValue, aPos[0], aPos[1]);
            },
            "submitdata": function(value, settings) {
               return {
                  "row_id": this.parentNode.getAttribute('id'),
                  "column": oTable.fnGetPosition(this)[2]
               };
            },

            "width": "90%"
         });


      });

      function fnClickAddRow() {
         $('#editable').dataTable().fnAddData([
            "Custom row",
            "New row",
            "New row",
            "New row",
            "New row"
         ]);

      }
   </script>
</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/table_data_tables.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:38:48 GMT -->

</html>
<?php 
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login');
}
?>
<!DOCTYPE html>
<html>

<head>
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employees | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
    <?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/employeesprint.php';                     
                                       }else{
          ?>          
                <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-xs-2"><img src="img/sitelogo.<?php echo $logo;  ?>" class="img img-responsive"></div>
                                                      
                                
                            </div>
                 <h1 class="text-center">All Employees</h1>
              <div class="table-responsive m-t">
             <table class="table table-striped table-bordered table-hover ">
                    <thead>
                    <tr>
                       <th>Image</th>
                                              <th>Employee Number</th>
                                            <th>Full Names</th>
                                            <th>Designation</th>
                                            <th>Department</th>
                                            <th>Gender</th>             
                 </tr>
                    </thead>
                    <tbody>
              <?php
                       $employees=  mysqli_query($con,"SELECT * FROM employees WHERE status='1'");
             while ($row = mysqli_fetch_array($employees)) {
                                          $employee_id=$row['employee_id'];
                                           $fullname=$row['fullname'];
                                          $gender=$row['gender'];
                                           $employeenumber=$row['employeenumber'];
                                          $design_id=$row['designation'];
                                            $status=$row['status'];
                                            $ext=$row['ext'];											
                                          $dept2=  mysqli_query($con,"SELECT * FROM designations WHERE designation_id='$design_id'");
                                     $row2=  mysqli_fetch_array($dept2);
                                     $dept_id=$row2['department_id'];
                                    $design=$row2['designation'];
                                    $dept=  mysqli_query($con,"SELECT * FROM departments WHERE department_id='$dept_id'");
                                   $row2 = mysqli_fetch_array($dept);
                                     $dept_name=$row2['department'];
              ?>
               
                    <tr class="gradeA">
                     <td>
                                            <?php 
                                            if(empty($ext)){
                                            ?>
                                                <img src="img/employees/thumbs/<?php echo md5($employee_id).'.'.$ext; ?>" width="60">
                                            <?php }else{?>
                                                <img src="img/avatar.png" width="60">
                                            <?php }?>
                                                       </td>
                                            <td><?php echo $employeenumber; ?></td>
                                            <td><?php echo $fullname; ?></td>
                                            <td><?php echo $design; ?></td>
                                            <td><?php echo $dept_name; ?></td>
                                            <td><?php echo $gender; ?></td> </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 
                 
                            </div><!-- /table-responsive -->
                            
     </div>

    </div>
                                       <?php }?>
    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>

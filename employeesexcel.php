<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login');
} else {

   $delimiter = ",";

   $filename = "Employees.csv";

   $f = fopen('php://memory', 'w');

   $fields = array('Employee Number', 'Full Names', 'Designation', 'Department', 'Gender');

   fputcsv($f, $fields, $delimiter);

   $employees =  mysqli_query($con, "SELECT * FROM employees WHERE status='1'");
   while ($row = mysqli_fetch_array($employees)) {
      $employee_id = $row['employee_id'];
      $fullname = $row['fullname'];
      $gender = $row['gender'];
      $employeenumber = $row['employeenumber'];
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
      $lineData = array($employeenumber, $fullname, $design, $dept_name, $gender);

      fputcsv($f, $lineData, $delimiter);
   }

   fseek($f, 0);

   header('Content-Type: text/xls');

   header('Content-Disposition: attachment; filename="' . $filename . '";');

   fpassthru($f);
}

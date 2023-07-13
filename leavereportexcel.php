<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login');
} else {
   $st = $_GET['st'];
   $en = $_GET['en'];

   $delimiter = ",";

   $filename = "Leaves report from " . date('d/m/Y', $st) . " to " . date('d/m/Y', $en) . ".csv";

   $f = fopen('php://memory', 'w');

   fwrite($f, "sep=,\n");
   $fields = [
      'Employee No',
      'Employee',
      'Designation',
      'Date of Request',
      'Start Date',
      'End Date / Return Date',
   ];

   fputcsv($f, $fields, $delimiter, chr(0));

   $leaves = mysqli_query($con, "SELECT * FROM leaves  WHERE status='1'  AND  timestamp>='$st' AND timestamp<='$en' ") or die(mysqli_error($con));
   while ($row =  mysqli_fetch_array($leaves)) {
      $leave_id = $row['leave_id'];

      $startdate = $row['startdate'];
      $enddate = $row['enddate'];
      $returndate = $row['returndate'];
      $employee_id = $row['employee_id'];
      $creator = $row['creator'];
      $timestamp = $row['timestamp'];
      $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$employee_id'");
      $row1 = mysqli_fetch_array($employee);
      $fullname = $row1['fullname'];
      $design_id = $row1['designation'];
      $employeenumber = $row1['employeenumber'];
      $dept2 =  mysqli_query($con, "SELECT * FROM designations WHERE designation_id='$design_id'");
      $row2 =  mysqli_fetch_array($dept2);
      $dept_id = $row2['department_id'];
      $design = $row2['designation'];
      $dept_id = $row2['department_id'];
      $dept =  mysqli_query($con, "SELECT * FROM departments WHERE department_id='$dept_id'");
      $row2 = mysqli_fetch_array($dept);
      $dept_name = $row2['department'];

      $lineData = [
         $employeenumber,
         $fullname,
         $design . '(' . $dept_name . ')',
         date('d/m/Y', $timestamp),
         date('d/m/Y', $startdate),
         (!empty($returndate)) ? date('d/m/Y', $returndate) : date('d/m/Y', $enddate),
      ];

      fputcsv($f, $lineData, $delimiter, chr(0));
   }

   fseek($f, 0);

   header('Content-Type: text/xls');

   header('Content-Disposition: attachment; filename="' . $filename . '";');

   fpassthru($f);
}

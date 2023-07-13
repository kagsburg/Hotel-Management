<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
  header('Location:login');
}
$st = $_GET['st'];
$en = $_GET['en'];

?>
<!DOCTYPE html>
<html>

<head>
  <style type="text/css" media="print">
    @page {
      size: auto;
      /* auto is the initial value */
      margin: 0;
      /* this affects the margin in the printer settings */
    }
  </style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Leave Report | Hotel Manager</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

  <link href="css/animate.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
  <?php
  if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
    include 'fr/leavereportprint.php';
  } else {
  ?>
    <div class="wrapper wrapper-content p-xl">
      <div class="ibox-content p-xl">
        <div class="row">
          <div class="col-xs-2"><img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive"></div>


        </div>
        <h1 class="text-center">Leave Report between <?php echo date('d/m/Y', $st); ?> and <?php echo date('d/m/Y', $en); ?></h1>


        <div class="table-responsive m-t">
          <?php
          $leaves = mysqli_query($con, "SELECT * FROM leaves  WHERE status='1'  AND  timestamp>='$st' AND timestamp<='$en' ") or die(mysqli_error($con));
          ?>
          <table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Employee No</th>
                <th>Employee</th>
                <th>Designation</th>
                <th>Date of Request</th>
                <th>Start Date</th>
                <th>End Date / Return Date</th>
              </tr>
            </thead>
            <tbody>
              <?php
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
              ?>
                <tr class="gradeA">
                  <td><?php echo $employeenumber; ?></td>
                  <td><?php echo $fullname; ?></td>
                  <td><?php echo $design . '(' . $dept_name . ')'; ?></td>
                  <td><?php echo date('d/m/Y', $timestamp); ?></td>
                  <td><?php echo date('d/m/Y', $startdate); ?></td>
                  <td>
                    <?php if (!empty($returndate)) {
                      echo date('d/m/Y', $returndate);
                    } else {
                      echo date('d/m/Y', $enddate);
                    } ?>
                  </td>

                </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php
          $name =  mysqli_query($con, "SELECT * FROM users WHERE user_id='" . $_SESSION['hotelsys'] . "'");
          $row =  mysqli_fetch_array($name);
          $employee = $row['employee'];
          $getemployee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$employee'");
          $roww = mysqli_fetch_array($getemployee);
          $fullname = $roww['fullname'];
          ?>
          <table class="table invoice-total">
            <tbody>
              <tr>
                <td style="padding-bottom: 50px;"><strong>Created by <?php echo $fullname; ?></strong></td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    <?php } ?>
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
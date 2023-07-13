<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login.php');
}
$id = $_GET['id'];
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details | Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
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
                        <h2>Profile</h2>
                        <ol class="breadcrumb">
                            <li>
                                <a href="">Home</a>
                            </li>
                            <li>
                                <a>Employees</a>
                            </li>

                            <li class="active">
                                <strong>View Employees</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content">
                    <div class="row animated fadeInRight">
                        <div class="col-md-4">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <?php
                                    $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$id'");

                                    $row = mysqli_fetch_array($employee);
                                    $employee_id = $row['employee_id'];
                                    $fullname = $row['fullname'];
                                    $gender = $row['gender'];
                                    $design_id = $row['designation'];
                                    $status = $row['status'];
                                    $employeenumber = $row['employeenumber'];
                                    $address = $row['address'];
                                    $ext = $row['ext'];
                                    $dob = $row['dob'];
                                    $email = $row['email'];
                                    $phone = $row['phone'];
                                    $salary = $row['salary'];
                                    $startdate = $row['start_date'];
                                    $enddate = $row['end_date'];
                                    $dept2 =  mysqli_query($con, "SELECT * FROM designations WHERE designation_id='$design_id'");
                                    $row2 =  mysqli_fetch_array($dept2);
                                    $dept_id = $row2['department_id'];
                                    $design = $row2['designation'];
                                    $dept =  mysqli_query($con, "SELECT * FROM departments WHERE department_id='$dept_id'");
                                    $row2 = mysqli_fetch_array($dept);
                                    $dept_name = $row2['department'];
                                    ?>
                                    <h3><?php echo $fullname; ?></h3>
                                </div>
                                <div>
                                    <div class="ibox-content no-padding border-left-right" style="">
                                        <img alt="image" class="img-responsive" src="img/employees/<?php echo md5($employee_id) . '.' . $ext; ?>" width="100%">
                                    </div>
                                    <div class="ibox-content profile-content">
                                        <h4><strong>
                                                <?php echo $design;   ?></strong></h4>

                                        <div class="user-button">
                                            <div class="row">

                                                <div class="col-md-7">
                                                    <a data-toggle="modal" class="btn btn-primary btn-sm" href="#modal-form"><i class="fa fa-edit"></i> Change Profile Picture</a>
                                                    <?php if ($employee_id == $_SESSION["emp_id"] || $_SESSION["hotelsyslevel"] == 1) { ?>
                                                        <br><br>
                                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#passwordModal">Change Password</button>
                                                    <?php } ?>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Employee Information</h5>

                                </div>
                                <div class="ibox-content">

                                    <div>
                                        <div class="feed-activity-list">
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Employee number</strong> : <?php echo $employeenumber; ?>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Designation</strong> : <?php echo $design; ?>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Department</strong> : <?php echo $dept_name; ?>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Gender</strong> : <?php echo $gender; ?>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Address</strong> : <?php echo $address; ?>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Contact Number</strong> : <?php echo $phone; ?>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Email</strong> : <?php echo $email; ?>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Date of Birth</strong> : <?php if (!empty($dob)) {
                                                                                            echo date('d/m/Y', $dob);
                                                                                        } ?>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Contract Start Date</strong> : <?php if (!empty($startdate)) {
                                                                                                echo date('d/m/Y', $startdate);
                                                                                            } ?>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Contract End Date</strong> : <?php if (!empty($enddate)) {
                                                                                                echo date('d/m/Y', $enddate);
                                                                                            } ?>
                                                </div>
                                            </div>
                                            <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Salary</strong> : <?php echo $salary; ?>
                                                </div>
                                            </div>



                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div id="modal-form" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="m-t-none m-b">Upload picture</h3>
                                <form role="form" method="POST" action="changeuserpic?id=<?php echo $id; ?>&&ext=<?php echo $ext; ?>" enctype="multipart/form-data">
                                    <div class="form-group"><input type="file" style="Padding:0px" name="image" required="required" class="form-control"></div>
                                    <div>
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Change picture</strong></button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="passwordModal" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="m-t-none m-b">Change password</h3>
                                <form role="form" method="POST" action="changeuserpass?id=<?php echo $id; ?>">
                                    <div class="form-group col-sm-12"><label class="control-label">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Enter  password">
                                        <div id='form_password_errorloc' class='text-danger'></div>
                                    </div>
                                    <div class="form-group col-sm-12"><label class="control-label">Repeat Password</label>
                                        <input type="password" name="repeat" class="form-control" placeholder="Repeat password">
                                        <div id='form_repeat_errorloc' class='text-danger'></div>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Change password</strong></button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>

    <!-- Peity -->
    <script src="js/demo/peity-demo.js"></script>

</body>

</html>
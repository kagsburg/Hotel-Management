<?php
include 'includes/conn.php';
if ((!isset($_SESSION['hotelsys'])) || ($_SESSION['hotelsyslevel'] != 1)) {
    header('Location:login');
}
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add User - Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/addemployee.php';
    } else {
    ?>

        <div id="wrapper">

            <?php
            include 'nav.php';
            ?>

            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
                            <li><a href="switchlanguage?lan=en">English</a> </li>
                        </ul>

                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Add New Employee</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="employees">Employees</a> </li>
                            <li class="active">
                                <strong>Add Employee</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Add New Employee <small>All fields marked (*) shouldn't be left blank</small></h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if (isset($_POST['fullname'], $_POST['gender'], $_POST['phone'], $_FILES['image'], $_POST['designation'], $_POST['email'], $_POST['salary'], $_POST['joining'])) {
                                        
                                        $fullname = mysqli_real_escape_string($con, trim($_POST['fullname']));
                                        $employeenumber = mysqli_real_escape_string($con, trim($_POST['employeenumber']));
                                        $joining = mysqli_real_escape_string($con,  strtotime(str_replace('/', '-', $_POST['joining'])));
                                        $ending = mysqli_real_escape_string($con,  strtotime(str_replace('/', '-', $_POST['ending'])));
                                        $dob = mysqli_real_escape_string($con,  strtotime(str_replace('/', '-', $_POST['dob'])));
                                        $phone = mysqli_real_escape_string($con, trim($_POST['phone']));
                                        $address = mysqli_real_escape_string($con, trim($_POST['address']));
                                        $email = mysqli_real_escape_string($con, trim($_POST['email']));
                                        $salary = mysqli_real_escape_string($con, trim($_POST['salary']));
                                        $gender = $_POST['gender'];
                                        $job = explode('-', $_POST['designation']);
                                        $designation =  current($job);
                                        $department = end($job);
                                        $username = mysqli_real_escape_string($con, trim($_POST['username']));
                                        $password = mysqli_real_escape_string($con, trim($_POST['password']));
                                        $role = $_POST['role'];
                                        if ($role == 'manager' || $role == 'director') {
                                            $status = 1;
                                        } else {
                                            $status = 0;
                                        }
                                        $check = mysqli_query($con, "SELECT * FROM employees WHERE email='$email' AND status='1'");
                                        
                                        $hasImage = false;
                                        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
                                            $hasImage = true;
                                            $image_name = $_FILES['image']['name'];
                                            $image_size = $_FILES['image']['size'];
                                            $image_temp = $_FILES['image']['tmp_name'];
                                            $allowed_ext = array('jpg', 'jpeg', 'png', 'PNG', 'gif', '');
                                            $imgext = explode('.', strtolower($image_name));
                                            $image_ext = end($imgext);
                                            if (in_array($image_ext, $allowed_ext) === false) {
                                                $errors[] = 'Image File type not allowed';
                                            }
                                            if ($image_size > 2097152) {
                                                $errors[] = 'Maximum Image size is 2Mb';
                                            }
                                        }
                                        if (mysqli_num_rows($check) > 0) {
                                            $errors[] = 'Email Already Exists';
                                        }
                                        if (!empty($errors)) {
                                            foreach ($errors as $error) {
                                    ?>
                                                <div class="alert alert-danger"><?php echo $error; ?></div>
                                    <?php
                                            }
                                        } else {

                                            include 'includes/thumbs3.php';
                                            $addemployee =  mysqli_query($con, "INSERT INTO employees(fullname,gender,employeenumber,address,phone,email,ext,designation,salary,dob,start_date,end_date,status) VALUES('$fullname','$gender','$employeenumber','$address','$phone','$email','$image_ext','$designation','$salary','$dob','$joining','$ending','1')") or die(mysqli_error($con));
                                            $last_id =  mysqli_insert_id($con);
                                            if ($hasImage) {
                                                $image_file =  md5($last_id) . '.' . $image_ext;
                                                move_uploaded_file($image_temp, 'img/employees/' . $image_file) or die(mysqli_errno($con));
                                                create_thumb('img/employees/', $image_file, 'img/employees/thumbs/');
                                            }
                                            if (!empty($role)) {
                                                mysqli_query($con, "INSERT INTO users(employee,username,password,role,level,status) VALUES('$last_id','$username','" . md5($password) . "','$role','$status','1')") or die(mysqli_error($con));
                                            }
                                            echo '<div class="alert alert-success">Employee Data succesfully Added</div>';
                                        }
                                    }

                                    ?>

                                    <form method="post" name='form' class="form" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="form-group col-sm-6"><label class="control-label">Employee number</label>

                                                <input type="text" name='employeenumber' class="form-control" placeholder="Enter Number">
                                            </div>
                                            <div class="form-group col-sm-6"><label class="control-label">* Fullname</label>

                                                <input type="text" name='fullname' class="form-control" placeholder="Enter fullname" required="required">
                                            </div>

                                            <div class="form-group col-sm-6"><label class="control-label">* Gender</label>
                                                <select name="gender" class="form-control">
                                                    <option value="">select gender...</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>


                                            <div class="form-group col-sm-6"><label class="control-label">*Phone</label>
                                                <input type="text" name="phone" class="form-control" placeholder="Enter  phone Number" required="required">
                                            </div>

                                            <div class="form-group col-sm-6"><label class="control-label">* Salary</label>
                                                <input type="text" name="salary" class="form-control" placeholder="Enter  Employee Salary" required="required">
                                            </div>

                                            <div class="form-group col-sm-6" id="data_1">
                                                <label class="control-label">Date of Birth</label>

                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="dob" placeholder="Enter Date of Birth" required="required">
                                                </div>

                                            </div>

                                            <div class="form-group col-sm-6"><label class="control-label">*Designation (Department)</label>

                                                <select class="form-control" name="designation">
                                                    <option value="" selected="selected">Select Designation....</option>
                                                    <?php

                                                    $dept2 =  mysqli_query($con, "SELECT * FROM designations WHERE status=1");
                                                    if (mysqli_num_rows($dept2) > 0) {
                                                        while ($row2 =  mysqli_fetch_array($dept2)) {
                                                            $design_id = $row2['designation_id'];
                                                            $dept_id = $row2['department_id'];
                                                            $design = $row2['designation'];
                                                            $status2 = $row2['status'];
                                                            $dept =  mysqli_query($con, "SELECT * FROM departments WHERE department_id='$dept_id' AND status=1");
                                                            if (mysqli_num_rows($dept) > 0) {
                                                                $row = mysqli_fetch_array($dept);
                                                                $dept_name = $row['department'];
                                                    ?>
                                                            <option value="<?php echo $design_id . '-' . $dept_id; ?>"> <?php echo $design . ' (' . $dept_name . ')'; ?></option>
                                                    <?php }
                                                    }
                                                    } ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-sm-6"><label class="control-label">* Residence Address</label>
                                                <input type="text" name="address" class="form-control" placeholder="Enter Address" required="required">
                                            </div>
                                            <div class="form-group col-sm-6" id="data_1">
                                                <label class="control-label">Contract Start Date</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="joining" placeholder="Enter Joining Date" required="required">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6" id="data_1">
                                                <label class="control-label">Contract End Date</label>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ending" placeholder="Enter Ending Date" required="required">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6"><label class="control-label"> Profile picture</label>
                                                <input type="file" name="image" class="form-control " style="padding: 0px">
                                            </div>
                                            <div class="form-group col-sm-6"><label class="control-label"> Email Address</label>
                                                <input type="email" name="email" class="form-control " placeholder="Enter a valid email address">
                                                <div id='form_email_errorloc' class='text-danger'></div>

                                            </div>

                                        </div>
                                        <h4>Fill This section if Employee should Access the System</h4>
                                        <div class="row">
                                            <div class="form-group col-sm-6"><label class="control-label">Username</label>

                                                <input type="text" name="username" class="form-control" placeholder="Enter your username">
                                            </div>
                                            <div class="form-group col-sm-6"><label class="control-label">Password</label>
                                                <input type="password" name="password" class="form-control" placeholder="Enter  your password">
                                                <div id='form_password_errorloc' class='text-danger'></div>
                                            </div>
                                            <div class="form-group col-sm-6"><label class="control-label">Repeat Password</label>
                                                <input type="password" name="repeat" class="form-control" placeholder="Repeat your password">
                                                <div id='form_repeat_errorloc' class='text-danger'></div>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label class="control-label">Select Role</label>

                                                <select data-placeholder="Choose a role..." class="form-control" name='role'>
                                                    <option value="" selected="selected">Assign Role</option>
                                                    <option value="manager">Manager</option>
                                                    <option value="director">Managing Director</option>
                                                    <!--<option value="Bar attendant">Bar Attendant</option>-->
                                                    <option value="Store Attendant">Store Attendant</option>
                                                    <option value="Receptionist">Receptionist</option>
                                                    <option value="Hall Attendant">Hall Attendant</option>
                                                    <option value="Laundry Attendant">Laundry Attendant</option>
                                                    <option value="Restaurant Attendant">Restaurant Attendant</option>
                                                    <option value="Accountant">Accountant</option>
                                                    <option value="Pool Attendant">Gym and Swimming Pool Attendant</option>
                                                    <option value="Small Stock Attendant">Small Stock Attendant</option>
                                                    <option value="Kitchen Exploitation Officer">Kitchen Exploitation Officer</option>
                                                    <option value="Marketing and Events">Marketing and Events</option>
                                                </select>

                                            </div>

                                        </div>
                                        <div class="form-group">

                                            <button class="btn btn-primary" type="submit">Add Employee</button>

                                        </div>
                                    </form>
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
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/chosen/chosen.jquery.js"></script>
    <!-- iCheck -->
    <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>

</html>
<script type="text/javascript">
    $(document).ready(function() {
        $('#data_1 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: "dd/mm/yyyy",
        });
    });
</script>
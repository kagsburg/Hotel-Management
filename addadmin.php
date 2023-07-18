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

</head>

<body>

    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/addadmin.php';
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
                        
                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Add New Admin</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="admins">Admins</a> </li>
                            <li class="active">
                                <strong>Add Admin</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Add New Admin <small> All fields marked (*) shouldn't be left blank</small></h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if (isset($_POST['employee'], $_POST['username'], $_POST['password'], $_POST['role'])) {

                                        $employee = $_POST['employee'];
                                        $username = mysqli_real_escape_string($con, trim($_POST['username']));
                                        $password = mysqli_real_escape_string($con, trim($_POST['password']));
                                        $role = $_POST['role'];
                                        if ($role == 'manager') {
                                            $status = 1;
                                        } else {
                                            $status = 0;
                                        }
                                        if ((empty($employee)) || (empty($username)) || (empty($password)) || (empty($role))) {
                                            $errors[] = 'All Fields marked * should be filled';
                                        }

                                        if (!empty($errors)) {
                                            foreach ($errors as $error) {
                                    ?>
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-10">
                                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            mysqli_query($con, "INSERT INTO users(employee,username,password,role,level,status) VALUES('$employee','$username','" . md5($password) . "','$role','$status','1')") or die(mysqli_error($con));
                                            ?>

                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-10">
                                                <div class="alert alert-success"><i class="fa fa-check"></i> Admin successfully Added</div>
                                            </div>
                                    <?php

                                        }
                                    }
                                    ?>

                                    <form method="post" name='form' class="form-horizontal" action="" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">* Select Employee</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name='employee'>
                                                    <option value="" selected="selected">Select Employee</option>
                                                    <?php
                                                    $employees =  mysqli_query($con, "SELECT * FROM employees WHERE status='1'");
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
                                                    ?>
                                                        <option value="<?php echo $employee_id; ?>"><?php echo $fullname . '(' . $design . ')'; ?></option>
                                                    <?php } ?>
                                                </select>

                                            </div>

                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group"><label class="col-sm-2 control-label">* Username</label>

                                            <div class="col-sm-10"><input type="text" name="username" class="form-control" placeholder="Enter your username" required="required">
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group"><label class="col-sm-2 control-label">*Password</label>

                                            <div class="col-sm-10"><input type="password" name="password" class="form-control" placeholder="Enter  your password" required="required">
                                                <div id='form_password_errorloc' class='text-danger'></div>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                        <div class="form-group"><label class="col-sm-2 control-label"> *Repeat Password</label>

                                            <div class="col-sm-10"><input type="password" name="repeat" class="form-control" placeholder="Repeat your password" required="required">
                                                <div id='form_repeat_errorloc' class='text-danger'></div>
                                            </div>
                                        </div>

                                        <div class="hr-line-dashed"></div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">* Select Role</label>
                                            <div class="col-sm-10" style="">
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
                                                    <option value="Housekeeping and Maintenance">Housekeeping and Maintenance</option>
                                                </select>

                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2">
                                                <button class="btn btn-primary" type="submit">Add Admin</button>
                                            </div>
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

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/chosen/chosen.jquery.js"></script>
    <!-- iCheck -->
    <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>

</html>
<script type="text/javascript">
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {
            allow_single_deselect: true
        },
        '.chosen-select-no-single': {
            disable_search_threshold: 10
        },
        '.chosen-select-no-results': {
            no_results_text: 'Oops, nothing found!'
        },
        '.chosen-select-width': {
            width: "95%"
        }
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

    var frmvalidator = new Validator("form");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();
    frmvalidator.addValidation("password", "minlength=6", "*password  should atleast be 6 characters");
    frmvalidator.addValidation("repeat", "eqelmnt=password", "*The passwords dont match");
</script>
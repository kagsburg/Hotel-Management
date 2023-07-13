<?php
include 'includes/conn.php';
if ((!isset($_SESSION['hotelsys'])) || ($_SESSION['hotelsyslevel'] != 1)) {
    header('Location:login');
}
$id = $_GET['id'];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit User - Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

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
                    <h2>Add New User</h2>
                    <ol class="breadcrumb">
                        <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>
                        <li> <a href="admins">Admins</a> </li>
                        <li class="active">
                            <strong>Edit Admin</strong>
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
                                <h5>Edit Admin Details <small>All fields marked (*) shouldn't be left blank</small></h5>

                            </div>
                            <div class="ibox-content">
                                <?php
                                if (isset($_POST['fullname'], $_POST['email'], $_POST['role'])) {
                                    $fullname = mysqli_real_escape_string($con, trim($_POST['fullname']));
                                    $email = mysqli_real_escape_string($con, trim($_POST['email']));
                                    $role = $_POST['role'];
                                    if ($role == 'manager') {
                                        $status = 1;
                                    } else {
                                        $status = 0;
                                    }
                                    if ((empty($fullname)) || (empty($email)) || (empty($role))) {
                                        $errors[] = 'All Fields marked *  should be filled';
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
                                        mysqli_query($con, "UPDATE  users SET fullname='$fullname',email='$email',role='$role',status='$status' WHERE user_id='$id' ") or die(mysql_error());

                                        ?>

                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-10">
                                            <div class="alert alert-success"><i class="fa fa-check"></i> Admin Details Successfully Edited</div>
                                        </div>
                                <?php

                                    }
                                }
                                $user = mysqli_query($con, "SELECT * FROM users WHERE user_id='$id'");
                                $row =  mysqli_fetch_array($user);
                                $fullname1 = $row['fullname'];
                                $email1 = $row['email'];
                                $role1 = $row['role'];
                                ?>

                                <form method="post" name='form' class="form-horizontal" action="" enctype="multipart/form-data">
                                    <div class="form-group"><label class="col-sm-2 control-label">* Fullname</label>

                                        <div class="col-sm-10"><input type="text" name='fullname' value="<?php echo $fullname1; ?>" class="form-control" placeholder="Enter fullname" required="required">
                                        </div>
                                    </div>

                                    <div class="form-group"><label class="col-sm-2 control-label"> *Email Address</label>

                                        <div class="col-sm-10"><input type="email" name="email" value="<?php echo $email1; ?>" class="form-control " placeholder="Enter a valid email address" required="required">
                                            <div id='form_email_errorloc' class='text-danger'></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">* Select Role</label>
                                        <div class="col-sm-10">

                                            <select data-placeholder="Choose a role..." class="form-control" name='role'>
                                                <option value="<?php echo $role1; ?>"><?php echo $role1; ?></option>
                                                <option value="manager">Manager</option>
                                                <option value="bar attendant">Bar Attendant</option>
                                                <option value="Store Attendant">Store Attendant</option>
                                                <option value="Receptionist">Receptionist</option>
                                                <option value="Laundry Attendant">Laundry Attendant</option>
                                                <option value="Restaurant Attendant">Restaurant Attendant</option>
                                                <option value="Accountant">Accountant</option>
                                                <option value="Kitchen Exploitation Officer">Kitchen Exploitation Officer</option>
                                                <option value="Marketing and Events">Marketing and Events</option>
                                            </select>

                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-4 col-sm-offset-2">
                                            <button class="btn btn-primary" type="submit">Edit User</button>
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
</script>
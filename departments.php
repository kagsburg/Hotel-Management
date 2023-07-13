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

    <title>Hotel Departments - Hotel Manager</title>
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
        include 'fr/departments.php';
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

                            <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
                            <li><a href="switchlanguage?lan=en">English</a> </li>
                        </ul>

                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Departments</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a>Departments</a> </li>
                            <li class="active">
                                <strong>Departments</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>
                <div class="wrapper wrapper-content">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Add New Department<small> All fields marked (*) shouldn't be left blank</small></h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if (isset($_POST['department'])) {
                                        $dept = mysqli_real_escape_string($con, trim($_POST['department']));
                                        if (empty($dept)) {
                                            echo '<div class="alert alert-danger">Enter Department To Continue</div>';
                                        } else {
                                            mysqli_query($con, "INSERT INTO departments(department,status) VALUES('$dept','1')");
                                    ?>

                                            <div class="alert alert-success"><i class="fa fa-check"></i>Department Successfully Added</div>
                                    <?php

                                        }
                                    }
                                    ?>

                                    <form method="post" name='form' class="form-horizontal" action="" enctype="multipart/form-data">
                                        <div class="form-group"><label class="col-sm-2 control-label">Department</label>

                                            <div class="col-sm-10"><input type="text" name='department' class="form-control" placeholder="Enter department" required="required">
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>


                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-2">

                                                <button class="btn btn-primary" type="submit">Add Department</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Hotel Departments</h5>

                                </div>
                                <div class="ibox-content">
                                    <div class="panel-body">
                                        <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Designations</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $depts =  mysqli_query($con, "SELECT * FROM departments WHERE status=1");
                                                while ($row = mysqli_fetch_array($depts)) {
                                                    $dept_id = $row['department_id'];
                                                    $dept = $row['department'];
                                                    $status = $row['status'];
                                                    $getdesignations = mysqli_query($con, "SELECT * FROM designations WHERE department_id='$dept_id' AND status=1");
                                                ?>
                                                    <tr>
                                                        <td><?php echo $dept; ?></td>
                                                        <td><?php echo mysqli_num_rows($getdesignations); ?></td>
                                                        <td>
                                                            <button data-toggle="modal" data-target="#basicModal<?php echo $dept_id; ?>" class="btn btn-xs btn-info">Edit</button>
                                                            <a href="removedepartment?id=<?php echo $dept_id; ?>" class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $dept_id; ?>()">Remove</a>
                                                            <script type="text/javascript">
                                                                function confirm_delete<?php echo $dept_id; ?>() {
                                                                    return confirm('You are about To Remove this item. Are you sure you want to proceed?');
                                                                }
                                                            </script>
                                                            <a href="designations?id=<?php echo $dept_id; ?>" class="btn btn-xs btn-success">Designations</a>
                                                        </td>
                                                    </tr>

                                                <?php } ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
        <?php
        $depts =  mysqli_query($con, "SELECT * FROM departments WHERE status=1");
        while ($row = mysqli_fetch_array($depts)) {
            $dept_id = $row['department_id'];
            $dept = $row['department'];
            $status = $row['status'];
        ?>
            <div id="basicModal<?php echo $dept_id; ?>" class="modal fade" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form action="editdepartment?id=<?php echo $dept_id; ?>" method="POST">
                                <div class="form-group">
                                    <label>Department</label>
                                    <input type="text" name='department' class="form-control" placeholder="Enter department" required="required" value="<?php echo $dept; ?>">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
    <?php }
    } ?>
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
    frmvalidator.addValidation("email", "email", "*Enter a valid  email address");
    frmvalidator.addValidation("password", "minlength=6", "*password  should atleast be 6 characters");
    frmvalidator.addValidation("repeat", "eqelmnt=password", "*The passwords dont match");
</script>
<?php
include 'includes/conn.php';

if (!isset($_SESSION['hotelsys'])) {
    header('Location:login.php');
}

?>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Sponsors  | Hotel Manager</title>
    <script src="ckeditor/ckeditor.js"></script>
    <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">



    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">



    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">


    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">


    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/poolpackages.php';
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
                        <h2>Sponsors & Organisations</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li class="active">
                                <strong>Sponsors & Organisations</strong>
                            </li>
                        </ol>
                    </div>

                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">

                                    <h5>Add Organisation <small>Ensure to fill all necessary fields</small></h5>

                                </div>
                                <div class="ibox-content">
                                    <?php
                                    if (isset($_POST['comname'], $_POST['location'], $_POST["contact"])) {
                                        $package =  mysqli_real_escape_string($con, trim($_POST['comname']));
                                        $charge =  mysqli_real_escape_string($con, trim($_POST['location']));
                                        $contact =  mysqli_real_escape_string($con, trim($_POST['contact']));
                                        $days =  mysqli_real_escape_string($con, trim($_POST['email']));
                                        $checkcompany = mysqli_query($con, "SELECT * FROM sponsors WHERE company_name='$package'") or die(mysqli_error($con));
                                        if (mysqli_num_rows($checkcompany) > 0) {
                                            echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Organisation Already Exists</div>';
                                        } else{
                                        if ((empty($package) || (empty($charge)))) {
                                            echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                                        } else {
                                            mysqli_query($con, "INSERT INTO sponsors(company_name ,company_location,company_email,company_contact,creator,timestamp,status) 
                                            VALUES('$package','$charge','$days','$contact','" . $_SESSION['emp_id'] . "',UNIX_TIMESTAMP(),'1')") or die(mysqli_error($con));

                                            echo '<div class="alert alert-success"><i class="fa fa-check"></i>Organisation successfully added</div>';
                                        }
                                    }
                                    }
                                    ?>
                                    <form method="post" class="form" action="" name="form" enctype="multipart/form-data">
                                        <div class="form-group"><label class="control-label">Organisation Name</label>
                                            <input type="text" class="form-control" name='comname' placeholder="Enter Name" required='required'>
                                        </div>

                                        <div class="form-group"><label class="control-label">Organisation Location</label>
                                            <input type="text" class="form-control" name="location" placeholder="Enter Location " required='required'>
                                        </div>

                                        <div class="form-group"><label class="control-label">Organisation Contact</label>
                                            <input type="text" class="form-control" name='contact' placeholder="Enter  Contact" required='required'>
                                        </div>
                                        <div class="form-group"><label class="control-label">Organisation Email</label>
                                            <input type="email" class="form-control" name='email' placeholder="Enter  Email" required='required'>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-success btn-sm" name="submit" type="submit">Add Organisation</button>
                                        </div>
                                    </form>


                                </div>


                            </div>

                        </div>
                        <div class="col-lg-7">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">

                                    <h5>Organisations</h5>

                                </div>
                                <div class="ibox-content">
                                    <table class="table table-striped  table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Location</th>
                                                <th>Contact</th>
                                                <th>&nbsp;</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr> <?php
                                                    $getpackages = mysqli_query($con, "SELECT * FROM sponsors WHERE status='1'");
                                                    if (mysqli_num_rows($getpackages) > 0) {
                                                        while ($row = mysqli_fetch_array($getpackages)) {
                                                            $poolpackage_id = $row['sponsor_id'];
                                                            $company_name = $row['company_name'];
                                                            $company_location = $row['company_location'];
                                                            $company_email = $row['company_email'];
                                                            $company_contact = $row['company_contact'];
                                                            $status = $row['status'];
                                                    ?>

                                            <tr>
                                                <td><?php echo $company_name; ?></td>
                                                <td><?php echo $company_location; ?></td>
                                                <td><?php echo $company_contact; ?></td>

                                                <td>
                                                    <?php
                                                            if (($_SESSION['hotelsyslevel'] == 1)) {
                                                    ?>
                                                        <a data-toggle="modal" class="btn btn-info btn-xs" href="#modal-form<?php echo $poolpackage_id; ?>"><i class="fa fa-edit"></i> Edit</a>

                                                        <a href="hidesponsor?id=<?php echo $poolpackage_id; ?>" onclick="return cdelete<?php echo $poolpackage_id; ?>()" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Remove</a>
                                                        <script type="text/javascript">
                                                            function cdelete<?php echo $poolpackage_id; ?>() {
                                                                return confirm('You are about To Delete a Organisation. Do you want to proceed?');
                                                            }
                                                        </script>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                    <?php
                                                        }
                                                    } else {
                                                        echo "<div class='alert alert-danger'>No Organisations Added Yet</div>";
                                                    }
                                    ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
        </div>
        <?php
        $getpackages = mysqli_query($con, "SELECT * FROM sponsors WHERE status='1'");
        while ($row = mysqli_fetch_array($getpackages)) {
            $poolpackage_id = $row['sponsor_id'];
            $company_name = $row['company_name'];
            $company_location = $row['company_location'];
            $company_email = $row['company_email'];
            $company_contact = $row['company_contact'];
            $status = $row['status'];
        ?>
            <div id="modal-form<?php echo $poolpackage_id; ?>" class="modal fade" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form method="post" class="form" action="editsponsor?id=<?php echo $poolpackage_id; ?>" name="form" enctype="multipart/form-data">
                            
                                <div class="form-group"><label class="control-label">Organisation Name</label>
                                    <input type="text" class="form-control" name='name_update' placeholder="Enter Bouquet" required='required' value="<?php echo $company_name; ?>">
                                </div>
                                <div class="form-group"><label class="control-label">Organisation Location</label>
                                    <input type="text" class="form-control" name='location_update' placeholder="Enter location" required='required' value="<?php echo $company_location; ?>">
                                </div>

                                <div class="form-group"><label class="control-label">Organisation Contact</label>
                                    <input type="number" class="form-control" name="contact_update" placeholder="Enter Days " required='required' value="<?php echo $company_contact; ?>">
                                </div>
                                <div class="form-group"><label class="control-label">Organisation Email</label>
                                            <input type="email" class="form-control" name='email_update' placeholder="Enter  Email" required='required' value="<?php echo $company_email; ?>">
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-success btn-sm" name="submit" type="submit">Edit Organisation</button>
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

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Chosen -->
    <script src="js/plugins/chosen/chosen.jquery.js"></script>

    <!-- Input Mask-->
    <!--<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>-->

    <!-- Data picker -->
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>


    <!-- iCheck -->
    <!--<script src="js/plugins/iCheck/icheck.min.js"></script>-->

    <!-- MENU -->
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>



</body>


</html>
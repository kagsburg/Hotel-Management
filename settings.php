<?php
include 'includes/conn.php';
if ((!isset($_SESSION['hotelsys'])) || ($_SESSION['hotelsyslevel'] != 1)) {
    header('Location:login.php');
}
?>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Settings | Hotel Manager</title>
    <!--<script src="ckeditor/ckeditor.js"></script>-->
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
        include 'fr/settings.php';
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
                        <h2>Settings</h2>
                        <ol class="breadcrumb">
                            <li> <a href="index"><i class="fa fa-home"></i> Home</a> </li>

                            <li class="active">
                                <strong>Settings</strong>
                            </li>
                        </ol>
                    </div>

                </div>
                <div class="wrapper wrapper-content animated fadeInRight">
                    <?php
                    $getsettings = mysqli_query($con, "SELECT * FROM settings");
                    if (mysqli_num_rows($getsettings) == 0) {
                    ?>
                        <a data-toggle="modal" class="btn btn-primary btn-sm" href="#modal-form"><i class="fa fa-edit"></i>Add Settings</a>
                    <?php } else { ?>
                        <a data-toggle="modal" class="btn btn-primary btn-sm" href="#edit-form"><i class="fa fa-edit"></i>Edit Settings</a>
                    <?php } ?>
                    <div class="row">

                        <div class="col-lg-7">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">

                                    <h5>Settings</h5>

                                </div>
                                <div class="ibox-content">
                                    <table class="table table-striped  table-hover">
                                        <tbody>

                                            <?php
                                            $row = mysqli_fetch_array($getsettings);
                                            $hotelname = $row['hotelname'];
                                            $nif = $row['nif'];
                                            $hoteladdress = $row['hoteladdress'];
                                            $corporatename = $row['corporatename'];
                                            $hotelcontacts =  $row['hotelcontacts'];
                                            $hotelemail =  $row['hotelemail'];
                                            $hotelmanager = $row['hotelmanager'];
                                            $annual_leave = $row['annual_leave'];
                                            $logo = $row['logo'];
                                            ?>
                                            <tr>
                                                <th>Hotel Name</th>
                                                <td><?php echo $hotelname; ?></td>
                                            </tr>
                                            <tr>
                                                <th>TIN</th>
                                                <td><?php echo $nif; ?></td>
                                            </tr>                                            
                                            <tr>
                                                <th>Hotel Address</th>
                                                <td><?php echo $hoteladdress; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Corporate Name</th>
                                                <td><?php echo $corporatename; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Hotel contacts</th>
                                                <td><?php echo $hotelcontacts; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Hotel Email</th>
                                                <td><?php echo $hotelemail; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Hotel Manager</th>
                                                <td><?php echo $hotelmanager; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Annual Leave</th>
                                                <td><?php echo $annual_leave; ?> days</td>
                                            </tr>
                                            <tr>
                                                <th>Hotel Logo</th>
                                                <td><img src="img/sitelogo.<?php echo $logo . '?' . time(); ?>" style="max-width: 200px"></td>
                                            </tr>



                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="edit-form" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="m-t-none m-b">Edit Settings</h3>

                                <form role="form" method="POST" action="editsettings" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="control-label">Hotel Name</label>
                                        <input type="text" class="form-control" name="hotelname" value="<?php echo $hotelname; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">TIN</label>
                                        <input type="text" class="form-control" name="nif" value="<?php echo $nif; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Hotel Address</label>
                                        <input type="text" class="form-control" name="hoteladdress" value="<?php echo $hoteladdress; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Corporate Name</label>
                                        <input type="text" class="form-control" name="corporatename" value="<?php echo $corporatename; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Hotel Contacts</label>
                                        <input type="text" class="form-control" name="hotelcontacts" value="<?php echo $hotelcontacts; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="text" class="form-control" name="hotelemail" value="<?php echo $hotelemail; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Hotel Manager</label>
                                        <input type="text" class="form-control" name="hotelmanager" value="<?php echo $hotelmanager; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Annual Leave (days)</label>
                                        <input type="number" class="form-control" name="annual_leave" value="<?php echo $annual_leave; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Hotel Logo (Leave Blank if not changing)</label>
                                        <input type="file" name="logo">
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-primary m-t-n-xs" type="submit" name="edit"><strong>Edit</strong></button>
                                    </div>
                                </form>
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
                                <h3 class="m-t-none m-b">Add Settings</h3>
                                <?php
                                if (isset($_POST['submit'])) {
                                    $hotelname = mysqli_real_escape_string($con, trim($_POST['hotelname']));
                                    $nif = mysqli_real_escape_string($con, trim($_POST['nif']));
                                    $hoteladdress = mysqli_real_escape_string($con, trim($_POST['hoteladdress']));
                                    $corporatename = mysqli_real_escape_string($con, trim($_POST['corporatename']));
                                    $hotelcontacts = mysqli_real_escape_string($con, trim($_POST['hotelcontacts']));
                                    $hotelcontacts = mysqli_real_escape_string($con, trim($_POST['hotelcontacts']));
                                    $hotelemail = mysqli_real_escape_string($con, trim($_POST['hotelemail']));
                                    $annual_leave = mysqli_real_escape_string($con, trim($_POST['annua$annual_leave']));
                                    $image_name = $_FILES['logo']['name'];
                                    $image_size = $_FILES['logo']['size'];
                                    $image_temp = $_FILES['logo']['tmp_name'];
                                    $allowed_ext = array('jpg', 'jpeg', 'png', 'PNG', 'gif', 'JPG', 'JPEG', 'GIF', '');
                                    $imgext = explode('.', $image_name);
                                    $image_ext = end($imgext);
                                    if (in_array($image_ext, $allowed_ext) === false) {
                                        $errors[] = 'Image File type not allowed';
                                    }
                                    if ($image_size > 20097152) {
                                        $errors[] = 'Maximum Image size is 20Mb';
                                    }
                                    if (!empty($errors)) {
                                        foreach ($errors as $error) {
                                            echo $error;
                                        }
                                    } else {
                                        if ((!empty($hotelname)) && (mysqli_num_rows($getsettings) == 0)) {
                                            mysqli_query($con, "INSERT INTO settings(hotelname,nif,hoteladdress,corporatename,hotelcontacts,hotelemail,hotelmanager,logo,annual_leave) VALUES('$hotelname','$nif','$hoteladdress','$corporatename','$hotelcontacts','$hotelemail','$hotelmanager','$image_ext','$annual_leave')");
                                            $image_file = 'sitelogo.' . $image_ext;
                                            move_uploaded_file($image_temp, 'img/' . $image_file) or die(mysqli_error($con));
                                        }
                                    }
                                }
                                ?>
                                <form role="form" method="POST" action="" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="control-label">Hotel Name</label>
                                        <input type="text" class="form-control" name="hotelname">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">NIF</label>
                                        <input type="text" class="form-control" name="nif">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Hotel Address</label>
                                        <input type="text" class="form-control" name="hoteladdress">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Corporate Name</label>
                                        <input type="text" class="form-control" name="corporatename">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Hotel Contacts</label>
                                        <input type="text" class="form-control" name="hotelcontacts">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Hotel Email</label>
                                        <input type="email" class="form-control" name="hotelemail">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Hotel Manager</label>
                                        <input type="text" class="form-control" name="hotelmanager">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Hotel Logo</label>
                                        <input type="file" name="logo">
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-primary m-t-n-xs" type="submit" name="submit"><strong>Submit</strong></button>
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
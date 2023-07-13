<?php
include '../includes/conn.php';
   if(!isset($_SESSION['oseadmin'])){
header('Location:login.php');
   }
   ?>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/form_advanced.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:38:04 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EA champs admin</title>
<script src="ckeditor/ckeditor.js"></script>
     <!--<link rel="stylesheet" href="ckeditor/samples/sample.css">-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    

    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">

  

    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">

   
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    
    <link href="css/animate.css" rel="stylesheet">
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
                    <h2>Add Event</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>
                            <a>Events</a>
                        </li>
                        <li class="active">
                            <strong>Add Event</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">

                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Add New Event <small>Ensure to fill all necessary fields</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                            <?php
                            include_once 'includes/crop.php';
                            if(isset($_POST['title'],$_POST['venue'],$_POST['time'],$_POST['town'],$_POST['date'],$_FILES['uploaded_file'],$_POST['description'])){
                                if(empty($_POST['description'])){
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Article description missing</div>';
                                }else{
                                    $title=  AddSlashes(trim($_POST['title']));
                                    $town= mysql_real_escape_string(trim($_POST['town']));
                                    $venue= AddSlashes(trim($_POST['venue']));
                                    $date= mysql_real_escape_string(trim($_POST['date']));
                                    $time= mysql_real_escape_string(trim($_POST['time']));
                                    $description= trim($_POST['description']);
                                    $totime=  strtotime(str_replace('/', '-', $date));
                                    $fileName = $_FILES["uploaded_file"]["name"]; // The file name
$fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["uploaded_file"]["type"]; // The type of file it is
$fileSize = $_FILES["uploaded_file"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["uploaded_file"]["error"]; // 0 for false... and 1 for true
$kaboom = explode(".", $fileName); // Split file name into an array using the dot
$fileExt = end($kaboom);
if (!$fileTmpLoc) { // if file not chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
} else if($fileSize > 5242880) { // if file size is larger than 5 Megabytes
    echo "ERROR: Your file was larger than 5 Megabytes in size.";
    unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
    exit();
} else if (!preg_match("/.(gif|jpg|png)$/i", $fileName) ) {
     // This condition is only if you wish to allow uploading of specific file types    
     echo "ERROR: Your image was not .gif, .jpg, or .png.";
     unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
     exit();
} else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1
    echo "ERROR: An error occured while processing the file. Try again.";
    exit();
}
                                  if(empty($headline)){
                                     $head='no'; }
                                 else {
                        $head='yes';                                                               }
            mysql_query("INSERT INTO events VALUES('','$title','$venue','$time','$town','$fileExt','$totime','$description','$fullname','".$_SESSION['oseadmin']."','published')") or die(mysql_error());
           $image_file=md5(mysql_insert_id()).'.'.$fileExt;
            move_uploaded_file($fileTmpLoc, "../images/events/$image_file") or die("Error moving file");                    
            $target_file = "../images/events/$image_file";
$resized_file = "../images/events/cropped/$image_file";
$wmax = 350;
$hmax = 500;
ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
// ----------- End Adams Universal Image Resizing Function ----------
// ------ Start Adams Universal Image Thumbnail(Crop) Function ------
$target_file = "../images/events/cropped/$image_file";
$thumbnail = "../images/events/thumbs/$image_file";
$wthumb = 300;
$hthumb = 180;
ak_img_thumb($target_file, $thumbnail, $wthumb, $hthumb, $fileExt);
unlink($target_file);
echo '<div class="alert alert-success"><i class="fa fa-check"></i> Event successfully posted</div>';
                                 }
                            }
                            ?>
                          
  <form method="post" class="form-horizontal"  action=""  enctype="multipart/form-data" >
                                <div class="form-group"><label class="col-sm-2 control-label">Event Title</label>

                                    <div class="col-sm-10"><input type="text" name="title" class="form-control" placeholder="Enter event Title" required="required"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                  <div class="form-group"><label class="col-sm-2 control-label">Event Venue</label>
                                    <div class="col-sm-10"><input type="text" name="venue" class="form-control" placeholder="Enter event venue" required="required"></div>
                                </div>
                                 <div class="hr-line-dashed"></div>
                                  <div class="form-group"><label class="col-sm-2 control-label">Event time</label>
                                    <div class="col-sm-10"><input type="text" name="time" class="form-control" placeholder="Enter event time" required="required"></div>
                                </div>
                                 <div class="hr-line-dashed"></div>
                                  <div class="form-group"><label class="col-sm-2 control-label">Event town</label>
                                    <div class="col-sm-10"><input type="text" name="town" class="form-control" placeholder="Enter town where venue is located" required="required"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                   
                                                               <div class="form-group"><label class="col-sm-2 control-label">Event Image</label>

                                    <div class="col-sm-10"><input type="file" name="uploaded_file"class="form-control " style="padding: 0px" placeholder="Enter Event image" required="required"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                
                               <div class="form-group" id="data_1">
                                <label class="col-sm-2 control-label">Event Date</label>
                                <div class="col-sm-10">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input data-mask="99/99/9999" type="text" name="date" class="form-control" placeholder="Enter event date" required="required">
                                </div>
                                </div>
                            </div>
                                                           <div class="hr-line-dashed"></div>
                                                                                                   <div class="form-group">
                                            <label class="col-sm-2 control-label">Event  Description</label>
                                          <div class="col-sm-10"> <textarea class="ckeditor" cols="70" id="editor1" name="description" rows="10" required="required"></textarea>
                                              <div id='form_description_errorloc' class='text-danger'></div>	
                                        </div>
                                        </div>
                                                                    <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-primary" type="submit">Submit Event</button>
                                    </div>
                                </div>
                            </form>
                                                 

                    </div>

                  
                </div>
             
                    </div>
                    </div>




    </div>

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

    <script>
        $(document).ready(function(){

            $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "dd/mm/yyyy",
            });

          
//
//            var elem = document.querySelector('.js-switch');
//            var switchery = new Switchery(elem, { color: '#1AB394' });
//
//            var elem_2 = document.querySelector('.js-switch_2');
//            var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
//
//            var elem_3 = document.querySelector('.js-switch_3');
//            var switchery_3 = new Switchery(elem_3, { color: '#1AB394' });

//            $('.i-checks').iCheck({
//                checkboxClass: 'icheckbox_square-green',
//                radioClass: 'iradio_square-green',
//            });
        });
                    var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }


    </script>

</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/form_advanced.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:38:25 GMT -->
</html>
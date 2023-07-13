<?php
include '../includes/conn.php';
 $id=$_GET['id'];
   $name=$_GET['name'];
   $poster_id=$_GET['poster'];
        if(($poster_id==$_SESSION['oseadmin'])||($_SESSION['oseadminlevel']==1)){ 
            $artist=mysql_query("SELECT * FROM artists WHERE artist_id='$id'");
            $row=mysql_fetch_array($artist);
            $stagename=$row['stagename'];
            $artext=$row['ext'];
            $artfullname=$row['fullname'];
            $artcountry=$row['country'];
            $bio=$row['biography'];
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
 <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
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
                    <a href="login.html">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Edit Artist Profile</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>
                            <a>Artists</a>
                        </li>
                        <li class="active">
                            <strong>Edit Profile</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">

                <div class="col-lg-3">
                     <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?php echo $stagename; ?></h5>
                        </div>
                        <div>
                            <div class="ibox-content no-padding border-left-right">
                                <img alt="image" class="img-responsive" src="../images/artists/<?php echo md5($id).'.'.$artext; ?>">
                            </div>
                            <div class="ibox-content profile-content">
                                <h4><strong>Country</strong>-<?php echo $artcountry; ?></h4>
                                
                             
                                <div class="user-button">
                                    <div class="row">
                                        <div class="col-md-6">
                                          <a data-toggle="modal" class="btn btn-primary btn-sm" href="#modal-form"><i class="fa fa-edit"></i> Change Profile Picture</a>
                                        
                                        </div>
                                                              
                                    </div>
                                </div>
                                
                            </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-9">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Edit Artist Profile <small>Ensure to fill all necessary fields</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                           <?php
                                
                            if(isset($_POST['fullname'],$_POST['stagename'],$_POST['country'],$_POST['biography'])){
                                if(empty($_POST['biography'])){
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Artist biography missing</div>';
                                }else{
                               
                                    $artname=  mysql_real_escape_string(trim($_POST['fullname']));
                                    $stagename2= mysql_real_escape_string(trim($_POST['stagename']));
                                    $country2= mysql_real_escape_string(trim($_POST['country']));
                                    $bio2= trim($_POST['biography']);
                              
        mysql_query("UPDATE artists  SET fullname='$artname',stagename='$stagename2',country='$country2',biography='$bio2' WHERE artist_id='$id'") or die(mysql_error());
       
        echo '<div class="alert alert-success"><i class="fa fa-check"></i> Artist profile successfully edited</div>';
                                 }
                            }
                           ?>
  <form method="post" class="form-horizontal" action="">
                                <div class="form-group"><label class="col-sm-3 control-label">Change Fullname</label>

                                    <div class="col-sm-12"><input type="text" class="form-control" value="<?php echo $artfullname; ?>" name="fullname" placeholder="Enter artist's  fullname"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                  <div class="form-group"><label class="col-sm-3 control-label">Change Stage Name</label>
                                    <div class="col-sm-12"><input type="text" class="form-control" value="<?php echo $stagename; ?>" name="stagename" placeholder="Enter artist's stage name"></div>
                                </div>
                                 <div class="hr-line-dashed"></div>
                       
                                <div class="form-group"><label class="col-sm-3 control-label">Change Country</label>

                                    <div class="col-sm-12"><select class="form-control m-b" name="country">
                                            <option value="<?php echo $artcountry; ?>" selected="selected"><?php echo $artcountry; ?></option>
                                        <option value='Uganda'>Uganda</option>
                                        <option  value='Tanzania'>Tanzania</option>
                                        <option  value='Kenya'>Kenya</option>
                                        <option  value='Rwanda'>Rwanda</option>
                                    </select>

                                        
                                    </div>
                                </div>
                               
                                <div class="hr-line-dashed"></div>
                                
                        
                                                                                                   <div class="form-group">
                                            <label class="col-sm-3 control-label">Edit Biography</label>
                                          <div class="col-sm-12"> <textarea class="ckeditor" cols="70" id="editor1" name="biography" rows="10" required="required">
<?php echo $bio; ?>
                                              </textarea>
                                              <div id='form_description_errorloc' class='text-danger'></div>	
                                        </div>
                                        </div>
                                                                    <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-primary" type="submit">Edit profile</button>
                                    </div>
                                </div>
                            </form>
                                                 

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
                                                <div class="col-sm-12"><h3 class="m-t-none m-b">Upload picture</h3>
                                                    <form role="form" action="changeartistpic.php?id=<?php echo $id.'&&ext='.$ext;?>" method="POST" enctype="multipart/form-data">
                                                          <div class="form-group"><input type="file" style="Padding:0px" name="uploaded_file"class="form-control" required="required"></div>
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
                autoclose: true
            });

           $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
           radioClass: 'iradio_square-green',
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
<?php
        }else{
       header('Location:'.$_SERVER['HTTP_REFERER']);
        }
?>
<?php
include '../includes/conn.php';
   if(!isset($_SESSION['oseadmin'])){
header('Location:login.php');
   }
      $id=$_GET['id'];
   $title=$_GET['title'];
   $poster_id=$_GET['poster'];
        if(($poster_id==$_SESSION['oseadmin'])||($_SESSION['oseadminlevel']==1)){ 
         
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
                   <h2>Edit <?php echo '"'.$title.'"'; ?> Article</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>
                            <a>Events</a>
                        </li>
                        <li class="active">
                            <strong>Edit Event</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">

                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Edit Event <small>Ensure to fill all necessary fields</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                               <?php
                    
                            if(isset($_POST['title'],$_POST['venue'],$_POST['town'],$_POST['date'],$_POST['time'],$_POST['description'])){
                                if(empty($_POST['description'])){
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Event description missing</div>';
                                }else{
                                    $title=  mysql_real_escape_string(trim($_POST['title']));
                                    $venue= mysql_real_escape_string(trim($_POST['venue']));
                                    $town= mysql_real_escape_string(trim($_POST['town']));
                                    $date= mysql_real_escape_string(trim($_POST['date']));
                                    $totime=strtotime(str_replace('/', '-', $date));
                                    $time= mysql_real_escape_string(trim($_POST['time']));
                                   $description= trim($_POST['description']);
                                   
        mysql_query("UPDATE events SET event_title='$title',event_venue='$venue',event_town='$town',event_date='$totime',event_description='$description',event_time='$time' WHERE event_id='$id'") or die(mysql_error());
        
echo '<div class="alert alert-success"><i class="fa fa-check"></i> Event successfully edited</div>';
                                 }
                            }
                            
                            $article=  mysql_query("SELECT * FROM events WHERE event_id='$id'");
                            $row=  mysql_fetch_array($article);
                            $ev_title=$row['event_title'];
                            $ev_venue=$row['event_venue'];
                            $ev_desc=$row['event_description'];
                            $ev_time=$row['event_time'];
                            $ev_date=$row['event_date'];
                            $ev_town=$row['event_town'];
                                                       ?>
                          
                          
  <form method="post" class="form-horizontal"  action=""  enctype="multipart/form-data" >
                                <div class="form-group"><label class="col-sm-2 control-label">Edit Title</label>

                                    <div class="col-sm-10"><input type="text" name="title" class="form-control"  value="<?php echo $ev_title; ?>" placeholder="Enter event Title" required="required"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                  <div class="form-group"><label class="col-sm-2 control-label">Edit  Venue</label>
                                    <div class="col-sm-10"><input type="text" name="venue" class="form-control" value="<?php echo $ev_venue; ?>" placeholder="Enter event venue" required="required"></div>
                                </div>
                                 <div class="hr-line-dashed"></div>
                                  <div class="form-group"><label class="col-sm-2 control-label">Edit time</label>
                                    <div class="col-sm-10"><input type="text" name="time" class="form-control" value="<?php echo $ev_time; ?>" placeholder="Enter event time" required="required"></div>
                                </div>
                                 <div class="hr-line-dashed"></div>
                                  <div class="form-group"><label class="col-sm-2 control-label">Change  town</label>
                                    <div class="col-sm-10"><input type="text" name="town" class="form-control" value="<?php echo $ev_town; ?>" placeholder="Enter town where venue is located" required="required"></div>
                                </div>
                                
                                <div class="hr-line-dashed"></div>
                                
                               <div class="form-group" id="data_1">
                                <label class="col-sm-2 control-label">Edit Date</label>
                                <div class="col-sm-10">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input data-mask="99/99/9999" type="text" value="<?php echo date('m/d/Y',$ev_date); ?>" name="date" class="form-control" placeholder="Enter event date" required="required">
                                </div>
                                </div>
                            </div>
                                                           <div class="hr-line-dashed"></div>
                                                                                                   <div class="form-group">
                                            <label class="col-sm-2 control-label">Edit   Description</label>
                                          <div class="col-sm-10"> <textarea class="ckeditor" cols="70" id="editor1" name="description" rows="10" required="required">
<?php echo $ev_desc; ?>"
                                              </textarea>
                                              <div id='form_description_errorloc' class='text-danger'></div>	
                                        </div>
                                        </div>
                                                                    <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                                                           <button class="btn btn-primary" type="submit">Edit Event</button>
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
<?php
        }else{
       header('Location:'.$_SERVER['HTTP_REFERER']);
        }
?>
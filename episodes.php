<?php
include '../includes/conn.php';
   if(!isset($_SESSION['oseadmin'])){
header('Location:login.php');
   }
   $id=$_GET['id'];
   $hangout=$_GET['hangout'];
 ?>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/empty_page.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:38:45 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ea champs admin</title>
<script src="ckeditor/ckeditor.js"></script>
      <script language="JavaScript" src="../js/gen_validatorv4.js" type="text/javascript"></script>
<link rel="stylesheet" href="ckeditor/samples/sample.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
 <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
</head>

<body>

    <div id="wrapper">

        <?php include 'nav.php'; ?>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
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
                <div class="col-lg-9">
                    <h2>Episodes of <?php echo $hangout; ?></h2>
                 <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>
                            <a>Hangout</a>
                        </li>
                        <li class="active">
                            <strong>Episodes</strong>
                        </li>
                    </ol>
                </div>
                           </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="wrapper wrapper-content">
                    <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add New Episode<small class="m-l-sm">Fill the form below to add new episode</small></h5>
                        
                    </div>
                    <div class="ibox-content">
                    <?php
                      include 'includes/getimage.php';
                    if(isset($_POST['episode'],$_POST['date'],$_POST['url'],$_POST['description'])){
                        if(!empty($_POST['description'])){
                        $episode=  mysql_real_escape_string(trim($_POST['episode']));
                        $url=  mysql_real_escape_string(trim($_POST['url']));
                        $episode=  mysql_real_escape_string(trim($_POST['episode']));
                        $date=  mysql_real_escape_string(trim($_POST['date']));
                          $totime=  strtotime(str_replace('/', '-', $date));
                          $description=trim($_POST['description']);
                          $img=youtube_thumbnail_url($url);
                        mysql_query("INSERT INTO episodes VALUES('','$episode','$url','$img','$description','$id','$totime','$fullname','$user_id','4','published')") or die(mysql_error());
                        echo '<div class="alert alert-success"><i class="fa fa-check"></i> New episodes successfully added</div>';                        
                    }
                    else{
                          echo '<div class="alert alert-danger"><i class="fa fa-warning"></i>Description missing</div>';  
                    }
                    }
                    ?>        
                      
  <form method="post" class="form-horizontal" action="">
                                <div class="form-group"><label class="col-sm-8 control-label">New Episode</label>

                                    <div class="col-sm-12"><input type="text" name="episode" class="form-control" placeholder="Enter new hangout" required="required"></div>
                                </div>
      <div class="form-group"><label class="col-sm-8 control-label">Video url</label>

                                    <div class="col-sm-12"><input type="text" name="url" class="form-control" placeholder="Enter video url" required="required"></div>
                                </div>
        <div class="form-group" id="data_1">
                                <label class="col-sm-8 control-label">Episode Date</label>
                                <div class="col-sm-12">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input data-mask="99/99/9999" type="text" name="date" class="form-control" placeholder="Enter event date" required="required">
                                </div>
                                </div>
                            </div>
                                                           <div class="hr-line-dashed"></div>
          <div class="form-group">
                                            <label class="col-sm-8 control-label">Episode Description</label>
                                          <div class="col-sm-12"> <textarea class="ckeditor" cols="70" id="editor1" name="description" rows="10" required="required"></textarea>
                                                                                  </div>
                                        </div>
                                <div class="hr-line-dashed"></div>
  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-3">
                                                                           <button class="btn btn-primary" type="submit">Add Episode</button>
                                    </div>
                                </div>
  </form>
                    </div>
                </div>
                </div>
            </div>
              <div class="col-lg-6">
                  <div class="wrapper wrapper-content">
               <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Episodes</h5>
                     
                    </div>
                    <div class="ibox-content">
<?php 
$episodes=mysql_query("SELECT * FROM episodes WHERE hangout_id='$id' ORDER BY episode_id DESC");
if(mysql_num_rows($episodes)>0){
    ?>
                                                <table class="table table-striped">
                            <thead>
                            <tr>
                                     <th>Episode</th>
                                                                                                  <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php 
                             
                                while($row3=mysql_fetch_array($episodes)){
                                    $episode_id=$row3['episode_id'];
                                    $episode_name=$row3['episode'];
                                              $status=$row3['status'];
                                    $poster_id=$row3['poster_id'];
                                    ?>
                            <tr>
                               
                                  <td><?php echo $episode_name; ?></td>
                                  
                                   <td>
                                       <?php
                                        if($status=='published'){ ?>
                            <a href="hide_episode.php?id=<?php echo $episode_id.'&&status='.$status; ?>" class="btn btn-danger btn-xs">unpublish <i class="fa fa-arrow-down"></i></a>
                            <?php }else{ ?>
                             <a href="hide_episode.php?id=<?php echo $episode_id.'&&status='.$status; ?>"  class="btn btn-primary  btn-xs">publish <i class="fa fa-arrow-up"></i></a>
                                 <?php }?>
                                        <a href="edit_episode.php?id=<?php echo $episode_id.'&&episode='.$episode_name; ?>"  class="btn btn-success  btn-xs">Edit</a>
                                   </td>
                                                           </tr>
                                <?php } ?>              
                            </tbody>
                        </table>

    <?php
}
else{
    echo '<div class="alert alert-danger"><i class="fa fa-warning"></i> Oops!!No episodes created yet</div>';
}
?>
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
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
</body>
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
            });
</script>
<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/empty_page.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:38:45 GMT -->
</html>

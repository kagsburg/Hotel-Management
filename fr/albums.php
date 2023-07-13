<?php
include '../includes/conn.php';
   if(!isset($_SESSION['oseadmin'])){
header('Location:login.php');
   }
 ?>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/empty_page.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:38:45 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ea champs admin</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

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
                    <h2>Albums</h2>
                 <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>
                            <a>Album</a>
                        </li>
                        <li class="active">
                            <strong>View Album</strong>
                        </li>
                    </ol>
                </div>
                           </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="wrapper wrapper-content">
                    <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add New Hangout<small class="m-l-sm">Fill the form below to add new album</small></h5>
                        
                    </div>
                    <div class="ibox-content">
                    <?php
                    if(isset($_POST['album'])){
                        $album=  mysql_real_escape_string(trim($_POST['album']));
                       
                        mysql_query("INSERT INTO albums VALUES('','$album')") or die(mysql_error());
                        echo '<div class="alert alert-success"><i class="fa fa-check"></i> New album successfully added</div>';                        
                    }
                    ?>        
                      
  <form method="post" class="form-horizontal" action="">
                                <div class="form-group"><label class="col-sm-3 control-label">New Album</label>

                                    <div class="col-sm-9"><input type="text" name="album" class="form-control" placeholder="Enter new album" required="required"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-3">
                                                                           <button class="btn btn-primary" type="submit">Add album</button>
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
                        <h5>All Hangouts</h5>
                     
                    </div>
                    <div class="ibox-content">
<?php 
$albums=mysql_query("SELECT * FROM albums ORDER BY album_id DESC");
if(mysql_num_rows($albums)>0){
    ?>
                                                <table class="table table-striped">
                            <thead>
                            <tr>
                                     <th>Album</th>
                                                              <th>Photos</th>
                                                              <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php 
                             
                                while($row=mysql_fetch_array($albums)){
                                    $album_id=$row['album_id'];
                                    $album_name=$row['album_name'];
                                    $photos=mysql_query("SELECT* FROM photos WHERE album_id='$album_id'");
                                    $num=  mysql_num_rows($photos);
                                    ?>
                            <tr>
                               
                                  <td><?php echo $album_name; ?></td>
                                  <td><?php echo $num; ?> photos</td>
                                  
                                   <td>
                                      
                                        <a href="photos.php?id=<?php echo $album_id.'&&album='.$album_name; ?>"  class="btn btn-success  btn-xs">View Photos</a>
                                   </td>
                                                           </tr>
                                <?php } ?>              
                            </tbody>
                        </table>

    <?php
}
else{
    echo '<div class="alert alert-danger"><i class="fa fa-warning"></i> Oops!!No albums created yet</div>';
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


</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/empty_page.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:38:45 GMT -->
</html>

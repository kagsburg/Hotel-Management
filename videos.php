<?php
include '../includes/conn.php';
   if(!isset($_SESSION['oseadmin'])){
header('Location:login.php');
   }
 ?>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/table_data_tables.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:38:45 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EA champs admin</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

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
                    <h2>Videos</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>
                            <a>Music</a>
                        </li>
                         <li>
                            <a>Videos</a>
                        </li>
                        <li class="active">
                            <strong>View videos</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Videos <small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">

                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                    <th>Id</th>
                        <th>Video Title</th>
                        <th>Artist(s)</th>
                        <th>Views</th>
                        <th>Country</th>
                        <th>Uploaded by</th>
                        <th>Genre</th>
                                                <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
               <?php
          $videos=mysql_query("SELECT * FROM videos");
           if(mysql_num_rows($videos)>0){
                while($row=  mysql_fetch_array($videos)){
  $video_name=$row['video_name'];
$video_id=$row['video_id'];
     $artists=$row['artists'];
     $img=$row['image'];
     $url=$row['url'];
     $poster=$row['poster'];
     $genre_id=$row['genre_id'];
     $country=$row['country'];
     $status=$row['status'];
     $poster_id=$row['poster_id'];
     $views=$row['views'];
        ?>
                    <tr class="gradeA">
                     <td><?php echo $video_id; ?></td>
                        <td><?php echo $video_name; ?></td>
                        <td><?php echo $artists; ?></td>
                         <td><?php echo $views; ?></td>
                        <td><?php echo $country; ?></td>
                        <td><?php echo $poster; ?></td>
                        <td class="center">      <?php 
                                            $songgenre=mysql_query("SELECT * FROM genres  WHERE genre_id='$genre_id'");
                                            $row=  mysql_fetch_array($songgenre);
                                            $genrename=$row['genre'];
                       echo $genrename; ?></td>
                                             
  <td class="center">    
        <?php if(($poster_id==$_SESSION['oseadmin'])||($_SESSION['oseadminlevel']==1)){ ?>
                            <a href="edit_video?id=<?php echo $video_id.'&&title='.$video_name.'&&poster='.$poster_id;?>" class="btn btn-success btn-xs">Edit  <i class="fa fa-edit"></i></a> 
                            <?php 
                            }
                             ?>
                                          
                                 <?php                                                  
                                                  if($status=='published'){
                                                      $check=mysql_query("SELECT * FROM sponsored_vid WHERE video_id='$video_id'");
                                                      if(mysql_num_rows($check)<1){
                                                      ?>
                                <a href="favorite?id=<?php echo $video_id;?>" class="btn btn-info btn-xs">Make Sponsored <i class="fa fa-flag"></i></a>
                                <?php }?>
                            <a href="hidevideo.php?id=<?php echo $video_id.'&&status='.$status; ?>" class="btn btn-danger btn-xs">unpublish <i class="fa fa-arrow-down"></i></a>
                            <?php }else{ ?>
                              <a href="hidevideo.php?id=<?php echo $video_id.'&&status='.$status; ?>"  class="btn btn-primary  btn-xs">publish <i class="fa fa-arrow-up"></i></a>
                                 <?php }?>
                    </tr>
           <?php }}else{
               echo '<div class="alert alert-danger">No Videos Added yet</div>';
           }?>
                    
                 
                    </tbody>
                
                    </table>

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

    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('.dataTables-example').dataTable();

            /* Init DataTables */
            var oTable = $('#editable').dataTable();

            /* Apply the jEditable handlers to the table */
            oTable.$('td').editable( 'http://webapplayers.com/example_ajax.php', {
                "callback": function( sValue, y ) {
                    var aPos = oTable.fnGetPosition( this );
                    oTable.fnUpdate( sValue, aPos[0], aPos[1] );
                },
                "submitdata": function ( value, settings ) {
                    return {
                        "row_id": this.parentNode.getAttribute('id'),
                        "column": oTable.fnGetPosition( this )[2]
                    };
                },

                "width": "90%"
            } );


        });

        function fnClickAddRow() {
            $('#editable').dataTable().fnAddData( [
                "Custom row",
                "New row",
                "New row",
                "New row",
                "New row" ] );

        }
    </script>
</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/table_data_tables.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:38:48 GMT -->
</html>
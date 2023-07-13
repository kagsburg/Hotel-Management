<?php
include '../includes/conn.php';
   if(!isset($_SESSION['oseadmin'])){
header('Location:login.php');
   }
 ?>
<html>
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
                    <h2>Articles</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>
                            <a>Articles</a>
                        </li>
                        <li class="active">
                            <strong>View Articles</strong>
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
                        <h5>All Articles <small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
 
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>Id</th>
                         <th>Title</th>
                        <th>Posted By</th>
                        <th>Views</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                         <?php
                        $articles=mysql_query("SELECT * FROM news  ORDER BY news_id DESC");
                       while($row=  mysql_fetch_array($articles)){
                        $news_id=$row['news_id'];
                        $title=stripslashes($row['title']);
                        $ext=$row['ext'];
                        $status=$row['status'];
                        $timestamp=$row['timestamp'];
                        $category=$row['category'];
                        $poster=$row['poster'];
                        $poster_id=$row['poster_id'];
                        $count=$row['count'];
                        ?>
                                  <tr class="gradeA">
                                   <td><?php echo $news_id; ?></td>
                        <td><?php echo $title; ?></td>
                        <td> <div class="tooltip-demo">
                            <a href="profile?id=<?php echo $poster_id; ?>" data-original-title="View admin profile"  data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php echo $poster; ?></a> </div></td>
                        <td> <?php echo $count;?></td>
                        <td class="center"><?php echo $category; ?></td>
                        <td class="center"><?php echo $status; ?></td>
                        <td class="center">
                            <?php if(($poster_id==$_SESSION['oseadmin'])||($_SESSION['oseadminlevel']==1)){ ?>
                            <a href="editarticle?id=<?php echo $news_id.'&&title='.$title.'&&poster='.$poster_id;?>" class="btn btn-success btn-xs">Edit  <i class="fa fa-edit"></i></a> 
                            <?php 
                            }
                            if($_SESSION['oseadminlevel']==1){
                            if($status=='published'){ ?>
                            <a href="hidearticle.php?id=<?php echo $news_id.'&&status='.$status; ?>" class="btn btn-danger btn-xs">unpublish <i class="fa fa-arrow-down"></i></a>
                            <?php }else{ ?>
                             <a href="hidearticle.php?id=<?php echo $news_id.'&&status='.$status; ?>"  class="btn btn-primary  btn-xs">publish <i class="fa fa-arrow-up"></i></a>
                            <?php }}
                                 ?>
                        </td>
                    </tr>
                       <?php }?>
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
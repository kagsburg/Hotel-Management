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
                    <h2>News Categories</h2>
                 <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>
                            <a>Articles</a>
                        </li>
                        <li class="active">
                            <strong>Categories</strong>
                        </li>
                    </ol>
                </div>
                           </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="wrapper wrapper-content">
                    <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add New Category<small class="m-l-sm">Fill the form below to add new category</small></h5>
                        
                    </div>
                    <div class="ibox-content">
                    <?php
                    if(isset($_POST['category'])){
                        $newcat=  mysql_real_escape_string(trim($_POST['category']));
                        $check=mysql_query("SELECT * FROM newscategories WHERE category='$newcat'");
                        if(mysql_num_rows($check)>0){
                         echo '<div class="alert alert-danger"><i class="fa fa-warning"></i> Category already exists</div>';   
                        }
                        else{
                        mysql_query("INSERT INTO newscategories VALUES('','$newcat','$fullname','$user_id','published')") or die(mysql_error());
                        echo '<div class="alert alert-success"><i class="fa fa-check"></i> New category successfully added</div>';                        
                    }}
                    ?>        
                      
  <form method="post" class="form-horizontal" action="">
                                <div class="form-group"><label class="col-sm-3 control-label">New Category</label>

                                    <div class="col-sm-9"><input type="text" name="category" class="form-control" placeholder="Enter new category" required="required"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-3">
                                                                           <button class="btn btn-primary" type="submit">Add Category</button>
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
                        <h5>All Categories</h5>
                     
                    </div>
                    <div class="ibox-content">
<?php 
$categories=mysql_query("SELECT * FROM newscategories ORDER BY category_id DESC");
if(mysql_num_rows($categories)>0){
    ?>
                                                <table class="table table-striped">
                            <thead>
                            <tr>
                                     <th>Category</th>
                                <th>Added By</th>
                              <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php 
                             
                                while($row3=mysql_fetch_array($categories)){
                                    $cat_id=$row3['category_id'];
                                    $cat=$row3['category'];
                                    $addedby=$row3['addedby'];
                                    $status=$row3['status'];
                                    $poster_id=$row3['poster_id'];
                                    ?>
                            <tr>
                               
                                  <td><?php echo $cat; ?></td>
                                  <td> <div class="tooltip-demo">
                            <a href="profile?id=<?php echo $poster_id; ?>" data-original-title="View admin profile"  data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php echo $addedby; ?></a> </div></td>
                                   <td>
                                       <?php
                                        if($status=='published'){ ?>
                            <a href="hide_cat.php?id=<?php echo $cat_id.'&&status='.$status.'&&cat='.$cat; ?>" class="btn btn-danger btn-xs">unpublish <i class="fa fa-arrow-down"></i></a>
                            <?php }else{ ?>
                             <a href="hide_cat.php?id=<?php echo $cat_id.'&&status='.$status; ?>"  class="btn btn-primary  btn-xs">publish <i class="fa fa-arrow-up"></i></a>
                                 <?php }?>
                                       
                                   </td>
                                                           </tr>
                                <?php } ?>              
                            </tbody>
                        </table>

    <?php
}
else{
    echo '<div class="alert alert-danger"><i class="fa fa-warning"></i> Oops!!No categories created yet</div>';
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

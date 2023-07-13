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


<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/form_basic.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:38:04 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>EA champs admin</title>
<script src="ckeditor/ckeditor.js"></script>
      <script language="JavaScript" src="../js/gen_validatorv4.js" type="text/javascript"></script>
<link rel="stylesheet" href="ckeditor/samples/sample.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/bootstrap-tagsinput.css" rel="stylesheet">
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
                        <li>                         <a>Articles</a>                       </li>
                        <li class="active">
                            <strong>edit Article</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Edit Article <small>Ensure to fill all neccesary fields</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                            <?php
                    
                            if(isset($_POST['title'],$_POST['subtitle'],$_POST['description'])){
                                if(empty($_POST['description'])){
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Article description missing</div>';
                                }else{
                                    $title=  mysql_real_escape_string(trim($_POST['title']));
                                    $subtitle= mysql_real_escape_string(trim($_POST['subtitle']));
                                      $description= trim($_POST['description']);
                                    $headline=$_POST['headline'];
                                       if(empty($headline)){
                                     $head='no'; }
                                 else {
                        $head='yes';                                                               }
                              
        mysql_query("UPDATE fashion SET title='$title',subtitle='$subtitle',headline='$head',description='$description' WHERE article_id='$id'") or die(mysql_error());
        
echo '<div class="alert alert-success"><i class="fa fa-check"></i> Article successfully edited</div>';
                                 }
                            }
                            
                            $article=  mysql_query("SELECT * FROM fashion WHERE article_id='$id'");
                            $row=  mysql_fetch_array($article);
                            $art_title=$row['title'];
                            $art_subtitle=$row['subtitle'];
                            $art_desc=$row['description'];
                            $art_head=$row['headline'];
                         
                            ?>
                          
                            <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Edit Article Title</label>

                                    <div class="col-sm-10"><input type="text" name="title" class="form-control" value='<?php echo $art_title; ?>' placeholder="Enter Article Title"  required="required"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                  <div class="form-group"><label class="col-sm-2 control-label">Edit Article Sub Title</label>

                                    <div class="col-sm-10"><input type="text" name="subtitle" value='<?php echo $art_subtitle; ?>' class="form-control" placeholder="Enter Article Sub Title"  required="required"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                   
                                <div class="form-group"><label class="col-sm-2 control-label">Is it Headline?</label>

                                    <div class="col-sm-10">
                                        <div class="checkbox i-checks"><label>
                                                <?php
                                                if($art_head=="yes"){
                                                ?>
                                                <input type="checkbox" name="headline" value="yes" checked>
                                                <?php                                             }  else{
                                                      echo '<input type="checkbox" name="headline" value="yes">';
                                                }
                                                ?>
                                            </label></div>
                                                                        </div>
                                </div>
                                <div class="hr-line-dashed"></div>
<!--                                  <div class="form-group"><label class="col-sm-2 control-label">Article Tags</label>

                                    <div class="col-sm-10">
                                         

    <select multiple data-role="tagsinput">
    <option value="Amsterdam">Amsterdam</option>
    <option value="Washington">Washington</option>
    <option value="Sydney">Sydney</option>
    <option value="Beijing">Beijing</option>
    <option value="Cairo">Cairo</option>
    </select>
                                        <div class="tags"></div>

                                    </div>
                                </div>-->

                               
                             
                                                           <div class="hr-line-dashed"></div>
                                                                                                   <div class="form-group">
                                            <label class="col-sm-2 control-label">Edit Article Description</label>
                                          <div class="col-sm-10"> <textarea class="ckeditor" cols="70" id="editor1" name="description" rows="10" required="required">
<?php echo $art_desc; ?>
                                              </textarea>
                                                                                  </div>
                                        </div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-primary" type="submit">Edit Article</button>
                                    </div>
                                </div>
                            </form>
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
    <script src="js/bootstrap-tagsinput.min.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
<script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
        <script>
            $(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
               
            });
//            var year = $('select').val ();
//           $('#clickme').click(function() {
//            $('.tags').text(year);});
        </script>
        
</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/form_basic.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:38:04 GMT -->
</html>
<?php
        }else{
       header('Location:'.$_SERVER['HTTP_REFERER']);
        }
?>
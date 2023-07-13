<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login.php');
}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Categories | Hotel Manager</title>
    <script src="ckeditor/ckeditor.js"></script>
    <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">  

    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">  

    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
   
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
                    <h2>catégories de produits</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                
                        <li class="active">
                            <strong>catégories de produits</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">

                <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Ajouter catégorie<small>Tapez Assurez-vous de remplir tous les champs nécessaires</small></h5>
                                                </div>
                        <div class="ibox-content">
                                       <?php
                   if (isset($_POST['category'])) {
                       $category=  mysqli_real_escape_string($con, trim($_POST['category']));
                       if (empty($category)) {
                           $errors[]='Category Name Required';
                       }
                       $check=  mysqli_query($con, "SELECT * FROM categories WHERE category='$category' AND status=1");
                       if (mysqli_num_rows($check)>0) {
                           $errors[]='Category Already Added';
                       }
                       if (!empty($errors)) {
                           foreach ($errors as $error) {
                               echo '<div class="alert alert-danger">'.$error.'</div>';
                           }
                       } else {
//               $myArray = explode(',', $category);
//                    foreach ($myArray as $cat) {
                           mysqli_query($con, "INSERT INTO categories(category,status) VALUES('$category',1)") or die(mysqli_error($con));
                           echo '<div class="alert alert-success">Product Category Successfully Added</div>';
//                      }
                       }
                   }
?>
                      <form action="" method="POST">
                                    <div class="form-group">
	                      <label>Nom catégorie</label>
                              <input type="text" class="form-control" name="category" required="required">
	                    </div>
                      <div class="form-group">
                          <button class="btn btn-primary" type="submit">Enregistrer</button>
                      </div>
                      </form>                                                

                    </div>

                  
                </div>
             
                    </div>
                       <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">                            
                            <h5>Catégories</h5>
                                                </div>
                        <div class="ibox-content">
                        
                              <table class="table table-striped  table-hover">
                    <thead>
                          <tr>
                            <th>Nom de Catégorie</th>                                                
                                                                        
                            <th>Action</th>                        
                          </tr>
                        </thead>
                        <tbody>
                            <?php
  $getcats=  mysqli_query($con, "SELECT * FROM categories WHERE status=1");
while ($row1=  mysqli_fetch_array($getcats)) {
    $category_id=$row1['category_id'];
    $category=$row1['category'];
    ?>
                          <tr>
                            <td><?php echo $category; ?></td>
                                        
                          
                            <td>
                                <button data-toggle="modal" data-target="#basicModal<?php echo $category_id; ?>" 
                                 class="btn btn-sm btn-info">Editer</button>
                                <a href="removecategory?id=<?php echo $category_id; ?>"
                                 class="btn btn-sm btn-danger" onclick="return confirm_delete<?php echo $category_id;?>()">Supprimer</a>
                     <script type="text/javascript">
function confirm_delete<?php echo $category_id; ?>() {
  return confirm('You are about To Remove this item. Are you sure you want to proceed?');
}
</script>

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
      <?php
    $getcats=  mysqli_query($con, "SELECT * FROM categories WHERE status=1");
while ($row1=  mysqli_fetch_array($getcats)) {
    $category_id=$row1['category_id'];
    $category=$row1['category'];
    ?>
        <div id="basicModal<?php echo $category_id; ?>" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                               <form action="editcategory?id=<?php echo $category_id; ?>" method="POST">
                                    <div class="form-group">
	                      <label>Nom de Catégorie</label>
                              <input type="text" class="form-control"
                               name="category" required="required" value="<?php echo $category; ?>">
	                    </div>
                      <div class="form-group">
                          <button class="btn btn-primary" type="submit">Entré</button>
                      </div>                 
                          </form>
              </div>
           
            </div>
          </div>
        </div>
            <?php }?>
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

  <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <!-- iCheck -->
    <!--<script src="js/plugins/iCheck/icheck.min.js"></script>-->

    <!-- MENU -->
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
 <script>
        $(document).ready(function(){

        
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
   </script>
 
</body>


</html>

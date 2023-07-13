<?php
include 'includes/conn.php';
 if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
   }
  ?>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>Add Supplier</title>
<script src="ckeditor/ckeditor.js"></script>
      <script language="JavaScript" src="../js/gen_validatorv4.js" type="text/javascript"></script>
<link rel="stylesheet" href="ckeditor/samples/sample.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
 <?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/addsupplier.php';                     
                                       }else{
          ?>                               
  
    <div id="wrapper">

     <?php
     include 'nav.php';
              ?>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
         
        </div>
             <ul class="nav navbar-top-links navbar-right">
            <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
            <li><a href="switchlanguage?lan=en">English</a> </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Add Supplier</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a href="suppliers">Suppliers</a>                       </li>
                        <li class="active">
                            <strong>Add Supplier</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Add Supplier <small>Ensure to fill all neccesary fields</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                <?php 
                      if(isset($_POST['suppliername'],$_POST['address'],$_POST['phone'],$_POST['email'])){
                    $suppliername=mysqli_real_escape_string($con,trim($_POST['suppliername']));
                    $address=mysqli_real_escape_string($con,trim($_POST['address']));
                    $phone=mysqli_real_escape_string($con,trim($_POST['phone']));
                  $email=  mysqli_real_escape_string($con,trim($_POST['email']));     
                  $products=$_POST['products'];
     if((empty($suppliername))||(empty($address))||(empty($phone))){
         $errors[]='Some Fields marked * are Empty';
     }
       if(!empty($errors)){
                    foreach ($errors as $error) {
                        echo '<div class="alert alert-danger">'.$error.'</div>';              
                          }
                      }else{                 
                      mysqli_query($con,"INSERT INTO suppliers(suppliername,address,phone,email,admin_id,timestamp,status) VALUES('$suppliername','$address','$phone','$email','".$_SESSION['hotelsys']."','$timenow',1)") or die(mysqli_error($con));
                  $last_id= mysqli_insert_id($con);
                  foreach ($products as $product) {
                      mysqli_query($con,"INSERT INTO supplierproducts(product_id,supplier_id,status) VALUES('$product','$last_id',1)");
                  }
                      echo '<div class="alert alert-success">Supplier Successfully Edited</div>';
                      }
                      }                 
                      ?>
                      <form action="" method="POST" enctype="multipart/form-data">
                                 <div class="form-group">
                                        <label>Supplier Name *</label>
                                        <input type="text" class="form-control" name="suppliername" required="required">
	                    </div>
                      
                                   <div class="form-group">
                                        <label>Address *</label>
                                        <input type="text" class="form-control" name="address" required="required">
	                    </div>
                                        <div class="form-group">
                                        <label>Phone*</label>
                                        <input type="text" class="form-control" name="phone" required="required">
	                    </div>
                                     <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email">
	                    </div>                                                  
                            <div class="form-group">
                      <label>Products Supplied</label>
                       <select data-placeholder="Choose Products..." class="chosen-select" name='products[]' multiple style="width:100%;" tabindex="4">
                             
                        <?php
               $stock=mysqli_query($con,"SELECT * FROM stock_items WHERE status=1");
               while($row=  mysqli_fetch_array($stock)){
  $stockitem_id=$row['stockitem_id'];
  $cat_id=$row['category_id'];
$stockitem=$row['stock_item'];
  $minstock=$row['minstock'];
  $measurement=$row['measurement'];
  $status=$row['status'];
                    ?>
                          <option value="<?php echo $stockitem_id; ?>"><?php echo $stockitem; ?></option>
                   <?php } ?>
                      </select>
                    </div>
                      <div class="form-group">
                          <button class="btn btn-primary" type="submit">Submit</button>
                      </div>                 
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </div>
                                       <?php }?>
    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/bootstrap-tagsinput.min.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
 <script src="js/plugins/chosen/chosen.jquery.js"></script>      
        <script type="text/javascript">
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


<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/form_basic.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:38:04 GMT -->
</html>
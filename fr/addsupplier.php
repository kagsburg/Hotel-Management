
    <div id="wrapper">

        <?php include 'nav.php'; ?>

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
                    <h2>Ajouter Fournisseur</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>                         <a href="suppliers">Fournisseur</a>                       </li>
                        <li class="active">
                            <strong>Ajouter Fournisseur</strong>
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
                            <h5>Ajouter Fournisseur <small>Tapez Assurez-vous de remplir tous les champs nécessaires</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                <?php
                      if (isset($_POST['suppliername'],$_POST['address'],$_POST['phone'],$_POST['email'])) {
                          $suppliername=mysqli_real_escape_string($con, trim($_POST['suppliername']));
                          $address=mysqli_real_escape_string($con, trim($_POST['address']));
                          $phone=mysqli_real_escape_string($con, trim($_POST['phone']));
                          $email=  mysqli_real_escape_string($con, trim($_POST['email']));
                          $products=$_POST['products'];
                          if ((empty($suppliername))||(empty($address))||(empty($phone))) {
                              $errors[]='Some Fields marked * are Empty';
                          }
                          if (!empty($errors)) {
                              foreach ($errors as $error) {
                                  echo '<div class="alert alert-danger">'.$error.'</div>';
                              }
                          } else {
                              mysqli_query($con, "INSERT INTO suppliers(suppliername,address,phone,email,admin_id,timestamp,status) VALUES('$suppliername','$address','$phone','$email','".$_SESSION['hotelsys']."','$timenow',1)") or die(mysqli_error($con));
                              $last_id= mysqli_insert_id($con);
                              foreach ($products as $product) {
                                  mysqli_query($con, "INSERT INTO supplierproducts(product_id,supplier_id,status) VALUES('$product','$last_id',1)");
                              }
                              echo '<div class="alert alert-success">Supplier Successfully Edited</div>';
                          }
                      }
        ?>
                      <form action="" method="POST" enctype="multipart/form-data">
                                 <div class="form-group">
                                        <label>Nom Fournisseur*</label>
                                        <input type="text" class="form-control" name="suppliername" required="required">
	                    </div>
                      
                                   <div class="form-group">
                                        <label>Addresse *</label>
                                        <input type="text" class="form-control" name="address" required="required">
	                    </div>
                                        <div class="form-group">
                                        <label>Téléphone*</label>
                                        <input type="text" class="form-control" name="phone" required="required">
	                    </div>
                                     <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email">
	                    </div>                                                  
                            <div class="form-group">
                      <label>Produits fournis</label>
                       <select data-placeholder="Choisissez des produits..." class="chosen-select"
                        name='products[]' multiple style="width:100%;" tabindex="4">
                             
                        <?php
               $stock=mysqli_query($con, "SELECT * FROM stock_items WHERE status=1");
        while ($row=  mysqli_fetch_array($stock)) {
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
                          <button class="btn btn-primary" type="submit">Enregistrer</button>
                      </div>                 
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </div>

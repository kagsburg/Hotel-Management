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
                    <h2>Fournisseurs</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                                          <li class="active">
                            <strong>catégories de produits</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <a href="addsupplier" class="btn btn-info">Ajouter Fournisseur</a>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Tous les fournisseurs <small>trier, chercher</small></h5>
                       
                    </div>
                    <div class="ibox-content">
         
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                        <tr>
                           <th scope="col">Nom fournisseur</th>                            
                           <th scope="col">Téléphone</th>    
                          <th scope="col">Addresse</th>   
                          <th scope="col">Email</th>   
                          <th scope="col">Produits</th>                          
                          <th scope="col">&nbsp;</th>                   
                        </tr>
                      </thead>
                      <tbody>
                  <?php
                   $suppliers=  mysqli_query($con, "SELECT * FROM suppliers WHERE status=1") or die(mysqli_error($con));
        while ($row=  mysqli_fetch_array($suppliers)) {
            $supplier_id=$row['supplier_id'];
            $suppliername=$row['suppliername'];
            $email=$row['email'];
            $phone=$row['phone'];
            $address=$row['address'];
            ?>
                        <tr>
                          <td><?php echo $suppliername;?></td>
                          
                            <td><?php echo $phone;?></td>
                          <td><?php echo $address;?></td>
                          <td><?php echo $email;?></td>
                          <td><?php
                    $productarray=array();
            $getsupplierproducts= mysqli_query($con, "SELECT * 
                              FROM supplierproducts WHERE supplier_id='$supplier_id'");
            while ($row1= mysqli_fetch_array($getsupplierproducts)) {
                $product_id=$row1['product_id'];
                $getproduct=  mysqli_query($con, "SELECT * FROM stock_items
                    WHERE stockitem_id='$product_id' AND status=1") or die(mysqli_error($con));
                $row2=  mysqli_fetch_array($getproduct);
                $stockitem=$row2['stock_item'];
                array_push($productarray, $stockitem);
            }
            $List = implode(', ', $productarray);
            ?></td>                    
                        <td>
                            <button  data-toggle="modal" data-target="#supplier<?php echo $supplier_id; ?>" 
                             class="btn btn-xs btn-info">Editer</button>
                            <a href="removesupplier?id=<?php echo $supplier_id; ?>" 
                            class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $supplier_id;?>()">Supprimer</a>
                        <script type="text/javascript">
                    function confirm_delete<?php echo $supplier_id; ?>() {
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
                   $suppliers=  mysqli_query($con, "SELECT * FROM suppliers WHERE status=1") or die(mysqli_error($con));
        while ($row=  mysqli_fetch_array($suppliers)) {
            $supplier_id=$row['supplier_id'];
            $suppliername=$row['suppliername'];
            $email=$row['email'];

            $phone=$row['phone'];
            $address=$row['address'];
            ?>
       <div id="supplier<?php echo $supplier_id; ?>" class="modal fade" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifier le fournisseur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                           <div class="modal-body">
                                  <form action="editsupplier?id=<?php echo $supplier_id; ?>" method="POST">
                                 <div class="form-group">
                                        <label>Nom du fournisseur *</label>
                                        <input type="text" class="form-control"
                                         name="suppliername" required="required" value="<?php echo $suppliername; ?>">
	                    </div>
                                   
                                   <div class="form-group">
                                        <label>Addresse *</label>
                                        <input type="text" class="form-control"
                                         name="address" required="required" value="<?php echo $address; ?>">
	                    </div>
                                                        <div class="form-group">
                                        <label>Téléphone*</label>
                                        <input type="text" class="form-control" 
                                        name="phone" required="required" value="<?php echo $address; ?>">
	                    </div>
                                     <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
	                    </div>   
                                       <div class="form-group">
                      <label>Produits fournis</label>
                      <select class="form-control select2" name="products[]" multiple style="width:100%">
                        <?php
             $stock=mysqli_query($con, "SELECT * FROM stock_items WHERE status=1");
            while ($row=  mysqli_fetch_array($stock)) {
                $stockitem_id=$row['stockitem_id'];
                $cat_id=$row['category_id'];
                $stockitem=$row['stock_item'];
                $minstock=$row['minstock'];
                $measurement=$row['measurement'];
                $status=$row['status'];

                $getsupplierproducts= mysqli_query($con, "SELECT * FROM supplierproducts WHERE
                      supplier_id='$supplier_id' AND product_id='$stockitem_id'");
                if (mysqli_num_rows($getsupplierproducts)>0) {
                    ?>
                          <option value="<?php echo $stockitem_id; ?>" 
                          selected="selected"><?php echo $stockitem; ?></option>
                   <?php } else { ?>
                     <option value="<?php echo $stockitem_id; ?>">
                     <?php echo $stockitem; ?></option>      
               <?php    }
            } ?>
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
                   <?php }?>
    
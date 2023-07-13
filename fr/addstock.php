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
                    <h2>Ajouter Stock</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>  <a href="stockitems">Stock</a>                       </li>
                        <li class="active">
                            <strong>Ajouter Stock</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
       
                                <div class="row">
                                    
                                            <div class="col-lg-10">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Ajouter un nouveau stock 
                                <small>tous les champs marqués(*) ne doivent pas restés vides</small></h5>                           
                        </div>
                        
                        <div class="ibox-content">
                             <?php
if (isset($_POST['submit'])) {
    $date= mysqli_real_escape_string($con, strtotime($_POST['date']));
    if (empty($date)) {
        echo '<div class="alert alert-danger">Date is required</div>';
    } else {
        $supplier=$_POST['supplier'];
        $item=$_POST['item'];
        $quantity=$_POST['quantity'];
        mysqli_query($con, "INSERT INTO addedstock(date,admin_id,status) 
   VALUES('$date','".$_SESSION['hotelsys']."',1)") or die(mysqli_errno($con));
        $last_id=mysqli_insert_id($con);
        $allproducts= sizeof($item);
        for ($i=0;$i<$allproducts;$i++) {
            $activity=$fullname.' added '.$quantity[$i];
            mysqli_query($con, "INSERT INTO stockitems(item_id,quantity,addedstock_id,supplier_id,status) VALUES('$item[$i]','$quantity[$i]','$last_id','$supplier[$i]',1)");
            mysqli_query($con, "INSERT INTO stockevents(item_id,activity,timestamp,status) VALUES('$item[$i]','$activity','$date','1')") or die(mysqli_error($con));
        }
        ?>
<div class="alert alert-success"><i class="fa fa-check"></i>Stock ajouté avec succès</div>
  <?php
    }
}
        ?>
    <form method="post" name='form' class="form" action=""  enctype="multipart/form-data">
         <div class="row">
           <div class="form-group col-lg-6"><label class="control-label">* Date de fourniture </label>
                 <input type="date" name="date" class="form-control">
             </div>
         </div>
                                     <div class='subobj'>
                          <div class='row'>
                                  <div class="form-group col-lg-6"><label class="control-label">* Produits </label>
                                         <select data-placeholder="Choose item..." name="item[]" class="chosen-select" style="width:100%;" tabindex="2">
                                    <option value="" selected="selected">Choisir L’ élément..</option>
                                        <?php
                       $stock=mysqli_query($con, "SELECT * FROM stock_items WHERE status=1");
        while ($row=  mysqli_fetch_array($stock)) {
            $stockitem_id=$row['stockitem_id'];
            $cat_id=$row['category_id'];
            $stockitem=$row['stock_item'];
            $minstock=$row['minstock'];
            $measurement=$row['measurement'];
            $status=$row['status'];
            $getmeasure=  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
            $row2=  mysqli_fetch_array($getmeasure);
            $measurement2=$row2['measurement'];
            ?>
                                    <option value="<?php echo $stockitem_id; ?>"><?php echo $stockitem.' ('.$measurement2.')'; ?></option>
               <?php }?>
                                         </select>
                                                                                                        </div>
                                  <div class="form-group col-lg-5"><label class="control-label">Quantité</label>
                                    <input type="text" name='quantity[]' class="form-control" placeholder="Quantité">
                                                                                                        </div>
                        
                               <div class="form-group col-lg-1">
                                                         <a href='#' class="subobj_button btn btn-success" style="margin-top:25px">+</a>                                              
                                            </div> 
                                <div class="form-group col-lg-6"><label class="control-label">Fournisseur</label>
                                  <select data-placeholder="Choose supplier..." name="supplier[]" class="chosen-select" style="width:100%;" tabindex="2">
                                    <option value="" selected="selected">choisir le fournisseur..</option>
                                        <?php
                $suppliers=  mysqli_query($con, "SELECT * FROM suppliers WHERE status=1") or die(mysqli_error($con));
        while ($row=  mysqli_fetch_array($suppliers)) {
            $supplier_id=$row['supplier_id'];
            $suppliername=$row['suppliername'];
            $email=$row['email'];
            ?>
                                    <option value="<?php echo $supplier_id; ?>"><?php echo $suppliername; ?></option>
               <?php }?>
                                         </select>
                                                                                                        </div>
                          
                                  </div>
                                                                                                        </div>    
                              <div class="form-group">
                                  <button class="btn btn-success" type="submit" name="submit">Ajouter Stock</button>
                                       </div>
                            </form>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
        </div>
    </div>

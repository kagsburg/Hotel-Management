
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
                    <h2>Créer une liste d'achat</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>                         <a>Inventaire</a>                       </li>
                        <li class="active">
                            <strong>créer une liste</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-6">
           
                  
                      <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Sélectionnez les éléments dans la liste</h5>                           
                        </div>
                        <div class="ibox-content menu-list">
                                 <table class="table table-striped table-bordered table-hover dataTables-example"  id="datatable"> 
                                      <thead>
                                    <tr>
                                        <th>Nom Article</th>                                       
                                        <th>Quantité</th>
                                         <th>Prix ​​unitaire</th>
                                        <th>&nbsp;</th>
                                                    </tr>
                                    </thead>
                                     <tbody>
                                <?php
$stock=mysqli_query($con, "SELECT * FROM stock_items ORDER BY stock_item");
        while ($row=  mysqli_fetch_array($stock)) {
            $stockitem_id=$row['stockitem_id'];
            $stockitem=$row['stock_item'];
            //  $quantity=$row['quantity'];
            $minstock=$row['minstock'];
            // $itemcategory_id=$row['itemcategory_id'];
            $measurement=$row['measurement'];
            $status=$row['status'];
            $getmeasure=  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
            $row2=  mysqli_fetch_array($getmeasure);
            $measurement2=$row2['measurement']

            ?>
                                         <form class="form-item">
                                   <tr><td><?php echo $stockitem.' ('.$measurement2.')'; ?></td>
                                        <td>
                                          
                  <input type="text" class="form-control" name="product_qty" style="width:60px" required="required"> 
                                       </td>
                                       <td><input type="text" class="form-control" name="price" style="width:70px" required="required"> </td>
                                      
    <td>
              <input type="hidden" name="item_id" value="<?php echo $stockitem_id; ?>">
        <button class="btn btn-xs btn-success" type="submit">Ajouter dans la liste</button></td>
                                        </tr>
                                                     </form>   
 <?php }?>
                                        </tbody>
                                 </table>  
                             </div></div>
                    <a href="listdetails" class="btn btn-primary">Procéder</a>
                    </div>
                                                           <div class="col-lg-6 parentdiv">
                    <div class="ibox float-e-margins" id="ordered">
                        <div class="ibox-title">
                            <h5>Créer une liste</h5>
                            <label class="label label-info pull-right" id="label-info">
                           <?php
if (isset($_SESSION["rproducts"])) {
    echo count($_SESSION["rproducts"]);
} else {
    echo 0;
}
        ?>
                                </label>
                        </div>
                        <div class="ibox-content ">
                        <div class="showit ">
                     
                        </div>
                         
<!--                            <a href="view_cart" class="btn btn-sm btn-primary">View Order</a>-->
                        </div>
                        
                        </div>
                </div>
                </div>                                 
                        </div>
        </div>
        </div>
    </div>

    <!-- Mainly scripts -->

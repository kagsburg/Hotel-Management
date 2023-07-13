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
                    <h2>Articles en stock</h2>
                    <ol class="breadcrumb">
                        <li>  <a href="index"><i class="fa fa-home"></i> Accueil</a>  </li>                       
                                               <li class="active">
                            <strong>Afficher les articles en stock</strong>
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
                        <h5>Tous les articles en stock<small>trier, chercher</small></h5>
                        <a href="stockprint" target="_blank" class="btn btn-sm btn-warning pull-right">
                            <i class="fa fa-print"></i> Imprimer en PDF</a>
                    </div>
                    <div class="ibox-content">
<?php
$stock=mysqli_query($con, "SELECT * FROM stock_items WHERE status=1");
        if (mysqli_num_rows($stock)>0) {
            ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Articles en stock</th>
                        <th>Stock Minimum</th>
                        <th>Unité</th>
                        <th>Catégorie</th>
                        <th>Stock Statut</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
                           while ($row=  mysqli_fetch_array($stock)) {
                               $stockitem_id=$row['stockitem_id'];
                               $cat_id=$row['category_id'];
                               $stockitem=$row['stock_item'];
                               $minstock=$row['minstock'];
                               $measurement=$row['measurement'];
                               $status=$row['status'];
                               $getadded= mysqli_query($con, "SELECT SUM(quantity) as addedstock FROM 
  stockitems WHERE item_id='$stockitem_id'") or die(mysqli_error($con));
                               $rowa= mysqli_fetch_array($getadded);
                               $addedstock=$rowa['addedstock'];
                               $getissued= mysqli_query($con, "SELECT SUM(quantity) as issuedstock FROM 
issueditems WHERE item_id='$stockitem_id'") or die(mysqli_error($con));
                               $rowi= mysqli_fetch_array($getissued);
                               $issuedstock=$rowi['issuedstock'];
                               $stockleft=$addedstock-$issuedstock;
                               ?>
               <tr class="gradeA">
                    <td><?php echo $stockitem_id; ?></td>
                        <td><?php echo $stockitem; ?></td>
                        <td><?php echo $minstock; ?></td>
                  <td> <div class="tooltip-demo">
                                      <?php
                                                              $getmeasure=  mysqli_query($con, "SELECT * FROM
                                               stockmeasurements WHERE measurement_id='$measurement'");
                               $row2=  mysqli_fetch_array($getmeasure);
                               $measurement2=$row2['measurement'];
                               echo $measurement2; ?> </div></td>
     <td><?php
     $getcat=  mysqli_query($con, "SELECT * FROM categories WHERE status=1 AND category_id='$cat_id'");
                               $row1=  mysqli_fetch_array($getcat);
                               $category_id=$row1['category_id'];
                               $category=$row1['category'];
                               echo $category;
                               ?></td>                   
            <th><?php      if ($stockleft<=$minstock) {
                echo '<div class="text-danger">LOW</div>';
            } else {
                echo 'HIGH';
            } ?></th>                                      
  <td class="center"> 
       <a href="itemdetails?id=<?php echo $stockitem_id; ?>" class="btn btn-info btn-xs">
       <i class="fa fa-plus"></i> Détails des Articles</a> 
                                                
                            </td>
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }?>
                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>

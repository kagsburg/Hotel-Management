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
                    <h2>Ajouter une Nouvelle Commande</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>    
                                    </li>
                        <li>        <a>Réstaurant</a>                       </li>
                        <li class="active">
                            <strong>Ajouter Une Commande</strong>
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
                            <h5>Sélectioner élément(s) a partir du Menu</h5>
                           
                        </div>
                        <div class="ibox-content menu-list">
          <table class="table table-striped table-bordered table-hover dataTables-example" >
                                      <thead>
                                    <tr>
                                        <th>Nom de L’ élément</th>
                                        <th>Prix</th>
                                        <th>Quantité</th>
                                        <th>&nbsp;</th>
                                                    </tr>
                                    </thead>
                                     <tbody>
                                <?php
$fooditems=mysqli_query($con, "SELECT * FROM menuitems WHERE status='1' ORDER BY menuitem");
   while ($row=  mysqli_fetch_array($fooditems)) {
       $menuitem_id=$row['menuitem_id'];
       $menuitem=$row['menuitem'];
       $itemprice=$row['itemprice'];

       ?>
    <form class="form-item">
                                   <tr><td><?php echo $menuitem; ?></td><td><?php echo $itemprice; ?></td>
                                       <td>
                                          
                  <input type="text" class="form-control" name="product_qty" style="width:40px" required="required"> 
                                       </td>
    <td>
              <input type="hidden" name="item_id" value="<?php echo $menuitem_id; ?>">
        <button class="btn btn-xs btn-success" type="submit">Ajouter</button></td>
                                        </tr>
                                                     </form>   
 <?php }?>
                                        </tbody>
                                 </table>  
                             </div></div>
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                          <h5>Entrer Les Détails de la Commande <small class="text-danger">Entrer Les Détails de la Commande , Séléctionner d’ abord les commandes</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                                 
                            <form method="get" name='form' class="form" action="restorderdetails"  enctype="multipart/form-data">
                              
                          
                                    <div class="form-group"><label class="control-label">*Serveur</label>

                                    <input type="text" class="form-control" name='waiter' placeholder="Serveur">
                                                             <div id='form_waiter_errorloc' class='text-danger'></div>
                                                          </div> 
                              
                                        <div class="form-group"><label class="control-label">*Table</label>
                                            <select name="rtable" class="form-control">
                                                <option value="" selected="selected">Selectionner la Table</option>
                                <?php
                    $tables=mysqli_query($con, "SELECT * FROM hoteltables WHERE area='rest' AND status='1'");
   while ($row=  mysqli_fetch_array($tables)) {
       $hoteltable_id=$row['hoteltable_id'];
       $table_no=$row['table_no'];
       ?>
                       <option value="<?php echo $hoteltable_id; ?>"><?php echo $table_no; ?></option>
<?php }?>
                                                                    </select>
                            <!--<div id='form_rtable_errorloc' class='text-danger'></div>-->
                                                            
                                                          </div>     
                            <div class="form-group">
                                <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="linked" id="resident">
                    <label class="form-check-label" for="defaultCheck1">
                    le client est_il un résident de l’hôtel ?
                    </label>
                    </div>    
                    </div>   
        <div class="form-group forresidents" style="display:none"><label class="control-label">*Sélectionnez Résident</label>
                                                <select name="guest" class="form-control">
                                                    <option value="0" selected="selected">Sélectionnez Résident</option>
                                    <?php
$reservation=mysqli_query($con, "SELECT * FROM reservations WHERE status='1'");
   while ($row=  mysqli_fetch_array($reservation)) {
       $firstname1=$row['firstname'];
       $lastname1=$row['lastname'];
       $room_id=$row['room'];
       $reservation_id=$row['reservation_id'];
       $roomtypes=mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
       $row1=  mysqli_fetch_array($roomtypes);
       $roomnumber=$row1['roomnumber'];

       ?>
                       <option value="<?php echo $reservation_id; ?>">
                       <?php echo $firstname1.' '.$lastname1 .' ('.$roomnumber.')';  ?></option>
<?php }?>
                                                                    </select>
                                                                                   
                                                          </div>     
          <div class="form-group">
                                                                    
                                        <button class="btn btn-primary" type="submit" name="submit">
Procéder</button>
                                                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
                                   
                                    <div class="col-lg-6 parentdiv">
                    <div class="ibox float-e-margins" id="ordered">
                        <div class="ibox-title">
                            <h5>Commandes du clients</h5>
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

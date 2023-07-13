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
                <div class="col-lg-12">
                    <h2>Commandes a L’ Hotel des Clients n’ Ayant pas de Reservation</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                       
                         <li>
                            <a>Menu</a>
                        </li>
                        <li class="active">
                            <strong>Commandes</strong>
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
                        <h5>Toutes les Commandes <small>Trier, Rechercher</small></h5>
                                           </div>
                    <div class="ibox-content">
<?php
$restorders=mysqli_query($con, "SELECT * FROM orders WHERE status IN(1,2) AND guest='0' ORDER BY order_id DESC");
        if (mysqli_num_rows($restorders)>0) {
            ?>
      <table class="table table-striped table-bordered table-hover dataTables-example"  id="datatable">
        <thead>
                 <tr>
                         <th>N° de commande</th>
                         <th>Commandes</th>
                           <th>Prix Total</th>
                         <th>Table</th>
                                      <th>Serveur</th>
                           <th>Date</th>
                           <th>Paiment</th>
                           <th>Action</th>
                        
                        </tr>
                    </thead>
                    <tbody>
              <?php
                         while ($row=  mysqli_fetch_array($restorders)) {
                             $order_id=$row['order_id'];
                             $guest=$row['guest'];
                             $rtable=$row['rtable'];
                             $discount=$row['discount'];
                             $waiter=$row['waiter'];
                             $status=$row['status'];
                             $mode=$row['mode'];
                             $timestamp=$row['timestamp'];
                             $foodsordered=  mysqli_query($con, "SELECT * FROM restaurantorders WHERE order_id='$order_id'");
                             ?>
               <tr class="gradeA">
                        <td><?php echo 23*$order_id; ?></td>
                      <td><?php
                               while ($row3=  mysqli_fetch_array($foodsordered)) {
                                   $restorder_id=$row3['restorder_id'];
                                   $food_id=$row3['food_id'];
                                   $price=$row3['foodprice'];
                                   $quantity=$row3['quantity'];

                                   $foodmenu=mysqli_query($con, "SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                                   $row=  mysqli_fetch_array($foodmenu);
                                   $menuitem_id=$row['menuitem_id'];
                                   $menuitem=$row['menuitem'];
                                   echo $quantity.' '.$menuitem.'<br/>';
                               }
                             ?></td>
                         <td class="center">
                                        <?php
                                                      $totalcharges=mysqli_query($con, "SELECT 
                                               COALESCE(SUM(foodprice*quantity), 0) AS totalcosts 
                                               FROM restaurantorders WHERE order_id='$order_id'");
                             $row=  mysqli_fetch_array($totalcharges);
                             $totalcosts=$row['totalcosts'];
                             $net=$totalcosts-(($discount/100)*$totalcosts);
                             echo number_format($net);
                             ?>
                        </td>
                                            <td> <?php   echo $rtable;  ?></td>
                      <td><?php  echo $waiter;  ?></td>
                    <td><?php echo date('d/m/Y', $timestamp);?></td>    
                    <td style="font-weight: bold"><?php   if ($status==1) {
                        echo '<span class="text-info">PAID</span>
                         ('.$mode.')';
                    } else {
                        echo '<span class="text-warning">PENDING</span>';
                    }  ?></td>
                           <td>
                          
                               <a href="restinvoice?id=<?php echo $order_id; ?>" class="btn btn-xs btn-success">Voir la Facture</a>
                            <?php
                            if ($status==2) {
                                ?>
                                     <button data-toggle="modal" data-target="#basicModal<?php echo $order_id; ?>"  
                                     class="btn btn-xs btn-info">Approuver le Paiement</button>
                           
                               <!--<a href="restorderpayment?id=<?php echo $order_id; ?>" class="btn btn-xs btn-info"
                                onclick="return confirm_payment<?php echo $order_id; ?>()">Approve Payment</a><br>-->
                            <?php }?>
                               <a href="hiderestorder?id=<?php echo $order_id;?>" class="btn btn-xs btn-danger" 
                               onclick="return confirm_delete<?php echo $order_id; ?>()">Annuler</a>
                                <script type="text/javascript">
                                   function confirm_payment<?php echo $order_id; ?>() {
  return confirm('You are about To confirm Payment. Are you sure you want to proceed?');
}
function confirm_delete<?php echo $order_id; ?>() {
  return confirm('You are about To Remove this Order. Are you sure you want to proceed?');
}
</script>                 
                           </td>       
                                          
                      </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php } else {?>
                        <div class="alert alert-danger">
    Aucune commande de restaurant ajoutée pour le moment</div>
 <?php }?>
                    </div>
                </div>
            </div>
                
            </div>
          
        </div>
        </div>


    </div>
<?php
$restorders=mysqli_query($con, "SELECT * FROM orders WHERE status IN(1,2) AND guest='0' ORDER BY order_id DESC");
        while ($row=  mysqli_fetch_array($restorders)) {
            $order_id=$row['order_id'];
            ?>
      <div id="basicModal<?php echo $order_id; ?>" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form action="restorderpayment?id=<?php echo $order_id; ?>" method="POST">
                                    <div class="form-group">
	                      <label>Mode de paiement</label>
                              <select name="mode" class="form-control">
                                  <option value=""selected="selected">
                        Sélectionnez le mode</option>
                                  <option value="Bonus">Bonus</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Credit">Credit</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Visa Card">Visa Card</option>
                                                <option value="Lumicash">Lumicash</option>
                                                <option value="Ecocash">Ecocash</option>
                              </select>
	                    </div>
                      <div class="form-group">
                          <button class="btn btn-primary" type="submit">Envoyer</button>
                      </div>                 
                          </form>
              </div>
           
            </div>
          </div>
        </div>
      <?php }?>
    <!-- Mainly scripts -->
   
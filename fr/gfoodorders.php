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
                    <h2>Commandes d'hôtel des clients réservés</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                       
                         <li>
                            <a>Menu</a>
                        </li>
                        <li class="active">
                            <strong> Commandes Réstaurant</strong>
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
                        <h5>Toutes les Commandes <small>Trier, Rechercher</small></h5>                        
                    </div>
                    <div class="ibox-content">
<?php
$restorders=mysqli_query($con, "SELECT * FROM orders WHERE status IN (1,2) AND guest>'0' ORDER BY order_id DESC");
        if (mysqli_num_rows($restorders)>0) {
            ?>
  <form action="archiverestaurant" method="post"> 
                                            <table class="table table-striped table-bordered table-hover dataTables-example"  id="datatable">
        <thead>
                 <tr>
                         <th>N° de commande</th>
                         <th>Commandes</th>
                           <th>Prix</th>
                           <th>Détails du client</th>
                           <th>Serveur</th>
                                 <th>Date</th>
                           <th>Action</th>
                    
                        </tr>
                    </thead>
                    <tbody>
              <?php
                          while ($row=  mysqli_fetch_array($restorders)) {
                              $order_id=$row['order_id'];
                              $guest=$row['guest'];
                              $waiter=$row['waiter'];
                              $creator=$row['creator'];
                              $timestamp=$row['timestamp'];
                              $foodsordered=  mysqli_query($con, "SELECT * FROM restaurantorders WHERE order_id='$order_id'");
                              ?>
             <tr class="gradeA">
                        <td> <?php echo 23*$order_id; ?></td>
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
                              echo number_format($totalcosts);
                              ?>
                        </td>
                        <td>
                            <?php

                               $reservation=mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$guest'");
                              $row=  mysqli_fetch_array($reservation);
                              $firstname1=$row['firstname'];
                              $lastname1=$row['lastname'];
                              $room_id=$row['room'];
                              $roomtypes=mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                              $row1=  mysqli_fetch_array($roomtypes);
                              $roomnumber=$row1['roomnumber'];
                              echo $firstname1.' '.$lastname1 .' ('.$roomnumber.')';
                              ?>
                        </td>
                         <td><?php echo $waiter;?></td>
                      <td><?php echo date('d/m/Y', $timestamp);?></td>    
                           <td>
                             
                               <a href="restinvoice_print?id=<?php echo $order_id; ?>"
                                class="btn btn-xs btn-success">Voir les Factures</a>                           
                              <a href="hiderestorder?id=<?php echo $order_id;?>"
                               class="btn btn-xs btn-danger" onclick="return
                                confirm_delete<?php echo $order_id; ?>()">Annuler</a>
                            
                                 <script type="text/javascript">
function confirm_delete<?php echo $order_id; ?>() {
  return confirm('You are about To Remove this Order. Are you sure you want to proceed?');
}
</script>                 
                           </td>       
                                              
                      </tr>
                 <?php }?>
                    </tbody>
                                    </table> </form>
 <?php } else {?>
                        <div class="alert alert-danger">Aucune commande de restaurant ajoutée pour le moment</div>
 <?php }?>
                    </div>
                </div>
            </div>
                
            </div>
          
        </div>
        </div>


    </div>

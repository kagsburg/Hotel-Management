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
                    <h2>Restaurant & Bar Rapport entre <?php echo date('d/m/Y', $start); ?> et <?php echo date('d/m/Y', $end); ?></h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Accueil</a>                    </li>
                     
                                          <li class="active">
                            <strong>Rappor du Restaurant</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-12">
                    <a href="restaurantreportprint?start=<?php echo $st;?>&&end=<?php echo $en; ?>"
                      target="_blank" class="btn btn-success ">Imprimer en PDF</a><br/><br/>
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                      <h5>Rapport du restaurant généré</h5>
                     </div>
                        <div class="ibox-content">
                             <?php
  if ($start>$end) {
      $errors[]='Start Date Cant be later than End Date';
  }
if (!empty($errors)) {
    foreach ($errors as $error) {
        ?>
 <div class="alert alert-danger"><?php echo $error; ?></div>
<?php
    }
} else {  ?>
           <h2 class="text-center">
RAPPORT BAR & RESTAURANT</h2>
    <div class="table-responsive m-t">
        <?php
                       $totalbill=0;
    $restorders=mysqli_query($con, "SELECT * FROM orders WHERE status IN(1,2) 
 AND timestamp>='$start' AND timestamp<='$end' ORDER BY order_id");
    if (mysqli_num_rows($restorders)>0) {
        ?>
                                <table class="table table-bordered">
                                    <thead>
                                 <th>N° de commande</th>
                                   <th>Date</th>
                         <th>Commandes</th>
                          <th>Table</th>
                           <th>Serveur</th>
                         <th>Type de client</th>
                              <th>Prix Total</th>
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
                 $timestamp=$row['timestamp'];
                 $foodsordered=  mysqli_query($con, "SELECT * FROM restaurantorders WHERE order_id='$order_id'");
                 ?>
     <tr>
                             <td><?php echo 23*$order_id; ?></td>
                                     <td><?php echo date('d/m/Y', $timestamp);?></td> 
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
                      
                      
                                            <td> <?php   echo $rtable;  ?></td>
                      <td><?php  echo $waiter;  ?></td>
               
                      <td><?php if ($guest>0) {
                          echo 'RESIDENT';
                      } else {
                          echo 'NON RESIDENT';
                      }  ?></td>
                             <td class="center">
                                        <?php
                                               $totalcharges=mysqli_query(
                          $con,
                          "SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'"
                      );
                 $row=  mysqli_fetch_array($totalcharges);
                 $totalcosts=$row['totalcosts'];
                 $net=$totalcosts-(($discount/100)*$totalcosts);
                 echo number_format($net);
                 $totalbill=$totalbill+$net;
                 ?>
                        </td>
                                    </tr>
                <?php } ?>

                                    </tbody>
                                </table>
                            <?php } ?>
                            </div><!-- /table-responsive -->
<table class="table invoice-total">
                                <tbody>
                                                               <tr>
                                    <td><strong>TOTALE :</strong></td>
                                    <td><strong><?php echo number_format($totalbill);?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                         
    <?php
}

        ?>
                        
  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </div>

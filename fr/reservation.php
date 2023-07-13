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
                    <h2>Réservation d'hôtel</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Accueil</a>                    </li>
                       
                         <li>
                             <a href="guestsin">Réservation</a>
                        </li>
                        <li class="active">
                            <strong>Afficher les détails de la réservation</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Détails de l'invité</h5>
                       
                    </div>
                    <div class="ibox-content">
<?php
$reservations=mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$id'");
        $row=  mysqli_fetch_array($reservations);
        $reservation_id=$row['reservation_id'];
        $firstname=$row['firstname'];
        $lastname=$row['lastname'];
        $checkin=$row['checkin'];
        $arrivaltime=$row['arrivaltime'];
        $arrivingfrom=$row['arrivingfrom'];
        $departuretime=$row['departuretime'];
        $phone=$row['phone'];
        $email=$row['email'];
        $adults=$row['adults'];
        $kids=$row['kids'];
        $mealplan_id=$row['mealplan'];
        $extrabed=$row['extrabed'];
        $company=$row['company'];
        $dob=$row['dob'];
        $usdtariff=$row['usdtariff'];
        $fax=$row['fax'];
        $website=$row['website'];
        $mode=$row['mode'];
        $modevalue=$row['modevalue'];
        $id_number=$row['id_number'];
        $checkout=$row['checkout'];
        $actualcheckout=$row['actualcheckout'];
        $room_id=$row['room'];
        $email=$row['email'];
        $status=$row['status'];
        $nationality=$row['nationality'];
        $creator=$row['creator'];
        $occupation=$row['occupation'];


        ?>
     <div>
                                <div class="feed-activity-list">

                                    <div class="feed-element">
                                <div class="media-body ">
                                    <strong>Nom du Client</strong>. : <?php echo $firstname.' '.$lastname; ?> <br>
</div>
                                    </div>
                                      
                                         <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Nationalité</strong>. : <?php echo $nationality; ?> <br>
                </div>
                                    </div>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Numéro de Téléphone</strong>. : <?php echo $phone; ?> <br>
                                             </div>
                                    </div>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Occupation</strong>. : <?php echo $occupation; ?> <br>
                                             </div>
                                    </div>
                                         <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>C Compagnie</strong>. : <?php echo $company; ?> <br>
                                             </div>
                                    </div>
                                     <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Numéro de passeport/d'identité</strong>. : <?php echo $id_number; ?> <br>
                                             </div>
                                    </div>
                                        <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Email</strong>. : <?php echo $email; ?> <br>
                                             </div>
                                    </div>
                                        <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Site Internet</strong>. : <?php echo $website; ?> <br>
                                             </div>
                                    </div>
                                        <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Fax</strong>. : <?php echo $fax; ?> <br>
                                             </div>
                                    </div>
                                         <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>USD Tariff</strong>. : <?php echo $usdtariff; ?> <br>
                                             </div>
                                    </div>
                                    <?php
                                                            if (!empty($email)) { ?>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Email</strong>. : <?php echo $email; ?> <br>
                                             </div>
                                    </div>
                                    <?php } ?>                               
                                    
                                    
                                    
                                                                                                 
                                             </div>
                            </div>
                    </div>
                </div>
           

            </div>
                <div class="col-lg-6">
                       <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Détails de la réservation</h5>
                        
                        </div>
                        <div class="ibox-content">

                            <div>
                                <div class="feed-activity-list">

                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                     <strong>Numéro Chambre: </strong>
                                                     <?php
                                      $getnumber=mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
        $row1=  mysqli_fetch_array($getnumber);
        $roomnumber=$row1['roomnumber'];
        $type_id=$row1['type'];
        echo $roomnumber; ?>
                                                     . <br>
                                                                                                                              </div>
                                    </div>
                                      <div class="feed-element">
                                                                              <div class="media-body ">
                                                     <strong>Type de chambre: </strong>
                                                     <?php
                             $roomtypes=mysqli_query($con, "SELECT * FROM roomtypes WHERE roomtype_id='$type_id'");
        $row1=  mysqli_fetch_array($roomtypes);
        $roomtype=$row1['roomtype'];
        echo $roomtype; ?>
                                                     . <br>
                                                                                                                              </div>
                                    </div>
                                      <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Adulte</strong>. : <?php echo $adults; ?> <br>
                                             </div>
                                    </div>
                                       <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Enfants</strong>. : <?php echo $kids; ?> <br>
                                             </div>
                                    </div>
                                           <div class="feed-element">
                                                    <?php
                             $mealplans=mysqli_query($con, "SELECT * FROM mealplans WHERE mealplan_id='$mealplan_id'");
        $row1=  mysqli_fetch_array($mealplans);
        $mealplan=$row1['mealplan'];
        ?>
                                                                              <div class="media-body ">
                                                                                  <strong>Plans de repas</strong>. : <?php echo $mealplan; ?> <br>
                                             </div>
                                    </div>
                                      <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Date d'arrivée</strong>  : <?php echo date('d/m/Y', $checkin); ?> <br>
                                             </div>
                                    </div>
                                       <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Heure d'arrivée</strong>  : <?php echo $arrivaltime; ?> <br>
                                             </div>
                                    </div>
                                    <?php
                                    if ($status==2) {
                                        $checkedouts=  mysqli_query($con, "SELECT * FROM checkoutdetails WHERE reserve_id='$id'");
                                        $row2=  mysqli_fetch_array($checkedouts);
                                        $checkoutdetails_id=$row2['checkoutdetails_id'];
                                        $reserve_id=$row2['reserve_id'];
                                        $paidamount=$row2['paidamount'];
                                        $totalbill=$row2['totalbill'];
                                        ?>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Départ le</strong>  : <?php echo date('d/m/Y', $actualcheckout); ?> <br>
                                             </div>
                                    </div>
                                      <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Prix Total</strong>  : <?php echo number_format($totalbill); ?> <br>
                                             </div>
                                    </div>
                                      <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Montant payé</strong>  : <?php echo number_format($paidamount); ?> <br>
                                             </div>
                                    </div>
                                    <?php } else { ?>
                                                                                                   <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Date de départ prévue</strong>  : <?php echo date('d/m/Y', $checkout); ?> <br>
                                             </div>
                                    </div>
                                     <div class="feed-element">
                                                                              <div class="media-body ">
                                    <strong>Heure de départ prévue</strong>  : <?php echo $departuretime; ?> <br>
                                             </div>
                                    </div>
                                      <div class="feed-element">
                                                                              <div class="media-body ">
                                    <strong>Mode de paiement</strong>  : <?php echo $mode;
                                        if (!empty($modevalue)) {
                                            echo ' ('.$modevalue.')';
                                        }
                                        ?> <br>
                                             </div>
                                    </div>
                                    <?php   }?>
                                    
                                       <div class="feed-element">
                                <div class="media-body ">
                                    <strong>Status</strong>  : <?php             if ($status==2) {
                                        echo '<span class="text-danger">GUEST OUT</span>';
                                    } elseif (($timenow>$checkout)&&($status==1)) {
                                        echo '<span class="text-danger">PENDING GUEST OUT</span>';
                                    } elseif (($timenow<$checkout)&&($status==1)) {
                                        echo '<span class="text-successr">GUEST IN</span>';
                                    } elseif (($timenow<$checkout)&&($status==0)) {
                                        echo '<span class="text-info">PENDING</span>';
                                    } elseif ($status==3) {
                                        echo '<span class="text-danger">CANCELLED</span>';
                                    }
        ?> <br>
                                             </div>
                                    </div>
                                    
                                    </div>
                                    </div>
                                    </div>
                       </div>
                   <?php
                    if ($_SESSION['sysrole']=='Receptionist') {
                        if ($status==1) {
                            echo '<a href="editreservation?id=<?php echo $id; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit Info</a>';
                            echo '<a href="checkoutconfirm?id='.$id.'" class="btn btn-info btn-sm" onclick="return confirm_delete()"><i class="fa fa-reply"></i> Confirm Checkout</a>&nbsp;';
                            echo '<a data-toggle="modal"  href="#modal-form"  class="btn btn-primary btn-sm">Extend Stay <i class="fa fa-arrow-right"></i></a>&nbsp;';
                        }
                        if (($status!=0)&&($status!=3)) {
                            echo '<a  href="getbill?id='.$id.'&&n='.$firstname.' '.$lastname.'"  class="btn btn-success btn-sm">Get Bill <i class="fa fa-eye"></i></a>';
                        }
                        if ($status==0) {
                            echo '<a href="checkinconfirm?id='. $reservation_id.'&&st='.$status.'" 
                          class="btn btn-success btn-sm" onclick="return confirm_checkin()"><i class="fa fa-sign-in"></i> Confirm Guest In</a>&nbsp;';
                            echo '<a href="cancelbooking?id='.$id.'" class="btn btn-info btn-sm btn-danger" onclick="return confirm_cancel()">
                            <i class="fa fa-cancel"></i> Cancel booking</a>&nbsp;';
                        }
                        ?>
                      <script type="text/javascript">
                          function confirm_checkin() {
  return confirm('You are about To checkin  this guest. Are you sure you want to proceed?');
}
function confirm_delete() {
  return confirm('You are about To checkout  this guest. Are you sure you want to proceed?');
}
function confirm_cancel() {
  return confirm('You are about To checkout  this guest. Are you sure you want to proceed?');
}
</script>    
                    <?php }?>
            </div>
                <div class="col-lg-8">
                     <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Autres services</h5>
                    <a data-toggle="modal"  href="#addotherservice" class="btn btn-sm btn-primary pull-right">Ajouter autre service</a>
                            <div style="clear: both"></div>
                       </div>
                        <div class="ibox-content">
                            <table class="table table-responsive">
                                <thead>
                   <tr><th>Date</th><th>Service</th><th>Prix</th><th>Réduction</th><th>Action</th></tr>
                              </thead>
                              <tbody>
                        <?php
                        $getotherservices= mysqli_query($con, "SELECT * FROM otherservices WHERE reservation_id='$id' AND status=1") or die(mysqli_error($con));
        while ($row3 = mysqli_fetch_array($getotherservices)) {
            $otherservice_id=$row3['otherservice_id'];
            $otherservice=$row3['otherservice'];
            $reduction=$row3['reduction'];
            $currency=$row3['currency'];
            $price=$row3['price'];
            $timestamp=$row3['timestamp'];
            ?>
                                  <tr><td><?php echo date('d/m/Y', $timestamp); ?></td><td><?php echo $otherservice;  ?></td>
                                      <td><?php echo $price;  ?></td><td><?php echo $reduction;  ?></td>
                                      <td><a href="removeotherservice?id=<?php echo $otherservice_id;?>"
                                       class="btn btn-xs btn-danger" onclick="return confirm_delete
                                       <?php echo $otherservice_id;?>()">Supplimer</a></td>
                                  </tr> 
                                 <script type="text/javascript">
function confirm_delete<?php echo $otherservice_id; ?>() {
  return confirm('You are about To Remove this Room. Are you sure you want to proceed?');
}
</script>        
                   <?php
        }
        ?>

                              </tbody>
                            </table>
                        </div>
                        </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>
  <div id="addotherservice" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form method="post" class="form" action='addotherservice?id=<?php echo $id; ?>'  name="form" enctype="multipart/form-data">
                                  <div class="form-group">
                                      <label class="control-label">* Nom du Service</label>
<input type="text" name='servicename' class="form-control" placeholder="Nom du Service" required="required">
                        </div>                         
                 <div class="form-group">
                                      <label class="control-label">* Service Prix</label>
<input type="text" name='serviceprice' class="form-control" placeholder="Service Prix" required="required">
                        </div>              
                                                   <div class="form-group">
                                      <label class="control-label">Monnaie</label>
<input type="text" name='currency' class="form-control" placeholder="Monnaie">
                        </div>              
                      <div class="form-group">
                                      <label class="control-label">Réduction</label>
<input type="text" name='reduction' class="form-control" placeholder="Réduction">
                        </div>      
                                                <div class="form-group">
                                                    <button class="btn btn-sm btn-info" name="submit">Entré</button>
                                                </div>
                            </form>
                                                </div>
                                                </div>
                                                </div>
                                                </div>
<div id="modal-form" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <form role="form" method="POST" action="extendstay?id=
                            <?php echo $id;?>&&check=<?php echo $checkout; ?>" enctype="multipart/form-data">
                                    <div class="form-group" id="data_1">
        <label class="font-noraml">Sélectionnez Nouvelle date de paiement</label>
        <div class="input-group date">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text"  name="newcheckout" class="form-control" required="required">
        </div>
    </div>
                                    <button class="btn btn-sm btn-info pull-right m-t-n-xs" type="submit"><strong>Date de modification</strong></button>
                                                                                        
                            </form></div>
                        </div>
                                                
                                        </div>
                                    </div>
                                    </div>
                                </div>
    <div id="modal-form2" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form  role="form" method="POST" action="?id=<?php echo $id;?>" enctype="multipart/form-data">
                                <div class="form-group" id="data_1">
    <label class="font-noraml">Sélectionnez Nouvelle date de paiement</label>
    <div class="input-group date">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text"  name="newcheckout" class="form-control" required="required">
    </div>
</div>
                                <button class="btn btn-sm btn-info pull-right m-t-n-xs" type="submit"><strong>Date de modification</strong></button>
                                                                                    
                        </form></div>
                    </div>
                    
            </div>
        </div>
        </div>
    </div>
</div>

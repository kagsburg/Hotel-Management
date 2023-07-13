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
                    <h2>Détails Personnels</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Accueil</a>                    </li>
                       
                         <li>
                             <a href="hallbookings">Réservation</a>
                        </li>
                        <li class="active">
                            <strong>Détails de La Réservation</strong>
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
                        <h5>Détails de La Réservation</h5>
                       
                    </div>
                    <div class="ibox-content">
<?php
$reservations=mysqli_query($con, "SELECT * FROM hallreservations WHERE hallreservation_id='$id'");
        $row=  mysqli_fetch_array($reservations);
        $hallreservation_id1=$row['hallreservation_id'];
        $fullname1=$row['fullname'];
        $checkin1=$row['checkin'];
        $phone1=$row['phone'];
        $checkout1=$row['checkout'];
        $status1=$row['status'];
        $people1=$row['people'];
        $purpose1=$row['purpose'];
        $description1=$row['description'];
        $country1=$row['country'];
        $creator1=$row['creator'];
        $days=($checkout1-$checkin1)/(3600*24)+1;

        $purposes=mysqli_query($con, "SELECT * FROM hallpurposes WHERE hallpurpose_id='$purpose1'");
        $row3 = mysqli_fetch_array($purposes);
        $hallpurpose_id=$row3['hallpurpose_id'];
        $hallpurpose=$row3['hallpurpose'];
        $charge=$row3['charge'];
        $totalcharge=$charge*$days;
        $hallincome=mysqli_query($con, "SELECT COALESCE(SUM(amount), 0) AS totalhallincome FROM hallpayments WHERE hallbooking_id='$id'");
        $row4=  mysqli_fetch_array($hallincome);
        $totalhallincome=$row4['totalhallincome'];


        ?>
     <div>
                                <div class="feed-activity-list">

                <div class="feed-element">
                                                            <div class="media-body ">
                                                                <strong>Nom Complet</strong>. : <?php echo $fullname1; ?> <br>
                                             </div>
                                    </div>
                                         <div class="feed-element">
                                                    <div class="media-body ">
                                                        <strong>Pays</strong>. : <?php echo $country1; ?> <br>
                                             </div>
                                    </div>
                                    <div class="feed-element">
                                                        <div class="media-body ">
                                                            <strong>Numéro de Télephone</strong>. : <?php echo $phone1; ?> <br>
                        </div>
            </div>
                                  
                                  
                                                                                                 
                                             </div>
                            </div>
                    </div>
                </div>
                      <?php
               if ($status1==1) { ?>
                         <a href="hallcheckin?id=<?php echo $id;?>" class="btn btn-sm btn-info" 
                         onclick="return confirm_in<?php echo $id;?>()">
Confirmer l'enregistrement</a>
                         <a href="cancelhallbooking?id=<?php echo $id; ?>" class="btn btn-sm btn-danger" 
                         onclick="return confirm_delete<?php echo $id;?>()">Annuler la réservation</a>
                         <a href="edithallreservation?id=<?php echo $id; ?>" class="btn btn-sm btn-primary">Editer</a>
                     <?php } elseif ($status1==2) { ?>
                         <a href="hallcheckout?id=<?php echo $id; ?>" class="btn btn-sm btn-danger">Vérifier</a>
                      <a href="edithallreservation?id=<?php echo $id; ?>" class="btn btn-sm btn-primary">Editer</a>
                     <?php }?>
                         <a href="hallinvoice?id=<?php echo $id;?>" class="btn btn-sm btn-success">Facture d'achat</a>
                     <script type="text/javascript">
                         function confirm_in<?php echo $id; ?>() {
  return confirm('You are about To Confirm A check in. Do you want to proceed?');
}
function confirm_delete<?php echo $id; ?>() {
  return confirm('You are about To Remove this Booking. Are you sure you want to proceed?');
}
</script>                 
            </div>
                <div class="col-lg-6">
                       <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Détails de La Réservation</h5>
                                                   </div>
                        <div class="ibox-content">
          <div class="feed-activity-list">

                                                                       <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>vérifier entrée</strong>  : <?php echo date('d/m/Y', $checkin1); ?> <br>
                                             </div>
                                    </div>
                                    <div class="feed-element">
                                        <div class="media-body ">
                                            <strong>Départ Prévu</strong>  : <?php echo date('d/m/Y', $checkout1); ?> <br>
                                             </div>
                                    </div>
                                            
                                      <div class="feed-element">
                                                <div class="media-body ">
                                                    <strong>Personnels</strong>  : <?php echo $people1; ?> <br>
                                             </div>
                                    </div>      
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Objectif</strong>  : <?php
                                               $purposes=mysqli_query($con, "SELECT * FROM hallpurposes WHERE hallpurpose_id='$purpose1'");
        $row3 = mysqli_fetch_array($purposes);
        $hallpurpose_id=$row3['hallpurpose_id'];
        $hallpurpose=$row3['hallpurpose'];
        $charge=$row3['charge'];
        echo  $hallpurpose; ?> <br>
                                             </div>
                                    </div>     
               <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Status</strong>  : <?php
                                     if ($status1==3) {
                                         echo '<span class="text-danger">GUEST OUT</span>';
                                     } elseif ($status1==2) {
                                         echo '<span class="text-success">GUEST IN</span>';
                                     } elseif ($status1==1) {
                                         echo '<span class="text-info">BOOKED</span>';
                                     } elseif ($status1==3) {
                                         echo '<span class="text-danger">CANCELLED</span>';
                                     }
        ?> <br>
                                             </div>
                                    </div>
              
               <div class="feed-element">
                                    <div class="media-body ">
                                        <?php
                        if ($status1==1) {
                            ?>
                                        <strong>Ajouté par</strong>  :  
                                        <?php } elseif ($status1==2) {?>
                                        <strong>Enregistré par</strong>  :
                                        <?php } elseif ($status1==3) {?>
                                        <strong>Vérifié par</strong>  :
                                        <?php }?>
                                        <a href="employee?id=<?php echo $creator1; ?>"
                                         data-original-title="View admin profile" 
                                          data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php
                            $employee=  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator1'");
        $row = mysqli_fetch_array($employee);
        $employee_id=$row['employee_id'];
        $fullname=$row['fullname'];
        echo $fullname; ?></a> <br>
                                             </div>
                                    </div>
                                    <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Charge Totale</strong>  : <?php echo $totalcharge; ?> <br>
                                             </div>
                                    </div>   
                <div class="feed-element">
                                                                              <div class="media-body ">
                                     <strong>Montant Payé</strong>  : <?php echo  number_format($totalhallincome); ?> <br>
                                             </div>
                                    </div>   
                <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Déscription</strong>  : <?php echo $description1; ?> <br>
                                             </div>
                                    </div>   
                                      
                                                                                                 
                                             </div>

                            <div style="clear:both"></div>
                                    </div>
                       </div>
                 
            </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>

   
                        </div>
  
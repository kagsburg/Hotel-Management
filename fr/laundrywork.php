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
                    <h2>Les Travaux de Lessive de l’Hôtel</h2>
                    <ol class="breadcrumb">
                         <li>              <a href="index"><i class="fa fa-home"></i> Accueil</a>                    </li>
                       
                         <li>
                             <a href="laundrywork">lessive </a>
                        </li>
                        <li class="active">
                            <strong>Voir Travaux</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                 <div class="col-lg-4">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-home fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Travaux de Lessive d’aujourd’hui</span>
                            <h2 class="font-bold"><?php
                            $today=mysqli_query($con, "SELECT * FROM laundry WHERE round(($timenow-timestamp)/(3600*24))+1=1");
        echo mysqli_num_rows($today);
        ?></h2>
                        </div>
                    </div>
                </div>
                </div>
                 <div class="col-lg-4">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-home fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Blanchisserie au cours des 7 derniers jours</span>
                            <h2 class="font-bold">
                              <?php
        $week=mysqli_query($con, "SELECT * FROM laundry WHERE round(($timenow-timestamp)/(3600*24))<=7");
        echo mysqli_num_rows($week);
        ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
               
                 <div class="col-lg-4">
                <div class="widget style1 red-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-home fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Blanchisserie au cours des 30 derniers jours</span>
                            <h2 class="font-bold">   <?php
        $month=mysqli_query($con, "SELECT * FROM laundry WHERE round(($timenow-timestamp)/(3600*24))<=30");
        echo mysqli_num_rows($month);
        ?></h2>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Touts les travaux de Lessive <small>trier, chercher</small></h5>
                      
                    </div>
                    <div class="ibox-content">
<?php
$totallaundry=0;
        $laundry=mysqli_query($con, "SELECT * FROM laundry WHERE status IN (0,1) ORDER BY laundry_id DESC");
        if (mysqli_num_rows($laundry)>0) {
            ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                          <th>Client</th>
                        <th>Numéro de chambre</th>
                          <th>Nombre d’habits</th>
                        <th>Prix</th>
                        <th>Ajouté le</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
                          while ($row=  mysqli_fetch_array($laundry)) {
                              $laundry_id=$row['laundry_id'];
                              $reserve_id=$row['reserve_id'];
                              $clothes=$row['clothes'];
                              $package_id=$row['package_id'];
                              $charge=$row['charge'];
                              $timestamp=$row['timestamp'];
                              $status=$row['status'];
                              $creator=$row['creator'];
                              $reservation=mysqli_query($con, "SELECT * FROM
                               reservations WHERE reservation_id='$reserve_id'");
                              $row2=  mysqli_fetch_array($reservation);
                              $firstname=$row2['firstname'];
                              $lastname=$row2['lastname'];
                              $room_id=$row2['room'];
                              $getpackage=mysqli_query($con, "SELECT * FROM 
                              laundrypackages WHERE status='1' AND laundrypackage_id='$package_id'");
                              $row3 = mysqli_fetch_array($getpackage);
                              $laundrypackage=$row3['laundrypackage'];

                              ?>
               
                    <tr class="gradeA">
                    <td><?php echo $firstname.' '.$lastname; ?></td>
                     
                         <td class="center">
                                         <?php
                                            $roomtypes=mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                              $row1=  mysqli_fetch_array($roomtypes);
                              $roomtype=$row1['roomnumber'];
                              echo $roomtype; ?>
                        </td>
                        <td><?php echo $clothes; ?></td>
                        <td><?php echo $laundrypackage ?></td>
                        <td>
                            <div class="text-info"><?php echo date('d/m/Y', $timestamp); ?></div>
                        </td>
                        <td><?php if ($status==1) {
                            echo '<span class="text-success">Finished</span>';
                        }
                               if ($status==0) {
                                   echo '<span class="text-warning">Pending</span>';
                               }
                              ?></td>
                       <td>
                           <?php   if ($status==0) { ?>
                              <a href="finishlaundry?id=<?php echo $laundry_id;?>" 
                              class="btn btn-xs btn-primary" 
                              onclick="return confirm_finish<?php echo $laundry_id; ?>()" target="_blank"
                              >Confirmer Terminer</a>
                           <?php } if ($status==1) { ?>
                              <a href="laundryinvoice_print?id=<?php echo $laundry_id;?>" 
                              class="btn btn-xs btn-info" target="_blank">facture</a>
                              <?php } ?>
                           <a href="hidelaundry?id=<?php echo $laundry_id;?>" 
                           class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $laundry_id; ?>()">Supprimer</a>
                            <script type="text/javascript">
function confirm_delete<?php echo $laundry_id; ?>() {
  return confirm('You are about To Remove this Item. Are you sure you want to proceed?');
}
function confirm_finish<?php echo $laundry_id; ?>() {
  return confirm('You are about To approve this work. Are you sure you want to proceed?');
}
</script>                 
                                            </td>
      
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php } else {?>
                        <div class="alert  alert-danger">Oops!! Aucune nouvelle réservation n'a encore été effectuée</div>
 <?php }?>
                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>

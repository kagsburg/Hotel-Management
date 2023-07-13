    <div id="wrapper">
        <?php include 'nav.php'; ?>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
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
                    <div class="col-lg-9">
                        <h2>Tableau de bord</h2>
                        <ol class="breadcrumb">
                            <li><a href="index"><i class="fa fa-home"></i> Accueil</a></li>                        
                        </ol>
                    </div>
                  </div>
            <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <?php
                 if (($level==1)||($role=='Restaurant Attendant')) {
                     ?>
                <div class="col-lg-4">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-cutlery fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Commandes de restaurant aujourd'hui</span>
                            <h2 class="font-bold">    <?php
                                 $today=mysqli_query($con, "SELECT * FROM orders WHERE round(($timenow-timestamp)/(3600*24))+1=1");
                     echo mysqli_num_rows($today);
                     ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                <?php
                 }
                if (($level==1)||($role=='Receptionist')) {
                    ?>
                 <div class="col-lg-4">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-building-o fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Réservations effectuées aujourd'hui</span>
                            <h2 class="font-bold">
                             <?php
                                $today=mysqli_query($con, "SELECT * FROM reservations WHERE round(($timenow-timestamp)/(3600*24))+1=1");
                    echo mysqli_num_rows($today);
                    ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                <?php }
                if (($level==1)||($role=='Hall Attendant')) {
                    ?>
                  <div class="col-lg-4">
                <div class="widget style1 yellow-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-money fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Réservations de salle aujourd'hui</span>
                            <h2 class="font-bold">  
                    <?php
                           $reservations=mysqli_query($con, "SELECT * FROM hallreservations WHERE status!='0' AND
                        round(($timenow-timestamp)/(3600*24))+1=1   ORDER BY hallreservation_id DESC");
                    echo mysqli_num_rows($reservations);
                    ?></h2>
                        </div>
                    </div>
                </div>
                </div>
                   <?php } ?>                                 
                    </div>
               <?php
                if (($level==1)||($role=='Receptionist')) {
                    ?>
                <div class="row">
                             <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">                            
                            <h5>Clients enregistrés</h5>                        
                        </div>
                        <div class="ibox-content">
                         <?php
                        $reservations=mysqli_query($con, "SELECT * FROM reservations WHERE status='1' ORDER BY checkin LIMIT 10");
                    if (mysqli_num_rows($reservations)>0) {
                        ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                          <th>Nom et Prenom</th>
                        <th>Numéro de chambre</th>
                           <th>Date Entrée)</th>
                        <th>Date Sortie</th>
                         <th>Action</th>
                        <!--<th>Action</th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        while ($row=  mysqli_fetch_array($reservations)) {
                            $reservation_id=$row['reservation_id'];
                            $firstname=$row['firstname'];
                            $lastname=$row['lastname'];
                            $checkin=$row['checkin'];
                            $phone=$row['phone'];
                            $checkout=$row['checkout'];
                            $room_id=$row['room'];
                            $email=$row['email'];
                            $status=$row['status'];
                            $creator=$row['creator'];
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
                        <td><?php echo date('d/m/Y', $checkin); ?></td>
                        <td><?php echo date('d/m/Y', $checkout); ?></td>                    
                        <td><a href="reservation?id=<?php echo $reservation_id;?>" class="btn btn-xs btn-info">Détails</a>
                        </td>      
                    </tr>
                 <?php }?>
                    </tbody>
                </table>
                <?php } else {?>
                        <div class="alert  alert-danger">Oops!! Aucune réservation n'a encore été ajoutée</div>
                <?php }?>
                        </div>
                    </div>
                                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Chambres disponibles</h5>
                        
                        </div>
                        <div class="ibox-content">
                           <?php
                            $rooms=mysqli_query($con, "SELECT * FROM rooms WHERE status='1' ORDER BY roomnumber");
                    if (mysqli_num_rows($rooms)>0) {
                        ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Numéro du Chambre</th>
                        <th>Status</th>
                        <th>Type du Chambre</th>                            
                    </tr>
                    </thead>
                    <tbody>
              <?php
               while ($row=  mysqli_fetch_array($rooms)) {
                   $roomnumber=$row['roomnumber'];
                   $room_id=$row['room_id'];
                   $type=$row['type'];
                   $status=$row['status'];
                   $creator=$row['creator'];
                   $check=  mysqli_query($con, "SELECT * FROM reservations WHERE  room='$room_id' AND status='1'");
                   $row2= mysqli_fetch_array($check);
                   $room_id2=$row2['room'];
                   if ($room_id!=$room_id2) {
                       ?>
                    <tr class="gradeA">
                    <td><?php echo $room_id; ?></td>
                        <td><?php echo $roomnumber; ?></td>
                        <td><?php
                           $check2=  mysqli_query($con, "SELECT * FROM reservations WHERE  room='$room_id' AND status='0' AND checkin>='$timenow' ORDER BY checkin");
                       if (mysqli_num_rows($check2)>0) {
                           $row3= mysqli_fetch_array($check2);
                           $checkin=date("d/m/Y", $row3['checkin']);
                           $checkout=date("d/m/Y", $row3['checkout']);
                           echo '<div class="text-primary">Available till '.$checkin.'</div>';
                       } else {
                           echo '<div class="text-success">Available</div>';
                       }?></td>
                         <td class="center">
                        <?php
                       $roomtypes=mysqli_query($con, "SELECT * FROM roomtypes  WHERE roomtype_id='$type'");
                       $row1=  mysqli_fetch_array($roomtypes);
                       $roomtype=$row1['roomtype'];
                       echo $roomtype; ?>
                        </td>
                     <?php }?>                                               
                     </tr>
                    <?php }?>
                    </tbody>
                    </table>
                    <?php }?>
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">                            
                            <h5>Clients qui ont quitté</h5>                        
                        </div>
                        <div class="ibox-content">
                         <?php
                       $reservations=mysqli_query($con, "SELECT * FROM reservations WHERE status='2' ORDER BY checkout LIMIT 10");
                    if (mysqli_num_rows($reservations)>0) {
                        ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                          <th>Nom et Prenom</th>
                        <th>Numéro de chambre</th>
                           <th>Date Entrée</th>
                        <th>Date Sortie</th>
                         <th>Action</th>
                        <!--<th>Action</th>-->
                    </tr>
                    </thead>
                    <tbody>
              <?php
               while ($row=  mysqli_fetch_array($reservations)) {
                   $reservation_id=$row['reservation_id'];
                   $firstname=$row['firstname'];
                   $lastname=$row['lastname'];
                   $checkin=$row['checkin'];
                   $phone=$row['phone'];
                   $checkout=$row['checkout'];
                   $room_id=$row['room'];
                   $email=$row['email'];
                   $status=$row['status'];
                   $creator=$row['creator'];
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
                    <td><?php echo date('d/m/Y', $checkin); ?></td>
                    <td><?php echo date('d/m/Y', $checkout); ?></td>            
                    <td><a href="reservation?id=<?php echo $reservation_id;?>" class="btn btn-xs btn-info">Détails</a></td>      
                    </tr>
                 <?php }?>
                    </tbody>
        </table>
             <?php } else {?>
              <div class="alert  alert-danger">Oops!! Aucune réservation n'a encore été ajoutée</div>
            <?php }?>
                        </div>
                    </div>  
                    </div>
                        <div class="col-lg-6">                 
                    </div>
                </div>
             <?php }?>
        </div>
    </div>

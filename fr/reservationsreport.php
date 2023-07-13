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
                    <h2>Rapport de réservation entre entre <?php echo date('d/m/Y', $start); ?> et <?php echo date('d/m/Y', $end); ?>                    
  </h2>
           
                </div>
                           </div>
            <div class="wrapper wrapper-content animated fadeInRight">
           
                <div class="row">
                   
                 <div class="col-lg-12">
                     <a href="reservationsreportprint?start=<?php echo $st;?>&&end=<?php echo $en; ?>"  
                     target="_blank" class="btn btn-success ">Imprimer PDF</a><br/><br/>                 
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Générer le Rapport des Réservations</h5>
                  
                    </div>
                    <div class="ibox-content">
                       
                     <div class="panel blank-panel">

   <div class="panel-body">

    <?php
   $reservations=mysqli_query($con, "SELECT * FROM reservations WHERE timestamp>='$start' AND timestamp<='$end' AND status IN(0,1,2)");
        if (mysqli_num_rows($reservations)>0) {
            ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                         <th>Client</th>
                        <th>Numéro de la Chambre</th>
                           <th>entrée</th>
                        <th>sortie</th>
                        <th>Status</th>
                 
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
                           $status=$row['status'];
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
                        <td><?php if ($status==0) {
                            echo 'Pending';
                        } if ($status==1) {
                            echo 'Guest In';
                        } if ($status==2) {
                            echo 'Guest Out';
                        } ?></td>
                 
                 <?php }?>
                    </tbody>
                                    </table>
 <?php } else {?>
                        <div class="alert  alert-danger">Oops!! Aucune réservation n'a encore été ajoutée</div>
 <?php }?>

                      
                        </div>

                    </div>
                    </div>
                </div>
            </div>

                                   </div>
                   </div>
    </div>

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
                    <h2>Sorties des clients de l'hôtel en attente</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                       
                         <li>
                            <a>Réservations</a>
                        </li>
                        <li class="active">
                            <strong>Afficher les Clients En attente</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                 <div class="col-lg-4">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-group fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Sorties des clients de l'hôtel en attente</span>
                            <h2 class="font-bold"><?php
                           $reservations=mysqli_query($con, "SELECT * FROM reservations WHERE checkout<'$timenow' AND status='1' ORDER BY reservation_id DESC");
        echo mysqli_num_rows($reservations);
        ?></h2>
                        </div>
                    </div>
                </div>
                </div>
                               
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Tous les Clients  <small>trier, rechercher</small></h5>
                       
                    </div>
                    <div class="ibox-content">
<?php

if (mysqli_num_rows($reservations)>0) {
    ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                          <th>Détails du client</th>
                        <th>Numéro de la Chambre</th>
                           <th>entrée</th>
                        <th>sortie</th>
                        <th>Status</th>
                        <th>Ajouté par</th>
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
                        <td><?php
                       if (($timenow>$checkout)&&($status==2)) {
                           echo '<div class="text-danger">guest out</div>';
                       } elseif (($timenow>$checkout)&&($status==1)) {
                           echo '<div class="text-danger">Pending guest out</div>';
                       } elseif ($timenow<$checkout) {
                           echo '<div class="text-danger">guest in</div>';
                       }
                      ?></td>
                       <td> <div class="tooltip-demo">
                               
                               <a href="employee?id=<?php echo $creator; ?>" data-original-title="View admin profile"  data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php
                                          $employee=  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                      $row = mysqli_fetch_array($employee);
                      $employee_id=$row['employee_id'];
                      $fullname=$row['fullname'];
                      echo $fullname;  ?></a> </div></td>
                       <td><a href="reservation?id=<?php echo $reservation_id;?>" class="btn btn-xs btn-info">Details</a>
                     
                       </td>
      
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php } else {?>
                        <div class="alert  alert-danger">Oops!! Pas encore d'invités</div>
 <?php }?>
                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>

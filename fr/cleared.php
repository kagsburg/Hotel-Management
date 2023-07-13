
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
                    <h2>Clients de l'hôtel qui ont réglé toutes les factures</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Accueil</a>                    </li>
                       
                  
                        <li class="active">
                            <strong>Afficher les invités</strong>
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
                        <h5>Tous les Clients avec facture payée<small>trier, rechercher </small></h5>
                     
                    </div>
                    <div class="ibox-content">
<?php
   $checkedouts=  mysqli_query($con, "SELECT * FROM checkoutdetails WHERE totalbill<=paidamount");
        if (mysqli_num_rows($checkedouts)>0) {
            ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                          <th>Détails du client</th>
                        <th>Numéro de la Chambre</th>
                           <th>Clients enregistrés</th>
                        <th>Vérifié</th>
                        <th>Prix Total</th>
                        <th>Somme payée</th>
                        <th>Vérifié par</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php

                          while ($row2=  mysqli_fetch_array($checkedouts)) {
                              $checkoutdetails_id=$row2['checkoutdetails_id'];
                              $reserve_id=$row2['reserve_id'];
                              $paidamount=$row2['paidamount'];
                              $totalbill=$row2['totalbill'];
                              $reservations=mysqli_query($con, "SELECT * FROM reservations 
             WHERE  status='2' AND reservation_id='$reserve_id' ORDER BY reservation_id DESC");
                              $row=  mysqli_fetch_array($reservations);
                              $reservation_id=$row['reservation_id'];
                              $firstname=$row['firstname'];
                              $lastname=$row['lastname'];
                              $checkin=$row['checkin'];
                              $phone=$row['phone'];
                              $checkout=$row['checkout'];
                              $actualcheckout=$row['actualcheckout'];
                              $room_id=$row['room'];
                              $email=$row['email'];
                              $status=$row['status'];
                              $country=$row['country'];
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
                        <td><?php echo date('d/m/Y', $actualcheckout); ?></td>
                        <td><?php echo number_format($totalbill); ?></td>
                        <td><?php echo number_format($paidamount); ?></td>
                                                                  <td> <div class="tooltip-demo">
                               
                                         <a href="employee?id=<?php echo $creator; ?>" data-original-title="View admin profile"  data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php
                                                        $employee=  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                              $row = mysqli_fetch_array($employee);
                              $employee_id=$row['employee_id'];
                              $fullname=$row['fullname'];
                              echo $fullname; ?></a> </div></td>
                       <td><a href="reservation?id=<?php echo $reservation_id;?>" class="btn btn-xs btn-info">Détails du client</a>
                     
                       </td>
      
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php } else {?>
                        <div class="alert  alert-danger">Oops!! Pas encore d'invités avec des factures payées</div>
 <?php }?>
                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>

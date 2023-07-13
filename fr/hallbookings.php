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
                    <h2>Réservations de Salle</h2>
                    <ol class="breadcrumb">
                         <li><a href=""><i class="fa fa-home"></i> Accueil</a> </li>                      
                      
                        <li class="active">
                            <strong>Voir Réservations de salle</strong>
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
                        <h5>outes Les Réservations de Salle <small>trier, chercher</small></h5>
                                          </div>
                    <div class="ibox-content">
                    <?php
                    $reservations=mysqli_query($con, "SELECT * FROM hallreservations WHERE status='1' OR status='2'   ORDER BY hallreservation_id DESC");
        if (mysqli_num_rows($reservations)>0) {
            ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                          <th>Nom et Prenom</th>
                        <th>Téléphone</th>
                          <th>Personnes</th>
                          <th>Dates</th>
                        <th>Objectif</th>
                        <th>Ajouté par</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
               while ($row=  mysqli_fetch_array($reservations)) {
                   $hallreservation_id=$row['hallreservation_id'];
                   $fullname=$row['fullname'];
                   $checkin=$row['checkin'];
                   $phone=$row['phone'];
                   $checkout=$row['checkout'];
                   $status=$row['status'];
                   $people=$row['people'];
                   $purpose=$row['purpose'];
                   $description=$row['description'];
                   $country=$row['country'];
                   $creator=$row['creator'];

                   ?>
               
                    <tr class="gradeA">
                    <td><?php echo $fullname; ?></td>
                        <td><?php echo $phone; ?></td>
                                              <td><?php
                                                  echo $people;
                   ?></td>
                               <td><?php echo date('d/m/Y', $checkin).' to '.date('d/m/Y', $checkout);
                   ; ?></td>
                        <td><?php
                          $purposes=mysqli_query($con, "SELECT * FROM hallpurposes WHERE hallpurpose_id='$purpose'");
                   $row3 = mysqli_fetch_array($purposes);
                   $hallpurpose_id=$row3['hallpurpose_id'];
                   $hallpurpose=$row3['hallpurpose'];
                   echo $hallpurpose; ?></td>
                     <td> <div class="tooltip-demo">
                               
                                <a href="employee?id=<?php echo $creator; ?>" data-original-title="View admin profile"  data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php
                                   $employee=  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                   $row = mysqli_fetch_array($employee);
                   $employee_id=$row['employee_id'];
                   $fullname=$row['fullname'];
                   echo $fullname; ?></a> </div>
                     </td>          
                     
                     <td><?php
                     if ($status==1) {
                         echo 'BOOKED';
                     } elseif ($status==2) {
                         echo 'CHECKED IN';
                     }
                   ?></td>
                     <td>
                          <a href="halldetails?id=<?php echo $hallreservation_id;?>" class="btn btn-xs btn-success">Détails</a>
                       
                     </td>
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php } else { ?>
    <div class="alert alert-danger"> Aucune réservation de salle n'a encore été ajoutée</div>
  <?php }?>
                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>

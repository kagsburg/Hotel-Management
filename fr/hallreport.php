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
                    <h2>Rapport de salle de conférence entre<?php echo date('d/m/Y', $start); ?> et
                     <?php echo date('d/m/Y', $end); ?></h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Accueil</a>                    </li>
                     
                                          <li class="active">
                            <strong>Rappor des Salles</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-12">
              <a href="hallreportprint?start=<?php echo $st;?>&&end=<?php echo $en; ?>"  
              target="_blank" class="btn btn-success ">Imprimer en PDF</a><br/><br/>
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                      <h5>Rapport de salle de conférence généré</h5>
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
           <h2 class="text-center">RAPPORT DE LA SALLE DE CONFÉRENCE</h2>
    <div class="table-responsive m-t">
        <?php
                       $totalcosts=0;
    $reservations=mysqli_query($con, "SELECT * FROM hallreservations
  WHERE status IN(1,2) AND timestamp>='$start' AND timestamp<='$end'");
    if (mysqli_num_rows($reservations)>0) {
        ?>
                                <table class="table table-bordered">
                                    <thead>
                                  <tr>
                          <th>Client</th>
                           <th>Personnel</th>
                          <th>Dates</th>
                        <th>Objectif</th>
                         <th>Status</th>
                         <th>Charge</th>
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
                  $charge=$row['charge'];
                  $creator=$row['creator'];
                  $getdays=(($checkout-$checkin)/(24*3600))+1;
                  $totalcosts=$totalcosts+($charge*$getdays);

                  ?>
     <tr>
                            <td><?php echo $fullname; ?></td>
                                     <td><?php
                                                       echo $people;
                  ?></td>
                               <td><?php echo date('d/m/Y', $checkin).' to '.date('d/m/Y', $checkout);  ?></td>
                        <td><?php
                          $purposes=mysqli_query($con, "SELECT * FROM hallpurposes WHERE hallpurpose_id='$purpose'");
                  $row3 = mysqli_fetch_array($purposes);
                  $hallpurpose_id=$row3['hallpurpose_id'];
                  $hallpurpose=$row3['hallpurpose'];
                  echo $hallpurpose; ?></td>
                   
                           <td><?php
                     if ($status==1) {
                         echo 'BOOKED';
                     } elseif ($status==2) {
                         echo 'CHECKED IN';
                     }
                  ?></td>
                           <td><?php  echo $charge*$getdays;   ?></td>
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
                                    <td><strong><?php echo number_format($totalcosts);?></strong></td>
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

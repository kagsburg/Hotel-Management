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
                    <h2>Rapport de gym entre <?php echo date('d/m/Y', $start); ?> et <?php echo date('d/m/Y', $end); ?></h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Accueil</a>                    </li>
                     
                                          <li class="active">
                            <strong>rapport du Gym</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-12">
                        <a href="gymreportprint?start=
                        <?php echo $st;?>&&end=<?php echo $en; ?>"  target="_blank" class="btn btn-success ">Imprimer en PDF</a><br/><br/>
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>rapport du Gym généré</h5>
                           
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
                                     <h2 class="text-center">Rapport du Gym</h2>
    <div class="table-responsive m-t">
        <?php
                       $totalcosts=0;
    $subscriptions=mysqli_query($con, "SELECT * FROM gymsubscriptions WHERE status='1'  AND timestamp>='$start' AND timestamp<='$end'");
    if (mysqli_num_rows($subscriptions)>0) {
        ?>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                <th>ID</th>
                                <th>Client</th>
                        <th>téléphone</th>
                          <th>date du début</th>
                        <th>date du fin</th>
                        <th>Bouquet</th>
                        <th>Charge</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                         <?php
               while ($row=  mysqli_fetch_array($subscriptions)) {
                   $gymsubscription_id=$row['gymsubscription_id'];
                   $fullname=$row['fullname'];
                   $startdate=$row['startdate'];
                   $enddate=$row['enddate'];
                   $phone=$row['phone'];
                   $charge=$row['charge'];
                   $creator=$row['creator'];
                   $bouquet=$row['bouquet'];
                   $getbouquet=mysqli_query($con, "SELECT * FROM gymbouquets WHERE status='1' AND gymbouquet_id='$bouquet'");
                   $row1 = mysqli_fetch_array($getbouquet);
                   $gymbouquet_id=$row1['gymbouquet_id'];
                   $gymbouquet=$row1['gymbouquet'];
                   if (strlen($gymsubscription_id)==1) {
                       $pin='000'.$gymsubscription_id;
                   }
                   if (strlen($gymsubscription_id)==2) {
                       $pin='00'.$gymsubscription_id;
                   }
                   if (strlen($gymsubscription_id)==3) {
                       $pin='0'.$gymsubscription_id;
                   }
                   if (strlen($gymsubscription_id)>=4) {
                       $pin=$gymsubscription_id;
                   }
                   $totalcosts=$charge+$totalcosts;
                   ?>
                                    <tr>
                           <td><?php echo $pin; ?></td>
                    <td><?php echo $fullname; ?></td>
                        <td><?php echo $phone; ?></td>
                          <td><?php echo date('d/m/Y', $startdate); ?></td>
                               <td><?php echo date('d/m/Y', $enddate); ?></td>
                        <td><?php     echo $gymbouquet; ?></td>
                        <td><?php     echo $charge; ?></td>
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

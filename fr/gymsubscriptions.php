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
                    <h2>Abonnements à la salle de sport</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                       
                      
                        <li class="active">
                            <strong>Voir les abonnements aux salles de sport</strong>
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
                        <h5>Tous les abonnements à la salle de sport <small>trier, chercher</small></h5>
                                          </div>
                    <div class="ibox-content">
                    <?php
                    $subscriptions=mysqli_query($con, "SELECT * FROM gymsubscriptions WHERE status='1'  ORDER BY gymsubscription_id DESC");
        if (mysqli_num_rows($subscriptions)>0) {
            ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                          <th> ID</th>
                          <th>Nom et Prenom du Client</th>
                        <th>Numéro de Téléphone</th>
                          <th>Date début</th>
                        <th>Date fin</th>
                        <th>Bouquet</th>
                        <th>Charge</th>
                        <th>Action</th>
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
                   ?>
               
                    <tr class="gradeA">
                    <td><?php echo $pin; ?></td>
                    <td><?php echo $fullname; ?></td>
                        <td><?php echo $phone; ?></td>
                          <td><?php echo date('d/m/Y', $startdate); ?></td>
                               <td><?php echo date('d/m/Y', $enddate); ?></td>
                        <td><?php     echo $gymbouquet; ?></td>
                        <td><?php     echo $charge; ?></td>
                    <td>
                          <a href="editgymsubscription?id=<?php echo $gymsubscription_id;?>" class="btn btn-xs btn-info">Editer</a>
                          <a href="removesubscription?id=<?php echo $gymsubscription_id;?>" 
                          class="btn btn-xs btn-danger" onclick="return cdelete<?php echo $gymsubscription_id;?>()">Supprimer</a>
                            <script type="text/javascript">
                         function cdelete<?php echo $gymsubscription_id; ?>() {
  return confirm('You are about To Delete this item. Do you want to proceed?');
}
</script>                 
                     </td>
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php } else { ?>
    <div class="alert alert-danger"> Aucun Abonnement Ajouté pour le moment</div>
  <?php }?>
                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>

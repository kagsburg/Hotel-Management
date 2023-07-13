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
                    <h2>Abonnements Piscine</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                       
                      
                        <li class="active">
                            <strong>Voir les abonnements</strong>
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
                        <h5>Tout les Abonnements Piscine <small>trier, rechercher</small></h5>
                                          </div>
                    <div class="ibox-content">
<?php
$subscriptions=mysqli_query($con, "SELECT * FROM poolsubscriptions WHERE status='1' ORDER BY poolsubscription_id DESC");
        if (mysqli_num_rows($subscriptions)>0) {
            ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                          <th> ID</th>
                          <th>Client</th>
                          <th>Date de commencement</th>
                        <th>Date de fin</th>
                        <th>paquet</th>
                        <th>Prix</th>
                        <th>Réduction</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
                          while ($row=  mysqli_fetch_array($subscriptions)) {
                              $poolsubscription_id=$row['poolsubscription_id'];
                              $firstname=$row['firstname'];
                              $lastname=$row['lastname'];
                              $startdate=$row['startdate'];
                              $enddate=$row['enddate'];
                              $reduction=$row['reduction'];
                              $charge=$row['charge'];
                              $creator=$row['creator'];
                              $package=$row['package'];
                              $getpackage=mysqli_query($con, "SELECT * FROM poolpackages WHERE status='1' AND poolpackage_id='$package'");
                              $row1 = mysqli_fetch_array($getpackage);
                              $poolpackage=$row1['poolpackage'];
                              if (strlen($poolsubscription_id)==1) {
                                  $pin='000'.$poolsubscription_id;
                              }
                              if (strlen($poolsubscription_id)==2) {
                                  $pin='00'.$poolsubscription_id;
                              }
                              if (strlen($poolsubscription_id)==3) {
                                  $pin='0'.$poolsubscription_id;
                              }
                              if (strlen($poolsubscription_id)>=4) {
                                  $pin=$poolsubscription_id;
                              }
                              ?>
                <tr class="gradeA">
                    <td><?php echo $pin; ?></td>
                    <td><?php echo $firstname.' '.$lastname; ?></td>
                  <td><?php echo date('d/m/Y', $startdate); ?></td>
                    <td><?php echo date('d/m/Y', $enddate); ?></td>
                    <td><?php  echo $poolpackage; ?></td>
                    <td><?php   echo $charge; ?></td>
                    <td><?php   echo $reduction; ?></td>                              
                    <td>
                     <a href="poolsubscriptionprint?id=<?php echo $poolsubscription_id;?>" 
                     class="btn btn-xs btn-primary">Voir la carte</a>
                     <a href="editpoolsubscription?id=<?php echo $poolsubscription_id;?>" class="btn btn-xs btn-info">Editer</a>
                      <a href="removepoolsubscription?id=<?php echo $poolsubscription_id;?>" class="btn btn-xs btn-danger"
                       onclick="return cdelete<?php echo $poolsubscription_id;?>()">Supprimer</a>
                            <script type="text/javascript">
                         function cdelete<?php echo $poolsubscription_id; ?>() {
  return confirm('You are about To Delete this item. Do you want to proceed?');
}
</script>                 
         </td>
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php } else { ?>
    <div class="alert alert-danger"> Aucun abonnement ajouté pour le moment</div>
  <?php }?>
                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>

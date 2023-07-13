    <div id="wrapper">
       <?php include 'nav.php'; ?>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " 
            href="#"><i class="fa fa-bars"></i> </a>
                    </div>
            <ul class="nav navbar-top-links navbar-right">               
                <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
            <li><a href="switchlanguage?lan=en">English</a> </li>
            </ul>
        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>paquets Piscine</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                                             <li class="active">
                            <strong>paquets Piscine</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
                   <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Ajouter un Paquet Piscine  <small>
                                Assurer vous de remplir tout les cha mps nécéssaire</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                        if (isset($_POST['package'],$_POST['charge'])) {
                            $package=  mysqli_real_escape_string($con, trim($_POST['package']));
                            $charge=  mysqli_real_escape_string($con, trim($_POST['charge']));
                            if ((empty($package)||(empty($charge)))) {
                                echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                            }
                            if (is_numeric($charge)==false) {
                                echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Charge should be An Integer</div>';
                            } else {
                                mysqli_query($con, "INSERT INTO poolpackages(poolpackage,charge,creator,status) VALUES('$package','$charge','".$_SESSION['emp_id']."','1')") or die(mysqli_error($con));

                                echo '<div class="alert alert-success"><i class="fa fa-check"></i>Pool Package successfully added</div>';
                            }
                        }
       ?>
  <form method="post" class="form" action=""  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">paquet</label>
 <input type="text" class="form-control" name='package' placeholder="Entrer le paquet" required='required'></div>
                          
        <div class="form-group"><label class="control-label">Prix</label>
<input type="text" class="form-control" name='charge' placeholder="Prix" required='required'></div>
                         
                                                 <div class="form-group">
                        <button class="btn btn-success btn-sm" name="submit" type="submit">Ajouter paquet</button>
                                  </div>
                            </form>
                                                 

                    </div>

                  
                </div>
             
                    </div>
                                 <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Paquets</h5>
                        
                        </div>
                        <div class="ibox-content">
                             <table class="table table-striped  table-hover">
                    <thead>
                    <tr>
                      <th>Paquet</th>
                        <th>Prix</th>
                            <th>&nbsp;</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                        <tr>     <?php
                            $getpackages=mysqli_query($con, "SELECT * FROM poolpackages WHERE status='1'");
       if (mysqli_num_rows($getpackages)>0) {
           while ($row = mysqli_fetch_array($getpackages)) {
               $poolpackage_id=$row['poolpackage_id'];
               $poolpackage=$row['poolpackage'];
               $charge=$row['charge'];
               $creator=$row['creator'];
               $status=$row['status'];
               ?>
                                     
                       <tr>
                                      <td><?php echo $poolpackage; ?></td>
                                   <td><?php echo $charge; ?></td>
                                                                  
                                 
                                                         <td>
                                        <?php
                                            if (($_SESSION['hotelsyslevel']==1)) {
                                                ?>
                                <a data-toggle="modal" class="btn btn-info btn-xs" 
                                href="#modal-form<?php echo $poolpackage_id; ?>"><i class="fa fa-edit"></i> Editer</a>
                                  
                 <a href="hidepoolpackage?id=<?php echo $poolpackage_id;?>" 
                 onclick="return cdelete<?php echo $poolpackage_id;?>()" 
                 class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Supprimer</a>
                       <script type="text/javascript">
                         function cdelete<?php echo $poolpackage_id; ?>() {
  return confirm('You are about To Delete a Package. Do you want to proceed?');
}
</script>                 
                                            <?php } ?>
                                    </td>
                       </tr>
                       
                                    <?php
           }
       } else {
           echo "<div class='alert alert-danger'>No Packages Added Yet</div>";
       }
       ?>
                    
                    </tbody>
                             </table>
                        </div>
                    </div>
                    </div>




    </div>
    </div>
    </div>
    </div>
      <?php
                    $getpackages=mysqli_query($con, "SELECT * FROM poolpackages WHERE status='1'");
       while ($row = mysqli_fetch_array($getpackages)) {
           $poolpackage_id=$row['poolpackage_id'];
           $poolpackage=$row['poolpackage'];
           $charge=$row['charge'];
           ?>
   <div id="modal-form<?php echo $poolpackage_id; ?>" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form method="post" class="form" 
                                            action="editpoolpackage?id=<?php echo $poolpackage_id; ?>" 
                                             name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">Paquet</label>
                                    <input type="text" class="form-control" name='package' placeholder="Paquets" 
                                    required='required' value="<?php echo $poolpackage; ?>"></div>
                          
        <div class="form-group"><label class="control-label">Prix</label>
            <input type="text" class="form-control" name='charge' placeholder="Prix"
             required='required' value="<?php echo $charge; ?>"></div>                         
                                                 <div class="form-group">
                        <button class="btn btn-success btn-sm" name="submit" type="submit">Modifier le package</button>
                                  </div>
                            </form>
                                                </div>
                                                </div>
                                                </div>
                                                </div>
                                <?php }?>
   
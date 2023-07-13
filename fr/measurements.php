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
                    <h2> Mesures des stocks</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>
                            <a>Stock</a>
                        </li>
                        <li class="active">
                            <strong>Mesures du stock de l'hôtel</strong>
                        </li>
                    </ol>
                </div>             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">                            
                            <h5>Ajouter des mesures de stock<small>Tapez Assurez-vous de remplir
                                 tous les champs nécessaires</small></h5>
                                                </div>
                        <div class="ibox-content">
                                               <?php
                                 if (isset($_POST['measurement'])) {
                                     if (empty($_POST['measurement'])) {
                                         echo '  <div class="alert alert-danger">
                                    <i class="fa fa-warning"></i>Fill The Field To Proceed</div>';
                                     } else {
                                         $measurement=  mysqli_real_escape_string($con, trim($_POST['measurement']));
                                         mysqli_query($con, "INSERT INTO stockmeasurements(measurement,status) VALUES('$measurement',1)")
                                         or die(mysqli_errno($con));
                                         echo '<div class="alert alert-success"><i class="fa fa-check"></i>Measurement successfully added</div>';
                                     }
                                 }
       ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-3 control-label">Unité de mesure</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name='measurement' 
                                        placeholder="Enter item" required='required'></div>
                                </div>
                                  <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                     <button class="btn btn-primary" name="submit" 
                                     type="submit">Ajouter  la mesure</button>
                                    </div>
                                </div>
                            </form>                                              

                    </div>                  
                </div>             
                    </div>
                       <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Unité de mesure</h5>
                                                </div>
                        <div class="ibox-content">
                            <?php
                  $measurements=  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE status=1");
       if (mysqli_num_rows($measurements)>0) {
           ?>
                              <table class="table table-striped  table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Unité de mesure</th>                                            
                        <th>Action</th>                                            
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                      while ($row = mysqli_fetch_array($measurements)) {
                          $measure_id=$row['measurement_id'];
                          $measure=$row['measurement'];

                          ?>
                        <tr><td><?php echo $measure_id;?></td>
                            <td><?php echo $measure; ?></td>
                            <td>
                                <a href="editmeasurement?id=<?php echo $measure_id; ?>" class="btn btn-success btn-xs">Editer</a>
                                <a href="removemeasurement?id=<?php echo $measure_id; ?>"
                                 class="btn btn-danger btn-xs" 
                                 onclick="return confirm_delete<?php echo $measure_id;?>()">Supprimer</a>
                                 <script type="text/javascript">
function confirm_delete<?php echo $measure_id; ?>() {
  return confirm('You are about To Remove this item. Are you sure you want to proceed?');
}
</script>
                            </td>
                        </tr>    
                                                    <?php } ?>
                    </tbody>    
                    </table>    
                            <?php } else { ?>
                            <div class="alert alert-danger">Oops Aucune mesure ajoutée pour le moment</div>
                            <?php } ?>
                                                                                </div>  
                                                    </div>  
                                                    </div>  

    </div>

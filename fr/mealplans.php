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
                    <h2>Plans de repas</h2>
                    <ol class="breadcrumb">
                         <li>              <a href="index"><i class="fa fa-home"></i> Accueil</a>                    </li>
                      
                        <li class="active">
                            <strong>Plans de repas</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
   <?php
                                            if (($_SESSION['hotelsyslevel']==1)) {
                                                ?>
                <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Ajouter des Plans de Repas <small>Veillez Remplir tout les champs nécéssaires</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                                                            if (isset($_POST['mealplan'])) {
                                                                $mealplan=  mysqli_real_escape_string($con, trim($_POST['mealplan']));
                                                                if ((empty($mealplan))) {
                                                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                                                                } else {
                                                                    mysqli_query($con, "INSERT INTO mealplans(mealplan,status) VALUES('$mealplan','1')") or die(mysqli_error($con));

                                                                    echo '<div class="alert alert-success"><i class="fa fa-check"></i>Plan de repas ajouté avec succès</div>';
                                                                }
                                                            }



                                                ?>
  <form method="post" class="form" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">Plans de Repas</label>

                             <input type="text" class="form-control" name='mealplan'
                              placeholder="Plans de Repas" required='required'>
                                </div>        
                                      <button class="btn btn-primary btn-sm" name="submit" type="submit">Ajouter le plan de repas</button>
                                 
                                </div>
                            </form>
                                                 

                    </div>

                  
                </div>
             
                    </div>
                           <?php } ?>
                           <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Plans de Repas</h5>
                        
                        </div>
                        <div class="ibox-content">
                             <table class="table table-striped  table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                             <th>Plans de Repas</th>
                          <th>&nbsp;</th>                       
                    </tr>
                    </thead>
                    <tbody>
                        <tr>    
   <?php
                                                                           $getplans=  mysqli_query($con, "SELECT * FROM mealplans WHERE status=1");
       while ($row = mysqli_fetch_array($getplans)) {
           $mealplan_id=$row['mealplan_id'];
           $mealplan=$row['mealplan'];


           ?>
                                     
                       <tr><td><?php echo $mealplan_id; ?></td>
                                   <td><?php echo $mealplan; ?></td>
                                                           
                                    <td>
                                        <?php
                                            if (($_SESSION['hotelsyslevel']==1)) {
                                                ?>
                                        <a href="editmealplan?id=<?php echo $mealplan_id;?>" class="btn btn-xs btn-warning"><i class="fa fa-edit"></i> Editer</a>
                                        
                                <a href="hidemealplan?id=<?php echo $mealplan_id;?>&&status=<?php echo $status; ?>" class="btn btn-xs btn-danger"
                                  onclick="return confirm_delete<?php echo $mealplan_id;?>()"><i class="fa fa-arrow-down"></i> Supprimer</a>
                                          <script type="text/javascript">
                     
function confirm_delete<?php echo $mealplan_id; ?>() {
  return confirm('You are about To Remove this item. Are you sure you want to proceed?');
}
</script>                 
                                         <?php  }?>
                                    </td>
                       </tr>
                       
                                    <?php
       }

       ?>
                    
                    </tbody>
                             </table>
                        </div>
                    </div>
                    </div>




    </div>

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
                    <h2>Modifier le bouquet Gym</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>
                            <a href="gymbouquets">Bouquets de Salle de sport </a>
                        </li>
                        <li class="active">
                            <strong>Modifier le bouquet</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
                   <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Modifier le bouquet<small>Tapez Assurez-vous de remplir tous les champs nécessaires</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                                                 if (isset($_POST['bouquet'],$_POST['charge'],$_POST['days'])) {
                                                     $bouquet=mysqli_real_escape_string($con, trim($_POST['bouquet']));
                                                     $charge=  mysqli_real_escape_string($con, trim($_POST['charge']));
                                                     $days=  mysqli_real_escape_string($con, trim($_POST['days']));
                                                     if ((empty($bouquet))||(empty($charge))||(empty($days))) {
                                                         echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>
                                     Enter All Fields To Proceed</div>';
                                                     }
                                                     if (is_numeric($charge)==false) {
                                                         echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>
                                      Charge should be An Integer</div>';
                                                     } else {
                                                         mysqli_query($con, "UPDATE gymbouquets 
               SET gymbouquet='$bouquet',days='$days',charge='$charge' WHERE gymbouquet_id='$id'") or die(mysqli_errno($con));

                                                         echo '<div class="alert alert-success"><i class="fa fa-check"></i>Bouquet successfully Edited</div>';
                                                     }
                                                 }
                                            $gymbouquets=mysqli_query($con, "SELECT * FROM gymbouquets WHERE status='1' AND gymbouquet_id='$id'");
       $row = mysqli_fetch_array($gymbouquets);
       $gymbouquet_id=$row['gymbouquet_id'];
       $gymbouquet=$row['gymbouquet'];
       $charge=$row['charge'];
       $days=$row['days'];
       $creator=$row['creator'];
       $timestamp=$row['timestamp'];
       $status=$row['status'];
       ?>
  <form method="post" class="form" action=''  name="form" enctype="multipart/form-data">
                               <div class="form-group"><label class="control-label">Bouquet Nom</label>
                                   <input type="text" class="form-control" name='bouquet' 
                                   placeholder="Enter Bouquet" required='required' value="<?php echo $gymbouquet; ?>"></div>
                                
        <div class="form-group"><label class="control-label">Nombre de jours</label>
 <input type="number" class="form-control" name="days" placeholder="Nombre de jours"
  required='required' value="<?php echo $days; ?>"></div>
                              
                          <div class="form-group"><label class="control-label">Charge</label>
<input type="text" class="form-control" name='charge' placeholder="Charge" required='required' 
value="<?php echo $charge; ?>"></div>
                          <div class="form-group">
                             <button class="btn btn-success btn-sm" name="submit" type="submit">Editer</button>
                        
                                </div>
                            </form>
                                                 

                    </div>

                  
                </div>
             
                    </div>
                

    </div>

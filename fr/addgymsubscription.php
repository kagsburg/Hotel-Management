
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
                    <h2>Ajouter un nouvel abonnement à la salle de sport</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>   <a href="gymsubscriptions">Abonnements</a>                       </li>
                        <li class="active">
                            <strong>Ajouter un abonnement</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-10">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Ajouter Nouvel abonnement <small>Tout champs marqué par un (*) ne devrait pas être laissé vide</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                             <?php
if (isset($_POST['fullname'],$_POST['number'],$_POST['bouquet'],$_POST['startdate'])) {
    $fullname=mysqli_real_escape_string($con, trim($_POST['fullname']));
    $phone=mysqli_real_escape_string($con, trim($_POST['number']));
    $startdate=mysqli_real_escape_string($con, strtotime($_POST['startdate']));
    $bouquet=mysqli_real_escape_string($con, trim($_POST['bouquet']));
    if ((empty($fullname))||(empty($phone))||(empty($startdate))||(empty($bouquet))) {
        $errors[]='All Fields Marked * shouldnt be blank';
    }
    $split= explode('_', $bouquet);
    $bouquet_id=$split[0];
    $days=($split[1])-1;
    $charge=$split[2];
    $enddate=$startdate+(24*3600*$days);
    if (!empty($errors)) {
        foreach ($errors as $error) {
            ?>
 <div class="alert alert-danger"><?php echo $error; ?></div>
<?php
        }
    } else {
        mysqli_query($con, "INSERT INTO gymsubscriptions(fullname,phone,bouquet,charge,startdate,enddate,timestamp,creator,status) VALUES('$fullname','$phone','$bouquet_id','$charge','$startdate','$enddate',UNIX_TIMESTAMP(),'".$_SESSION['emp_id']."','1')") or die(mysqli_error($con));
        ?>
 ><div class="alert alert-success"><i class="fa fa-check"></i>Abonnement à la salle de sport ajouté avec succès. </div>
    <?php
    }
}
        ?>
                        
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">* Nom Complet</label>

            <div class="col-sm-10"><input type="text" name='fullname' class="form-control" placeholder="Nom Complet"
             required="required">
                                                    </div>
        </div>                                                                
        
                                        <div class="hr-line-dashed"></div>
                                           <div class="form-group"><label class="col-sm-2 control-label">* Téléphone</label>

                                    <div class="col-sm-10"><input type="text" name="number" class="form-control" 
                                    placeholder="Téléphone" required="required">
                                                                        </div>
                                </div>
                                          <div class="hr-line-dashed"></div>
                     
                                            <div class="form-group">
                                <label class="col-sm-2 control-label">* Sélectionnez Bouquet</label>
                                <div class="col-sm-10" style="">
                                     <select class="form-control" name='bouquet'>
                                    <option value="" selected="selected">Sélectionnez Bouquet</option>
                                 <?php
                               $gymbouquets=mysqli_query($con, "SELECT * FROM gymbouquets WHERE status='1'");
        while ($row = mysqli_fetch_array($gymbouquets)) {
            $gymbouquet_id=$row['gymbouquet_id'];
            $gymbouquet=$row['gymbouquet'];
            $charge=$row['charge'];
            $days=$row['days'];
            ?>
                                    <option value="<?php echo $gymbouquet_id.'_'.$days.'_'.$charge; ?>"><?php echo $gymbouquet; ?></option>
                                <?php } ?>
                                      </select>   
                                                      
                                </div>
                                                            
                            </div>                              
                           
                                  <div class="hr-line-dashed"></div>
             <div class="form-group"><label class="col-sm-2 control-label">Date de début</label>

                                    <div class="col-sm-10">
                                        <input type="date" name='startdate' class="form-control" placeholder="Date de début">
                                                                            </div>
                                </div>                                                                
                      <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-primary" type="submit">Ajouter un abonnement</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </div>

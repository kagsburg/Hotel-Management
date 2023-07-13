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
                    <h2>Ajouter Un Nouvel abonnement Piscine</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>   <a href="poolsubscriptions">Abonnements</a>                       </li>
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
                            <h5>Ajouter Nouvel abonnement <small>tous les champs marqués(*) ne doivent pas être laissés vides</small></h5>
                       </div>
                        <div class="ibox-content">
                             <?php
if (isset($_POST['firstname'],$_POST['lastname'],$_POST['package'],$_POST['startdate'])) {
    $firstname=mysqli_real_escape_string($con, trim($_POST['firstname']));
    $lastname=mysqli_real_escape_string($con, trim($_POST['lastname']));
    $startdate=mysqli_real_escape_string($con, strtotime($_POST['startdate']));
    $enddate=mysqli_real_escape_string($con, strtotime($_POST['enddate']));
    $package=mysqli_real_escape_string($con, trim($_POST['package']));
    $reduction=mysqli_real_escape_string($con, trim($_POST['reduction']));
    if ((empty($firstname))||(empty($lastname))||(empty($enddate))||(empty($startdate))||(empty($package))) {
        $errors[]='All Fields Marked * shouldnt be blank';
    }
    $split= explode('_', $package);
    $package_id=$split[0];
    $charge=$split[1];
    if (!empty($errors)) {
        foreach ($errors as $error) {
            ?>
 <div class="alert alert-danger"><?php echo $error; ?></div>
<?php
        }
    } else {
        mysqli_query($con, "INSERT INTO poolsubscriptions(firstname,lastname,package,charge,startdate,enddate,reduction,timestamp,creator,status) VALUES('$firstname','$lastname','$package_id','$charge','$startdate','$enddate','$reduction',UNIX_TIMESTAMP(),'".$_SESSION['emp_id']."','1')") or die(mysqli_error($con));
        ?>
 ><div class="alert alert-success"><i class="fa fa-check"></i>Pool Subscription Successfully Added. </div>
    <?php
    }
}
        ?>
                        
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">* Prénom</label>
   <div class="col-sm-10"><input type="text" name='firstname' class="form-control" placeholder="Prénom" required="required">
                                                                            </div>
                                </div>                                                                
                              <div class="form-group"><label class="col-sm-2 control-label">* Nom</label>
   <div class="col-sm-10"><input type="text" name='lastname' class="form-control" placeholder="Nom" required="required">
                                                                            </div>
                                </div>      
                                    
                                                             <div class="hr-line-dashed"></div>
                     
                                            <div class="form-group">
                                <label class="col-sm-2 control-label">* Séléctionner le paquet</label>
                                <div class="col-sm-10" style="">
                                     <select class="form-control" name='package'>
                                    <option value="" selected="selected">Séléctionner le paquet</option>
                                 <?php
                             $getpackages=mysqli_query($con, "SELECT * FROM poolpackages WHERE status='1'");
        while ($row = mysqli_fetch_array($getpackages)) {
            $poolpackage_id=$row['poolpackage_id'];
            $poolpackage=$row['poolpackage'];
            $charge=$row['charge'];
            $creator=$row['creator'];
            $status=$row['status'];
            ?>
                                    <option value="<?php echo $poolpackage_id.'_'.$charge; ?>">
                                    <?php echo $poolpackage; ?></option>
                                <?php } ?>
                                      </select>   
                                                      
                                </div>
                                                            
                            </div>                              
                       <div class="form-group"><label class="col-sm-2 control-label">Réduction</label>
   <div class="col-sm-10"><input type="text" name='reduction' class="form-control" placeholder="Réduction">
                          </div>
                                </div>             
                             
             <div class="form-group"><label class="col-sm-2 control-label">Date de Debut</label>

                                    <div class="col-sm-10">
                                        <input type="date" name='startdate' class="form-control" placeholder="Enter Date">
                                                                            </div>
                                </div>       
                      <div class="form-group"><label class="col-sm-2 control-label">Date de fin</label>

                                    <div class="col-sm-10">
                                        <input type="date" name='enddate' class="form-control" placeholder="Date de Debut">
                                                                            </div>
                                </div>       
                      <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-primary" type="submit">Ajouter Abonnement</button>
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

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
                    <h2>Ajouter un Congé</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>   <a href="pendingleaves">Congés en Attente</a>                       </li>
                        <li class="active">
                            <strong>Ajouter un Congé</strong>
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
                            <h5>Ajouter un Congé<small>Ajouter Nouvel 
                                Admin, Tout champs marqué(*) ne devrait pas être laissé vide</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                             <?php
if (isset($_POST['employee'],$_POST['enddate'],$_POST['startdate'])) {
    $employee=$_POST['employee'];
    $startdate=mysqli_real_escape_string($con, strtotime($_POST['startdate']));
    $enddate=mysqli_real_escape_string($con, strtotime($_POST['enddate']));
    if ((empty($employee))||(empty($startdate))||(empty($enddate))) {
        $errors[]='All Fields Marked * shouldnt be blank';
    }
    if (!empty($errors)) {
        foreach ($errors as $error) {
            ?>
 <div class="alert alert-danger"><?php echo $error; ?></div>
<?php
        }
    } else {
        mysqli_query($con, "INSERT INTO leaves(employee_id,startdate,enddate,returndate,timestamp,creator,status) VALUES('$employee','$startdate','$enddate','',UNIX_TIMESTAMP(),'".$_SESSION['emp_id']."','0')") or die(mysqli_error($con));
        ?>
 <div class="alert alert-success"><i class="fa fa-check"></i>
Laisser ajouté avec succès. </div>
    <?php
    }
}
        ?>
                        
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">*Employé</label>
                 <div class="col-sm-10">
                                        <select name="employee" class="form-control">
                                            <option value="" selected="selected">Sélectionner employé ...</option>
                                                 <?php
                                     $employees=mysqli_query($con, "SELECT * FROM employees WHERE status='1'");
        while ($row = mysqli_fetch_array($employees)) {
            $employee_id=$row['employee_id'];
            $fullname=$row['fullname'];
            $checkleave= mysqli_query($con, "SELECT * FROM leaves
                                     WHERE employee_id='$employee_id' AND status=1 AND returndate=''");
            if (mysqli_num_rows($checkleave)==0) {
                ?>
                            <option value="<?php echo $employee_id; ?>"><?php echo $fullname; ?></option>
                                   <?php }
            } ?>        
                              </select>
                           </div>
                                </div>                                                                
                              <div class="hr-line-dashed"></div>
             <div class="form-group"><label class="col-sm-2 control-label">Date de début du congé</label>
                   <div class="col-sm-10">
                        <input type="date" name='startdate' class="form-control" placeholder="Date de début du congé">
                                     </div>
                                </div>                
                <div class="hr-line-dashed"></div>
             <div class="form-group"><label class="col-sm-2 control-label">Date de fin du congé</label>
                   <div class="col-sm-10">
                                        <input type="date" name='enddate' class="form-control" placeholder="Date de fin du congé">
                                                                            </div>
                                </div>                
                      <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-primary" type="submit">Ajouter un congé</button>
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
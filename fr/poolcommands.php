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
                    <h2>Commandes Piscine</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                       
                                   <li class="active">
                            <strong>Commandes Piscine</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                   <div class="col-lg-8">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Ajouter un Paquet</h5>
                       
                    </div>
                    <div class="ibox-content">
                        <?php
                        if (isset($_POST['submit'])) {
                            $firstname=mysqli_real_escape_string($con, trim($_POST['firstname']));
                            $lastname=mysqli_real_escape_string($con, trim($_POST['lastname']));
                            $package=mysqli_real_escape_string($con, trim($_POST['package']));
                            $contact=mysqli_real_escape_string($con, trim($_POST['contact']));
                            if ((empty($package))) {
                                $errors[]='All Fields Marked * shouldnt be blank';
                            }
                            $split= explode('_', $package);
                            $package_id=$split[0];
                            $charge=$split[1];
                            if (!empty($errors)) {
                                foreach ($errors as $error) {
                                    echo '<div class="alert alert-danger">'.$error.'</div>';
                                }
                            } else {
                                mysqli_query($con, "INSERT INTO poolcommands(firstname,lastname,contact,package_id,charge,admin_id,timestamp,status) VALUES('$firstname','$lastname','$contact','$package_id','$charge','".$_SESSION['emp_id']."',UNIX_TIMESTAMP(),'1')") or die(mysqli_error($con));
                                echo '<div class="alert alert-success">Pool Command Successfully Added</div>';
                            }
                        }
        ?>
                        <form method="post" name='form' class="form" action=""  enctype="multipart/form-data">
                            <div class="row">
                              <div class="form-group col-lg-6"><label class="control-label">* Prénom</label>
 <input type="text" name='firstname' class="form-control" placeholder="Prénom" required="required">
                                                                                      </div>                                                                
                               <div class="form-group col-lg-6"><label class="control-label">* Nom</label>
   <input type="text" name='lastname' class="form-control" placeholder="Nom" required="required">
                                                                                     </div>    
              <div class="form-group col-lg-6"><label class="control-label">* Contact</label>
   <input type="text" name='contact' class="form-control" placeholder="Entrer le Contact" required="required">
                                                                                     </div>                      
                       <div class="form-group col-lg-6">
                                <label class="control-label">* Séléctionner le paquet</label>
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
                                    <option value="<?php echo $poolpackage_id.'_'.$charge; ?>"><?php echo $poolpackage; ?></option>
                                <?php } ?>
                                      </select>   
                       </div>   
                       </div>   
                                <div class="form-group">
                         <button class="btn btn-primary" type="submit" name="submit">Ajouter</button>           
                                </div>
                    
                        </form>
                    </div>
                    </div>
                    </div>
                                           <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Toute les Abonnements<small>trier, Rechercher</small></h5>
                       
                    </div>
                    <div class="ibox-content">
                   <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                       <th>Client</th>
                        <th>Téléphone</th>
                        <th>Forfait</th>
                        <th>Prix</th>
                        <th>Ajouté par</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
             $commands= mysqli_query($con, "SELECT * FROM poolcommands WHERE status=1") or die(mysqli_error($con));
        while ($row=  mysqli_fetch_array($commands)) {
            $poolcommand_id=$row['poolcommand_id'];
            $firstname=$row['firstname'];
            $lastname=$row['lastname'];
            $contact=$row['contact'];
            $charge=$row['charge'];
            $status=$row['status'];
            $admin_id=$row['admin_id'];
            $package=$row['package_id'];
            $timestamp=$row['timestamp'];
            $getpackage=mysqli_query($con, "SELECT * FROM poolpackages WHERE status='1' AND poolpackage_id='$package'");
            $row1 = mysqli_fetch_array($getpackage);
            $poolpackage=$row1['poolpackage'];
            ?>
               
                    <tr class="gradeA">
                    <td><?php echo $firstname.' '.$lastname; ?></td>
                        <td><?php echo $contact; ?></td>
                        <td><?php echo $poolpackage; ?></td>
                        <td><?php echo $charge; ?></td>
                   
                     <td> <div class="tooltip-demo">
                               
                                   <?php
                                      $employee=  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
            $row = mysqli_fetch_array($employee);
            $employee_id=$row['employee_id'];
            $fullname=$row['fullname'];
            echo $fullname; ?> </div> </td>                    
                     <td><?php echo date('d/m/Y', $timestamp); ?></td>                           
  <td class="center"> 
      <a href="poolcommand?id=<?php echo $poolcommand_id; ?>" class="btn btn-primary btn-xs" target="_blank">Imprimer</a> 
   
         <?php
         if (($creator==$_SESSION['hotelsys'])||($_SESSION['hotelsyslevel']==1)) {
             ?>
     <a href="hidecommand.php?id=<?php echo $poolcommand_id; ?>" class="btn btn-danger btn-xs"
      onclick="return confirm_delete<?php echo $poolcommand_id;?>()">Supprimer <i class="fa fa-arrow-down"></i></a> 
     <script type="text/javascript">
function confirm_delete<?php echo $poolcommand_id; ?>() {
  return confirm('You are about To Remove this item. Are you sure you want to proceed?');
}
</script>                                             
  <?php
         }
            ?>
  </td>
                    </tr>
                                            <?php }?>
                    </tbody>
                                    </table>

                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>

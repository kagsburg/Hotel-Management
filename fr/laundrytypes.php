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
                    <h2>forfaits de lessive </h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                                             <li class="active">
                            <strong>Forfaits de lessive</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
                   <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Ajouter un forfait de lessive<small>
                                assurez-vous de remplir tous les champs nécessaires</small></h5>
                        
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
                                                         mysqli_query($con, "INSERT INTO laundrypackages(laundrypackage,charge,creator,status) 
              VALUES('$package','$charge','".$_SESSION['emp_id']."','1')") or die(mysqli_error($con));

                                                         echo '<div class="alert alert-success"><i class="fa fa-check"></i>Laundry Package successfully added</div>';
                                                     }
                                                 }
       ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Forfaits</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name='package'
                                     placeholder="Forfaits" required='required'></div>
                                </div>
        <div class="form-group"><label class="col-sm-2 control-label">Prix</label>

                                    <div class="col-sm-10"><input type="text"
                                     class="form-control" name='charge' placeholder="Prix" required='required'></div>
                                </div>
                                                 <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                      <button class="btn btn-success btn-sm" name="submit" type="submit">Ajouter paquet</button>
                                    </div>
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
                        <th>Ajouté par</th>
                       <th>&nbsp;</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                        <tr>     <?php
                            $getpackages=mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1'");
       if (mysqli_num_rows($getpackages)>0) {
           while ($row = mysqli_fetch_array($getpackages)) {
               $laundrypackage_id=$row['laundrypackage_id'];
               $laundrypackage=$row['laundrypackage'];
               $charge=$row['charge'];
               $creator=$row['creator'];
               $status=$row['status'];
               ?>
                                     
                       <tr>
                                      <td><?php echo $laundrypackage; ?></td>
                                   <td><?php echo $charge; ?></td>
                                                                  
                                    <td> <div class="tooltip-demo">
                               
                               <a href="employee?id=<?php echo $creator; ?>" 
                               data-original-title="View admin profile"  data-toggle="tooltip" 
                               data-placement="bottom" title="">
                                             <?php
                                            $employee=  mysqli_query($con, "SELECT * 
                                            FROM employees WHERE employee_id='$creator'");
               $row2 = mysqli_fetch_array($employee);
               $employee_id=$row2['employee_id'];
               $fullname=$row2['fullname'];
               echo $fullname;  ?></a> </div></td>
                                                         <td>
                                        <?php
                                            if (($_SESSION['hotelsyslevel']==1)) {
                                                ?>
                                        <a href="editlaundrypackage?id=<?php
                                                echo $laundrypackage_id;?>" class="btn btn-xs btn-info">
                                        <i class="fa fa-edit"></i> Editer</a>
                 <a href="hidelaundrypackage?id=<?php echo $laundrypackage_id;?>" 
                 onclick="return cdelete<?php echo $laundrypackage_id;?>()" class="btn btn-xs btn-danger">
                 <i class="fa fa-trash-o"></i> Supprimer</a>
                       <script type="text/javascript">
                         function cdelete<?php echo $laundrypackage_id; ?>() {
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

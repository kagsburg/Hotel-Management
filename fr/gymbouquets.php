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
                    <h2>Bouquets de Salle de sport</h2>
                    <ol class="breadcrumb">
                         <li> <a href=""><i class="fa fa-home"></i> Accueil</a> </li>                      
                        <li class="active">
                            <strong>Bouquets de Salle de sport</strong>
                        </li>
                    </ol>
                </div>             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
                   <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Ajouter une bouquet du salle de sport</h5>
                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                                                 if (isset($_POST['bouquet'],$_POST['charge'],$_POST['days'])) {
                                                     $bouquet=mysqli_real_escape_string($con, trim($_POST['bouquet']));
                                                     $charge=  mysqli_real_escape_string($con, trim($_POST['charge']));
                                                     $days=  mysqli_real_escape_string($con, trim($_POST['days']));
                                                     if ((empty($bouquet))||(empty($charge))||(empty($days))) {
                                                         echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                                                     }
                                                     if (is_numeric($charge)==false) {
                                                         echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Charge should be An Integer</div>';
                                                     } else {
                                                         mysqli_query($con, "INSERT INTO gymbouquets(gymbouquet,charge,days,creator,timestamp,status) 
              VALUES('$bouquet','$charge','$days','".$_SESSION['emp_id']."',UNIX_TIMESTAMP(),'1')") or die(mysqli_error($con));
                                                         echo '<div class="alert alert-success"><i class="fa fa-check"></i>Reservation Purpose successfully added</div>';
                                                     }
                                                 }
       ?>
  <form method="post" class="form" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">   Nom Bouquet</label>
  <input type="text" class="form-control" name='bouquet' placeholder="Nom Bouquet" required='required'></div>
                                
        <div class="form-group"><label class="control-label">Nombre de jours</label>
 <input type="number" class="form-control" name="days" placeholder="jours" required='required'></div>
                              
                          <div class="form-group"><label class="control-label">Charge</label>
<input type="text" class="form-control" name='charge' placeholder="Charge" required='required'></div>
                               
                         <div class="form-group">
                            <button class="btn btn-success btn-sm" name="submit" type="submit">Enregistrer</button>
                                
                                </div>
                            </form>
                                                 

                    </div>

                  
                </div>
             
                    </div>
                                 <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Bouquet</h5>
                        
                        </div>
                        <div class="ibox-content">
                             <table class="table table-striped  table-hover">
                    <thead>
                    <tr>
                       <th>Nom</th>
                        <th>Charge</th>
                        <th>Jours</th>
                        <th>Ajouté par</th>
                       <th>&nbsp;</th>                       
                    </tr>
                    </thead>
                    <tbody>
                        <tr>     <?php
                            $gymbouquets=mysqli_query($con, "SELECT * FROM gymbouquets WHERE status='1'");
       if (mysqli_num_rows($gymbouquets)>0) {
           while ($row = mysqli_fetch_array($gymbouquets)) {
               $gymbouquet_id=$row['gymbouquet_id'];
               $gymbouquet=$row['gymbouquet'];
               $charge=$row['charge'];
               $days=$row['days'];
               $creator=$row['creator'];
               $timestamp=$row['timestamp'];
               $status=$row['status'];
               ?>
                                     
                       <tr>
                                      <td><?php echo $gymbouquet; ?></td>
                                   <td><?php echo $charge; ?></td>
                                   <td><?php echo $days; ?></td>                                                                  
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
                                        <a href="editbouquet?id=<?php echo $gymbouquet_id;?>" 
                                        class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Editer</a>
                 <a href="hidebouquet?id=<?php echo $gymbouquet_id;?>" onclick="return cdelete<?php echo $gymbouquet_id;?>()" 
                 class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Supprimer</a>
                       <script type="text/javascript">
                         function cdelete<?php echo $gymbouquet_id; ?>() {
  return confirm('You are about To Delete this item. Do you want to proceed?');
}
</script>                 
         <?php } ?>
                                    </td>
                       </tr>
                       
                                    <?php
           }
       } else {
           echo "<div class='alert alert-danger'>No Bouquet Added Yet</div>";
       }
       ?>
                    
                    </tbody>
                             </table>
                        </div>
                    </div>
                    </div>




    </div>

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
                    <h2>Objectifs de réservation de salle</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>
                            <a href="hallbookings">Réservations</a>
                        </li>
                        <li class="active">
                            <strong>Fins de réservation</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
                   <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">                            
                            <h5>Ajouter des objectifs de réservation
                                <small>Veillez Remplir tout les champs nécéssaires</small></h5>                        
                        </div>
                        <div class="ibox-content">
                            <?php
                if (isset($_POST['purpose'],$_POST['charge'])) {
                    $purpose=  mysqli_real_escape_string($con, trim($_POST['purpose']));
                    $charge=  mysqli_real_escape_string($con, trim($_POST['charge']));
                    if ((empty($purpose)||(empty($charge)))) {
                        echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                    }
                    if (is_numeric($charge)==false) {
                        echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Purpose Charge should be An Integer</div>';
                    } else {
                        mysqli_query($con, "INSERT INTO hallpurposes(hallpurpose,charge,creator,timestamp,status) VALUES('$purpose','$charge','".$_SESSION['emp_id']."',UNIX_TIMESTAMP(),'1')") or die(mysqli_errno($con));

                        echo '<div class="alert alert-success"><i class="fa fa-check"></i>Reservation Purpose successfully added</div>';
                    }
                }
       ?>
            <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                <div class="form-group"><label class="col-sm-2 control-label">Objectif</label>
                    <div class="col-sm-10"><input type="text" class="form-control" name='purpose' 
                    placeholder="Objectif" required='required'></div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">Charge</label>
                            <div class="col-sm-10"><input type="text" class="form-control"
                             name='charge' placeholder="Enter  Charge" required='required'></div>
                        </div>    <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                       <button class="btn btn-success btn-sm" name="submit"
                                        type="submit">Ajouter un objectif</button>
                                    </div>
                                </div>
                            </form> 
                    </div>                  
                </div>             
                    </div>
                    <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">                            
                            <h5>Objectifs</h5>                        
                        </div>
                        <div class="ibox-content">
                             <table class="table table-striped  table-hover">
                    <thead>
                    <tr>
                       
                        <th>Objectif</th>
                        <th>Charge</th>
                        <th>Ajouté par</th>
                        <th>Ajouté le</th>
                        <th>&nbsp;</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                        <tr>     <?php
                            $purposes=mysqli_query($con, "SELECT * FROM hallpurposes WHERE status='1'");
       if (mysqli_num_rows($purposes)>0) {
           while ($row = mysqli_fetch_array($purposes)) {
               $hallpurpose_id=$row['hallpurpose_id'];
               $hallpurpose=$row['hallpurpose'];
               $charge=$row['charge'];
               $creator=$row['creator'];
               $timestamp=$row['timestamp'];
               $status=$row['status'];
               ?>
                                     
                       <tr>
                                      <td><?php echo $hallpurpose; ?></td>
                                   <td><?php echo $charge; ?></td>
                                                                  
                                    <td> <div class="tooltip-demo">                               
                               <a href="employee?id=<?php echo $creator; ?>" data-original-title="View admin profile" 
                                data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php
                                            $employee=  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
               $row2 = mysqli_fetch_array($employee);
               $employee_id=$row2['employee_id'];
               $fullname=$row2['fullname'];
               echo $fullname;  ?></a> </div></td>
                                    <td><?php echo date('d/m/Y', $timestamp); ?></td>
                                    <td>
                                        <?php
                                            if (($_SESSION['hotelsyslevel']==1)) {
                                                ?>
                                        <a href="editpurpose?id=<?php echo $hallpurpose_id;?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
                                <a href="hidehallpurpose?id=<?php echo $hallpurpose_id;?>" onclick="return cdelete<?php echo $hallpurpose_id;?>()" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Remove</a>
                                    <script type="text/javascript">
                                        function cdelete<?php echo $hallpurpose_id; ?>() {
  return confirm('You are about To Delete a Purpose. Do you want to proceed?');
}
</script>                 
                                            <?php } ?>
                                    </td>
                       </tr>
                       
                                    <?php
           }
       } else {
           echo "<div class='alert alert-danger'>  Aucun objectif ajouté pour le moment</div>";
       }
       ?>  </tbody>
                             </table>
                        </div>
                    </div>
                    </div>
    </div>
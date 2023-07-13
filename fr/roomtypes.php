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
                    <h2>Type Chambres</h2>
                    <ol class="breadcrumb">
                         <li> <a href=""><i class="fa fa-home"></i> Accueil</a>  </li>
                        <li>
                            <a href="rooms">Chambres</a>
                        </li>
                        <li class="active">
                            <strong>Ajouter une chambre</strong>
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
                            <h5>Ajouter une chambre <small>Tapez Assurez-vous de remplir tous les champs nécessaires  </small></h5>                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                                    include_once 'includes/thumbs3.php';
                            if (isset($_POST['type'],$_POST['charge'])) {
                                $type=  mysqli_real_escape_string($con, trim($_POST['type']));
                                $charge=  mysqli_real_escape_string($con, trim($_POST['charge']));
                                if ((empty($type)||(empty($charge)))) {
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                                }
                                if (is_numeric($charge)==false) {
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Room Charge should be An Integer</div>';
                                } else {
                                    mysqli_query($con, "INSERT INTO roomtypes(roomtype,charge,status) VALUES('$type','$charge','1')") or die(mysqli_errno($con));
                                    echo '<div class="alert alert-success"><i class="fa fa-check"></i>Room type successfully added</div>';
                                }
                            }
                            ?>
                        <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Nom Type</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name='type' placeholder="Nom Type" required='required'>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Chambres Prix</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name='charge' placeholder="Chambres Prix" required='required'></div>
                                         </div>                                                                                                                            
                                           <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" name="submit" type="submit">Ajouter une chambre</button>
                                </div>
                            </div>
                        </form>                   
                    </div>
                </div>             
                    </div>
                           <?php } ?>
                           <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">                            
                            <h5>Type Chambres</h5>                        
                        </div>
                        <div class="ibox-content">
                             <table class="table table-striped  table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type Chambre</th>
                        <th>Prix</th>
                        <th>Chambres</th>                       
                        <th>&nbsp;</th>                       
                    </tr>
                    </thead>
                    <tbody>
                        <tr>     <?php
                             $roomtypes=mysqli_query($con, "SELECT * FROM roomtypes WHERE status=1");
       if (mysqli_num_rows($roomtypes)>0) {
           while ($row = mysqli_fetch_array($roomtypes)) {
               $roomtype_id=$row['roomtype_id'];
               $roomtype=$row['roomtype'];
               $charge=$row['charge'];
               $status=$row['status'];
               $getrooms=mysqli_query($con, "SELECT * FROM rooms WHERE type='$roomtype_id' AND status=1");
               ?>                                     
                       <tr><td><?php echo $roomtype_id; ?></td>
                                   <td><?php echo $roomtype; ?></td>
                                   <td><?php echo $charge; ?></td>
                                                                  
                                    <td><?php echo mysqli_num_rows($getrooms); ?></td>
                                 
                                    <td>
                                        <?php
                     if (($_SESSION['hotelsyslevel']==1)) {
                         ?>
                                        <a href="editroomtype?id=<?php echo $roomtype_id;?>" class="btn btn-xs btn-warning">
                                        <i class="fa fa-edit"></i> Editer</a>                                  
                                    <a href="hideroomtype?id=<?php echo $roomtype_id;?>" class="btn btn-xs btn-danger" 
                                    onclick="return confirm_delete<?php echo $roomtype_id;?>()"><i class="fa fa-arrow-down"></i>supprimer</a>
                        <script type="text/javascript">
                            function confirm_delete<?php echo $roomtype_id; ?>() {
                            return confirm('You are about To Perform  this Action. Are you sure you want to proceed?');
                            }
                        </script>                                       
                            <?php }?>
                        </td>
                        </tr>
                                        <?php
           }
       } else {
           echo "<div class='alert alert-danger'>No Room Types Added Yet</div>";
       }
       ?>                    
                    </tbody>
                             </table>
                        </div>
                    </div>
                    </div>
                </div>

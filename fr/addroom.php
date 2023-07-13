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
                    <h2>Ajouter une nouvelle Chambre</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>                         <a href="rooms">Chambre</a>            </li>
                        <li class="active">
                            <strong>Ajouter Salle</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Ajouter une nouvelle Chambre <small>
                                Assurez-vous de remplir tous les champs nécessaires</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                           <?php
                          if (isset($_POST['number'],$_POST['type'])) {
                              if ((!empty($_POST['number']))||(!empty($_POST['type']))) {
                                  $number=  mysqli_real_escape_string($con, trim($_POST['number']));
                                  $type= mysqli_real_escape_string($con, trim($_POST['type']));
                                  $check=  mysqli_query($con, "SELECT * FROM rooms WHERE roomnumber='$number'");
                                  if (mysqli_num_rows($check)>0) {
                                      echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Room Number Already Exists</div>';
                                  } else {
                                      mysqli_query($con, "INSERT INTO rooms(roomnumber,type,creator,status) 
                                   VALUES('$number','$type','".$_SESSION['emp_id']."','1')") or die(mysqli_errno($con));
                                      echo '<div class="alert alert-success"><i class="fa fa-check"></i> Room successfully Added</div>';
                                  }
                              } else {
                                  echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>All Fields Required</div>';
                              }
                          }
        ?>
                          
                            <form method="post" name='form' class="form" action=""  enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">Numéro Chamre</label>
            <input type="text" name="number" class="form-control" placeholder="Numéro Chamre"  required="required">
                                </div>
                                                   <div class="form-group"><label class="control-label">Type de chambre</label>
                                        <select name="type" class="form-control">
                                                         <option value="" selected="selected">sélectionner le type de chambre...</option>
                                                      <?php
                                  $gettypes=  mysqli_query($con, "SELECT * FROM roomtypes");
        while ($row = mysqli_fetch_array($gettypes)) {
            $roomtype_id=$row['roomtype_id'];
            $roomtype=$row['roomtype'];
            $status=$row['status'];

            ?>
                                                     <option value="<?php echo $roomtype_id; ?>"><?php echo $roomtype; ?></option>
                                                  
                                                      <?php } ?>
                                                       
                                          </select></div>
                                                                       
                               <div class="form-group">
                                    <button class="btn btn-primary " type="submit">Ajouter Chambre</button>                               
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>


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
                    <h2>Ajouter un nouveau travail de lessive</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>                         <a href="laundrywork">Lessive</a>                       </li>
                        <li class="active">
                            <strong>Ajouter travail de lessive</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Ajouter un nouveau travail de lessive <small>
                                tous les champs marqués(*) ne doivent pas être laissés vides</small></h5>                           
                        </div>
                        <div class="ibox-content">
                             <?php
if (isset($_POST['reserve'],$_POST['clothes'],$_POST['package'])) {
    $reserve_id=mysqli_real_escape_string($con, trim($_POST['reserve']));
    $clothes=mysqli_real_escape_string($con, trim($_POST['clothes']));
    $package=mysqli_real_escape_string($con, trim($_POST['package']));
    if ((empty($reserve_id))||(empty($clothes))||(empty($package))) {
        $errors[]='All Fields Marked with * should be filled';
    }

    if (is_numeric($clothes)==false) {
        $errors[]='Number of Clothes Should Be an Integer';
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            ?>
 <div class="alert alert-danger"><?php echo $error; ?></div>
<?php
        }
    } else {
        $split= explode('_', $package);
        $package_id= current($split);
        $charge=end($split);
        mysqli_query($con, "INSERT INTO laundry(reserve_id,clothes,package_id,charge,creator,timestamp,status)VALUES('$reserve_id','$clothes','$package_id','$charge','".$_SESSION['hotelsys']."','$timenow','0')") or die(mysqli_errno($con));
        ?>
 <div class="alert alert-success"><i class="fa fa-check"></i> Travail de blanchisserie ajouté avec succès</div>
    <?php
    }
}
        ?>
                        
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                    <div class="form-group" id="data_5">
                               <label class="col-sm-2 control-label">* 
Sélectionnez l'invité</label>
                              <div class="col-sm-10">  
                                  <select class="form-control" name="reserve">
                                      <option value="" selected="selected">Sélectionnez Invité et chambre</option>
                                       <?php
                            $reservations=mysqli_query($con, "SELECT * FROM reservations WHERE status='1' ORDER BY reservation_id DESC");
        while ($row=  mysqli_fetch_array($reservations)) {
            $reservation_id=$row['reservation_id'];
            $firstname=$row['firstname'];
            $lastname=$row['lastname'];
            $room_id=$row['room'];
            $roomtypes=mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
            $row1=  mysqli_fetch_array($roomtypes);
            $roomtype=$row1['roomnumber'];
            ?>
                                      <option value="<?php echo $reservation_id; ?>">
                                      <?php echo $firstname.' '.$lastname.'('.$roomtype.')'; ?></option>
<?php }?>
    
                                  </select>
                                </div>
                            </div>
         <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">* Nombre d’habits</label>

                                    <div class="col-sm-10"><input type="text" name='clothes' 
                                    class="form-control" placeholder="Nombre d’habits" required="required">
                                                                            </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">* Prix</label>

                                    <div class="col-sm-10">
                                        <select name="package" class="form-control">
                                            <option value="" selected="selected"> Sélectionner ...</option>
                                              <?php
                                       $getpackages=mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1'");
        while ($row = mysqli_fetch_array($getpackages)) {
            $laundrypackage_id=$row['laundrypackage_id'];
            $laundrypackage=$row['laundrypackage'];
            $charge=$row['charge'];
            ?>
                                            <option value="<?php echo $laundrypackage_id.'_'.$charge; ?>" >
                                             <?php echo $laundrypackage.' ('.$charge.')'; ?></option>
                                <?php }?>
                                        </select>
                                                                            </div>
                                </div>
                                      
                                                                                     <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-primary" type="submit">Ajouter Lessive</button>
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

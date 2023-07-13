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
                    <h2>Paramètres</h2>
                    <ol class="breadcrumb">
                         <li>              <a href="index"><i class="fa fa-home"></i> Accueil</a>                    </li>
                      
                        <li class="active">
                            <strong>Paramètres</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
           <?php
           $getsettings= mysqli_query($con, "SELECT * FROM settings");
       if (mysqli_num_rows($getsettings)==0) {
           ?>
                    <a data-toggle="modal" class="btn btn-primary btn-sm" 
                    href="#modal-form"><i class="fa fa-edit"></i>Ajouter des paramètres</a>
           <?php } else {?>
                <a data-toggle="modal" class="btn btn-primary btn-sm" href="#edit-form">
                    <i class="fa fa-edit"></i>Editer les Paramètre</a>
           <?php }?>
                    <div class="row">

                           <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Paramètres</h5>
                        
                        </div>
                        <div class="ibox-content">
                             <table class="table table-striped  table-hover">
                                    <tbody>
                   
   <?php
 $row = mysqli_fetch_array($getsettings);
       $hotelname= $row['hotelname'];
       $nif= $row['nif'];
       $hoteladdress= $row['hoteladdress'];
       $corporatename= $row['corporatename'];
       $hotelcontacts=  $row['hotelcontacts'];
       $hotelmanager= $row['hotelmanager'];
       $logo= $row['logo'];
       ?>
     <tr><th>Nom de L’Hotel</th><td><?php echo $hotelname; ?></td> </tr>
     <tr><th>NIF</th><td><?php echo $nif; ?></td> </tr>
     <tr><th>Addrèsse de l’ Hotel</th><td><?php echo $hoteladdress; ?></td> </tr>
     <tr><th>Addrèsse de l’ Hotel</th><td><?php echo $hoteladdress; ?></td> </tr>
     <tr><th>Dénomination Social</th><td><?php echo $corporatename; ?></td> </tr>
     <tr><th>Contacts de l’ Hotel</th><td><?php echo $hotelcontacts; ?></td> </tr>
     <tr><th>Manageur(euse) de L’ Hotel</th><td><?php echo $hotelmanager; ?></td> </tr>
     <tr><th>logo de L’ Hotel (Laissez vide si inchangé) </th><td>
        <img src="img/sitelogo.<?php echo $logo.'?'. time();?>" style="max-width: 200px"></td> </tr>
                       
                               
                    
                    </tbody>
                             </table>
                        </div>
                    </div>
                    </div>
   </div>
   </div>
   </div>
   </div>
    <div id="edit-form" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12"><h3 class="m-t-none m-b">Editer les Paramètre</h3>
                                              
                                                    <form role="form" method="POST" action="editsettings" enctype="multipart/form-data">
                                                        <div class="form-group">
                                                            <label class="control-label">Nom de L’Hotel</label>
                                                            <input type="text" class="form-control" name="hotelname" value="<?php echo $hotelname; ?>">
                                                        </div>
                                                             <div class="form-group">
                                                            <label class="control-label">NIF</label>
                                                            <input type="text" class="form-control" name="nif" value="<?php echo $nif; ?>">
                                                        </div>
                                                             <div class="form-group">
                                                            <label class="control-label">Addrèsse de l’ Hotel</label>
                                                            <input type="text" class="form-control" name="hoteladdress" value="<?php echo $hoteladdress; ?>">
                                                        </div>
                                                           <div class="form-group">
                                                            <label class="control-label">Dénomination Social</label>
                                                            <input type="text" class="form-control" name="corporatename" value="<?php echo $corporatename; ?>">
                                                        </div>
                                                           <div class="form-group">
                                                            <label class="control-label">Contacts de l’ Hotel</label>
                                                            <input type="text" class="form-control" name="hotelcontacts" value="<?php echo $hotelcontacts; ?>">
                                                        </div>
                                                           <div class="form-group">
                                                            <label class="control-label">Manageur(euse) de L’ Hotel</label>
                                                            <input type="text" class="form-control" name="hotelmanager" value="<?php echo $hotelmanager; ?>">
                                                        </div>
                                                           <div class="form-group">
                                                            <label class="control-label">logo de L’ Hotel (Laissez vide si inchangé)</label>
                                                            <input type="file"  name="logo">
                                                        </div>
                                                        <div>
                                                            <button class="btn btn-sm btn-primary m-t-n-xs" type="submit" name="edit"><strong>Editer</strong></button>
                                                                                                                </div>
                                                    </form>
                                                </div>
                                                
                                        </div>
                                    </div>
                                    </div>
                                </div>
                        </div>
<div id="modal-form" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12"><h3 class="m-t-none m-b">Ajouter des paramètres</h3>
                                                 <?php
                                                      if (isset($_POST['submit'])) {
                                                          $hotelname= mysqli_real_escape_string($con, trim($_POST['hotelname']));
                                                          $nif=mysqli_real_escape_string($con, trim($_POST['nif']));
                                                          $hoteladdress= mysqli_real_escape_string($con, trim($_POST['hoteladdress']));
                                                          $corporatename= mysqli_real_escape_string($con, trim($_POST['corporatename']));
                                                          $hotelcontacts= mysqli_real_escape_string($con, trim($_POST['hotelcontacts']));
                                                          $hotelmanager= mysqli_real_escape_string($con, trim($_POST['hotelmanager']));
                                                          $image_name=$_FILES['logo']['name'];
                                                          $image_size=$_FILES['logo']['size'];
                                                          $image_temp=$_FILES['logo']['tmp_name'];
                                                          $allowed_ext=array('jpg','jpeg','png','PNG','gif','JPG','JPEG','GIF','');
                                                          $imgext=explode('.', $image_name);
                                                          $image_ext=end($imgext);
                                                          if (in_array($image_ext, $allowed_ext)===false) {
                                                              $errors[]='Image File type not allowed';
                                                          }
                                                          if ($image_size>20097152) {
                                                              $errors[]='Maximum Image size is 20Mb';
                                                          }
                                                          if (!empty($errors)) {
                                                              foreach ($errors as $error) {
                                                                  echo $error;
                                                              }
                                                          } else {
                                                              if ((!empty($hotelname))&&(mysqli_num_rows($getsettings)==0)) {
                                                                  mysqli_query($con, "INSERT INTO settings(hotelname,nif,hoteladdress,corporatename,hotelcontacts,hotelmanager,logo) VALUES('$hotelname','$nif','$hoteladdress','$corporatename','$hotelcontacts','$hotelmanager','$image_ext')");
                                                                  $image_file='sitelogo.'.$image_ext;
                                                                  move_uploaded_file($image_temp, 'img/'.$image_file) or die(mysqli_error($con));
                                                              }
                                                          }
                                                      }
       ?>
                                                    <form role="form" method="POST" action="" enctype="multipart/form-data">
                                                        <div class="form-group">
                                                            <label class="control-label">Nom de L’Hotel</label>
                                                            <input type="text" class="form-control" name="hotelname">
                                                        </div>
                                                             <div class="form-group">
                                                            <label class="control-label">NIF</label>
                                                            <input type="text" class="form-control" name="nif">
                                                        </div>
                                                             <div class="form-group">
                                                            <label class="control-label">Addrèsse de l’ Hotel</label>
                                                            <input type="text" class="form-control" name="hoteladdress">
                                                        </div>
                                                           <div class="form-group">
                                                            <label class="control-label">Dénomination Social</label>
                                                            <input type="text" class="form-control" name="corporatename">
                                                        </div>
                                                           <div class="form-group">
                                                            <label class="control-label">Contacts de l’ Hotel</label>
                                                            <input type="text" class="form-control" name="hotelcontacts">
                                                        </div>
                                                           <div class="form-group">
                                                            <label class="control-label">Manageur(euse) de L’ Hotel</label>
                                                            <input type="text" class="form-control" name="hotelmanager">
                                                        </div>
                                                           <div class="form-group">
                                                            <label class="control-label">logo de L’ Hotel</label>
                                                            <input type="file"  name="logo">
                                                        </div>
                                                        <div>
                                                            <button class="btn btn-sm btn-primary m-t-n-xs" type="submit" name="submit">
                                                                <strong>Soummettre  </strong></button>
                                                                                                                </div>
                                                    </form>
                                                </div>
                                                
                                        </div>
                                    </div>
                                    </div>
                                </div>
                        </div>
   
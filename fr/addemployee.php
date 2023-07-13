
    <div id="wrapper">

        <?php include 'nav.php'; ?>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
          
        </div>
            <!-- <ul class="nav navbar-top-links navbar-right">
               
             <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
            <li><a href="switchlanguage?lan=en">English</a> </li>
            </ul> -->

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Ajouter un nouvel employé</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>                         <a>Employés</a>                       </li>
                        <li class="active">
                            <strong>Ajouter employé</strong>
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
                            <h5>Ajouter un nouvel employé
                                 <small>Tapez Assurez-vous de remplir tous les champs nécessaires</small></h5>
                           
                        </div>
                        <div class="ibox-content">
 <?php
   if (isset($_POST['fullname'],$_POST['gender'],$_POST['phone'],
       $_FILES['image'],$_POST['designation'],$_POST['email'],$_POST['salary'],$_POST['joining'])) {
       $image_name=$_FILES['image']['name'];
       $image_size=$_FILES['image']['size'];
       $image_temp=$_FILES['image']['tmp_name'];
       $allowed_ext=array('jpg','jpeg','png','PNG','gif','');
       $imgext=explode('.', $image_name);
       $image_ext=end($imgext);
       $fullname=mysqli_real_escape_string($con, trim($_POST['fullname']));
       $employeenumber=mysqli_real_escape_string($con, trim($_POST['employeenumber']));
       $joining=mysqli_real_escape_string($con, strtotime($_POST['joining']));
       $ending=mysqli_real_escape_string($con, strtotime($_POST['ending']));
       $dob=mysqli_real_escape_string($con, strtotime($_POST['dob']));
       $phone= mysqli_real_escape_string($con, trim($_POST['phone']));
       $address= mysqli_real_escape_string($con, trim($_POST['address']));
       $email= mysqli_real_escape_string($con, trim($_POST['email']));
       $salary= mysqli_real_escape_string($con, trim($_POST['salary']));
       $gender=$_POST['gender'];
       $job=explode('-', $_POST['designation']);
       $designation=  current($job);
       $department=end($job);
       $username= mysqli_real_escape_string($con, trim($_POST['username']));
       $password= mysqli_real_escape_string($con, trim($_POST['password']));
       $role=$_POST['role'];
       if ($role=='manager') {
           $status=1;
       } else {
           $status=0;
       }
       $check=mysqli_query($con, "SELECT * FROM employees WHERE email='$email' AND status='1'");
       if (in_array($image_ext, $allowed_ext)===false) {
           $errors[]='Image File type not allowed';
       }
       if ($image_size>2097152) {
           $errors[]='Maximum Image size is 2Mb';
       }
       if (mysqli_num_rows($check)>0) {
           $errors[]='Email Already Exists';
       }
       if (!empty($errors)) {
           foreach ($errors as $error) {
               ?>
 <div class="alert alert-danger"><?php echo $error; ?></div>
<?php
           }
       } else {
           include 'includes/thumbs3.php';
           $addemployee=  mysqli_query($con, "INSERT INTO employees(fullname,gender,employeenumber,address,phone,email,ext,designation,salary,dob,start_date,end_date,status) VALUES('$fullname','$gender','$employeenumber','$address','$phone','$email','$image_ext','$designation','$salary','$dob','$joining','$ending','1')") or die(mysqli_errno($con));
           $last_id=  mysqli_insert_id($con);
           $image_file=  md5($last_id).'.'.$image_ext;
           move_uploaded_file($image_temp, 'img/employees/'.$image_file) or die(mysqli_errno($con));
           create_thumb('img/employees/', $image_file, 'img/employees/thumbs/');
           if (!empty($role)) {
               mysqli_query($con, "INSERT INTO users(employee,username,password,role,level,status) VALUES('$last_id','$username','".md5($password)."','$role','$status','1')") or die(mysqli_error($con));
           }
           echo '<div class="alert alert-success">Données sur les employés ajoutées avec succès</div>';
       }
   }

        ?>
                        
     <form method="post" name='form' class="form" action=""  enctype="multipart/form-data">
         <div class="row">
               <div class="form-group col-sm-6"><label class="control-label">Numéro Employée</label>

                               <input type="text" name='employeenumber' class="form-control" placeholder="Enter Number">
                                                                            </div>
                                <div class="form-group col-sm-6"><label class="control-label">* Nom Complet</label>

                               <input type="text" name='fullname' class="form-control" placeholder="Nom Complet" required="required">
                                                                            </div>
                        
                                  <div class="form-group col-sm-6"><label class="control-label">* Genre</label>
  <select name="gender" class="form-control">
                                            <option value="">sélectionnez le sexe...</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                </div>
           
                                   
                                 <div class="form-group col-sm-6"><label class="control-label">*Téléphone</label>
<input type="text" name="phone" class="form-control" placeholder="Téléphone" required="required">
                                                                                               </div>
                             
                                  <div class="form-group col-sm-6"><label class="control-label">* Salaire</label>
<input type="text" name="salary" class="form-control" placeholder="Salaire" required="required">
                                                                        </div>
                               
                           <div class="form-group col-sm-6" id="data_1">
                              <label class="control-label">Date Naissance</label>
                             
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i>
                                </span><input type="text" class="form-control" name="dob" placeholder="Date Naissance" required="required">
                                </div>
                            
                            </div>
                      
                           <div class="form-group col-sm-6"><label class="control-label">*Désignation (Département)</label>

                                      <select class="form-control" name="designation">
                                            <option value="" selected="selected">Sélectionnez la désignation....</option>
                                            <?php

        $dept2=  mysqli_query($con, "SELECT * FROM designations");
        if (mysqli_num_rows($dept2)>0) {
            while ($row2=  mysqli_fetch_array($dept2)) {
                $design_id=$row2['designation_id'];
                $dept_id=$row2['department_id'];
                $design=$row2['designation'];
                $status2=$row2['status'];
                $dept=  mysqli_query($con, "SELECT * FROM departments WHERE department_id='$dept_id'");
                $row = mysqli_fetch_array($dept);
                $dept_name=$row['department'];
                ?>
                  <option value="<?php echo $design_id.'-'.$dept_id;?>"> <?php echo $design.' ('.$dept_name.')';?></option>
                                    <?php }
            } ?>
                                        </select>
                                    </div>
                
                       <div class="form-group col-sm-6"><label class="control-label">* Residence</label>
<input type="text" name="address" class="form-control" placeholder="Residence" required="required">
                                                                                                 </div>                                 
                   <div class="form-group col-sm-6" id="data_1">
                              <label class="control-label">Date de début du contrat</label>
                               <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i>
                                </span><input type="text" class="form-control" name="joining" placeholder="Date de début du contrat" required="required">
                                </div>
                                </div>    
                <div class="form-group col-sm-6" id="data_1">
                              <label class="control-label">Date de fin du contrat</label>
                               <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar">

                                    </i></span><input type="text" class="form-control" name="ending" placeholder="Date de fin du contrat" required="required">
                                </div>
                                </div>    
                                  <div class="form-group col-sm-6"><label class="control-label"> Image de profil</label>
<input type="file"  name="image" class="form-control " style="padding: 0px" required="required">
                                  </div>
                               <div class="form-group col-sm-6"><label class="control-label"> Email</label>
<input type="email" name="email" class="form-control "  placeholder="Email">
                                      <div id='form_email_errorloc' class='text-danger'></div>
                                 
                                </div>
   
                                </div>
          <h4>Remplissez cette section si l'employé doit accéder au système</h4>
         <div class="row">
          <div class="form-group col-sm-6"><label class="control-label">Nom d'utilisateur</label>

                               <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur">
                                                                        </div>
                                        <div class="form-group col-sm-6"><label class="control-label">Mot de passe</label>
<input type="password" name="password" class="form-control" placeholder="Mot de passe">
                                      <div id='form_password_errorloc' class='text-danger'></div>
                                              </div>
  <div class="form-group col-sm-6"><label class="control-label">Répéter le mot de passe</label>
<input type="password" name="repeat" class="form-control" placeholder="Répéter le mot de passe">
                                      <div id='form_repeat_errorloc' class='text-danger'></div>
                                          </div>
                                                                
               <div class="form-group col-sm-6">
                                <label class="control-label">Sélectionnez un rôle</label>
                          
                                     <select data-placeholder="Choisissez un rôle..." class="form-control" name='role'>
                                    <option value="" selected="selected">Attribuer un rôle</option>
                                <option value="manager">Manageur</option>
                                <!--<option value="Bar attendant">Bar Attendant</option>-->
                                <option value="Store Attendant">Store Attendant</option>
                                 <option value="Receptionist">Receptionist</option>
                                <option value="Hall Attendant">Hall Attendant</option>
                                <option value="Laundry Attendant">Laundry Attendant</option>
                                <option value="Restaurant Attendant">Restaurant Attendant</option>
                                <option value="Accountant">Accountant</option>
                                                                             </select>   
                                    
                                </div>
                                                            
                            </div>             
                             <div class="form-group">
                           
                                        <button class="btn btn-primary" type="submit">Ajouter employé
</button>
                          
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </div>

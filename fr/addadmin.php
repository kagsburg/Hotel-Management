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
                    <h2>Ajouter Nouvel Admin</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>                         <a href="admins">Admins</a>                       </li>
                        <li class="active">
                            <strong>Ajouter Nouvel Admin</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Ajouter Nouvel Admin <small> Ajouter Nouvel Admin, Tout champs marqué(*) ne devrait pas être laissé vide</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                             <?php
if (isset($_POST['employee'],$_POST['username'],$_POST['password'],$_POST['role'])) {
    $employee=$_POST['employee'];
    $username= mysqli_real_escape_string($con, trim($_POST['username']));
    $password= mysqli_real_escape_string($con, trim($_POST['password']));
    $role=$_POST['role'];
    if ($role=='manager') {
        $status=1;
    } else {
        $status=0;
    }
    if ((empty($employee))||(empty($username))||(empty($password))||(empty($role))) {
        $errors[]='All Fields marked * should be filled';
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            ?>
 <div class="col-sm-2"></div><div class="col-sm-10"><div class="alert alert-danger"><?php echo $error; ?></div></div>
<?php
        }
    } else {
        mysqli_query($con, "INSERT INTO users(employee,username,password,role,level,status)
          VALUES('$employee','$username','".md5($password)."','$role','$status','1')") or die(mysql_error());
        ?>
  
     <div class="col-sm-2"></div><div class="col-sm-10"><div class="alert alert-success"><i class="fa fa-check"></i>
     Admin ajouté avec succès</div></div>
    <?php

    }
}
        ?>
                        
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                                 <div class="form-group">
                                <label class="col-sm-2 control-label">* Sélectionner employé</label>
                                <div class="col-sm-10">
                                  <select  class="form-control" name='employee'>
                                    <option value="" selected="selected">Sélectionner employé</option>
                                     <?php
                                     $employees=  mysqli_query($con, "SELECT * FROM employees WHERE status='1'");
        while ($row = mysqli_fetch_array($employees)) {
            $employee_id=$row['employee_id'];
            $fullname=$row['fullname'];
            $gender=$row['gender'];
            $design_id=$row['designation'];
            $status=$row['status'];
            $ext=$row['ext'];
            $dept2=  mysqli_query($con, "SELECT * FROM designations WHERE
                                              designation_id='$design_id'");
            $row2=  mysqli_fetch_array($dept2);
            $dept_id=$row2['department_id'];
            $design=$row2['designation'];
            ?>
                                    <option value="<?php echo $employee_id; ?>"><?php
                                    echo $fullname.'('.$design.')';?></option>
                                 <?php }?>
                                                     </select>   
                                                      
                                </div>
                                                            
                            </div>                  
                                <div class="hr-line-dashed"></div>
                                  <div class="form-group"><label class="col-sm-2 control-label">* Nom Utilisateur</label>

                                    <div class="col-sm-10"><input type="text" name="username" class="form-control" placeholder="Nom Utilisateur" required="required">
                                                                        </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                   
                                 <div class="form-group"><label class="col-sm-2 control-label">*Mot de passe</label>

                                    <div class="col-sm-10"><input type="password" name="password" class="form-control" 
                                    placeholder="Mot de passe" required="required">
                                      <div id='form_password_errorloc' class='text-danger'></div>
                                    </div>
                                </div>
                                    <div class="hr-line-dashed"></div>
                                     <div class="form-group"><label class="col-sm-2 control-label"> *Repetez le mot de passe</label>

                                    <div class="col-sm-10"><input type="password" name="repeat" class="form-control"
                                     placeholder="Repetez le mot de passe" required="required">
                                      <div id='form_repeat_errorloc' class='text-danger'></div>
                                    </div>
                                </div>
                                                                 
                                <div class="hr-line-dashed"></div>
                                  
                                <div class="form-group">
                                <label class="col-sm-2 control-label">* Sélectionnez le Role</label>
                                <div class="col-sm-10" style="">
                                     <select data-placeholder="Choose a role..." class="form-control" name='role'>
                                    <option value="" selected="selected">Assignez un Role</option>
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
                                    <div class="col-sm-4 col-sm-offset-2">                                   
                                        <button class="btn btn-primary" type="submit">Ajouter Admins</button>
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

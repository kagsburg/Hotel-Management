
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
                    <h2>Départements</h2>
                    <ol class="breadcrumb">
                        <li>  <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li> <a>Départements</a>                       </li>
                        <li class="active">
                            <strong>Departments</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">                                    
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Ajouter un nouveau département<small> tous les champs marqués(*) ne doivent pas restés vides

                            </small></h5>
                           
                        </div>
                        <div class="ibox-content">
                             <?php
if (isset($_POST['department'])) {
    $dept=mysqli_real_escape_string($con, trim($_POST['department']));
    if (empty($dept)) {
        echo '<div class="alert alert-danger">Enter Department To Continue</div>';
    } else {
        mysqli_query($con, "INSERT INTO departments(department,status) VALUES('$dept','1')");
        ?>
  
     <div class="col-sm-2"></div><div class="col-sm-10"><div class="alert alert-success">
        <i class="fa fa-check"></i>Département ajouté avec succès</div></div>
    <?php

    }
}
        ?>
                        
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Département</label>
                                    <div class="col-sm-10"><input type="text" name='department' 
                                    class="form-control" placeholder="Départements" required="required">
                                                                            </div>
                                </div>
                                                             <div class="hr-line-dashed"></div>
                            
                                                                                                  
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-primary" type="submit">Ajouter un département</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                                        <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>départements de l’hôtel</h5>                            
                        </div>
                        <div class="ibox-content">
                            <div class="panel-body">
                                <div class="panel-group" id="accordion">
                                    <?php
                                            $depts=  mysqli_query($con, "SELECT * FROM departments");
        while ($row = mysqli_fetch_array($depts)) {
            $dept_id=$row['department_id'];
            $dept=$row['department'];
            $status=$row['status'];
            ?>
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            <h5 class="panel-title">
                                                <a data-toggle="collapse" 
                                                data-parent="#accordion" href="#collapse<?php echo $dept_id; ?>">
                                                <?php echo $dept; ?></a>
                                            </h5>
                                        </div>
                                        <div id="collapse<?php echo $dept_id; ?>"
                                         class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <?php
                          $dept3=  mysqli_query($con, "SELECT * 
                                                  FROM designations WHERE department_id='$dept_id'");
            if (mysqli_num_rows($dept3)>0) {
                ?>
                                                      <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>La désignation</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                   while ($row2=  mysqli_fetch_array($dept3)) {
                                       $design_id=$row2['designation_id'];
                                       $design=$row2['designation'];
                                       $status2=$row2['status'];
                                       ?>
                                    <tr>
                                        <td><?php echo $design_id; ?></td>
                                        <td><?php echo $design; ?></td>
                                       
                                    </tr>
                                  
								
                                
                                    <?php }?>
                                </tbody>
                            </table>  
                                <?php } else {?>    
                                <div class="text-danger text-center">Aucune désignation ajoutée pour le moment</div>
                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                     <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Ajouter une nouvelle désignation<small>
                                 tous les champs marqués(*) ne doivent pas restés vides</small></h5>                           
                        </div>
                        <div class="ibox-content">
                             <?php
if (isset($_POST['department2'],$_POST['designation'])) {
    $dept2=mysqli_real_escape_string($con, trim($_POST['department2']));
    $designation=mysqli_real_escape_string($con, trim($_POST['designation']));
    if ((empty($dept2)||(empty($designation)))) {
        echo '<div class="alert alert-danger">Enter All Fields To Continue</div>';
    } else {
        mysqli_query($con, "INSERT INTO designations(department_id,designation,status) VALUES('$dept2','$designation','1')");
        ?>
<div class="alert alert-success"><i class="fa fa-check"></i>Désignation ajoutée avec succès</div>
    <?php

    }
}
        ?>
                        
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Désignation</label>

                                    <div class="col-sm-10"><input type="text" name='designation'
                                     class="form-control" placeholder="Désignation" required="required">
                                                                            </div>
                                </div>
                                                             <div class="hr-line-dashed"></div>
                               <div class="form-group"><label class="col-sm-2 control-label">Désignation</label>

                                    <div class="col-sm-10">
                                        <select name="department2" class="form-control">
                                            <option value="" selected="selected">sélectionner le département....</option>
                                               <?php
                                            $depts=  mysqli_query($con, "SELECT * FROM departments");
        while ($row = mysqli_fetch_array($depts)) {
            $dept_id=$row['department_id'];
            $dept=$row['department'];
            $status=$row['status'];
            ?>
                                            <option value="<?php echo $dept_id;?>"><?php echo $dept;?></option>
                                    <?php } ?>
                                        </select>
                                                                            </div>
                                </div>
                                                             <div class="hr-line-dashed"></div>
                            
                                                                                                  
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">                                   
                                        <button class="btn btn-primary" type="submit">Ajouter une désignation</button>
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

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
                    <h2>Employés de l'hôtel</h2>
                    <ol class="breadcrumb">
                         <li>              <a href="index"><i class="fa fa-home"></i> Accueil</a>                    </li>
                       
                       
                        <li class="active">
                            <strong>Afficher les employés</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-4">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-group fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> Tous les Employés</span>
                            <?php
                             $employees=  mysqli_query($con, "SELECT * FROM employees WHERE status='1'");
        ?>
                            <h2 class="font-bold"><?php echo mysqli_num_rows($employees); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Tous les Employés<small>trier, chercher</small></h5>
                       
                    </div>
                    <div class="ibox-content">
<?php

                    if (mysqli_num_rows($employees)>0) {
                        ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                   <thead>
                                        <tr>
                                              <th>Image</th>
                                            <th>Noms complets</th>
                                            <th>La désignation</th>
                                            <th>département</th>
                                            <th>Genre</th>
                                              <th>Action</th>
                                        </tr>
                                    </thead>
                    <tbody>
              <?php

                                                               while ($row = mysqli_fetch_array($employees)) {
                                                                   $employee_id=$row['employee_id'];
                                                                   $fullname=$row['fullname'];
                                                                   $gender=$row['gender'];
                                                                   $design_id=$row['designation'];
                                                                   $status=$row['status'];
                                                                   $ext=$row['ext'];
                                                                   $dept2=  mysqli_query($con, "SELECT * FROM designations WHERE designation_id='$design_id'");
                                                                   $row2=  mysqli_fetch_array($dept2);
                                                                   $dept_id=$row2['department_id'];
                                                                   $design=$row2['designation'];
                                                                   $dept=  mysqli_query($con, "SELECT * FROM departments WHERE department_id='$dept_id'");
                                                                   $row2 = mysqli_fetch_array($dept);
                                                                   $dept_name=$row2['department'];
                                                                   ?>
               
                     <tr class="gradeA">
                                                               <td>
                                                <img src="img/employees/thumbs/<?php echo md5($employee_id).'.'.$ext; ?>" width="80">
                                                       </td>
                                            <td><?php echo $fullname; ?></td>
                                            <td><?php echo $design; ?></td>
                                            <td><?php echo $dept_name; ?></td>
                                            <td><?php echo $gender; ?></td>
											
                                                                                        <td><a href="employee?id=<?php echo $employee_id; ?>"
                                                                                         class="btn btn-success btn-xs">Détails</a>
                                             <a href="editemployee?id=<?php echo $employee_id; ?>" class="btn btn-primary btn-xs">Editer</a>
                                             <a href="hideemployee?id=<?php echo $employee_id; ?>" class="btn btn-danger btn-xs" 
                                             onclick="return confirm_delete<?php echo $employee_id;?>()">Supprimer</a>
                                                 <script type="text/javascript">
function confirm_delete<?php echo $employee_id; ?>() {
  return confirm('You are about To Remove this Employee. Are you sure you want to proceed?');
}
</script>                 
                                            </td>
                                        </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }?>
                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>


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
                <div class="col-lg-12">
                    <h2>Tables de Réstaurant</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Accueil</a>                    </li>
                       
                         <li>
                             <a href="foodmenu">Menu</a>
                        </li>
                        <li class="active">
                            <strong>Voir les Tables du Réstaurant</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                 <div class="col-lg-5">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Ajouter une Nouvelle Table<small>trier, rechercher</small></h5>
                       
                    </div>
                    <div class="ibox-content">
                                                              <?php
       if (isset($_POST['table'])) {
           $table=  mysqli_real_escape_string($con, trim($_POST['table']));
           if (empty($table)) {
               $errors[]='Table Name is required';
           }
           $check=mysqli_query($con, "SELECT * FROM
                                    hoteltables WHERE table_no='$table' AND area='rest' AND status='1'");
           if (mysqli_num_rows($check)>0) {
               $errors[]='Nom de table déjà ajouté';
           }
           if (!empty($errors)) {
               foreach ($errors as $error) {
                   echo '<div class="alert alert-danger">'.$error.'</div>';
               }
           } else {
               mysqli_query($con, "INSERT INTO hoteltables(table_no,creator,area,status)
              VALUES('$table','".$_SESSION['emp_id']."','rest','1')") or die(mysqli_error($con));

               echo '<div class="alert alert-success"><i class="fa fa-check"></i>Table successfully added</div>';
           }
       }
        ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Numéro de Table)</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name='table' 
                                    placeholder="Numéro de Table" required='required'></div>
                                </div>
                                                          <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                       <button class="btn btn-primary btn-sm" name="submit" type="submit">Ajouter la Table</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                    </div>
                    </div>
                <div class="col-lg-7">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Toutes les Tables<small> trier, rechercher</small></h5>                       
                    </div>
                    <div class="ibox-content">
<?php
              $tables=mysqli_query($con, "SELECT * FROM hoteltables WHERE area='rest' AND status='1'");
        if (mysqli_num_rows($tables)>0) {
            ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                         
                        <th>ID</th>
                         <th>Nom de Table</th>
                          <th>Ajouté Par</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
                          while ($row=  mysqli_fetch_array($tables)) {
                              $hoteltable_id=$row['hoteltable_id'];
                              $table_no=$row['table_no'];
                              $area=$row['area'];
                              $status=$row['status'];
                              $creator=$row['creator'];

                              ?>
               
                    <tr class="gradeA">
                      <td><?php echo $hoteltable_id; ?></td>
                         <td class="center">
                                        <?php  echo $table_no; ?>
                        </td>
                      
                     <td> <div class="tooltip-demo">
                               
                                <a href="employee?id=<?php echo $creator; ?>"
                                 data-original-title="View admin profile"  
                                 data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php
                                                        $employee=  mysqli_query($con, "SELECT * FROM 
                                        employees WHERE employee_id='$creator'");
                              $row = mysqli_fetch_array($employee);
                              $employee_id=$row['employee_id'];
                              $fullname=$row['fullname'];
                              echo $fullname; ?></a> </div> </td>
                                        
                                               
  <td class="center">                                  
                     <a href="hidetable.php?id=<?php echo $hoteltable_id; ?>"  
                     class="btn btn-danger  btn-xs" onclick="return confirm_delete<?php
                     echo $hoteltable_id;?>()">Supprimer <i class="fa fa-arrow-down"></i></a>
                                    <script type="text/javascript">
                function confirm_delete<?php echo $hoteltable_id; ?>() {
                return confirm('You are about To Remove this table. Are you sure you want to proceed?');
                }
            </script>                                             
            </td>
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php } else {?>
                        <div class="alert alert-danger">Aucune table ajoutée pour le moment</div>
 <?php }?>
                    </div>
                </div>
            </div>
            </div>          
        </div>
        </div>
    </div>

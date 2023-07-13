
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
                    <h2>Listes en attente</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                       
                         <li>
                            <a>Inventaire</a>
                        </li>
                        <li class="active">
                            <strong>Afficher les listes</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-10">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Toutes les listes<small>trier, chercher</small></h5>
                                         </div>
                    <div class="ibox-content">
<?php
$list=mysqli_query($con, "SELECT * FROM purchaselists WHERE status=0");
        if (mysqli_num_rows($list)>0) {
            ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>  
                         <th>Identifiant de la liste</th>
                        <th>Créé sur</th>
                        <th>Créé par</th>
                          <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
                          while ($row=  mysqli_fetch_array($list)) {
                              $purchaselist_id=$row['purchaselist_id'];
                              $creator=$row['creator'];
                              $timestamp=$row['timestamp'];

                              ?>
               
                    <tr class="gradeA">
                         <td><?php echo $purchaselist_id; ?></td>
                         <td><?php echo date('d/m/Y', $timestamp); ?></td>
                        <td>  <a href="employee?id=<?php echo $creator; ?>"
                         data-original-title="View admin profile"  data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php
                                                       $employee=  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                              $row = mysqli_fetch_array($employee);
                              $employee_id=$row['employee_id'];
                              $fullname=$row['fullname'];
                              echo $fullname; ?></a> </td>
                                                              <td>
      <a href="purchaselist?id=<?php echo $purchaselist_id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>Détails</a>                                                 
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

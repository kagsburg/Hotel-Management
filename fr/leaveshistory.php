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
                    <h2>Historique des feuilles</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                       
                      
                        <li class="active">
                            <strong>Voir les congés</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Historique des feuilles<small>Trier,  chercher</small></h5>
                                          </div>
                    <div class="ibox-content">
<?php
$leaves=mysqli_query($con, "SELECT * FROM leaves  WHERE status='1'  AND returndate!='' ORDER BY startdate");
        ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                          <th> Numéro Employée</th>
                          <th>Employée</th>
                        <th>Designation</th>
                          <th>Date de Demande</th>
                        <th>Date de début de Congé</th>
                        <th>date de la fin/date du retour</th>
                         <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
            while ($row=  mysqli_fetch_array($leaves)) {
                $leave_id=$row['leave_id'];
                $startdate=$row['startdate'];
                $enddate=$row['enddate'];
                $returndate=$row['returndate'];
                $employee_id=$row['employee_id'];
                $creator=$row['creator'];
                $timestamp=$row['timestamp'];
                $employee=  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$employee_id'");
                $row1 = mysqli_fetch_array($employee);
                $fullname=$row1['fullname'];
                $design_id=$row1['designation'];
                $employeenumber=$row1['employeenumber'];
                $dept2=  mysqli_query($con, "SELECT * FROM designations WHERE designation_id='$design_id'");
                $row2=  mysqli_fetch_array($dept2);
                $dept_id=$row2['department_id'];
                $design=$row2['designation'];
                $dept_id=$row2['department_id'];
                $dept=  mysqli_query($con, "SELECT * FROM departments WHERE department_id='$dept_id'");
                $row2 = mysqli_fetch_array($dept);
                $dept_name=$row2['department'];
                ?>
            <tr class="gradeA">
                    <td><?php echo $employeenumber; ?></td>
                    <td><?php echo $fullname; ?></td>
                        <td><?php echo $design.'('.$dept_name.')'; ?></td>
                          <td><?php echo date('d/m/Y', $timestamp); ?></td>
                          <td><?php echo date('d/m/Y', $startdate); ?></td>
                          <td><?php echo date('d/m/Y', $returndate); ?></td>
                   <td>
            <a href="removeleave?id=<?php echo $leave_id;?>" class="btn btn-xs btn-danger" 
            onclick="return cdelete<?php echo $leave_id;?>()">Supprimer</a>
                          <script type="text/javascript">
                                            
                         function cdelete<?php echo $leave_id; ?>() {
  return confirm('You are about To Approve this leave. Do you want to proceed?');
}
</script>                 
                     </td>
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>

                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>
</div>
   

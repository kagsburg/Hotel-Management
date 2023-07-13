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
                    <h2>Les dépenses d'hôtel</h2>
                    <ol class="breadcrumb">
                        <li>  <a href="index.php"><i class="fa fa-home"></i> Accueil</a></li>
                        <li>
                            <a href="costs">Dépenses</a>
                        </li>
                        <li class="active">
                            <strong>Les dépenses d'hôtel</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
   <div class="col-lg-4">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-home fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Dépenses engagées aujourd'hui</span>
                            <h2 class="font-bold">
                              <?php
                         $today=mysqli_query($con, "SELECT COALESCE(SUM(amount), 0) AS todaycosts FROM costs WHERE round(($timenow-date)/(3600*24))+1=1");
       $row=  mysqli_fetch_array($today);
       $today=$row['todaycosts'];
       echo $today;
       ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                             <div class="col-lg-4">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-home fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Dépenses engagées au cours des 7 derniers jours</span>
                            <h2 class="font-bold">
                              <?php
                           $week=mysqli_query($con, "SELECT COALESCE(SUM(amount),0) 
                           AS weekcosts FROM costs WHERE round(($timenow-date)/(3600*24))<=7");
       $row=  mysqli_fetch_array($week);
       $week=$row['weekcosts'];
       echo $week;
       ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                             <div class="col-lg-4">
                <div class="widget style1 red-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-home fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Dépenses engagées au cours des 30 derniers jours</span>
                            <h2 class="font-bold">
                              <?php
       $month=mysqli_query($con, "SELECT COALESCE(SUM(amount),0) AS
                             monthcosts FROM costs WHERE round(($timenow-date)/(3600*24))<=30");
       $row=  mysqli_fetch_array($month);
       $month=$row['monthcosts'];
       echo $month;
       ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                           <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">                            
                            <h5>Les dépenses d'hôtel</h5>
                            <a href="costsprint" target="_blank" class="btn btn-sm btn-warning pull-right">
                                <i class="fa fa-print"></i> Imprimer en PDF</a>
                        </div>
                        <div class="ibox-content">
                            <?php
       $costs= mysqli_query($con, "SELECT * FROM costs WHERE status='1'") or die(mysqli_errno($con));
       if (mysqli_num_rows($costs)>0) {
           ?>
                             <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                     
                    <tr>
                        <th>Article</th>
                        <th>prix</th>
                        <th>Date</th>
                        <th>Ajouté par</th>
                        <th>Action</th>
                    </tr>
                                                 
                    </thead>
                    <tbody>
                     <?php
                while ($row = mysqli_fetch_array($costs)) {
                    $cost_id=$row['cost_id'];
                    $cost_item=$row['cost_item'];
                    $amount=$row['amount'];
                    $date=$row['date'];
                    $creator=$row['creator'];

                    ?>
                    <tr class="gradeA">
                        <td><?php echo $cost_item; ?></td>
                        <td><?php echo $amount;?> </td>
                        <td><?php echo date('d/m/Y', $date);?> </td>
                        <td> <div class="tooltip-demo">
                             <?php
                                    $employee=  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                    $row = mysqli_fetch_array($employee);
                    $employee_id=$row['employee_id'];
                    $fullname=$row['fullname'];
                    echo $fullname; ?> </div> </td>
                        <td>
                            <a href="editcost?id=<?php echo $cost_id; ?>" class="btn btn-xs btn-info">
                            <i class="fa fa-edit"></i> Editer</a> 
                           <a href="hidecost?id=<?php echo $cost_id;?>" 
                           class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $cost_id; ?>()">
                           <i class="fa fa-delete"></i> Masquer l'élément</a>
                            <script type="text/javascript">
                        function confirm_delete<?php echo $cost_id; ?>() {
                        return confirm('You are about To Remove this Item. Are you sure you want to proceed?');
                        }
                        </script>                 
                        </td>
                       
                    </tr>   <?php } ?>
                    </tbody>
                             </table>
                            <?php } else { ?>
                            <div class="alert alert-danger">Aucune dépense encourue pour le moment</div>
                            <?php }?>
                        </div>
                    </div>
                    </div>
    </div>

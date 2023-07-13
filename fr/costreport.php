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
                    <h2>Note de frais entre <?php echo date('d/m/Y', $start); ?> et <?php echo date('d/m/Y', $end); ?></h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>                         <a href="getincomereport">Générer un rapport de dépenses</a>                       </li>
                                          <li class="active">
                            <strong>
Rapport de dépenses</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-10">
                        <a href="costreportprint?start=<?php echo $st;?>&&end=<?php echo $en; ?>" 
                         target="_blank" class="btn btn-success ">Imprimer en PDF</a><br/><br/>
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Rapport de dépenses généré</h5>
                           
                        </div>
                        <div class="ibox-content">
                             <?php
  if ($start>$end) {
      $errors[]='Start Date Cant be later than End Date';
  }
if (!empty($errors)) {
    foreach ($errors as $error) {
        ?>
 <div class="alert alert-danger"><?php echo $error; ?></div>
<?php
    }
} else {  ?>
                                     <h2 class="text-center">FRAIS D'HÔTEL</h2>
    <div class="table-responsive m-t">
        <?php
                       $totalcosts=0;
    $costs= mysqli_query($con, "SELECT * FROM 
                            costs WHERE status='1' AND date>='$start' AND date<='$end'") or die(mysqli_errno($con));
    if (mysqli_num_rows($costs)>0) {
        ?>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                           <th>Date</th>
                                           <th>Dépenses</th>
                                        
                                        <th>Prix</th>
                                    
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
                    $totalcosts=$amount+$totalcosts;
                    ?>
                                    <tr>
                          <td>  <?php echo date('d/m/Y', $date); ?>             
                                            </td>
                                        <td>
                                                   <?php echo $cost_item; ?>
                                                
                                            </td>
                                                                                                                                                          
                                        <td><?php echo number_format($amount);?></td>
                                    </tr>
                <?php } ?>

                                    </tbody>
                                </table>
                            <?php } ?>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>
                                                               <tr>
                                    <td><strong>TOTALE :</strong></td>
                                    <td><strong><?php echo number_format($totalcosts);?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                         
    <?php
}

        ?>
                        
  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </div>

   
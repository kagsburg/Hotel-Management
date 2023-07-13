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
                    <h2><?php echo $item; ?> Stock </h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>                         <a>Stock</a>                       </li>
                        <li class="active">
                            <strong><?php echo $item; ?> Stock</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-lg-5">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-home fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span> Disponible en stock</span>
                            <h2 class="font-bold"><?php echo $addedstock-$issuedstock.' '.$measurement;?></h2>                            
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
                                           <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Articles ajoutés</h5>                           
                        </div>
                        
                        <div class="ibox-content">
<?php
$stockevents=mysqli_query($con, "SELECT * FROM stockevents WHERE item_id='$id'");
        if (mysqli_num_rows($stockevents)>0) {
            ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                    <th>Date</th>
                         <th>Activité</th>                   
                    </tr>
                    </thead>
                    <tbody>
              <?php
                          while ($row=  mysqli_fetch_array($stockevents)) {
                              $stockevent_id=$row['stockevent_id'];
                              $activity=$row['activity'];
                              $timestamp=$row['timestamp'];
                              ?>
               
                    <tr class="gradeA">
              <td><?php echo date('d/m/Y', $timestamp); ?></td>                        
                 <td><?php echo $activity; ?></td>                      
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php } ?>          
                           </div>
                                    </div>
            </div>           
 
        </div>
        </div>


    </div>

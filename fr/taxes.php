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
                    <h2>Taxes</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                                               <li class="active">
                            <strong>Taxes</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
   <?php
                                            if (($_SESSION['hotelsyslevel']==1)) {
                                                ?>
                <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Ajouter Taxe <small>Tapez Assurez-vous de remplir tous les champs nécessaires</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                                   if (isset($_POST['tax'],$_POST['rate'])) {
                                       $tax=  mysqli_real_escape_string($con, trim($_POST['tax']));
                                       $rate=  mysqli_real_escape_string($con, trim($_POST['rate']));
                                       if ((empty($tax)||(empty($rate)))) {
                                           $errors[]='Enter All Fields To Proceed';
                                       }
                                       if (is_numeric($rate)==false) {
                                           $errors[]='Room Charge should be An Integer';
                                       }
                                       if (!empty($errors)) {
                                           foreach ($errors as $error) {
                                               echo '<div class="alert alert-danger">'.$error.'</div>';
                                           }
                                       } else {
                                           mysqli_query($con, "INSERT INTO taxes(tax,rate,status) VALUES('$tax','$rate','1')") or die(mysqli_error($con));

                                           echo '<div class="alert alert-success"><i class="fa fa-check"></i>Tax successfully added</div>';
                                       }
                                   }



                                                ?>
  <form method="post" class="form" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">Nom de la Taxe</label>
<input type="text" class="form-control" name='tax' placeholder="Enter Tax Name" required='required'>
                                </div>                               
        <div class="form-group"><label class="control-label">Évaluer (%)</label>
<input type="text" class="form-control" name='rate' placeholder="Enter Tax Rate" required='required'></div>
                               
                               <div class="form-group">
                         <button class="btn btn-primary" name="submit" type="submit">Soummettre</button>
                               
                                </div>
                            </form>
                                                 

                    </div>

                  
                </div>
             
                    </div>
                           <?php } ?>
                           <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Les taux d'imposition</h5>
                        
                        </div>
                        <div class="ibox-content">
                             <table class="table table-striped  table-hover">
                    <thead>
                    <tr>
                      <th>Nom de la Taxe</th>
                        <th>Évaluer (%)</th>
                     <th>&nbsp;</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                        <tr>     <?php
                                                 $taxes=mysqli_query($con, "SELECT * FROM taxes WHERE status=1");
       if (mysqli_num_rows($taxes)>0) {
           while ($row = mysqli_fetch_array($taxes)) {
               $tax_id=$row['tax_id'];
               $tax=$row['tax'];
               $rate=$row['rate'];
               ?>
                       <tr>
                                   <td><?php echo $tax; ?></td>
                                   <td><?php echo $rate; ?></td>
                                           <td>
                                        <?php
                if (($_SESSION['hotelsyslevel']==1)) {
                    ?>
                                               <a data-toggle="modal"
                                                class="btn btn-info btn-xs" href="#modal-form<?php echo $tax_id; ?>">
                                                <i class="fa fa-edit"></i> Editer</a>
                                  
                                    <a href="hidetax?id=<?php echo $tax_id;?>" c
                                    lass="btn btn-xs btn-danger" 
                                    onclick="return confirm_delete<?php echo $tax_id;?>()"><i class="fa fa-arrow-down">

                                    </i>Supprimer</a>
              <script type="text/javascript">
function confirm_delete<?php echo $tax_id; ?>() {
  return confirm('You are about To Perform  this Action. Are you sure you want to proceed?');
}
</script>                                       
      <?php }?>
                                    </td>
                       </tr>
                    
                                    <?php
           }
       } else {
           echo "<div class='alert alert-danger'>Pas encore de taxes ajoutées</div>";
       }
       ?>
                    
                    </tbody>
                             </table>
                        </div>
                    </div>
                    </div>
 </div>
 </div>
 </div>
 </div>
 
             <?php
       $taxes=mysqli_query($con, "SELECT * FROM taxes WHERE status=1");
       while ($row = mysqli_fetch_array($taxes)) {
           $tax_id=$row['tax_id'];
           $tax=$row['tax'];
           $rate=$row['rate'];
           ?>
   <div id="modal-form<?php echo $tax_id; ?>" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form method="post" class="form" action='edittax?id=<?php echo $tax_id; ?>'  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">Nom de la Taxe</label>
                                    <input type="text" class="form-control" name='tax' placeholder="Nom de la Taxe" 
                                    required='required' value="<?php echo $tax; ?>">
                                </div>                               
        <div class="form-group"><label class="control-label">Évaluer (%)</label>
            <input type="text" class="form-control" name='rate' placeholder="Enter Tax Rate" 
            required='required' value="<?php echo $rate; ?>"></div>
                               
                               <div class="form-group">
                         <button class="btn btn-primary" name="submit" type="submit">Soummettre</button>
                               
                                </div>
                            </form>
                                                </div>
                                                </div>
                                                </div>
                                                </div>
                                <?php }?>
    
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
                    <h2>Ajouter Article dans le Stock</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>
                            <a href="stockitems">Stock</a>
                        </li>
                        <li class="active">
                            <strong>Ajouter Article dans le Stock</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">

                <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Ajouter Article dans le Stock<small>
                                 Tapez Assurez-vous de remplir tous les champs nécessaires</small></h5>
                                                </div>
                        <div class="ibox-content">
                                               <?php
                                 if (isset($_POST['item'],$_POST['measurement'])) {
                                     if ((empty($_POST['measurement']))||(empty($_POST['item']))||(empty($_POST['category']))) {
                                         echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Fill The Fields To Proceed</div>';
                                     } else {
                                         $measurement= $_POST['measurement'];
                                         $item=  mysqli_real_escape_string($con, trim($_POST['item']));
                                         $minstock=  mysqli_real_escape_string($con, trim($_POST['minstock']));
                                         $category=  mysqli_real_escape_string($con, trim($_POST['category']));
                                         mysqli_query($con, "INSERT INTO stock_items(stock_item,category_id,minstock,measurement,status) VALUES('$item','$category','$minstock','$measurement','1')") or die(mysqli_errno($con));
                                         echo '<div class="alert alert-success"><i class="fa fa-check"></i>Stock Item successfully added</div>';
                                     }
                                 }
       ?>
  <form method="post" class="form" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">nom de l’élément</label>
<input type="text" class="form-control" name='item' placeholder="entrer le nom de l’élément" required='required'></div>

             <div class="form-group">
            <label class="control-label">Unité de mesure</label>

                        <select class="form-control" name='measurement'>
                            <option value="" selected="selected">Sélectionnez la mesure...</option>
                               <?php
            $measurements=  mysqli_query($con, "SELECT * FROM stockmeasurements");
       while ($row = mysqli_fetch_array($measurements)) {
           $measure_id=$row['measurement_id'];
           $measure=$row['measurement'];
           ?>
                            <option value="<?php echo $measure_id; ?>"><?php echo $measure; ?></option>
                           <?php } ?>
                </select>
                    </div>
               <div class="form-group">
            <label class="control-label">Catégorie</label>

                        <select class="form-control" name='category'>
                            <option value="" selected="selected">Séléctioner la Categorie...</option>
                               <?php
                 $getcats=  mysqli_query($con, "SELECT * FROM categories WHERE status=1");
       while ($row1=  mysqli_fetch_array($getcats)) {
           $category_id=$row1['category_id'];
           $category=$row1['category'];
           ?>
                            <option value="<?php echo $category_id; ?>"><?php echo $category; ?></option>
                           <?php } ?>
                </select>
                    </div>
               <div class="form-group"><label class="control-label">Stock minimum</label>
<input type="text" class="form-control" name='minstock' placeholder="Enter minimum"></div>                
      <div class="form-group">
                 <button class="btn btn-primary" name="submit" type="submit">Ajouter un Article</button>
                </div>
                            </form>                                                

                    </div>                  
                </div>             
                    </div>                     
    </div>

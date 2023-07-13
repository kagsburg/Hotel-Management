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
                    <h2>Menu de l'hôtel</h2>
                    <ol class="breadcrumb">
                        <li> <a href="index"><i class="fa fa-home"></i> Accueil</a>   </li>                       
                         <li>
                            <a>Menu</a>
                        </li>
                        <li class="active">
                            <strong>Voir le Menu</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                 <div class="col-lg-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Ajouter éléments au Menu <small>trier , rechercher</small></h5>                       
                    </div>
                    <div class="ibox-content">
                                                              <?php
//                            include_once 'includes/thumbs3.php';
                            if (isset($_POST['item'],$_POST['price'])) {
                                $item=  mysqli_real_escape_string($con, trim($_POST['item']));
                                $price=  mysqli_real_escape_string($con, trim($_POST['price']));

                                if ((empty($_POST['item']))||(empty($_POST['price']))) {
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Enter all fields  To Proceed</div>';
                                } elseif (is_numeric($price)==false) {
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Price Should Be An Integer</div>';
                                } else {
                                    mysqli_query($con, "INSERT INTO menuitems(menuitem,itemprice,type,creator,status) VALUES('$item','$price','rest','".$_SESSION['emp_id']."','1')") or die(mysqli_error($con));
                                    echo '<div class="alert alert-success"><i class="fa fa-check"></i>Menu Item successfully added</div>';
                                }
                            }
        ?>
                                <form method="post" class="form" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">Article</label>
                                <input type="text" class="form-control" name='item' placeholder="Article" required='required'></div>                            
                                <div class="form-group"><label class="control-label">Prix</label>
                                <input name="price" class="form-control" placeholder="Prix" type="text">
                                </div>
                                <div class="form-group">
                                <button class="btn btn-primary btn-sm" name="submit" type="submit">Ajouter un item</button>
                               </div>
                            </form>
                    </div>
                    </div>
                    </div>
                <div class="col-lg-8">
                       <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Tous les éléments du menu principal<small>trier , rechercher</small></h5>
                       
                    </div>
                    <div class="ibox-content">
                    <?php
                    $menu=mysqli_query($con, "SELECT * FROM menuitems WHERE status=1 ORDER BY menuitem");
        if (mysqli_num_rows($menu)>0) {
            ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                         <th> Menu</th>
                        <th>Prix</th>                      
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
               while ($row=  mysqli_fetch_array($menu)) {
                   $menuitem_id=$row['menuitem_id'];
                   $menuitem=$row['menuitem'];
                   $itemprice=$row['itemprice'];
                   $status=$row['status'];
                   $creator=$row['creator'];

                   ?>
               
                    <tr class="gradeA">
                      <td><?php echo $menuitem; ?></td>
                         <td class="center">
                                        <?php  echo $itemprice; ?>
                        </td>
                     
  <td class="center"> 
         <?php
         if (($creator==$_SESSION['hotelsys'])||($_SESSION['hotelsyslevel']==1)) {
             ?>
                                         <a href="hideitem.php?id=<?php echo $menuitem_id.'&&status='.$status; ?>"  
                                         class="btn btn-danger  btn-xs"  onclick="return confirm_delete<?php echo
                  $menuitem_id; ?>()">Supprimer <i class="fa fa-arrow-up"></i></a>
                         
                     
                                 <?php
         }
                   ?>
                             <a href="editmenuitem?id=<?php echo $menuitem_id; ?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Editer</a>      
                             <script type="text/javascript">
function confirm_delete<?php echo $menuitem_id; ?>() {
  return confirm('You are about To Remove this Item. Are you sure you want to proceed?');
}
</script>    
  </td>
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php } else {?>
                        <div class="alert alert-danger">No Menu Items Added Yet</div>
 <?php }?>
                    </div>
                </div>
               
            </div>
            </div>
          
        </div>
        </div>


    </div>

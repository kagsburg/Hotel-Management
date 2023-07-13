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
                    <h2>Détails de la liste</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>                         <a href="approvedlists">Liste</a>                       </li>
                        <li class="active">
                            <strong>Détails de la liste</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-4">
                                          
                      <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Détails de la liste</h5>
                           
                        </div>
                        <div class="ibox-content">
                 <div class="feed-activity-list">
<?php
$list=mysqli_query($con, "SELECT * FROM purchaselists WHERE purchaselist_id='$id'");
        $row= mysqli_fetch_array($list);
        $purchaselist_id=$row['purchaselist_id'];
        $creator=$row['creator'];
        $status=$row['status'];
        $timestamp=$row['timestamp'];
        ?>
                                                                       
                       <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Identifiant de la liste</strong> : <?php echo $purchaselist_id; ?> <br>
                                             </div>
                                    </div>
                       <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Créé sur</strong> : <?php echo date('d/m/Y', $timestamp); ?><br>
                                             </div>
                                    </div>
                       <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Ajouté par</strong> :       <?php
                                                $employee=  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
        $row = mysqli_fetch_array($employee);
        $employee_id=$row['employee_id'];
        $fullname=$row['fullname'];
        echo $fullname; ?><br>
                                             </div>
                                    </div>
                       <div class="feed-element">
                                                                              <div class="media-body ">
                                                                                  <strong>Status</strong> : <?php if ($status==1) {
                                                                                      echo 'Approved';
                                                                                  } else {
                                                                                      echo 'Pending';
                                                                                  } ?><br>
                                             </div>
                                    </div>
                                    </div>
                             </div>
                      </div> 
                    <?php if (($status==0)&&($_SESSION['hotelsyslevel']==1)) { ?>
                     <a href="approvelist?id=<?php echo $id; ?>" class="btn btn-primary" 
                     onclick="return confirm_approve()"><i class="fa fa-thumbs-up"></i>Approuver la liste</a>
                     <script type="text/javascript">
                    function confirm_approve() {
                    return confirm('You are about To Approve this list. Are you sure you want to proceed?');
                    }
                    </script>                 
                                        <?php }?>
                                  </div>                                   
                                                    <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Éléments de la liste</h5>                          
                        </div>
                        <div class="ibox-content ">
                  

                            <div class="table-responsive m-t">
                                 <form action="addtostock" method="post"> 
                                    <?php
                                                                                                                       if ($status==1) {
                                                                                                                           $getitems=  mysqli_query($con, "SELECT * FROM purchaseditems 
                                    WHERE purchaselist_id='$id' AND status=0");
                                                                                                                           if (mysqli_num_rows($getitems)>0) {
                                                                                                                               ?>
                                 <button type="submit" class="btn btn-success btn-sm pull-right " 
                                 id="hid" name="submit" disabled><i class="fa fa-plus"></i> Ajouter au stock</button>
                                     <?php }
                                                                                                                           } ?>
                          <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Article</th>
                                        <th>Quantité</th>
                                       <th>Prix ​​unitaire</th>
                                       <th>Total</th>                                      
                                       <th>Action</th>
                                      
                                   
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $total=0;
        $getitems=  mysqli_query($con, "SELECT * FROM purchaseditems WHERE purchaselist_id='$id'");
        while ($product= mysqli_fetch_array($getitems)) {
            //set variables to use them in HTML content below
            $purchaseitem_id = $product["purchaseditem_id"];
            $price = $product["price"];
            $item_id = $product["item_id"];
            $quantity = $product["quantity"];
            $status2 = $product["status"];

            $subtotal = ($price * $quantity);
            $total = ($total + $subtotal);
            $stock=mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$item_id'");
            $row2=  mysqli_fetch_array($stock);
            $stockitem1=$row2['stock_item'];
            ?>
                                    <tr>
                                        <td><div><strong>
                                                   <?php echo $stockitem1; ?>
                                                </strong></div>
                                            </td>
                                        <td> <?php echo $quantity; ?></td>
                                        <td> <?php echo number_format($price); ?></td>
                                                      <td><?php echo number_format($subtotal); ?></td>
                                                      
                                                      <td> 
                                                            <?php if (($status==0)&&($_SESSION['hotelsyslevel']==1)) { ?>
                                                          <a data-toggle="modal" class="btn btn-success btn-xs"
                                                           href="#modal-form<?php echo $purchaseitem_id?>"><i class="fa fa-edit"></i>Modifier le prix</a>
                                                          
                                                             <?php }
                                                            if (($status==1)&&($status2==0)) {
                                                                ?>
                                                          <input type="checkbox"  name="checkbox[]" value="<?php echo $purchaseitem_id; ?>" class="form-control">
                                                             <?php } ?>
                                                      </td>
                                                 
                                                      <div id="modal-form<?php echo $purchaseitem_id?>" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12"><h3 class="m-t-none m-b">Modifier le prix unitaire pour <?php echo $stockitem1; ?></h3>
                                                    <form role="form" action="edititemprice.php?id=<?php echo $purchaseitem_id;?>"
                                                     method="POST" enctype="multipart/form-data">
                                                          <div class="form-group">
                                                              <input type="text"  name="unitprice"class="form-control"
                                                               required="required" value="<?php echo $price; ?>"></div>
                                                        <div>
                                                            <button class="btn btn-sm btn-primary pull-right m-t-n-xs" 
                                                            type="submit"><strong>Editer</strong></button>
                                                                                                                </div>
                                                    </form>
                                                </div>                                                
                                        </div>
                                    </div>
                                    </div>
                                </div>
                        </div>
                                                                                       </tr>
                                      <?php }?>

                                    </tbody>
                                </table>
                                 </form>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>
                                                                <tr>
                                                                
                                    <td><strong>TOTALE :</strong></td>
                                    <td><strong><?php echo number_format($total); ?></strong></td>
                                </tr>
                                </tbody>
                            </table>
			
                        </div>
                        
                        </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Mainly scripts -->

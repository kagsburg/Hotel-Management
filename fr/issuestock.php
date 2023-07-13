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
                    <h2>Issue Stock</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>  <a href="stockitems">Stock</a>                       </li>
                        <li class="active">
                            <strong>Issue Stock</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
       
                                <div class="row">
                                    
                                            <div class="col-lg-10">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Issue Stock <small>All  fields marked (*) shouldn't be left blank</small></h5>
                           
                        </div>
                        
                        <div class="ibox-content">
                             <?php
if(isset($_POST['submit'])){
     $date= mysqli_real_escape_string($con, strtotime($_POST['date']));
       if(empty($date)){
              echo '<div class="alert alert-danger">Date is required</div>';
      }  else {
             $item=$_POST['item'];
          $quantity=$_POST['quantity'];
   mysqli_query($con,"INSERT INTO issuedstock(date,admin_id,status) VALUES('$date','".$_SESSION['hotelsys']."',1)") or die(mysqli_error($con));
   $last_id=mysqli_insert_id($con);
   $allproducts= sizeof($item);
   for($i=0;$i<$allproducts;$i++){
          $activity=$fullname.' issued '.$quantity[$i];     
   mysqli_query($con,"INSERT INTO issueditems(item_id,quantity,issuedstock_id,status) VALUES('$item[$i]','$quantity[$i]','$last_id',1)") or die(mysqli_error($con));
    mysqli_query($con,"INSERT INTO stockevents(item_id,activity,timestamp,status) VALUES('$item[$i]','$activity','$date','1')") or die(mysqli_error($con));
}   
?>
<div class="alert alert-success"><i class="fa fa-check"></i>Stock Successfully Added</div>
  <?php
  }        
}
?>
    <form method="post" name='form' class="form" action=""  enctype="multipart/form-data">
         <div class="row">
           <div class="form-group col-lg-6"><label class="control-label">* Date of Supply</label>
               <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d',$timenow); ?>">
             </div>
         </div>
                                     <div class='subobj'>
                          <div class='row'>
                                  <div class="form-group col-lg-6"><label class="control-label">* Product </label>
                                         <select data-placeholder="Choose item..." name="item[]" class="chosen-select" style="width:100%;" tabindex="2">
                                    <option value="" selected="selected">choose item..</option>
                                        <?php
               $stock=mysqli_query($con,"SELECT * FROM stock_items WHERE status=1");
               while($row=  mysqli_fetch_array($stock)){
  $stockitem_id=$row['stockitem_id'];
  $cat_id=$row['category_id'];
$stockitem=$row['stock_item'];
  $minstock=$row['minstock'];
  $measurement=$row['measurement'];
  $status=$row['status'];
       $getmeasure=  mysqli_query($con,"SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");  
                                             $row2=  mysqli_fetch_array($getmeasure);
                                              $measurement2=$row2['measurement'];
               ?>
                                    <option value="<?php echo $stockitem_id; ?>"><?php echo $stockitem.' ('.$measurement2.')'; ?></option>
               <?php }?>
                                         </select>
                                                                                                        </div>
                                  <div class="form-group col-lg-5"><label class="control-label">Quantity</label>
                                    <input type="text" name='quantity[]' class="form-control" placeholder="Enter Quantity">
                                                                                                        </div>
                        
                               <div class="form-group col-lg-1">
                                                         <a href='#' class="subobj_button btn btn-success" style="margin-top:25px">+</a>                                              
                                            </div> 
                             
                          
                                  </div>
                                                                                                        </div>    
                              <div class="form-group">
                                  <button class="btn btn-success" type="submit" name="submit">Add Stock</button>
                                       </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        </div>


    </div>


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
                    <h2>Add Number of Drink Items</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a>Bar</a>                       </li>
                        <li class="active">
                            <strong>Add Number of Drink Items</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Add number of Drink Items</h5>
                           
                        </div>
                        <div class="ibox-content">
                          
                         <?php
                                      $getdrinks=  mysqli_query($con,"SELECT * FROM barorder_drinks WHERE baround_id='$id'");
                                      while($row=  mysqli_fetch_array($getdrinks)){ 
                                          $barorder_id=$row['barorder_id'];
                                          $drink_id=$row['drink_id'];
                                          $drinkorder_id=$row['drinkorder_id'];
                                          $baround_id=$row['baround_id'];
                                          $getdrink=mysqli_query($con,"SELECT * FROM drinks WHERE drink_id='$drink_id'");
                                            $row2=  mysqli_fetch_array($getdrink);
                                                  $drink=$row2['drinkname'];
                                                  $quantity=$row2['quantity'];
                                          ?>
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                                                           <?php
                                        if(isset($_POST['quantity'.$drinkorder_id])){
                                          $quantity2=$_POST['quantity'.$drinkorder_id];
                                            mysqli_query($con,"UPDATE barorder_drinks SET items='$quantity2' WHERE drinkorder_id='$drinkorder_id'");
                                            mysqli_query($con,"UPDATE barorders SET status='1' WHERE barorder_id='$barorder_id'");
                                            echo '<div class="alert alert-success">Number of  '.$drink.' Successfully Added.Click <a href="barorder?id='.$baround_id.'">here</a> to view Order</div>';
                                            //header('Location:barinvoice?id='.$order_id);
                                        }                                              
                                      ?>
                                <div class="form-group"><label class="col-sm-3 control-label"><?php echo $drink.' ('.$quantity.')'; ?></label>

                                    <div class="col-sm-9"><input type="text" class="form-control" name='quantity<?php echo $drinkorder_id; ?>' placeholder="Enter number of Items" required='required'></div>
                                </div>
                                      <?php } ?>

                                                        <div class="hr-line-dashed"></div>
                            
                                                                                                  
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-primary" type="submit">Add Item Numbers</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </div>

<?php 
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login');
}
?>
<!DOCTYPE html>
<html>

<head>
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hotel Stock Items</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">             
<div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                      <div class="row">
                                <div class="col-xs-2"><img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive"></div>
                                <div class="col-xs-4">
                                </div>

                              
                                
                            </div>
                 <h1 class="text-center">All Menu Items</h1>
                            <div class="table-responsive m-t">
                            
                                <table class="table invoice-table">
                                   <thead>
                    <tr>
                        <th>Menu Item</th>
                        <th>Category</th>                      
                        <th>Type</th>                      
                        <th>Price</th>                      
                        <th>Taxed</th>         
                                          </tr>
                    </thead>
                    <tbody>
              <?php
        $menu=mysqli_query($con,"SELECT * FROM menuitems WHERE status=1 ORDER BY menuitem");
              while($row=  mysqli_fetch_array($menu)){
  $menuitem_id=$row['menuitem_id'];
$menuitem=$row['menuitem'];
  $itemprice=$row['itemprice'];
  $type=$row['type'];
  $taxed=$row['taxed'];
  $category=$row['category'];
  $menucategory=$row['menucategory'];
  $status=$row['status'];
  $creator=$row['creator'];
    
               ?>
               
                    <tr class="gradeA">
                    <td><?php echo $menuitem; ?></td>
                    <td><?php
                       $getcat=  mysqli_query($con,"SELECT * FROM menucategories WHERE status=1 AND category_id='$menucategory'");
                         if(mysqli_num_rows($getcat)>0){
                      $row1=  mysqli_fetch_array($getcat);
           $categoryname=$row1['category'];
                  echo $categoryname; }?></td>
                       <td><?php if($type=='drink'){echo $type.' ('.$category.')'; }else{ echo $type; } ?></td>
                         <td class="center">
                                        <?php  echo $itemprice; ?>
                        </td>
                        <td>     <?php  if($taxed=='yes'){echo $taxed;}else{echo 'no';} ?></td>
                    </tr>
                 <?php }?>
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                        
                            
                            <div class="well m-t">
                                <strong style="font-style: italic">@<?php echo date('Y',$timenow);?> All Rights Reserved To <?php echo $hotelname; ?><strong>
                            </div>
                        </div>

    </div>
<!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>

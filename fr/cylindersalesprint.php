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

    <title>Gas Cylinder Sales  | Grace Land Hotel</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
                <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-2"><img src="assets/demo/graceland-logo.png" class="img img-responsive"></div>
                                <div class="col-sm-4">
                                                                       <address>
                                                                           <h3></h3>
                                        <strong>Graceland Hotel</strong><br>
                                        Mbela Misugwi<br>
                                        Mwanza, Tanzania<br>
                                        <strong>P : </strong> 0769657573 , 0767747515<br/>
                                        www.gracelandhotel.com<br/>
                                            
                                    </address>
                                 
                                </div>

                              
                                
                            </div>
                 <h1 class="text-center">Gas Cylinder Sales</h1>
                            <div class="table-responsive m-t">
                            
                                <table class="table invoice-table">
                                    <thead>
                                     <tr>
                         <th>Cylinder</th>
                        <th>Price(shs)</th>
                                             <th>Date</th>
                        
                    </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                   $sales=mysqli_query($con,"SELECT * FROM cylindersales WHERE status='1'");
                  while($row=  mysqli_fetch_array($sales)){
  $cylindersale_id=$row['cylinder_id'];
  $cylinder_id=$row['cylinder_id'];
   $price=$row['price'];
   $timestamp=$row['timestamp'];
   $creator=$row['creator'];
   $gettype=  mysqli_query($con, "SELECT * FROM cylinders WHERE cylinder_id='$cylinder_id'");
   $row2=  mysqli_fetch_array($gettype);
$cylinder_type=$row2['cylinder_type'];                   
                                                    
                        ?>
                    <tr class="gradeA">
                        <td><?php echo $cylinder_type; ?></td>
                         <td class="center">
                                        <?php  echo $price; ?>
                        </td>
                                                   
  <td class="center"> 
           <?php  echo date('d/m/Y',$timestamp); ?>
                              
  </td>
                                           
                    </tr>   <?php } ?>

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                        
                            
                            <div class="well m-t">
                                <strong style="font-style: italic">@<?php echo date('Y',$timenow);?> All Rights Reserved To Hotel Graceland<strong>
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

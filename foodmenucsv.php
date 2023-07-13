<?php
include 'includes/conn.php';
 if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
      } else{         

   $delimiter = ",";

    $filename ="Menu Items as of  ".date('d/m/Y',$timenow).".csv";    

    $f = fopen('php://memory', 'w');                            
                 
      $fields = array('Menu Item','Category','Type','Price','Taxed');

       fputcsv($f, $fields, $delimiter);
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
   $categoryname='';
      $getcat=  mysqli_query($con,"SELECT * FROM menucategories WHERE status=1 AND category_id='$menucategory'");
           if(mysqli_num_rows($getcat)>0){     
      $row1=  mysqli_fetch_array($getcat);
           $categoryname=$row1['category'];   
           }
      if($type=='drink'){ $ty=$type.' ('.$category.')'; }else{ $ty=$type; } 
       if($taxed=='yes'){$tax=$taxed;}else{$tax='no';}
   $lineData = array($menuitem,$categoryname,$ty,$itemprice,$tax);
  fputcsv($f, $lineData, $delimiter);
 }  
     fputcsv($f, $lineData, $delimiter);           

                     fseek($f, 0);    

    header('Content-Type: text/xls');

    header('Content-Disposition: attachment; filename="' . $filename . '";');

        fpassthru($f);
   }
?>
<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login');
} else {

   $delimiter = ",";

   $filename = "Menu.csv";

   $f = fopen('php://memory', 'w');

   fwrite($f, "sep=,\n");
   $fields = array('Menu Item', 'Category', 'Type', 'Price', 'Taxed');

   fputcsv($f, $fields, $delimiter, chr(0));

   $menu = mysqli_query($con, "SELECT * FROM menuitems WHERE status=1 ORDER BY menuitem");
   while ($row =  mysqli_fetch_array($menu)) {
      $menuitem_id = $row['menuitem_id'];
      $menuitem = $row['menuitem'];
      $itemprice = $row['itemprice'];
      $type = $row['type'];
      $taxed = $row['taxed'];
      $category = $row['category'];
      $menucategory = $row['menucategory'];
      $status = $row['status'];
      $creator = $row['creator'];
      if (!empty($menucategory)) {
         $getcat =  mysqli_query($con, "SELECT * FROM menucategories WHERE status=1 AND category_id='$menucategory'");
         $row1 =  mysqli_fetch_array($getcat);
         $categoryname = $row1['category'];
      } else {
         $categoryname = "";
      }
      if ($type == 'drink')
         $type .= ' (' . $category . ')';

      $lineData = array($menuitem, $categoryname, $type, $itemprice, ($taxed == 'yes') ? $taxed : "no");

      fputcsv($f, $lineData, $delimiter, chr(0));
   }

   fseek($f, 0);

   header('Content-Type: text/xls');

   header('Content-Disposition: attachment; filename="' . $filename . '";');

   fpassthru($f);
}

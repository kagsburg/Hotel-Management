<?php
include '../includes/conn.php';

 $latest=mysql_query("SELECT * FROM users LIMIT 2");
 $rows = array();
while($r = mysql_fetch_assoc($latest)) {
    $rows[] = $r;
}
print json_encode($rows,$options=2);
//   while($row=mysql_fetch_array($latest)){
      // include 'includes/thumbs3.php';
                      
                         //create_thumb('../img/',$image_file,'../img/thumbs/') or die(mysql_error());
                        
   //}
   
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

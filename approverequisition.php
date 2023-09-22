<?php
include 'includes/conn.php';
include 'utils/requisitions.php';
// include 'utils/dbquery.php';
if ((!isset($_SESSION['hotelsys']))) {
   header('Location:login');
} else {
   $id = $_GET['id'];
   update_requisition($pdo, $id, ['status' => 1]);
   // get requisition user id 
   $requisition = get_requisition_by_id($pdo, $id);
   $user_id = $requisition['user_id'];  
   // get employee's department
   $stmt = $pdo->prepare("SELECT * FROM employees WHERE employee_id=?");
   $stmt->execute([$user_id]);
   $employee = $stmt->fetch();
   $designation = $employee['designation'];
   // get department from designation
   $stmt = $pdo->prepare("SELECT * FROM designations WHERE designation_id=?");
   $stmt->execute([$designation]);
   $designation = $stmt->fetch();
   $department = $designation['department_id'];
   
   // issue the stock item to the department
   $stmt = $pdo->prepare("INSERT INTO issuedstock(date,admin_id,department_id,requisition_id,status) VALUES(UNIX_TIMESTAMP(),?,?,?,1)");
   $stmt->execute([$_SESSION['hotelsys'],$id, $department]);
   $last_id = $pdo->lastInsertId();
   $allproducts = $requisition['products'];
   $activity = 'Issued Requsition Request to ' . $employee['fullname'];
   foreach ($allproducts as $product) {
      $stmt = $pdo->prepare("INSERT INTO issueditems(item_id,quantity,issuedstock_id,status) VALUES(?,?,?,?)");
      $stmt->execute([$product['product_id'],$product['quantity'],$last_id,1]);
      $stmt = $pdo->prepare("INSERT INTO stockevents (timestamp,item_id,activity,status) VALUES(UNIX_TIMESTAMP(),?,?,?)");
      $stmt->execute([$product['product_id'],$activity,1]);
   }
   header('Location:' . $_SERVER['HTTP_REFERER']);
}

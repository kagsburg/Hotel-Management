<link href="css/bootstrap.min.css" rel="stylesheet">
<?php
include 'includes/conn.php';
include 'utils/requisitions.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login.php');
}
if (isset($_SESSION["reqproducts"]) && count($_SESSION["reqproducts"]) > 0) {
    $user_id = $_SESSION['emp_id'];
    // print_r($_SESSION); die();
    // print_r($_SESSION["reqproducts"]);
    $requisition_id = add_requisition($pdo, [
        'user_id' => $user_id,
        'status' => 0,
        'requisition_date'=>date('Y-m-d H:i:s'),
    ]);
    foreach ($_SESSION["reqproducts"] as $product) { //loop though items and prepare html content			
        $menuitem = $product["menuitem"];
        $price = $product["price"];
        $item_id = $product["item_id"];
        $product_qty = $product["product_qty"];
        $rpid = add_requisition_product($pdo, [
            'requisition_id' => $requisition_id,
            'product_id' => $item_id,
            'price' => $price,
            'quantity' => $product_qty,
        ]);
    }
    unset($_SESSION["reqproducts"]);
    // $purchaselist_id =  mysqli_insert_id($con);
    // foreach ($_SESSION["reqproducts"] as $product) { //loop though items and prepare html content			
    //     $menuitem = $product["menuitem"];
    //     $price = $product["price"];
    //     $item_id = $product["item_id"];
    //     $product_qty = $product["product_qty"];
    //     mysqli_query($con, "INSERT INTO purchaseditems(purchaselist_id,item_id,price,quantity,status) VALUES('$purchaselist_id','$item_id','$price','$product_qty',1)") or die(mysqli_error($con));
    //     unset($_SESSION["reqproducts"]);
    // }

?>

    <div class="col-sm-2"></div>
    <div class="col-sm-10">
        <div class="alert alert-success">
            <i class="fa fa-check"></i>
            Requisition Successfully Added. Click <strong><a href="addrequisition">Here</a></strong> To go back
        </div>
    </div>
<?php
}

?>
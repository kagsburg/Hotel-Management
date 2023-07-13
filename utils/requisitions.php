<?php

require_once 'dbquery.php';

function get_all_requisitions(PDO $conn, $status = 1)
{
    $stmt = $conn->prepare("SELECT * FROM requisitions WHERE status=?");
    $stmt->execute([$status]);
    $getallrequisitions = $stmt->fetchAll();
    return $getallrequisitions;
}

function get_requisitions_for_user(PDO $conn, $user_id, $status = 1)
{
    $stmt = $conn->prepare("SELECT * FROM requisitions WHERE user_id=? AND status=?");
    $stmt->execute([$user_id, $status]);
    $getrequisitionsforuser = $stmt->fetchAll();
    return $getrequisitionsforuser;
}

function get_requisition_for_user_by_id(PDO $conn, $user_id, $id, $status = null)
{
    $status = is_null($status) || !is_int($status) ? '' : "AND status=$status";
    $stmt = $conn->prepare("SELECT * FROM requisitions WHERE user_id=? AND requisition_id=? $status");
    $stmt->execute([$user_id, $id]);
    $requisition = $stmt->fetch();
    $requisition['products'] = get_requisition_products($conn, $id);
    return $requisition;
}

function get_requisition_by_id(PDO $conn, $id)
{
    $stmt = $conn->prepare("SELECT * FROM requisitions WHERE requisition_id=?");
    $stmt->execute([$id]);
    $requisition = $stmt->fetch();
    $requisition['products'] = get_requisition_products($conn, $id);
    return $requisition;
}

function get_requisition_products(PDO $conn, $requisition_id)
{
    $stmt = $conn->prepare("SELECT * FROM requisition_products WHERE requisition_id=?");
    $stmt->execute([$requisition_id]);
    while ($product = $stmt->fetch()) {
        $getstockproduct = $conn->prepare("SELECT * FROM stock_items WHERE stockitem_id=?");
        $getstockproduct->execute([$product['product_id']]);
        $stockproduct = $getstockproduct->fetch();
        $product['product_name'] = $stockproduct['stock_item'];
        yield $product;
    }
}

function add_requisition(PDO $conn, $attributes)
{
    return db_insert($conn, 'requisitions', $attributes);
}

function add_requisition_product(PDO $conn, $attributes)
{
    return db_insert($conn, 'requisition_products', $attributes);
}

function update_requisition(PDO $conn, $id, $attributes)
{
    return db_update($conn, 'requisitions', $attributes, ['requisition_id' => $id]);
}

function approve_requisition(PDO $conn, $id)
{
    $stmt = $conn->prepare("UPDATE requisitions SET status=1 WHERE requisition_id=?");
    $stmt->execute([$id]);
    return $stmt->rowCount() > 0;
}

function decline_requisition(PDO $conn, $id)
{
    $stmt = $conn->prepare("UPDATE requisitions SET status=3 WHERE requisition_id=?");
    $stmt->execute([$id]);
    return $stmt->rowCount() > 0;
}

function hide_requisition(PDO $conn, $id)
{
    $stmt = $conn->prepare("UPDATE requisitions SET status=0 WHERE requisition_id=?");
    $stmt->execute([$id]);
    return $stmt->rowCount() > 0;
}

// SQL for creating the requisitions table:
// CREATE TABLE `requisitions` (
//   `requisition_id` int(11) NOT NULL,
//   `user_id` int(11) NOT NULL,
//   `requisition_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
//   `status` int(11) NOT NULL DEFAULT 1
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

// ALTER TABLE `requisitions`
//   ADD PRIMARY KEY (`requisition_id`),
//   ADD KEY `user_id` (`user_id`);

// ALTER TABLE `requisitions`
//   MODIFY `requisition_id` int(11) NOT NULL AUTO_INCREMENT;
//
// SQL for creating the requisition_products table:
// CREATE TABLE `requisition_products` (
//   `requisition_product_id` int(11) NOT NULL,
//   `requisition_id` int(11) NOT NULL,
//   `product_id` int(11) NOT NULL,
//   `quantity` int(11) NOT NULL,
//   `price` int(11) NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

// ALTER TABLE `requisition_products`
//   ADD PRIMARY KEY (`requisition_product_id`),
//   ADD KEY `requisition_id` (`requisition_id`),
//   ADD KEY `product_id` (`product_id`);

// ALTER TABLE `requisition_products`
//   MODIFY `requisition_product_id` int(11) NOT NULL AUTO_INCREMENT;

// ALTER TABLE `requisition_products`
//   ADD CONSTRAINT `requisition_products_ibfk_1` FOREIGN KEY (`requisition_id`) REFERENCES `requisitions` (`requisition_id`),
//   ADD CONSTRAINT `requisition_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `stock_items` (`stockitem_id`);

// ALTER TABLE `requisitions`
//   ADD CONSTRAINT `requisitions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

<?php 

require_once 'dbquery.php';

function get_all_services(PDO $conn, $status=1)
{
    $stmt = $conn->prepare("SELECT * FROM services WHERE status=?");
    $stmt->execute([$status]);
    $getallservices = $stmt->fetchAll();
    return $getallservices;
}

function get_service_by_id(PDO $conn, $id)
{
    $stmt = $conn->prepare("SELECT * FROM services WHERE service_id=?");
    $stmt->execute([$id]);
    $getservicebyid = $stmt->fetch();
    return $getservicebyid;
}

function create_service(PDO $conn, $attributes)
{
    return db_insert($conn, 'services', $attributes);
}

function update_service(PDO $conn, $attributes, $id)
{
    return db_update($conn, 'services', $attributes, $id);
}

function hide_service(PDO $conn, $id)
{
    $stmt = $conn->prepare("UPDATE services SET status=0 WHERE service_id=?");
    $stmt->execute([$id]);
    return $stmt->rowCount() > 0;
}

// fields: service_id, service_name, service_price, service_description, status
// SQL for creating the services table:
// CREATE TABLE `services` (
//   `service_id` int(11) NOT NULL,
//   `service_name` varchar(255) NOT NULL,
//   `service_price` int(11) NOT NULL,
//   `service_description` text NOT NULL,
//   `status` int(11) NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

// ALTER TABLE `services`
//   ADD PRIMARY KEY (`service_id`);

// ALTER TABLE `services`
//   MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
//
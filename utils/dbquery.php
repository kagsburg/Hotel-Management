<?php 

function db_insert(PDO $conn, $table, $attributes)
{
    $columns = implode(', ', array_keys($attributes));
    $placeholders = implode(', ', array_fill(0, count($attributes), '?'));
    
    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

    $stmt = $conn->prepare($sql);
    $stmt->execute(array_values($attributes));

    return $stmt->rowCount() > 0 ? $conn->lastInsertId() : false;
}

function db_update(PDO $conn, $table, $attributes, $id)
{
    $columns = implode(', ', array_keys($attributes));
    $placeholders = implode(', ', array_fill(0, count($attributes), '?'));

    if (is_array($id)) {
        $idColumn = array_keys($id)[0];
        $idValue = array_values($id)[0];
    } else {
        $idColumn = 'id';
        $idValue = $id;
    }

    $stmt = $conn->prepare("UPDATE $table SET $columns = $placeholders WHERE $idColumn = ?");

    $values = array_values($attributes);
    $values[] = $idValue;
    
    $stmt->execute($values);

    return $stmt->rowCount() > 0;
}
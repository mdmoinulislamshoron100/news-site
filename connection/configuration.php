<?php
define('SECURE', true);
require_once(__DIR__ . '/config.php');

ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/db_errors.log');

$conn = mysqli_connect(HOST, USER, PASS, DB);

if (!$conn) {
    error_log("Database connection failed: " . mysqli_connect_error() . "\n", 3, __DIR__ . '/../logs/db_errors.log');
    die("Something went wrong. Please try again later.");
}
mysqli_set_charset($conn, "utf8mb4");

function filteration($data)
{
    $filtered = [];
    foreach ($data as $key => $value) {
        $value = trim($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        $value = stripslashes($value);
        $value = preg_replace('/\s+/', ' ', $value);
        $filtered[$key] = $value;
    }
    return $filtered;
}

function selectAll($table, $join = '', $where = '', $params = [], $types = '', $columns = '*', $orderBy = '', $limit = '')
{
    global $conn;

    $sql = "SELECT $columns FROM `$table`";

    if (!empty($join)) {
        $sql .= " $join";
    }

    if (!empty($where)) {
        $sql .= " WHERE $where";
    }

    if (!empty($orderBy)) {
        $sql .= " ORDER BY $orderBy";
    }

    if (!empty($limit)) {
        $sql .= " LIMIT $limit";
    }

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($conn) . "\n", 3, __DIR__ . '/../logs/db_errors.log');
        return false;
    }

    if (!empty($params) && !empty($types)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    if (!mysqli_stmt_execute($stmt)) {
        error_log("Execution failed: " . mysqli_stmt_error($stmt) . "\n", 3, __DIR__ . '/../logs/db_errors.log');
        return false;
    }

    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        error_log("Get result failed: " . mysqli_stmt_error($stmt) . "\n", 3, __DIR__ . '/../logs/db_errors.log');
        return false;
    }

    $rows = $result;

    mysqli_stmt_close($stmt);

    return $rows;
}

function insert($table, $data, $types)
{
    global $conn;

    $columns = implode(', ', array_keys($data));
    $placeholders = implode(', ', array_fill(0, count($data), '?'));
    $sql = "INSERT INTO `$table` ($columns) VALUES ($placeholders)";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        error_log("Insert prepare failed: " . mysqli_error($conn) . "\n", 3, __DIR__ . '/../logs/db_errors.log');
        return false;
    }

    mysqli_stmt_bind_param($stmt, $types, ...array_values($data));

    $result = mysqli_stmt_execute($stmt);
    if (!$result) {
        error_log("Insert execute failed: " . mysqli_stmt_error($stmt) . "\n", 3, __DIR__ . '/../logs/db_errors.log');
        return false;
    }

    $insertId = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);
    return $insertId;
}

function update($table, $data, $where, $params, $types)
{
    global $conn;

    $set = implode(', ', array_map(fn($col) => "$col = ?", array_keys($data)));
    $sql = "UPDATE `$table` SET $set WHERE $where";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        error_log("Update prepare failed: " . mysqli_error($conn) . "\n", 3, __DIR__ . '/../logs/db_errors.log');
        return false;
    }

    $values = array_merge(array_values($data), $params);
    $fullTypes = $types;

    mysqli_stmt_bind_param($stmt, $fullTypes, ...$values);

    $result = mysqli_stmt_execute($stmt);
    if (!$result) {
        error_log("Update execute failed: " . mysqli_stmt_error($stmt) . "\n", 3, __DIR__ . '/../logs/db_errors.log');
        return false;
    }

    mysqli_stmt_close($stmt);
    return true;
}

function delete($table, $where, $params, $types)
{
    global $conn;

    $sql = "DELETE FROM `$table` WHERE $where";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        error_log("Delete prepare failed: " . mysqli_error($conn) . "\n", 3, __DIR__ . '/../logs/db_errors.log');
        return false;
    }

    mysqli_stmt_bind_param($stmt, $types, ...$params);

    $result = mysqli_stmt_execute($stmt);
    if (!$result) {
        error_log("Delete execute failed: " . mysqli_stmt_error($stmt) . "\n", 3, __DIR__ . '/../logs/db_errors.log');
        return false;
    }

    mysqli_stmt_close($stmt);
    return true;
}

?>

<?php 
require __DIR__.'/../connection/configuration.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        die("<h3 style='text-align:center; color: red;'>Delete id must be a number. Thank you.</h3>");
    }

    $where = 'id = ?';
    $params = [$id];
    if(delete('categories', $where, $params, 'i')){
        header('Location: http://localhost/news.com/admin/category.php');
    }else{
        echo "<h3 style='text-align:center; color: red;'>Data not deleted. Something wrong. Thank you.</h3>";
        exit;
    }
}

?>
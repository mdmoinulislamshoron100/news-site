<?php
session_start();
if(isset($_SESSION['id']) && isset($_SESSION['username']) && isset($_SESSION['role'])){
    session_unset();
    session_destroy();
    header('Location: http://localhost/news.com/admin/index.php');
}

?>

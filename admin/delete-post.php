<?php 
require __DIR__ . '/../connection/configuration.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'], $_GET['cat_id'])) {
    $post_id = (int)$_GET['id'];
    $category_id = (int)$_GET['cat_id'];

    $where = 'id = ?';
    $params = [$post_id];

    $imgSelect = selectAll('posts','',$where, $params, 'i', 'image');
    if ($imgSelect && $imgRow = mysqli_fetch_assoc($imgSelect)) {
        $imageName = $imgRow['image'];

        if (!empty($imageName) && file_exists('upload/' . $imageName)) {
            unlink('upload/' . $imageName);
        }
    }

    if (delete('posts', $where, $params, 'i')) {
        $stmt = $conn->prepare("UPDATE categories SET post = post - 1 WHERE id = ?");
        $stmt->bind_param("i", $category_id);

        if ($stmt->execute()) {
            header('Location: http://localhost/news.com/admin/post.php');
            exit;
        } else {
            echo "<h4 style='text-align:center; color: red;'>Post deleted but category post count not updated.</h4>";
            exit;
        }
    }

}

?>
<?php 
include "header.php";
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header('Location: http://localhost/news.com/admin/index.php');
    exit;
}
?>

<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">

    <?php

        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $cleanData  = filteration($_POST);

            $post_id    = (int) $cleanData['post_id'];
            $post_title = $cleanData['post_title'];
            $postdesc   = $cleanData['postdesc'];
            $category   = isset($cleanData['category']) ? (int) $cleanData['category'] : null;

            $allowedExt  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxFileSize = 2 * 1024 * 1024;
            $targetDir   = "upload/";

            $oldDataRes = selectAll('posts', '', 'id = ?', [$post_id], 'i','category, image');
            $oldData    = $oldDataRes ? mysqli_fetch_assoc($oldDataRes) : null;
            $oldCategory = $oldData['category'] ?? null;
            $oldImage    = $oldData['image'] ?? '';

            $newFileName = $_POST['old-image'];

            if (empty($post_title) || empty($postdesc) || empty($category)) {
                $message = "<h4 style='text-align:center; color: red;'>All fields are required.</h4>";
            } 

            if (empty($message) && isset($_FILES['new-image']) && $_FILES['new-image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $fileError  = $_FILES['new-image']['error'];
                $fileName   = basename($_FILES['new-image']['name']);
                $fileSize   = $_FILES['new-image']['size'];
                $fileTmp    = $_FILES['new-image']['tmp_name'];
                $fileType   = mime_content_type($fileTmp);
                $fileExt    = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                if (substr_count($fileName, '.') > 1) {
                    $message = "Invalid file name.";
                } elseif ($fileError !== UPLOAD_ERR_OK) {
                    $message = "Error during file upload. Error code: {$fileError}";
                } elseif (!in_array($fileExt, $allowedExt)) {
                    $message = "Invalid file extension.";
                } elseif (!in_array($fileType, $allowedMime)) {
                    $message = "Invalid file MIME type.";
                } elseif ($fileSize > $maxFileSize) {
                    $message = "File too large. Max size is " . ($maxFileSize / 1024 / 1024) . " MB.";
                } elseif (getimagesize($fileTmp) === false) {
                    $message = "The uploaded file is not a valid image.";
                } else {
                    $newFileName = uniqid("IMG_", true) . "." . $fileExt;
                    if (move_uploaded_file($fileTmp, $targetDir . $newFileName)) {
                        if (!empty($oldImage) && file_exists($targetDir . $oldImage)) {
                            unlink($targetDir . $oldImage);
                        }
                    } else {
                        $message = "Failed to move uploaded file.";
                    }
                }
            }
            if (empty($message)) {

                $updatedata = [
                    'title'       => $post_title,
                    'description' => $postdesc,
                    'category'    => $category,
                    'image'       => $newFileName
                ];

                $where  = 'id = ?';
                $params = [$post_id];

                if (update('posts', $updatedata, $where, $params, 'ssisi')) {

                    if ($oldCategory && $oldCategory != $category) {
                        $stmtOld = $conn->prepare("UPDATE categories SET post = post - 1 WHERE id = ?");
                        $stmtOld->bind_param("i", $oldCategory);
                        $stmtOld->execute();
                        $stmtNew = $conn->prepare("UPDATE categories SET post = post + 1 WHERE id = ?");
                        $stmtNew->bind_param("i", $category);
                        $stmtNew->execute();
                    }

                    header('Location: http://localhost/news.com/admin/post.php');
                    exit;
                } else {
                    $message = "<h4 style='text-align:center; color: red;'>Data update failed. Please try again.</h4>";
                }
            }
        }

        if (!empty($message)) {
            echo $message;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            if (!filter_var($id, FILTER_VALIDATE_INT)) {
                echo "<h3 style='color:red;'>Update id must be a number. Thank you.</h3>";
                die();
            }
            $accessPost = selectAll(
                'posts',
                'INNER JOIN users ON posts.author = users.id',
                'posts.id = ?',
                [$id],
                'i',
                'posts.*, users.username'
            );
            $acpost = mysqli_fetch_assoc($accessPost);

            if (!$acpost) {
                echo "<h3 style='color:red;'>Post not found according to Id. Thank you.</h3>";
                die();
            }
            
            if ($_SESSION['role'] == 0 && $acpost['author'] != $_SESSION['id']) {
                echo "<h3 style='text-align:center; color: red;'>You are not allowed to edit this post. Thank you.</h3>";
                die();
            }
            
            $posts = selectAll(
                'posts',
                '',
                'id = ?',
                [$id],
                'i',
                '*',
            );
            if($posts && $posts->num_rows > 0){
                foreach($posts as $post):
            ?>
            
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo htmlspecialchars($post['id']); ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo htmlspecialchars($post['title']); ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  rows="5"><?php echo htmlspecialchars($post['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="category">Category</label>

            <?php 
            $categories = selectAll('categories');
            ?>
            <select name="category" class="form-control">
            <?php
            if ($categories && $categories->num_rows > 0) {
                foreach ($categories as $category) {
                    $selected = ($category['id'] == $post['category']) ? 'selected' : '';
                    ?>
                    <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php echo $selected; ?>>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                    <?php
                }
            } else {
                ?>
                <option value="">No category found</option>
                <?php
            }
            ?>
            </select>
            </div>

            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image">
                <img src="upload/<?php echo htmlspecialchars($post['image']); ?>" height="150px">
                <input type="hidden" name="old-image" value="<?php echo htmlspecialchars($post['image']); ?>">
            </div>

            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
            </form>

            <?php
                endforeach;
            }else{
            ?>
                <h4 style="text-align: center; color: red;">Not found any data of your update id.</h4>
            <?php
            }
        }else{
            echo "<h3 style='color:red; text-align:center;'>Invalid Server Request. Thank you.</h3>";
        }

    ?>

    </div>
  </div>
  </div>
</div>
<?php include "footer.php"; ?>

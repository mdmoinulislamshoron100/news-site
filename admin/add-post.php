<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <h1 class="admin-heading">Add New Post</h1>
             </div>
              <div class="col-md-offset-3 col-md-6">
                   
            <?php 
            
                $message = '';

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
                    $cleanData = filteration($_POST);

                    $post_title = $cleanData['post_title'];
                    $postdesc   = $cleanData['postdesc'];
                    $category = $cleanData['category'] ?? null; 

                    $targetDir      = "upload/";
                    $maxFileSize    = 2 * 1024 * 1024; // 2MB
                    $allowedExt     = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    $allowedMime    = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

                    if (empty($post_title) || empty($postdesc) || empty($category)) {
                        $message = "<h4 style='text-align:center; color: red;'>All fields are required.</h4>";
                    } 
                    elseif (!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] === UPLOAD_ERR_NO_FILE) {
                        $message = "<h4 style='text-align:center; color: red;'>Please upload an image.</h4>";
                    }
                    else {
                        $fileError  = $_FILES['fileToUpload']['error'];
                        $fileName   = basename($_FILES['fileToUpload']['name']);
                        $fileSize   = $_FILES['fileToUpload']['size'];
                        $fileTmp    = $_FILES['fileToUpload']['tmp_name'];
                        $fileType   = mime_content_type($fileTmp);
                        $fileExt    = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                        if ($fileError !== UPLOAD_ERR_OK) {
                            $message = "<h4 style='text-align:center; color: red;'>Error during file upload. Error code: {$fileError}</h4>";
                        }
                        elseif (!in_array($fileExt, $allowedExt)) {
                            $message = "<h4 style='text-align:center; color: red;'>Invalid file type. Only JPG, JPEG, PNG, GIF, WEBP allowed.</h4>";
                        }
                        elseif (!in_array($fileType, $allowedMime)) {
                            $message = "<h4 style='text-align:center; color: red;'>Invalid file MIME type.</h4>";
                        }
                        elseif ($fileSize > $maxFileSize) {
                            $message = "<h4 style='text-align:center; color: red;'>File too large. Max size is " . ($maxFileSize / 1024 / 1024) . " MB.</h4>";
                        }
                        elseif (getimagesize($fileTmp) === false) {
                            $message = "<h4 style='text-align:center; color: red;'>The uploaded file is not a valid image.</h4>";
                        }
                        else {
                            $newFileName = uniqid("IMG_", true) . "." . $fileExt;
                            if (move_uploaded_file($fileTmp, $targetDir . $newFileName)) {
                                $data = [
                                    'title'       => $post_title,
                                    'description' => $postdesc,
                                    'category'    => $category,
                                    'author'      => $_SESSION['id'],
                                    'image'       => $newFileName
                                ];

                                $insertId = insert('posts', $data, 'ssiss');
                                if ($insertId) {
                                    $stmt = $conn->prepare("UPDATE categories SET post = post + 1 WHERE id = ?");
                                    $stmt->bind_param("i", $category);
                                    if ($stmt->execute()) {
                                        header('Location: http://localhost/news.com/admin/post.php');
                                        exit;
                                    }else{
                                        $message = "<h4 style='text-align:center; color: red;'>Post not updated into category page. Thank you.</h4>";
                                    }
                                } else {
                                    $message = "<h4 style='text-align:center; color: red;'>Post not inserted. Please try again.</h4>";
                                }
                            } else {
                                $message = "<h4 style='text-align:center; color: red;'>Failed to move uploaded file. Please try again.</h4>";
                            }
                        }
                    }
                }

                if (!empty($message)) {
                    echo $message;
                }

            ?>

                <form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="post_title">Title</label>
                        <input type="text" name="post_title" class="form-control" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="postdesc"> Description</label>
                        <textarea name="postdesc" class="form-control" rows="5" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>

                    <?php 
                        $categories = selectAll('categories');
                    ?>
                        <select name="category" class="form-control">
                            <option value="" selected disabled> Select a category </option>
                        <?php
                        if($categories && $categories -> num_rows > 0){
                            foreach($categories as $category):
                        ?>
                            <option value="<?php echo htmlspecialchars($category['id']); ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                        <?php
                            endforeach;
                        }else{
                        ?>
                            <option value=""> No category found</option>
                            <?php
                        }  
                            ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="image">Post image</label>
                        <input type="file" id="image" name="fileToUpload">
                    </div>
                    <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                </form>

              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>

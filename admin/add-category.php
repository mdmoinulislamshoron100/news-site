<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add New Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">

                <?php 

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
                    $cleanData = filteration($_POST);
                    $category = $cleanData['cat'];

                    $cats = selectAll(
                        'categories',
                        '',
                        'name = ?',
                        [$category],
                        's',
                        '*',
                    );
                
                    if($cats -> num_rows > 0){
                        echo "<h3 style='text-align:center; color: red;'>Category name already exists. Thank you.</h3>";
                    } else{

                        $data = [
                            'name' => $category
                        ];

                        $insertId = insert('categories', $data, 's');
                        if($insertId){
                            header('Location: http://localhost/news.com/admin/category.php');
                            exit;
                        }else{
                            echo "<h3 style='text-align:center; color: red;'>Data not inserted. Thank you.</h3>";
                        }
                    }
                }
                ?>

                  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" autocomplete="off">
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                      </div>
                      <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                  </form>

              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>

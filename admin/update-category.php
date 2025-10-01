<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>

                <?php 

                if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){

                        $cleanData = filteration($_POST);
                        $id = $cleanData['cat_id'];
                        $name = $cleanData['cat_name'];


                    $check = selectAll(
                        'categories',
                        '',
                        'name = ? AND id != ?',
                        [$name, $id],
                        'si',
                        '*',
                        '',
                        ''
                    );
                    
                    if ($check && $check->num_rows > 0) {
                        echo "<h3 style='text-align:center; color: red;'>Category already exists. Please choose another one.</h3>";
                    }else{
                        $data = [
                            'name' => $name
                        ];
                        $where = 'id = ?';
                        $params = [$id];
                        
                        if(update('categories', $data, $where, $params, 's' . 'i')){
                            header('Location: http://localhost/news.com/admin/category.php');
                            exit;
                        }else{
                            echo "<h3 style='text-align:center; color: red;'>Category not updated. Thank you.</h3>";
                        }
                    }
                }


                if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {

                    $id = $_GET['id'];
                    if (!filter_var($id, FILTER_VALIDATE_INT)) {
                        die('<h3 style="color:red;text-align:center;">Invalid Category ID.</h3>');
                    }
                    $category = selectAll(
                        'categories',
                        '',
                        'id = ?',
                        [$id],
                        'i',
                        '*',
                    );
                    if($category && $category->num_rows > 0){
                    ?>

                    <div class="col-md-offset-3 col-md-6">
                            
                        <?php 
                            foreach($category as $cat):
                        ?>

                        <form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method ="POST">

                            <div class="form-group">
                                <input type="hidden" name="cat_id"  class="form-control" value="<?php echo htmlspecialchars($cat['id']); ?>" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Category Name</label>
                                <input type="text" name="cat_name" class="form-control" value="<?php echo htmlspecialchars($cat['name']); ?>"  placeholder="" required>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" required />

                        </form>

                        <?php endforeach ?>

                    </div>

                    <?php
                    }else{
                        ?>
                            <h3 style="text-align: center; color: red;">No Category found. Invalid category Id.</h3>
                        <?php
                    }

                }else{
                    echo "<h3 style='color:red; text-align:center;'>Invalid Server Request. Thank you.</h3>";
                }

                ?>


            </div>
      </div>
  </div>
  
<?php include "footer.php"; ?>

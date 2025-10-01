<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>

              <?php 
                if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
                        $cleanData = filteration($_POST);
                        $user_id = $cleanData['user_id'];
                        $f_name = $cleanData['f_name'];
                        $l_name = $cleanData['l_name'];
                        $username = $cleanData['username'];
                        $role = $cleanData['role'];
                    $check = selectAll(
                        'users',
                        '',
                        'username = ? AND id != ?',
                        [$username, $user_id],
                        'si',
                        '*',
                        '',
                        ''
                    );
                    if ($check && $check->num_rows > 0) {
                        echo "<h4 style='text-align:center; color: red;'>Username already exists. Please choose another one.</h4>";
                    }else{
                        $data = [
                            'first_name' => $f_name,
                            'last_name' => $l_name,
                            'username' => $username,
                            'role' => $role
                        ];
                        $where = 'id = ?';
                        $params = [$user_id];
                        if(update('users', $data, $where, $params, 'sssi' . 'i')){
                            header('Location: http://localhost/news.com/admin/users.php');
                            exit;
                        }else{
                            echo "<h4 style='text-align:center; color: red;'>User not updated. Thank you.</h4>";
                        }
                    }
                }

                if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
                    $id = $_GET['id'];
                    if (!filter_var($id, FILTER_VALIDATE_INT)) {
                        echo "<h3 style='color:red;'>Update id must be a number. Thank you.</h3>";
                        die();
                    }
                    $users = selectAll(
                        'users',
                        '',
                        'id = ?',
                        [$id],
                        'i',
                        '*',
                    );
                    if($users && $users->num_rows > 0){
                    ?>

                        <div class="col-md-offset-4 col-md-4">
                                
                            <?php 
                                foreach($users as $user):
                            ?>

                            <form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method ="POST">
                                <div class="form-group">
                                    <input type="hidden" name="user_id"  class="form-control" value="<?php echo htmlspecialchars($user['id']); ?>" placeholder="" >
                                </div>
                                    <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="f_name" class="form-control" value="<?php echo htmlspecialchars($user['first_name']); ?>" placeholder="" required>
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="l_name" class="form-control" value="<?php echo htmlspecialchars($user['last_name']); ?>" placeholder="" required>
                                </div>
                                <div class="form-group">
                                    <label>User Name</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" placeholder="" required>
                                </div>
                                <div class="form-group">
                                    <label>User Role</label>
                                    <select class="form-control" name="role">
                                        <?php 
                                            if($user['role'] == 0){
                                                ?>
                                                <option value="0" selected>normal User</option>
                                                <option value="1">Admin</option>
                                                <?php
                                            }else{
                                                ?>
                                                <option value="0">normal User</option>
                                                <option value="1" selected>Admin</option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>
                                <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                            </form>

                            <?php endforeach ?>
                            
                        </div>

                    <?php
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
<?php include "footer.php"; ?>


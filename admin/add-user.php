<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add User</h1>
              </div>

                <?php 

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
                    $cleanData = filteration($_POST);
                    $fname = $cleanData['fname'];
                    $lname = $cleanData['lname'];
                    $user = $cleanData['user'];
                    $password = md5($cleanData['password']);
                    $role = $cleanData['role'];

                    if(empty($fname) || empty($lname) || empty($user) || empty($password)){
                        echo "<h3 style='text-align:center; color: red;'>All input fields required. Thank you.</h3>";
                    }else{
                        $users = selectAll(
                            'users',
                            '',
                            'username = ?',
                            [$user],
                            's',
                            '*',
                        );
                    
                        if($users -> num_rows > 0){
                            echo "<h3 style='text-align:center; color: red;'>Username already registered. Thank you.</h3>";
                        } else{

                            $data = [
                                'first_name' => $fname,
                                'last_name' => $lname,
                                'username' => $user,
                                'password' => $password,
                                'role' => $role
                            ];
                            $insertId = insert('users', $data, 'ssssi');
                            if($insertId){
                                header('Location: http://localhost/news.com/admin/users.php');
                                exit;
                            }else{
                                echo "<h4 style='text-align:center; color: red;'>Data not inserted. Thank you.</h4>";
                            }
                        }
                    }
                }
                ?>

              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method ="POST" autocomplete="off">
                      <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                      </div>
                          <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="user" class="form-control" placeholder="Username" required>
                      </div>

                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control" placeholder="Password" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" >
                              <option value="0">Normal User</option>
                              <option value="1">Admin</option>
                          </select>
                      </div>
                      <input type="submit"  name="save" class="btn btn-primary" value="Save" required />
                  </form>
                   <!-- Form End-->
               </div>

           </div>
       </div>
   </div>
<?php include "footer.php"; ?>

<?php include "header.php"; ?>
<?php 
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true){
    header('Location: http://localhost/news.com/admin/index.php');
}

if (isset($_SESSION['role']) && $_SESSION['role'] === 0) {
    header('Location: http://localhost/news.com/admin/post.php');
}
?>


  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
              </div>
              <div class="col-md-12">
                <?php 
                    $limit = 5;
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0
                            ? (int)$_GET['page']
                            : 1;
                    
                    $offset = ( $page -1 ) * $limit;
                    $p = $offset .",". $limit;
                    $allUser = selectAll('users','','','','','*', 'id DESC', $p);
                    if($allUser && $allUser -> num_rows > 0){
                ?>

                        <table class="content-table">
                            <thead>
                                <th>S.No.</th>
                                <th>Full Name</th>
                                <th>User Name</th>
                                <th>Role</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </thead>
                            <tbody>
                                <?php 
                                    $serial = $offset+1;
                                    foreach($allUser as $user):
                                ?>
                                <tr>
                                    <td class='id'><?php echo htmlspecialchars($serial++); ?></td>
                                    <td><?php echo htmlspecialchars($user['first_name']); ?> <?php echo htmlspecialchars($user['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($user['role']) == 0 ? 'Normal' : 'Admin'; ?>
                                    </td>
                                    <td class='edit'><a href='update-user.php?id=<?php echo htmlspecialchars($user['id']); ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-user.php?id=<?php echo htmlspecialchars($user['id']); ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>

                <?php
                        $pagination = selectAll('users');
                        if($pagination && $pagination->num_rows > 5){
                            $totalRecords = $pagination->num_rows;
                            
                            $NoOfPage = ceil($totalRecords / $limit);
                            echo "<ul class='pagination admin-pagination'>";
                            if($page > 1){
                                echo "<li><a href='?page=".($page-1)."'>Prev</a></li>";
                            }
                            
                            for($i=1; $i<=$NoOfPage; $i++){
                                $active = '';
                                if($page == $i){
                                    $active .= 'active';
                                }
                                echo "<li class=$active><a href='?page=$i'>$i</a></li>";
                            }
                            if($page < $NoOfPage){
                                echo "<li><a href='?page=".($page+1)."'>Next</a></li>";
                            }
                            
                            echo "</ul>";
                        }else{
                            echo "";
                        }

                    }else{
                        echo "<h4 style='text-align:center; color: red;'>No user found. Please Add User. Thank you.</h4>";
                    }
                ?>

                    <?php 

                    ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>

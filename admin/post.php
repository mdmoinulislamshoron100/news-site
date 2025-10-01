<?php 
include "header.php";
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != true){
    header('Location: http://localhost/news.com/admin/index.php');
}
?>

  <div id="admin-content">
      <div class="container">
          <div class="row">

              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>

              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>

              <div class="col-md-12">
                <?php 
                    $limit = 5;
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0
                            ? (int)$_GET['page']
                            : 1;
                    $offset = ( $page -1 ) * $limit;
                    $p = $offset .",". $limit;

                    if($_SESSION['role'] === 0){
                        $posts = selectAll(
                            'posts',
                            'INNER JOIN categories ON posts.category = categories.id INNER JOIN users ON posts.author = users.id',
                            'users.id = ?',
                            [$_SESSION['id']],
                            'i',
                            'posts.id, posts.title, posts.category, categories.name, posts.post_date, users.username',
                            'id DESC',
                            $p
                        ); 
                    }else{
                        $posts = selectAll(
                            'posts',
                            'INNER JOIN categories ON posts.category = categories.id INNER JOIN users ON posts.author = users.id',
                            '',
                            [],
                            '',
                            'posts.id, posts.title, posts.category, categories.name, posts.post_date, users.username',
                            'id DESC',
                            $p
                        ); 
                    }
                    if($posts && $posts -> num_rows > 0){
                    ?>
                        <table class="content-table">
                            <thead>
                                <th>S.No.</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Author</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </thead>
                            <tbody>
                                <?php 
                                $serial = $offset + 1;
                                foreach($posts as $post): 
                                ?>
                                <tr>
                                    <td class='id'><?php echo htmlspecialchars($serial++); ?></td>
                                    <td><?php echo htmlspecialchars($post['title']); ?></td>
                                    <td><?php echo htmlspecialchars($post['name']); ?></td>
                                    <td><?php echo htmlspecialchars(date("F j, Y g:i A", strtotime($post['post_date']))); ?></td>
                                    <td><?php echo htmlspecialchars($post['username']); ?></td>
                                    
                                    <td class='edit'><a href='update-post.php?id=<?php echo htmlspecialchars($post['id']); ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-post.php?id=<?php echo htmlspecialchars($post['id']); ?>&cat_id=<?php echo htmlspecialchars($post['category']); ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php

                        if($_SESSION['role'] === 0){
                            $pagination = selectAll(
                                'posts',
                                'INNER JOIN users ON posts.author = users.id',
                                'users.id = ?',
                                [$_SESSION['id']],
                                'i',
                                '*'
                            ); 
                        }else{
                            $pagination = selectAll('posts');
                        }
                        if($pagination && $pagination->num_rows > $limit){
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
                        echo "<h3 style='text-align:center; color: red;'>No post found. Please Add new post. Thank you.</h3>";
                    }
                ?>

              </div>

          </div>
      </div>
  </div>
<?php include "footer.php"; ?>

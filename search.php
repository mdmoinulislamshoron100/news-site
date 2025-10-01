<?php include 'header.php'; ?>
<div id="main-content">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="post-container">
          
          <?php 
          if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
            $search_term = trim($_GET['search']);
            $limit = 2;
            $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0
                ? (int)$_GET['page']
                : 1;
            $offset = ($page - 1) * $limit;

            $search_param = '%' . $search_term . '%';
            $params = [$search_param, $search_param, $search_param];
            echo "<h2 class='page-heading'>" . htmlspecialchars($search_term) . "</h2>";
            $posts = selectAll(
                'posts',
                'LEFT JOIN categories ON posts.category = categories.id LEFT JOIN users ON posts.author = users.id',
                'users.username LIKE ? OR posts.title LIKE ? OR posts.description LIKE ?',
                $params,
                'sss',
                'posts.id, posts.title, posts.description, posts.post_date, posts.category, posts.author, posts.image, categories.name, users.username',
                'posts.id DESC',
                "$offset, $limit"
            );
            if ($posts && $posts->num_rows > 0) {
                while ($post = $posts->fetch_assoc()):
          ?>

          <div class="post-content">
              <div class="row">
                  <div class="col-md-4">
                      <a class="post-img" href="single.php?id=<?php echo htmlspecialchars($post['id']); ?>">
                          <img src="admin/upload/<?php echo htmlspecialchars($post['image']); ?>" alt="news picture"/>
                      </a>
                  </div>
                  <div class="col-md-8">
                      <div class="inner-content clearfix">
                          <h3><a href='single.php?id=<?php echo htmlspecialchars($post['id']); ?>'><?php echo htmlspecialchars($post['title']); ?></a></h3>
                          <div class="post-information">
                              <span>
                                  <i class="fa fa-tags" aria-hidden="true"></i>
                                  <a href='category.php?id=<?php echo htmlspecialchars($post['category']); ?>'><?php echo htmlspecialchars($post['name']); ?></a>
                              </span>
                              <span>
                                  <i class="fa fa-user" aria-hidden="true"></i>
                                  <a href='author.php?id=<?php echo htmlspecialchars($post['author']); ?>'><?php echo htmlspecialchars($post['username']); ?></a>
                              </span>
                              <span>
                                  <i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlspecialchars(date("F j, Y g:i A", strtotime($post['post_date']))); ?>
                              </span>
                          </div>
                          <p class="description"><?php echo htmlspecialchars(substr($post['description'], 0, 130)) . "..."; ?></p>
                          <a class='read-more pull-right' href='single.php?id=<?php echo htmlspecialchars($post['id']); ?>'>read more</a>
                      </div>
                  </div>
              </div>
          </div>

          <?php 
                endwhile;
                $count_result = selectAll(
                    'posts',
                    'LEFT JOIN categories ON posts.category = categories.id LEFT JOIN users ON posts.author = users.id',
                    'users.username LIKE ? OR posts.title LIKE ? OR posts.description LIKE ?',
                    $params,
                    'sss'
                );

                if ($count_result && $count_result->num_rows > $limit) {
                    $totalRecords = $count_result->num_rows;
                    $NoOfPage = ceil($totalRecords / $limit);
                    echo "<ul class='pagination admin-pagination'>";
                    
                    if ($page > 1) {
                        echo "<li><a href='?search=" . urlencode($search_term) . "&page=" . ($page - 1) . "'>Prev</a></li>";
                    }

                    for ($i = 1; $i <= $NoOfPage; $i++) {
                        $active = ($page == $i) ? "active" : "";
                        echo "<li class='{$active}'><a href='?search=" . urlencode($search_term) . "&page=$i'>$i</a></li>";
                    }

                    if ($page < $NoOfPage) {
                        echo "<li><a href='?search=" . urlencode($search_term) . "&page=" . ($page + 1) . "'>Next</a></li>";
                    }

                    echo "</ul>";
                }
            } else {
                echo "<h3 style='color:red;'>No post found. Thank you.</h3>";
            }
          }else{
            echo "<h3 style='color:red;'>Invalid Server Request. Thank you.</h3>";
          }
          ?>

        </div>
      </div>
      <?php include 'sidebar.php'; ?>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>

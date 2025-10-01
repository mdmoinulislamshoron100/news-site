<?php include 'header.php'; ?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="post-container">

                    <?php 
                        $limit = 4;
                        $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0
                                ? (int)$_GET['page']
                                : 1;
                        $offset = ( $page -1 ) * $limit;
                        $p = $offset .",". $limit;

                        $posts = selectAll(
                            'posts',
                            'LEFT JOIN categories ON posts.category = categories.id LEFT JOIN users ON posts.author = users.id',
                            '',
                            [],
                            '',
                            'posts.id, posts.title, posts.description, posts.post_date, posts.category, posts.author, posts.image, categories.name, users.username',
                            'posts.id DESC',
                            $p
                        );
                        if($posts && $posts->num_rows > 0){
                            foreach ($posts as $post):
                    ?>
                            <div class="post-content">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a class="post-img" href='single.php?id=<?php echo htmlspecialchars($post['id']); ?>'><img src="admin/upload/<?php echo htmlspecialchars($post['image']); ?>" alt="news picture"/></a>
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
                                                    <i class="fa fa-calendar me-2" aria-hidden="true"></i><?php echo htmlspecialchars(date("F j, Y g:i A", strtotime($post['post_date']))); ?></span>
                                            </div>
                                            <p class="description"> <?php echo htmlspecialchars(substr($post['description'],0,130). "..."); ?></p>
                                            <a class='read-more pull-right' href='single.php?id=<?php echo htmlspecialchars($post['id']); ?>'>read more</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    <?php 
                            endforeach;

                            $pagination = selectAll('posts');
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
                            echo "<h3 style='color:red;'>No post found. Thank you.</h3>";
                        }
                    ?>

                    </div>
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>

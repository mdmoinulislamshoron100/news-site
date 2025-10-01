<?php include 'header.php'; ?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="post-container">

                        <?php 
                        if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])){
                            $id = (int)$_GET['id'];
                        
                        $posts = selectAll(
                            'posts',
                            'LEFT JOIN categories ON posts.category = categories.id LEFT JOIN users ON posts.author = users.id',
                            'posts.id = ?',
                            [$id],
                            'i',
                            'posts.title, posts.description, posts.post_date, posts.image, posts.category, posts.author, categories.name, users.username',
                        );
                        if($posts && $posts->num_rows === 1){
                            $post = mysqli_fetch_assoc($posts);
                        ?>

                            <div class="post-content single-post">
                                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
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
                                        <i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlspecialchars(date("F j, Y g:i A", strtotime($post['post_date']))); ?></span>
                                </div>
                                <img class="single-feature-image" src="admin/upload/<?php echo htmlspecialchars($post['image']); ?>" alt=""/>
                                <p class="description"><?php echo htmlspecialchars($post['description']); ?></p>
                            </div>

                        <?php
                        }else{
                            echo "<h3 style='color:red;'>No post found.Invalid post ID. Thank you.</h3>";
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

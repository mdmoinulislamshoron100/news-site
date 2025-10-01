<div id="sidebar" class="col-md-4">
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method ="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit" name="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>

    <div class="recent-post-container">
        <h4>Recent Posts</h4>
    <?php 
        $posts = selectAll(
            'posts',
            'LEFT JOIN categories ON posts.category = categories.id',
            '',
            [],
            '',
            'posts.id, posts.title, posts.description, posts.post_date, posts.category, posts.image, categories.name',
            'posts.id DESC',
            3
        );
        if($posts && $posts->num_rows > 0){
            foreach ($posts as $post):
    ?>
        <div class="recent-post">
            <a class="post-img" href="single.php?id=<?php echo htmlspecialchars($post['id']); ?>"><img src="admin/upload/<?php echo htmlspecialchars($post['image']); ?>" alt="news picture"/></a>
            <div class="post-content">
                <h5><a href='single.php?id=<?php echo htmlspecialchars($post['id']); ?>'><?php echo htmlspecialchars($post['title']); ?></a></h5>
                <span>
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    <a href='category.php?id=<?php echo htmlspecialchars($post['category']); ?>'><?php echo htmlspecialchars($post['name']); ?></a>
                </span>
                <span>
                    <i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlspecialchars(date("F j, Y g:i A", strtotime($post['post_date']))); ?></span>
                </span>
                <a class="read-more" href='single.php?id=<?php echo htmlspecialchars($post['id']); ?>'>read more</a>
            </div>
        </div>
    <?php 
            endforeach;
        }else{
            echo "<h3 style='color:red;'>No post found. Thank you.</h3>";
        }
    ?>
    </div>
</div>

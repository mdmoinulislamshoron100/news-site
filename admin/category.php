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
                <h1 class="admin-heading">All Categories</h1>
            </div>

            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>

              <div class="col-md-12">
                <?php 
                    $limit = 5;
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0
                            ? (int)$_GET['page']
                            : 1;
                    
                    $offset = ( $page -1 ) * $limit;
                    $p = $offset .",". $limit;
                    $allcategory = selectAll('categories','','','','','*', 'id DESC', $p);
                    if($allcategory && $allcategory -> num_rows > 0){
                        ?>

                        <table class="content-table">
                            <thead>
                                <th>S.No.</th>
                                <th>Category Name</th>
                                <th>No. of Posts</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </thead>
                            <tbody>
                                <?php foreach($allcategory as $onecategory): ?>
                                <tr>
                                    <td class='id'><?php echo htmlspecialchars($onecategory['id']); ?></td>
                                    <td><?php echo htmlspecialchars($onecategory['name']); ?></td>
                                    <td><?php echo htmlspecialchars($onecategory['post']); ?></td>
                                    <td class='edit'><a href='update-category.php?id=<?php echo htmlspecialchars($onecategory['id']); ?>'><i class='fa fa-edit'></i></a></td>
                                    <td class='delete'><a href='delete-category.php?id=<?php echo htmlspecialchars($onecategory['id']); ?>'><i class='fa fa-trash-o'></i></a></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>

                        <?php
                        $pagination = selectAll('categories');
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
                        echo "<h4 style='text-align:center; color: red;'>No category found. Please Add Category. Thank you.</h4>";
                    }
                ?>
              </div>
              
        </div>
    </div>
</div>
<?php include "footer.php"; ?>

<?php 
    require __DIR__ . "/connection/configuration.php";
    $pagename = basename($_SERVER['PHP_SELF']);

    switch($pagename){
        case "search.php":
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $pageTitle = htmlspecialchars($_GET['search']);
            } else {
                $pageTitle = "Not found post";
            }
            break;
        case "single.php":
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $post=selectAll('posts', '', 'id = ?', [$id], 'i', 'title');
                if($post && $post->num_rows === 1){
                    $post_title = mysqli_fetch_assoc($post);
                    $pageTitle = $post_title['title'];
                }else{
                    $pageTitle = "Not found post";
                }
                
            }else{
                $pageTitle = "Not found post";
            }
            break;
        case "category.php";
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $category=selectAll('categories', '', 'id = ?', [$id], 'i', 'name');
                if($category && $category->num_rows === 1){
                    $category_name = mysqli_fetch_assoc($category);
                    $pageTitle = $category_name['name']. " News";
                }else{
                    $pageTitle = "Not found category";
                }
            }else{
                $pageTitle = "Not found post";
            }
            break;
        case "author.php";
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $author=selectAll('users', '', 'id = ?', [$id], 'i', 'username');
                if($author && $author->num_rows === 1){
                    $author_name = mysqli_fetch_assoc($author);
                    $pageTitle = $author_name['username'];
                }else{
                    $pageTitle = "Not found author";
                }

            }else{
                $pageTitle = "Not found post";
            }
            break;
        default:
            $pageTitle = "news.com";
            break;
    }
    $header_footer = selectAll('settings');
    $hfdata = mysqli_fetch_assoc($header_footer);
    $headers = $hfdata['header'];
    $footers = $hfdata['footer']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div id="header">
    <div class="container">
        <div class="row">
            <div class=" col-md-offset-4 col-md-4">
                <a href="index.php"><h2 style="color: white; font-family:Verdana, Geneva, Tahoma, sans-serif;"><?php echo $headers; ?></h2></a>
            </div>
        </div>
    </div>
</div>

<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class='menu'>
                    <?php 
                        $basename = basename($_SERVER['PHP_SELF']);
                    ?>
                    <li><a style="<?php echo ($basename == 'index.php') ? 'background-color:black;' : '' ?>" href='http://localhost/news.com/index.php'>Home</a></li>
                    <?php 
                    
                    $category = selectAll(
                        'categories',
                        '',
                        'post > ?',
                        [0],
                        'i',
                        'id,name'
                    );
                    if ($category && $category->num_rows > 0) {
                        while ($cat = $category->fetch_assoc()) {
                            $activecls = (isset($_GET['id']) && $_GET['id'] == $cat['id']) ? 'active' : '';
                            echo "<li><a class='{$activecls}' href='category.php?id={$cat['id']}'>" . htmlspecialchars($cat['name']) . "</a></li>";
                        }
                    } else {
                        echo "";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>


<?php 
    session_start();
    require __DIR__ . '/../connection/configuration.php';
    $settings = selectAll('settings');
    if($settings && $settings->num_rows === 1){
        $setting = mysqli_fetch_assoc($settings);
        $website_name = $setting['header'];
    }

    $basename = basename($_SERVER['PHP_SELF']);
    switch($basename){
        case "post.php":
            $page_title = "post.php";
            break;
        case "category.php":
            $page_title = "category.php";
            break;
        case "users.php":
            $page_title = "users.php";
            break;
        case "add-post.php":
            $page_title = "add-post.php";
            break;
        case "add-category.php":
            $page_title = "add-category.php";
            break;
        case "add-user.php":
            $page_title = "add-user.php";
            break;
        case "update-post.php":
            $page_title = "update-post.php";
            break;
        case "update-category.php":
            $page_title = "update-category.php";
            break;
        case "update-user.php":
            $page_title = "update-user.php";
            break;
        case "settings.php":
            $page_title = "settings.php";
            break;
        default:
            $page_title = "Not set";
            break;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ADMIN - <?php echo $page_title; ?></title>
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" href="../css/font-awesome.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div id="header-admin">
        <div class="container">
            <div class="row">

                <div class="col-xs-6 col-md-6">
                    <a href="post.php" style="color: white; text-decoration: none; font-size: 3rem;">
                        <?php echo htmlspecialchars($website_name); ?>
                    </a>
                </div>

                <div class="col-xs-6 col-md-6 text-right">
                    <a href="logout.php" class="admin-logout" style="color: white; text-decoration: none;">
                        <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </a>
                </div>

            </div>
        </div>
        </div>
        <div id="admin-menubar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            $basename = basename($_SERVER['PHP_SELF']);
                        ?>
                       <ul class="admin-menu">
                            <li>
                                <a href="post.php" style="<?php echo ($basename == 'post.php') ? 'background-color:black;' : '' ?>">Post</a>
                            </li>
                            <?php 
                                if (isset($_SESSION['role']) && $_SESSION['role'] === 1) {
                            ?>
                            <li>
                                <a href="category.php" style="<?php echo ($basename == 'category.php') ? 'background-color:black;' : '' ?>">Category</a>
                            </li>
                            <li>
                                <a href="users.php" style="<?php echo ($basename == 'users.php') ? 'background-color:black;' : '' ?>">Users</a>
                            </li>
                            <li>
                                <a href="settings.php" style="<?php echo ($basename == 'settings.php') ? 'background-color:black;' : '' ?>">Settings</a>
                            </li>
                            <?php } ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
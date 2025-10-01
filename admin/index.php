<?php 
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: http://localhost/news.com/admin/post.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADMIN | Login</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="font/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../css/style.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(135deg, #ff006a, #203a43, #36001cff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .body-content {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .form-container {
            background: #fff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }

        .heading {
            font-size: 28px;
            font-weight: bold;
            color: linear-gradient(to right, #203a43, #ff006a);
            margin-bottom: 30px;
        }

        .form-group label {
            color: #333;
            font-weight: 600;
        }

        .form-control {
            border-radius: 5px;
            height: 40px;
            font-size: 14px;
        }

        .btn-primary {
            background: linear-gradient(to right, #ff006a, #203a43);
            border: none;
            border-radius: 5px;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #203a43, #ff006a);
        }

        .text-danger {
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div id="wrapper-admin" class="body-content">
        <div class="form-container">
            <h3 class="heading text-center">Admin Login</h3>

            <?php 
                require __DIR__ . '/../connection/configuration.php';

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
                    $cleanData = filteration($_POST);
                    $username = $cleanData['username'];
                    $password = md5($cleanData['password']);

                    if(empty($username) || empty($password)){
                        echo "<p class='text-danger text-center'>Username and Password required.</p>";
                    }else{
                        $users = selectAll(
                            'users',
                            '',
                            'username = ? AND password = ?',
                            [$username, $password],
                            'ss',
                            'id, username, role'
                        );

                        if ($users && $users->num_rows === 1) {
                            $user = $users->fetch_assoc();

                            $_SESSION['loggedin'] = true;
                            $_SESSION['id'] = $user['id'];
                            $_SESSION['username'] = $user['username'];
                            $_SESSION['role'] = $user['role'];

                            header('Location: http://localhost/news.com/admin/post.php');
                            exit;
                        } else {
                            echo "<p class='text-danger text-center'>Username and Password does not match.</p>";
                        } 
                    }
                }
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <input type="submit" name="login" class="btn btn-primary" value="Login">
            </form>
            
        </div>
    </div>
</body>
</html>

<?php 
include "header.php";
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
              <div class="col-md-12">
                  <h1 class="admin-heading">Settings</h1>
              </div>

              <?php 
                if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])){
                    $cleanData = filteration($_POST);
                    $settings_id = $cleanData['set_id'];
                    $settings_header = $cleanData['header'];
                    $settings_footer = $cleanData['footer'];

                    if(empty($settings_header) || empty($settings_footer)){
                        echo "<h3 style='text-align:center; color: red;'>Input field not be empty. Thank you.</h3>";

                    }else{
                        $data = [
                            'header' => $settings_header,
                            'footer' => $settings_footer,
                        ];
                        $where = 'id = ?';
                        $params = [$settings_id];
                        if(update('settings', $data, $where, $params, 'ss' . 'i')){
                            header('Location: http://localhost/news.com/admin/post.php');
                            exit;
                        }else{
                            echo "<h4 style='text-align:center; color: red;'>Data not updated. Thank you.</h4>";
                        }
                    }
                }
              ?>

            <div class="col-md-offset-3 col-md-6">

                <?php 
                $settings = selectAll('settings');
                $data = mysqli_fetch_assoc($settings);
                $id = $data['id'];
                $header = $data['header'];
                $footer = $data['footer'];
                ?>

                <form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method ="POST" autocomplete="off">
                    <div class="form-group">
                        <label>News header</label>
                        <input type="hidden" name="set_id" value="<?php echo $id; ?>">
                        <input type="text" name="header" class="form-control" value="<?php echo $header; ?>" placeholder="Enter news header">
                    </div>
                        <div class="form-group">
                        <label>News footer</label>
                        <input type="text" name="footer" class="form-control" value="<?php echo $footer; ?>" placeholder="Enter news footer">
                    </div>
                    <input type="submit"  name="save" class="btn btn-primary" value="Save" required />
                </form>

            </div>

          </div>
      </div>
  </div>
<?php include "footer.php"; ?>

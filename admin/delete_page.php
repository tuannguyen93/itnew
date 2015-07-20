<?php $title= 'Xóa bài viết'; include('../includes/header.php');?>
<?php include('../includes/mysqli_connect.php');?>
<?php include('../includes/functions.php');?>
<?php include('../includes/sidebar-admin.php'); ?>
<div id="content">
    <?php 
        //Kiểm tra xem đang nhập rồi mà có phải là admin hay không?
        admin_access(); 
        
        if(isset($_GET['pid'], $_GET['page_name']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {            
            $pid = $_GET['pid'];
            $page_name = $_GET['page_name'];
            
            //Nếu pid và cat_name tồn tại thì xóa bài viết trong CSDL
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if(isset($_POST['delete']) && ($_POST['delete'] == 'yes')) {
                    $q = "DELETE FROM pages WHERE page_id = {$pid} LIMIT 1";
                    $r = mysqli_query($dbc, $q);
                    confirm_query($r, $q);
                    
                    if(mysqli_affected_rows($dbc) == 1) {
                        $messages = '<p class="success">Đã xóa bài viết thành công.</p>';
                    } else {
                        $messages = '<p class="error">Không thể xóa bài viết vì lỗi hệ thống.</p>';
                    }
                } else {
                    $messages = '<p class="success">Không xóa bất kỳ bài viết nào.</p>';
                }//End $_POST['delete'] == 'YES'
            }//End $_SERVER['REQUEST_METHOD'] == 'POST'
        } else {
            //Không tồn tại pid hoặc page_name
            redirect_to('admin/view_categories.php');
        }
        
        
    ?>
    <h2> Xóa bài viết: <?php if(isset($page_name)) echo htmlentities($page_name, ENT_COMPAT, 'UTF-8') ?></h2> 
    <?php if(!empty($messages)) echo $messages; ?>
	   <form action="" method="post">
       <fieldset>
            <legend>Xóa bìa viết</legend>
                <label for="delete">Xóa bài viết?</label>
                <div>
                    <input type="radio" name="delete" value="no" checked="checked" /> No
                    <input type="radio" name="delete" value="yes" /> Yes
                </div>
                <div><input type="submit" name="submit" value="Delete" onclick="return confirm('Xóa bài viết?');" /></div>
        </fieldset>
       </form>
</div><!--end content-->

<?php include('../includes/footer.php'); ?>
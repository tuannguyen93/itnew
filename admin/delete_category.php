<?php $title= 'Xóa danh mục'; include('../includes/header.php');?>
<?php include('../includes/mysqli_connect.php');?>
<?php include('../includes/functions.php');?>
<?php include('../includes/sidebar-admin.php'); ?>
<div id="content">
    <?php 
        //Kiểm tra xem đang nhập rồi mà có phải là admin hay không?
        admin_access(); 
        
        if(isset($_GET['cid'], $_GET['cat_name']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {            
            $cid = $_GET['cid'];
            $cat_name = $_GET['cat_name'];
            
            //Nếu cid và cat_name tồn tại thì xóa category trong CSDL
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if(isset($_POST['delete']) && ($_POST['delete'] == 'yes')) {
                    $q = "DELETE FROM categories WHERE cat_id = {$cid} LIMIT 1";
                    $r = mysqli_query($dbc, $q);
                    confirm_query($r, $q);
                    
                    if(mysqli_affected_rows($dbc) == 1) {
                        $messages = '<p class="success">Đã xóa danh mục thành công.</p>';
                    } else {
                        $messages = '<p class="error">Không thể xóa danh mục vì lỗi hệ thống.</p>';
                    }
                } else {
                    $messages = '<p class="success">Không xóa bất kỳ danh mục nào.</p>';
                }//End $_POST['delete'] == 'YES'
            }//End $_SERVER['REQUEST_METHOD'] == 'POST'
        } else {
            //Không tồn tại cid hoặc cat_name
            redirect_to('admin/view_categories.php');
        }
        
        
    ?>
    <h2> Xóa danh mục: <?php if(isset($cat_name)) echo htmlentities($cat_name, ENT_COMPAT, 'UTF-8') ?></h2> 
    <?php if(!empty($messages)) echo $messages; ?>
	   <form action="" method="post">
       <fieldset>
            <legend>Xóa danh mục</legend>
                <label for="delete">Xóa danh mục?</label>
                <div>
                    <input type="radio" name="delete" value="no" checked="checked" /> No
                    <input type="radio" name="delete" value="yes" /> Yes
                </div>
                <div><input type="submit" name="submit" value="Delete" onclick="return confirm('Xóa danh mục?');" /></div>
        </fieldset>
       </form>
</div><!--end content-->

<?php include('../includes/footer.php'); ?>
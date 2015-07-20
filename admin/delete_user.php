<?php $title= 'Xóa thành viên'; include('../includes/header.php');?>
<?php include('../includes/mysqli_connect.php');?>
<?php include('../includes/functions.php');?>
<?php include('../includes/sidebar-admin.php'); ?>
<div id="content">
    <?php 
        //Kiểm tra xem đang nhập rồi mà có phải là admin hay không?
        admin_access(); 
        
        if(isset($_GET['uid'], $_GET['user_name']) && filter_var($_GET['uid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {            
            $uid = $_GET['uid'];
            $user_name = $_GET['user_name'];
            
            //Nếu uid và user_name tồn tại thì xóa category trong CSDL
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                if(isset($_POST['delete']) && ($_POST['delete'] == 'yes')) {
                    $q = "DELETE FROM users WHERE user_id = {$uid} LIMIT 1";
                    $r = mysqli_query($dbc, $q);
                    confirm_query($r, $q);
                    
                    if(mysqli_affected_rows($dbc) == 1) {
                        $messages = '<p class="success">Đã xóa thành viên thành công.</p>';
                    } else {
                        $messages = '<p class="error">Không thể xóa thành viên vì lỗi hệ thống.</p>';
                    }
                } else {
                    $messages = '<p class="success">Không xóa bất kỳ thành viên nào.</p>';
                }//End $_POST['delete'] == 'YES'
            }//End $_SERVER['REQUEST_METHOD'] == 'POST'
        } else {
            //Không tồn tại uid hoặc user_name
            redirect_to('admin/manage_users.php');
        }
        
        
    ?>
    <h2> Xóa thành viên: <?php if(isset($user_name)) echo htmlentities($user_name, ENT_COMPAT, 'UTF-8') ?></h2> 
    <?php if(!empty($messages)) echo $messages; ?>
	   <form action="" method="post">
       <fieldset>
            <legend>Xóa thành viên</legend>
                <label for="delete">Xóa thành viên?</label>
                <div>
                    <input type="radio" name="delete" value="no" checked="checked" /> No
                    <input type="radio" name="delete" value="yes" /> Yes
                </div>
                <div><input type="submit" name="submit" value="Delete" onclick="return confirm('Xóa thành viên?');" /></div>
        </fieldset>
       </form>
</div><!--end content-->

<?php include('../includes/footer.php'); ?>
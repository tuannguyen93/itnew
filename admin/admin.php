<?php $title= 'Trang quản trị'; include('../includes/header.php');?>
<?php include('../includes/mysqli_connect.php');?>
<?php include('../includes/functions.php');?>
<?php include('../includes/sidebar-admin.php'); 
        //Kiểm tra xem đang nhập rồi mà có phải là admin hay không?
        admin_access(); 
?>
<div id="content">

    <h2>Chào mừng bạn đến Hệ thống quản lý dữ liệu của ITnews </h2>
    <div>
        <p>
           Chào mừng bạn đến với trang quản lý của ITnews. Bạn có thể thêm, xóa và chỉnh sửa bài viết ở đây.
        </p>
    </div>

</div><!--end content-->
<?php include('../includes/footer.php'); ?>
<?php $title = 'Lot Out'; include('includes/header.php');?>
<?php include('includes/mysqli_connect.php');?>
<?php include('includes/functions.php');?>
<?php include('includes/sidebar-a.php'); ?>
<div id="content">
    <?php 
        if(!isset($_SESSION['last_name'])) {
            // Nếu chưa đăng nhập thì chuyển người dùng về trang index.php
            redirect_to();
        } else {
            // Nếu đã đăng nhập thì tiến hành xóa SESSION
            $_SESSION = array(); // Xóa SESSION bằng cách đặt SESSSION là 1 array trống
            session_destroy(); // Hủy SESSION đã tạo
            setcookie(session_name(),'', time()-36000); // Xóa luôn cookie cho chắc cú
        } 
        echo "<h2 class='success'>Bạn đã đăng xuất thành công</h2>";
    ?>
</div><!--end content-->
<?php include('includes/sidebar-b.php');?>
<?php include('includes/footer.php'); ?>


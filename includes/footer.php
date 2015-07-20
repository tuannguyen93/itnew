
<div class="clear"></div>
<div id="footer">
    <ul class="footer-links">
       <?php 
       
        if(isset($_SESSION['user_level'])) {
            // Nếu có SESSION
            switch($_SESSION['user_level']) {
                case 0: // Người dùng đã đăng ký
                echo "
                    <li><a href='".BASE_URL."edit_profile.php'>Thông tin người dùng</a></li>
                    <li><a href='".BASE_URL."change_password.php'>Đổi mật khẩu</a></li>
                    <li><a href='".BASE_URL."logout.php'>Đăng xuất</a></li>
                ";
                break;
                
                case 1: // Admin
                echo "
                    <li><a href='".BASE_URL."edit_profile.php'>Thông tin người dùng</a></li>
                    <li><a href='".BASE_URL."change_password.php'>Đổi mật khẩu</a></li>
                    <li><a href='".BASE_URL."admin/admin.php'>Admin CP</a></li>
                    <li><a href='".BASE_URL."logout.php'>Đăng xuất</a></li>
                ";
                break;
                
                default://Người dùng chưa đưang ký
                echo "
                    <li><a href='".BASE_URL."'>Trang chủ</a></li>
                    <li><a href='".BASE_URL."register.php'>Đăng ký</a></li>
                    <li><a href='".BASE_URL."login.php'>Đăng nhập</a></li>
                ";
                break;
                
            }
            
        } else {
            // Không có SESSION
            echo "
                    <li><a href='".BASE_URL."'>Trang chủ</a></li>
                    <li><a href='".BASE_URL."register.php'>Đăng ký</a></li>
                    <li><a href='".BASE_URL."login.php'>Đăng nhập</a></li>
                ";
        }
       ?>
    </ul>
</div> <!--end container-->
</div> <!-- end content-container-->
</body>
</html>
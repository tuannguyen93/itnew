<?php $title = 'Đổi mật khẩu'; include('includes/header.php');?>
<?php include('includes/mysqli_connect.php');?>
<?php include('includes/functions.php');?>
<?php include('includes/sidebar-a.php'); ?>
<div id="content">
    <?php 
        // Kiểm tra xem người dùng log in chưa? Chưa thì đưa về trăng đăng nhập
        is_logged_in();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tạo biến chứa lỗi
            $errors = array();
            
            // Kiểm tra mật khẩu hiện tại hợp lệ hay không?
            if(isset($_POST['cur_password']) && preg_match('/^\w{4,20}$/', trim($_POST['cur_password']))) {
                    $cur_password = mysqli_real_escape_string($dbc,trim($_POST['cur_password']));
                    
                // Lấy mật khẩu trong cơ sở dữ liệu ra so sánh
                $q = "SELECT first_name FROM users WHERE pass = SHA1('$cur_password') AND user_id = {$_SESSION['uid']}";
                $r = mysqli_query($dbc, $q); confirm_query($r, $q);
                
                // Có giá trị trả về thì xử lý
                if(mysqli_num_rows($r) == 1) {
                    
                    //Kiểm tra mật khẩu 1 có hợp lệ không
                    if(isset($_POST['password1']) && preg_match('/^\w{4,20}$/', trim($_POST['password1']))) {
                        
                            //Kiểm tra mật khẩu 2 có bằng mật khẩu 1 không
                            if($_POST['password1'] == $_POST['password2']) {
                                $np = mysqli_real_escape_string($dbc, trim($_POST['password1']));
                                
                                //Thỏa mãn các yêu cầu hết rồi thì update vào CSDL
                                $q = "UPDATE users SET pass = SHA1('$np') WHERE user_id = {$_SESSION['uid']} LIMIT 1";
                                $r = mysqli_query($dbc, $q); confirm_query($r, $q);
                                
                                if(mysqli_affected_rows($dbc) == 1) {
                                    // Update thành công
                                    $message = "<p class='success'>Mật khẩu của bạn đã thay đổi thành công.</p>";
                                } else {
                                    // Không thành công
                                    $errors[] = "<p class='error'>Bạn chưa thể thay đổi mật khẩu do có lỗi hệ thống.</p>";
                                }
                                
                            } else {
                                // Hai cái mật khẩu khác nhau
                                $errors[] = "<p class='error>Mật khẩu bạn nhập vào không khớp với nhau</p>";
                            }
                        
                        } else {
                            // Mạt khẩu không hợp lệ
                            $errors[] = "<p class='error'>Mật khẩu của bạn quá ngắn, quá dài hoặc chứa ký tự không cho phép.</p>";
                        }
                        
                } else {
                    //Mật khẩu hiện tại không trùng với CSDL
                    $errors[] = "<p class='error'>Mật khẩu hiện tại bạn nhập vào không đúng. Hãy chắc là bạn đã tắt CapsLock.</p>";
                }
            } else {
                // Mật khẩu hiện tại của bạn nhập vào không đúng định dạng.
                $errors[] = "<p class='error'>Mật khẩu hiện tại của bạn nhập vào không đúng định dạng, quá ngắn hoặc quá dài.</p>";
            }
        } // END main IF
    ?>
    <h2>Đổi mật khẩu</h2>
    <?php if(isset($message)) echo $message; if(isset($errors)) {report_error($errors);}?>
    
    <form action="" method="post">          
        <fieldset>
    		<legend>Đổi mật khẩu</legend>
            <div>
                <label for="Current Password">Mật khẩu hiện tại</label> 
                <input type="password" name="cur_password" value="" size="20" maxlength="40" tabindex='1' />
            </div>
    
    		<div>
                <label for="New Password">Mật khẩu mới</label> 
                <input type="password" name="password1" value="" size="20" maxlength="40" tabindex='2' />
            </div>
            
            <div>
                <label for="Confirm Password">Xác nhận mật khẩu mới</label> 
                <input type="password" name="password2" value="" size="20" maxlength="40" tabindex='3' />
            </div>
    	</fieldset>
     <div><input type="submit" name="submit" value="Đổi mật khẩu" tabindex='4' /></div>
    </form>
</div><!--end content-->
<?php include('includes/sidebar-b.php');?>
<?php include('includes/footer.php'); ?>


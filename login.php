<?php $title = 'Ðăng nhập'; include('includes/header.php');?>
<?php include('includes/mysqli_connect.php');?>
<?php include('includes/functions.php');?>
<?php include('includes/sidebar-a.php'); ?>
<div id="content">
    <?php 
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Tạo biến chứa lỗi
        $errors = array();
        
        // Kiểm tra email có hợp lệ không
        if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $e = mysqli_real_escape_string($dbc, $_POST['email']); 
        } else {
            $errors[] = 'email';
        }
        
        // Kiểm tra mật khẩu có hợ lệ không
        if(isset($_POST['password']) && preg_match('/^[\w]{4,20}$/', $_POST['password'])) {
            $p = mysqli_real_escape_string($dbc, $_POST['password']);
        } else {
            $errors[] = 'password';
        }
        if(empty($errors)) {
            // Nếu không có lỗi thì lấy ra dữ liệu người dùng đăng nhập
            $q = "SELECT user_id, last_name, user_level FROM users WHERE (email = '{$e}' AND pass = SHA1('$p')) AND active IS NULL LIMIT 1";
            $r = mysqli_query($dbc, $q); confirm_query($r, $q);
            if(mysqli_num_rows($r) == 1) {
                session_regenerate_id();
                // Chuyển hướng người dùng đến trang thích hợp
                list($uid, $last_name, $user_level) = mysqli_fetch_array($r, MYSQLI_NUM);
                $_SESSION['uid'] = $uid;
                $_SESSION['last_name'] = $last_name;
                $_SESSION['user_level'] = $user_level;
                                
                redirect_to();
            } else {
                $message = "<p class='error'>Mật khẩu hay email không chính xác</p>";
            }
        } else {
            $message = "<p class='error'>Bạn phải điền các trường hợp lệ </p>";
        }
    
    } // END MAIN IF
    ?>
    
<div id="content">
	<h2>Đăng nhập</h2>
    <?php if(!empty($message)) echo $message; ?>
    <form id="login" action="" method="post">
        <fieldset>
        	<legend>Đăng nhập</legend>
            	<div>
                    <label for="email">Email
                        <?php if(isset($errors) && in_array('email',$errors)) echo "<span class='warning'>Bạn phải điền email hợp lệ</span>";?>
                    </label>
                    <input type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) {echo htmlentities($_POST['email']);} ?>" size="20" maxlength="80" tabindex="1" />
                </div>
                <div>
                    <label for="pass">Mật khẩu
                        <?php if(isset($errors) && in_array('password',$errors)) echo "<span class='warning'>Bạn phải điền mật khẩu hợp lệ</span>";?>
                    </label>
             <input type="password" name="password" id="pass" value="" size="20" maxlength="20" tabindex="2" />
                </div>
        </fieldset>
        <div><input type="submit" name="submit" value="Đăng nhập" /></div>
    </form>
    <p><a href="retrieve_password.php">Quên mật khẩu?</a></p>
 </div><!--end content-->

</div><!--end content-->
<?php include('includes/sidebar-b.php');?>
<?php include('includes/footer.php'); ?>
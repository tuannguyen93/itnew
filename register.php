<?php $title = 'Đăng ký'; include('includes/header.php');?>
<?php include('includes/mysqli_connect.php');?>
<?php include('includes/functions.php');?>
<?php include('includes/sidebar-a.php'); ?>
<div id="content">
    <?php 
        require_once('includes/recaptchalib.php');
         if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tạo biến chứa lỗi
            $errors = array();
            // Đặt mặc định các giá trị là FALSE
            $fn = $ln = $e = $p = $qs = FALSE;
            
            //Kiểm tra first name
            if(!empty($_POST['first_name'])) {
                $fn = mysqli_real_escape_string($dbc,trim(strip_tags($_POST['first_name'])));
            } else {
                $errors[] = 'first name';                
            }
            
            //Kiểm tra last name
            if(!empty($_POST['last_name'])) {
                $ln = mysqli_real_escape_string($dbc,trim(strip_tags($_POST['last_name'])));
            } else {
                $errors[] = 'first name';                
            }
            
            //Kiểm tra email nhập vào có hợp lệ 
            if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $e = mysqli_real_escape_string($dbc, $_POST['email']);
            } else {
                $errors[] = 'email';
            }
            
            //Kiểm tra xem độ dài, các ký tự nhập vào có hợp lệ, 2 mật khẩu có khớp
            if(preg_match('/^[\w\'.-]{4,20}$/', trim($_POST['password1']))) {
                if($_POST['password1'] == $_POST['password2']) {
                    // Hai mật khẩu khớp thì lưu lại để lưu vào CSDL
                    $p = mysqli_real_escape_string($dbc, trim($_POST['password1']));
                } else {
                    //Nếu mật khẩu không giống nay
                    $errors[] = "password_not_match";
                }
            } else {
                //Mật khẩu 1 nhập vào không phù hợp
                $errors[] = 'password';
            }//End (preg_match('/^[\w\'.-]{4,20}$/', trim($_POST['password1']))
            
             //Kiểm tra xem độ dài, các ký tự nhập vào có hợp lệ 
            if(preg_match('/^[\w\'.-]{2,20}$/i', trim($_POST['question_security']))) {
                $qs = mysqli_real_escape_string($dbc, trim($_POST['question_security']));
            } else {
                $errors[] = 'question_security';
            }
            
            
            if($fn && $ln && $e && $p && $qs) {
                // Nếu các trường đều hợp lệ thì lấy email ra so sánh xem đã tồn tại email nhập vào chưa?
                $q = "SELECT user_id FROM users WHERE email = '{$e}'";
                $r = mysqli_query($dbc, $q);
                confirm_query($r, $q);
                if(mysqli_num_rows($r) == 0) {
                    // Email còn trống, tạo chuỗi active
                    
                    // Chèn giá trị vào CSDL
                    $q = "INSERT INTO users (first_name, last_name, email, pass, question_security, registration_date)
                        VALUES ('{$fn}', '{$ln}', '{$e}', SHA1('$p'), SHA1('{$qs}'), NOW())";
                    $r = mysqli_query($dbc, $q);
                    confirm_query($r, $q);
                    
                    if(mysqli_affected_rows($dbc) == 1) {
                        // Ghi dữ liệu vào CSDL thành công
                            $message = "<p class='success'>Tài khoản của bạn đã được đăng ký thành công. Bạn đã có thể đăng nhập</p>";
                    } else {
                        $message = "<p class='warning'>Đã có lỗi xảy ra. Rất xin lỗi vì sự bất tiện này.</p>";
                    }
                    
                } else {
                    // Email đã tồn tại
                    $retrieve_pass = BASE_URL. "retrieve_password.php";
                    $message = "<p class='warning'>Email đã được sử dụng. Nếu bạn quên mật khẩu, hãy click vào <a href='".$retrieve_pass."'>ĐÂY</a>!!!</p>";
                }
            } else {
                // Có ít nhất 1 trường bị thiếu
                $message = "<p class='warning'>Bạn phải điền giá trị hợp lệ vào tất cả các trường bên dưới.</p>";
            }
         }//End main IF
    ?>
    
    <h2>Đăng ký</h2>
    <?php if(isset($message)) echo $message; ?>
    <form action="register.php" method="post">
        <fieldset>
       	    <legend>Đăng ký tài khoản</legend>
                <div>
                    <label for="First Name">Họ <span class="required">*</span>
                        <?php if(isset($errors) && in_array('first name', $errors)) echo "<span class='warning'>Bạn phải nhập giá trị <Họ> hợp lệ</span>"; ?>
                    </label> 
    	           <input type="text" name="first_name" size="20" maxlength="20" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name']; ?>" tabindex='1' />
                </div>
                
                <div>
                    <label for="Last Name">Tên <span class="required">*</span>
                    <?php if(isset($errors) && in_array('last name', $errors)) echo "<span class='warning'>Bạn phải nhập giá trị <Tên> hợp lệ</span>"; ?>
                    </label> 
    	           <input type="text" name="last_name" size="20" maxlength="40" value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name']; ?>" tabindex='2' />
                </div>
                
                <div>
                    <label for="email">Email <span class="required">*</span>
                    <?php if(isset($errors) && in_array('email', $errors)) echo "<span class='warning'>Bạn phải nhập giá trị <Email> hợp lệ</span>"; ?>
                    </label> 
    	           <input type="text" name="email" id="email" size="20" maxlength="80" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email'], ENT_COMPAT, 'UTF-8'); ?>" tabindex='3' />
                    <span id="available"></span>
                </div>
                
                <div>
                    <label for="password">Mật khẩu <span class="required">*</span>
                    <?php if(isset($errors) && in_array('password', $errors)) echo "<span class='warning'>Bạn phải nhập giá trị <Mật khẩu> hợp lệ</span>"; ?>
                    </label> 
    	           <input type="password" name="password1" size="20" maxlength="20" value="<?php if(isset($_POST['password1'])) echo $_POST['password1']; ?>" tabindex='4' />
                </div>
                
                <div>
                    <label for="email">Xác nhận mật khẩu <span class="required">*</span> 
                    <?php if(isset($errors) && in_array('password_not_match', $errors)) echo "<span class='warning'>Hai mật khẩu của bạn không khớp</span>"; ?>
                    </label> 
    	           <input type="password" name="password2" size="20" maxlength="20" value="<?php if(isset($_POST['password12'])) echo $_POST['password2']; ?>" tabindex='5' />
                </div>
                
                <div>
                    <label for="email">Câu hỏi bảo mật: Tên người mà bạn ghét nhất? <span class="required">*</span> 
                    <?php if(isset($errors) && in_array('question_security', $errors)) echo "<span class='warning'>Bạn phải điển câu hỏi bảo mật</span>"; ?>
                    </label> 
    	           <input type="text" name="question_security" size="20" maxlength="20" value="<?php if(isset($_POST['question_security'])) echo $_POST['question_security']; ?>" tabindex='6' />
                </div>
                
               
        </fieldset>
        <p><input type="submit" name="submit" value="Register" /></p>
    </form>
</div><!--end content-->
<?php include('includes/sidebar-b.php');?>
<?php include('includes/footer.php'); ?>


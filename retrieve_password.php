<?php $title = 'Quên mật khẩu'; include('includes/header.php');?>
<?php include('includes/mysqli_connect.php');?>
<?php include('includes/functions.php');?>
<?php include('includes/sidebar-a.php'); ?>
<div id="content">
    <?php 
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $uid = FALSE; 
            $errors = array();
            
            //Kiểm tra email có hợp lệ hay không
            if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $e = mysqli_real_escape_string($dbc, $_POST['email']);
                $question_security = mysqli_real_escape_string($dbc,$_POST['question_security']);
                
                // Kiểm tra email xem có tồn tại trong CSDL chưa, câu hỏi bảo mật có đúng không
                $q = "SELECT user_id FROM users WHERE email = '{$e}' AND question_security = SHA1('{$question_security}')";
                $r = mysqli_query($dbc, $q); confirm_query($r, $q);
                if(mysqli_num_rows($r) == 1) {
                    // Tìm được email thì lwuu lại
                    list($uid) = mysqli_fetch_array($r, MYSQLI_NUM);
                }
            } else {
                // Không điền điền email
                $errors[] = "<p class='error'>Bạn phải nhập email và câu hỏi bảo mật hợp lệ</p>";
            }
            
            if($uid) {
                // Có email thì chuẩn bị mật khẩu mới để update lại.
                $temp_pass = substr(md5(uniqid(rand(), true)), 3, 6);
                
                // Update CSDL với password mới.
                $q = "UPDATE users SET pass = SHA1('$temp_pass') WHERE user_id = {$uid} LIMIT 1";
                $r = mysqli_query($dbc, $q); confirm_query($r, $q);
                if(mysqli_affected_rows($dbc) == 1) {
                    // Update thành công thì hiển thị mật khẩu mới cho người dùng.
                    $message = "<p class='success'>Mật khẩu mới của bạn là:   $temp_pass  <p.";
                } else {
                    //Lỗi hệ thống
                    $message = "<p class='error'>Mật khẩu của bạn không thể đổi do lỗi hệ thống. Vui lòng kiểm tra lại.</p>";
                }
            } else {
                //Email không tồn tại
                $errors[] = "<p class='error'>Email không tồn tại hoặc câu hỏi bảo mật sai.<p>";
            }
        } // END main IF
    ?>
<h2>Quên mật khẩu</h2>
<?php if(isset($message)) echo $message; if(isset($errors)) {report_error($errors);}?>
<form id="login" action="" method="post">
    <fieldset>
    	<legend>Đổi mật khẩu mới</legend>
    	<div>
            <label for="email">Email: </label> 
            <input type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) {echo htmlentities($_POST['email']);} ?>" size="40" maxlength="80" tabindex="1" />
        </div>
        
        <div>
            <label for="email">Câu hỏi bảo mật: Tên người mà bạn ghét nhất? <span class="required">*</span></label> 
            <input type="text" name="question_security" size="20" maxlength="20" value="<?php if(isset($_POST['question_security'])) echo $_POST['question_security']; ?>" tabindex='6' />
        </div>
    </fieldset>
    <div><input type="submit" name="submit" value="Đổi mật khẩu" /></div>
</form>
</div><!--end content-->
<?php include('includes/sidebar-b.php');?>
<?php include('includes/footer.php'); ?>


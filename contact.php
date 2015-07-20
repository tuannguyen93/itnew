<?php $title = 'Liên hệ với chúng tôi'; include('includes/header.php');?>
<?php include('includes/mysqli_connect.php');?>
<?php include('includes/functions.php');?>
<?php include('includes/sidebar-a.php'); ?>
<?php include('includes/recaptchalib.php');?>
<div id="content">
    <?php 
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tạo biến chứa lỗi
            $errors = array();
            
            // Kiểm tra trường nhập tên
            if(empty($_POST['name'])) {
                $errors[] = 'name';
            }
            
            //Kiểm tra email có hợp lệ không
            if(!preg_match('/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/', $_POST['email'])) {
                $errors[] = 'email';
            }
            
            // Kiểm tra tin nhắn có để trống hay không
            if(empty($_POST['comment'])) {
                $errors[] = 'comment';
            }
            
            //Nhập captcha
            $privatekey = "6Lf-e9oSAAAAAPZy1LTJNkbW4ZutnUEmMGZWKX3i ";
                $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
        
            if (!$resp->is_valid) {
            // Khi nhập sai captcha
            $errors[] = 'captcha';
      }
            
            //Nếu không có lỗi thì gửi email
            if(empty($errors)) {
                $body = "Name: {$_POST['name']} \n\n Comment:\n ". strip_tags($_POST['comment']);
                $body = wordwrap($body, 70);
                if(mail('nhmtuan93@gmail.com', 'Biểu mẫu liên hệ', $body, 'FROM: localhost@localhost')) {
                    echo "<p class='success'>Cảm ơn bạn đã liên lạc với chúng tôi.</p>";
                    $_POST = array();
                } else {
                    echo "<p class='error'>Xin lỗi vì sự bất tiện. Email của bạn vẫn chưa được gửi. Vui lòng kiểm tra lại.</p>";
                }
                
            } else {
                // Nếu có lỗi thì hiển thị thông báo
                echo "<p class='warning'>Bạn phải nhập giá trị hợp lệ cho các trường</p>";
            }
        } // END Main submit if
    ?>
    
<form id="contact" action="" method="post">
    <fieldset>
    	<legend>Contact</legend>
            <div>
                <label for="Name">Tên của bạn <span class="required">*</span>
                    <?php if(isset($errors) && in_array('name',$errors)) { echo "<span class='warning'>Bạn phải nhập giá trị <Tên> hợp lệ</span>";}?>
                </label>
                <input type="text" name="name" id="name" value="<?php if(isset($_POST['name'])) {echo htmlentities($_POST['name'], ENT_COMPAT, 'UTF-8');} ?>" size="20" maxlength="80" tabindex="1" />
            </div>
        	<div>
                <label for="email">Email <span class="required">*</span>
                <?php if(isset($errors) && in_array('email',$errors)) {echo "<span class='warning'>Bạn phải nhập giá trị <Email> hợp lệ</span>";} ?>
                </label>
                <input type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) {echo htmlentities($_POST['email'], ENT_COMPAT, 'UTF-8');} ?>" size="20" maxlength="80" tabindex="2" />
            </div>
            <div>
                <label for="comment">Tin nhắn của bạn <span class="required">*</span>
                    <?php if(isset($errors) && in_array('comment',$errors)) {echo "<span class='warning'> Bạn không được để trống phần Tin nhắn</span>";} ?>
                </label>
                <div id="comment"><textarea name="comment" rows="10" cols="45" tabindex="3"><?php if(isset($_POST['comment'])) {echo htmlentities($_POST['comment'], ENT_COMPAT, 'UTF-8');} ?></textarea></div>
            </div>
            <div>
                <label>Điền vào ô reCaptcha
                <?php if(isset($errors) && in_array('sai captcha',$errors)) {echo "<span class='warning'>Bạn phải nhập đúng giá trị trong hình</span>";}?></label>
                </label>
                <?php
                    $publickey = "6Lf-e9oSAAAAAAL43oMxzaLMOC0aTKait1v-dhAk";
                    echo recaptcha_get_html($publickey);
                ?>
            </div>
           
    </fieldset>
    <div><input type="submit" name="submit" value="Gửi Email" tabindex="3" /></div>
</form>
</div><!--end content-->
<?php include('includes/sidebar-b.php');?>
<?php include('includes/footer.php'); ?>
<?php $title = 'Thông tin người dùng'; include('includes/header.php');?>
<?php include('includes/mysqli_connect.php');?>
<?php include('includes/functions.php');?>
<?php include('includes/sidebar-a.php'); 
	// Kiểm tra người dùng login chưa?
	is_logged_in();
?>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    //Tạo biến chứa lỗi
    $errors = array();
    
    // Cắt các khoảng trống trong thông tin nhập vào
    $trimmed = array_map('trim', $_POST);
    
    //Kiểm tra kiểm mới, dài 2-10 ký tự, không cho phép dùng các ký tự đặc biệt
    if(preg_match('/^[\w]{2,10}$/i', $trimmed['first_name'])) {
        $fn = $trimmed['first_name'];
    } else {
        $errors[] = "first_name";
    }
    
    //Kiểm tra kiểm mới, dài 2-10 ký tự, không cho phép dùng các ký tự đặc biệt
    if(preg_match('/^[\w]{2,10}$/i', $trimmed['last_name'])) {
        $ln = $trimmed['last_name'];
    } else {
        $errors[] = "last_name";
    }
    
    //Kiểm tra kiểm mới, dài 2-10 ký tự, không cho phép dùng các ký tự đặc biệt
    if(filter_var($trimmed['email'],FILTER_VALIDATE_EMAIL)) {
        $e = $trimmed['email'];
    } else {
        $errors[] = "email";
    }
    // Kiểm tra có tồn tại thì show ra - không bắt buộc
    $web = (!empty($trimmed['website'])) ? $trimmed['website'] : NULL;
    
    // Kiểm tra có tồn tại thì show ra - không bắt buộc
    $facebook = (!empty($trimmed['facebook'])) ? $trimmed['facebook'] : NULL;
    
    // Kiểm tra có tồn tại thì show ra - không bắt buộc
    $bio = (!empty($trimmed['bio'])) ? $trimmed['bio'] : NULL;
    
    //Kết nỗi lấy dữ liệu kiểu mới
    if(empty($errors)) {
        $q = "UPDATE users SET
            first_name = ?, last_name = ?, email = ?, website = ?, facebook = ?, bio = ?
            WHERE user_id = ?
            LIMIT 1";
        $stmt = mysqli_prepare($dbc, $q);
        mysqli_stmt_bind_param($stmt, 'ssssssi', $fn, $ln, $e, $web, $facebook, $bio, $_SESSION['uid']);
        mysqli_stmt_execute($stmt) or die("MySQL Error: $q" . mysqli_stmt_error($stmt));

        if(mysqli_stmt_affected_rows($stmt) > 0) {
            // Cập nhật thành công
            $message = "<p class='success'>Thông tin của bạn đã được cập nhật thành công.</p>";
        } else {
            // Có lỗi xảy ra
            $message[] = "<p class='error'>Thông tin của bạn chưa được cập nhật do lỗi hệ thống xảy ra.</p>";
        }
    }
          
}// END $_SERVER IF


?>
<div id="content">
    <?php if(!empty($message)) echo $message; ?>
<h2>User Profile</h2>
    <?php 
        // Truy xauast CSL đê hiên thị thông tin người dùng
        $user = fetch_user($_SESSION['uid']);
    ?>

<form enctype="multipart/form-data" action="avatar.php" method="post"> 
    <fieldset>
		<legend>Avatar</legend>
		<div>
            <img class="avatar" src="uploads/images/<?php echo (is_null($user['avatar']) ? "no_avatar.jpg" : $user['avatar']); ?>" alt="avatar" />
            <p>Bạn hãy chọn file JPEG hoặc PNG dung lượng nhỏ hơn 512Kb để làm avatar<p>
            </label> 
            <input type="hidden" name="MAX_FILE_SIZE" value="524288" />
            <input type="file" name="image" />
            <p><input class="change" type="submit" name="upload" value="Lưu thay đổi" /></p>
        </div>
  </fieldset> 
</form>

<form action="" method="post">        
    <fieldset>
        <legend>Thông tin của bạn</legend>
        <div>
            <label for="first-name">Họ
                <?php if(isset($errors) && in_array('first_name',$errors)) echo "<p class='warning'>Bạn phải nhập tên đúng định dạng.</p>";?>
            </label> 
            <input type="text" name="first_name" value="<?php if(isset($user['first_name'])) echo strip_tags($user['first_name']); ?>" size="20" maxlength="40" tabindex='1' />
        </div>
        
        <div>
            <label for="last-name">Tên
                <?php if(isset($errors) && in_array('last name',$errors)) echo "<p class='warning'>Bạn phải nhập họ đúng định dạng.</p>";?>
            </label> 
            <input type="text" name="last_name" value="<?php if(isset($user['last_name'])) echo strip_tags($user['last_name']); ?>" size="20" maxlength="40" tabindex='1' />
        </div>
  </fieldset>
  <fieldset>
        <legend>Contact Info</legend>
        <div>
            <label for="email">Email
            <?php if(isset($errors) && in_array('email',$errors)) echo "<p class='warning'>Bạn phải nhập email hợp lệ.</p>";?>
            </label> 
            <input type="text" name="email" value="<?php if(isset($user['email'])) echo $user['email']; ?>" size="20" maxlength="40" tabindex='3' />
        </div>
        
        <div>
            <label for="website">Website</label> 
            <input type="text" name="website" value="<?php echo (is_null($user['website'])) ? '' : strip_tags($user['website']); ?>" size="20" maxlength="40" tabindex='4' />
        </div>
        
        <div>
            <label for="yahoo">Facebook</label> 
            <input type="text" name="facebook" value="<?php echo (is_null($user['facebook'])) ? '' : strip_tags($user['facebook']); ?>" size="20" maxlength="40" tabindex='5' />
        </div>
  </fieldset> 
  <fieldset>
        <legend>Vài dòng về bạn</legend>
        <div>
            <textarea cols="50" rows="20" name="bio"><?php echo (is_null($user['bio'])) ? '' : htmlentities($user['bio'], ENT_COMPAT, 'UTF-8'); ?></textarea>
        </div>
  </fieldset>   
 <div><input type="submit" name="submit" value="Lưu thay đổi" /></div>
</form>
</div><!--end content-->
<?php include('includes/sidebar-b.php');?>
<?php include('includes/footer.php'); ?>


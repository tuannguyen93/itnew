<?php
    $title = "Sửa thông tin";
    include('../includes/header.php');
    require_once('../includes/mysqli_connect.php');
    require_once('../includes/functions.php');
    include('../includes/sidebar-admin.php');
    // Check to see if has admin access
    admin_access();  
?>
<?php
    if(isset($_GET['uid']) && filter_var($_GET['uid'],FILTER_VALIDATE_INT, array('min_range' => 1))) {
        $uid = $_GET['uid'];
    
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors = array();
            // Cắt bỏ khoản trống trong các thông tin nhập vào
            $trimmed = array_map('trim', $_POST);
            
            //Kiểm tra các ký tự được phép nhập vào
            if(preg_match('/^[\w]{2,10}$/i', $trimmed['first_name'])) {
                $fn = $trimmed['first_name'];
                } else {
                $errors[] = "first_name";
            }
            
            //Kiểm tra các ký tự được phép nhập vào
            if(preg_match('/^[\w ]{2,10}$/i', $trimmed['last_name'])) {
                $ln = $trimmed['last_name'];
                } else {
                $errors[] = "last name";
            }
            
            //Kiểm tra các ký tự được phép nhập vào
            if(filter_var($trimmed['email'],FILTER_VALIDATE_EMAIL)) {
                $e = $trimmed['email'];
                } else {
                $errors[] = "email";
            }
            
            //Kiểm tra các ký tự được phép nhập vào
            if(filter_var($trimmed['user_level'], FILTER_VALIDATE_INT, array('min_range'=>1))) {
                $ul = $trimmed['user_level'];
                } else {
                $errors[] = "user level";
            }
            
            //Kiểm tra nếu không có lỗi thì chạy câu lệnh kiểm tra email đã có chưa?
            if(empty($errors)) {
                // Kiểm tra email đã có trong CSDL chưa
                $q = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
                if($stmt = mysqli_prepare($dbc, $q)) {
                    
                    // Gắn tham số cho câu lệnh prepare
                    mysqli_stmt_bind_param($stmt, 'si', $e, $uid);

                    // Cahyj câu lệnh prepare
                    mysqli_stmt_execute($stmt);

                    // Luw kết quả lại xài
                    mysqli_stmt_store_result($stmt);

                    if(mysqli_stmt_num_rows($stmt) == 0) {
                        // Email hợp lệ, cập nhật CSDL
                        $query = "UPDATE users SET 
                                    first_name = ?, 
                                    last_name = ?, email = ?, 
                                    user_level =? 
                                    WHERE user_id = ? LIMIT 1";
                        if($upd_stmt = mysqli_prepare($dbc, $query)) {

                            // Gắn tham số
                            mysqli_stmt_bind_param($upd_stmt, 'sssii', $fn, $ln, $e, $ul, $uid);

                            // Cho chạy câu lệnh
                            mysqli_stmt_execute($upd_stmt) or die("Mysqli Error: $query ". mysqli_stmt_error($upd_stmt));

                            if(mysqli_stmt_affected_rows($upd_stmt) == 1) {
                                $message = "<p class='success'>Thông tin thành viên được cập nhật thành công.</p>";
                            } else {
                                $message = "<p class='error'>Thông tin thành viên KHÔNG được cập nhật do lỗi hệ thống.</p>";
                            }
                        }
                    } else {
                        $message = "<p class='error'>Email này đã có trong hệ thống. Vui lòng chọn email khác.</p>";
                    }//End if(mysqli_stmt_num_rows($stmt) == 0)

                }// END if($STMT)

                }// end empty($errors) 
            
            } // END main IF POST
        
        } else {
            // uid không hợp lệ thì đá về trang quản lý
        redirect_to('admin/manage_users.php');
    }// End main IF
?>
    <?php 
        // Truy xuất cơ sở dữ liệu hiển thị thông tin đã có trong CSDL
        if($user = fetch_user($uid)) { 
            //Nếu uid tồn tại thì hiển thị đoạn HTML bên dưới
    ?>

<div id="content">
    <h2>Sửa đổi thông tin: <?php echo $user['first_name'] ." ". $user['last_name'];?> </h2>
    <?php if(isset($message)) {echo $message;}?>

<form action="" method="post">        
<fieldset>
    <legend>Thông tin người dùng</legend>
    <div>
        <label for="first-name">Tên
            <?php if(isset($errors) && in_array('first_name',$errors)) echo "<p class='warning'>Bạn phải điền Tên hợp lệ.</p>";?>
        </label> 
        <input type="text" name="first_name" value="<?php if(isset($user['first_name'])) echo strip_tags($user['first_name']); ?>" size="20" maxlength="40" tabindex='1' />
    </div>
    
    <div>
        <label for="last-name">Họ
            <?php if(isset($errors) && in_array('last name',$errors)) echo "<p class='warning'>Bạn phải điền Họ hợp lệ.</p>";?>
        </label> 
        <input type="text" name="last_name" value="<?php if(isset($user['last_name'])) echo strip_tags($user['last_name']); ?>" size="20" maxlength="40" tabindex='1' />
    </div>

    <div>
        <label for="email">Email
        <?php if(isset($errors) && in_array('email',$errors)) echo "<p class='warning'>Bạn phải điền email hợp lệ.</p>";?>
        </label> 
        <input type="text" name="email" value="<?php if(isset($user['email'])) echo $user['email']; ?>" size="20" maxlength="40" tabindex='3' />
    </div>

    <div>
        <label for="User Level">Cấp độ người dùng
            <?php if(isset($errors) && in_array('user level',$errors)) echo "<p class='warning'>Bạn phải chọn cấp độ thành viên hợp lệ.</p>";?>
        </label>
        <select name="user_level">
        <?php
            // Lấy giá trị ra rồi gán cho các chức danh
            $roles = array(1 => 'Registered Member', 2 => 'Moderator', 3 => 'Super Mod', 4 => 'Admin');
            foreach ($roles as $key => $role) {
                echo "<option value='{$key}'";
                    if($key == $user['user_level']) {echo "selected='selected'";}
                echo ">".$role."</option>";
            }
        ?>
        </select>
    </div>
</fieldset>

<div><input type="submit" name="submit" value="Lưu thay đổi" /></div>
<?php } else {
    echo "<p class='error'>Không tìm thấy thông tin thành viên.</p>";
} ?>
</div><!--end content-->

    
<?php 
    include('../includes/footer.php'); 
?>
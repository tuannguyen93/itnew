<?php 
session_start();
include('includes/mysqli_connect.php');?>
<?php include('includes/functions.php');?>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_FILES['image'])) {
			// Tạo biến chứa lỗi
			$errors = array();

			// Tạo array chứa phần mở rộng cho phép
			$allowed = array('image/jpeg', 'image/jpg', 'image/png', 'images/x-png');

			// Kiểm tra phần mở rộng, hợp lệ thì đổi tên tập tin
			if(in_array(strtolower($_FILES['image']['type']), $allowed)) {
				// Đổi tên tập tin
				$ext = end(explode('.', $_FILES['image']['name']));
				$renamed = uniqid(rand(), true).'.'."$ext";
    
                //Kiểm tra có thư mục upload chưa
				if(!move_uploaded_file($_FILES['image']['tmp_name'], "uploads/images/".$renamed)) {
					$errors[] = "<p class='error'>Lỗi hệ thống</p>";
				} else {
					echo "Ok! Đã tải lên thành công";
				}
			} else {
				// Người dùng tải lên định dạng không cho phép
				$errors[] = "<p class='error'>Bạn chỉ được tải lên hình ảnh với định dạng png hoặc jpg</p>";
			} 
		} // END isset $_FILES

	//Kiểm tra có lỗi hay không
    if($_FILES['image']['error'] > 0) {
        $errors[] = "<p class='error'>Tệp ảnh không thể tải lên vì: <strong>";

        // In ra thông báo lỗi kèm theo
        switch ($_FILES['image']['error']) {
            case 1:
                $errors[] .= "Kích thước tập tin lớn hơn kích thước upload_max_filesize cài đặt trong php.ini";
                break;
                
            case 2:
                $errors[] .= "Kích thước tập tin lớn hơn kích thước  MAX_FILE_SIZE trong HTML form";
                break;
             
            case 3:
                $errors[] .= "Không thể tải lên hoàn toàn";
                break;
            
            case 4:
                $errors[] .= "Không có tệp nào được tải lên";
                break;

            case 6:
                $errors[] .= "Không tìm thấy thư mục uploads";
                break;

            case 7:
                $errors[] .= "Không có quyền ghi vào thư mục";
                break;

            case 8:
                $errors[] .= "Tải lên bị ngưng";
                break;
            
            default:
                $errors[] .= "Hệ thống xảy ra lỗi";
                break;
        } // END of switch

        $errors[] .= "</strong></p>";
    } // END of error IF

    // Xóa tập tin tạm thời
    if(isset($_FILES['image']['tmp_name']) && is_file($_FILES['image']['tmp_name']) && file_exists($_FILES['image']['tmp_name'])) {
    	unlink($_FILES['image']['tmp_name']);
    }

	} // END main if
    
    //Kiểm tra không có lỗi thì cập nhật CSDL
	if(empty($errors)) {
		// Update cSDL
		$q = "UPDATE users SET avatar = '{$renamed}' WHERE user_id = {$_SESSION['uid']} LIMIT 1";
		$r = mysqli_query($dbc, $q); confirm_query($r, $q);

		if(mysqli_affected_rows($dbc) > 0) {
			// Update thanh cong, chuyen huong nguoi dung ve trang edit_profile
			redirect_to('edit_profile.php');
		}
	}

	report_error($errors);
	if(!empty($message)) echo $message; 
?>














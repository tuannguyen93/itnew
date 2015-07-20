<?php 
session_start();
include('includes/mysqli_connect.php');?>
<?php include('includes/functions.php');?>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_FILES['image'])) {
			// T?o m?t bi?n ch?a l?i
			$errors = array();

			// T?o array ch?a các d?nh d?ng cho phép
			$allowed = array('image/jpeg', 'image/jpg', 'image/png', 'images/x-png');

			// Ki?m tra tên file có ph?i d?nh d?ng cho phép
			if(in_array(strtolower($_FILES['image']['type']), $allowed)) {
				// N?u d?nh d?ng du?c cho phép thì tách l?y d?nh d?ng, d?i tên r?i g?n d?nh d?ng l?i - d?i tên file
				$ext = end(explode('.', $_FILES['image']['name']));
				$renamed = uniqid(rand(), true).'.'."$ext";
    
                //Ki?m tra xem hình dã vào thu m?c upload chua?
				if(!move_uploaded_file($_FILES['image']['tmp_name'], "uploads/images/".$renamed)) {
					$errors[] = "<p class='error'>L?i h? th?ng</p>";
				} else {
					echo "Ok! Ðã t?i lên hoàn t?t";
				}
			} else {
				// Ngu?i dùng t?i lên file không dúng d?nh d?ng cho phép.
				$errors[] = "<p class='error'>B?n ph?i upload t?p ?nh có d?nh d?ng png và jpg</p>";
			} 
		} // END isset $_FILES

	//Ki?m tra xem có l?i hay không?
    if($_FILES['image']['error'] > 0) {
        $errors[] = "<p class='error'>T?p ?nh không th? t?i lên vì: <strong>";

        // In ra thông báo kèm theo
        switch ($_FILES['image']['error']) {
            case 1:
                $errors[] .= "Kích thu?c t?p l?n hon kích thu?c c?a thông s? upload_max_filesize cài d?t trong php.ini";
                break;
                
            case 2:
                $errors[] .= "Kích thu?c t?p l?n hon kích thu?c c?a thông s? MAX_FILE_SIZE trong HTML form";
                break;
             
            case 3:
                $errors[] .= "Không th? t?i lên hoàn toàn";
                break;
            
            case 4:
                $errors[] .= "Không có t?p nào du?c t?i lên";
                break;

            case 6:
                $errors[] .= "Không tìm th?y thu m?c t?i lên";
                break;

            case 7:
                $errors[] .= "Không th? ghi vào thu m?c";
                break;

            case 8:
                $errors[] .= "T?i lên t?p b? ng?ng";
                break;
            
            default:
                $errors[] .= "H? th?ng dã x?y ra l?i";
                break;
        } // END of switch

        $errors[] .= "</strong></p>";
    } // END of error IF

    // Xóa t?p t?m t?i lên và d?i tên lúc tru?c
    if(isset($_FILES['image']['tmp_name']) && is_file($_FILES['image']['tmp_name']) && file_exists($_FILES['image']['tmp_name'])) {
    	unlink($_FILES['image']['tmp_name']);
    }

	} // END main if
    
    //Không có l?i nào h?t thì cài d?t avatar là hình upload lên
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














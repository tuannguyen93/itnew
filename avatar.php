<?php 
session_start();
include('includes/mysqli_connect.php');?>
<?php include('includes/functions.php');?>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if(isset($_FILES['image'])) {
			// T?o m?t bi?n ch?a l?i
			$errors = array();

			// T?o array ch?a c�c d?nh d?ng cho ph�p
			$allowed = array('image/jpeg', 'image/jpg', 'image/png', 'images/x-png');

			// Ki?m tra t�n file c� ph?i d?nh d?ng cho ph�p
			if(in_array(strtolower($_FILES['image']['type']), $allowed)) {
				// N?u d?nh d?ng du?c cho ph�p th� t�ch l?y d?nh d?ng, d?i t�n r?i g?n d?nh d?ng l?i - d?i t�n file
				$ext = end(explode('.', $_FILES['image']['name']));
				$renamed = uniqid(rand(), true).'.'."$ext";
    
                //Ki?m tra xem h�nh d� v�o thu m?c upload chua?
				if(!move_uploaded_file($_FILES['image']['tmp_name'], "uploads/images/".$renamed)) {
					$errors[] = "<p class='error'>L?i h? th?ng</p>";
				} else {
					echo "Ok! �� t?i l�n ho�n t?t";
				}
			} else {
				// Ngu?i d�ng t?i l�n file kh�ng d�ng d?nh d?ng cho ph�p.
				$errors[] = "<p class='error'>B?n ph?i upload t?p ?nh c� d?nh d?ng png v� jpg</p>";
			} 
		} // END isset $_FILES

	//Ki?m tra xem c� l?i hay kh�ng?
    if($_FILES['image']['error'] > 0) {
        $errors[] = "<p class='error'>T?p ?nh kh�ng th? t?i l�n v�: <strong>";

        // In ra th�ng b�o k�m theo
        switch ($_FILES['image']['error']) {
            case 1:
                $errors[] .= "K�ch thu?c t?p l?n hon k�ch thu?c c?a th�ng s? upload_max_filesize c�i d?t trong php.ini";
                break;
                
            case 2:
                $errors[] .= "K�ch thu?c t?p l?n hon k�ch thu?c c?a th�ng s? MAX_FILE_SIZE trong HTML form";
                break;
             
            case 3:
                $errors[] .= "Kh�ng th? t?i l�n ho�n to�n";
                break;
            
            case 4:
                $errors[] .= "Kh�ng c� t?p n�o du?c t?i l�n";
                break;

            case 6:
                $errors[] .= "Kh�ng t�m th?y thu m?c t?i l�n";
                break;

            case 7:
                $errors[] .= "Kh�ng th? ghi v�o thu m?c";
                break;

            case 8:
                $errors[] .= "T?i l�n t?p b? ng?ng";
                break;
            
            default:
                $errors[] .= "H? th?ng d� x?y ra l?i";
                break;
        } // END of switch

        $errors[] .= "</strong></p>";
    } // END of error IF

    // X�a t?p t?m t?i l�n v� d?i t�n l�c tru?c
    if(isset($_FILES['image']['tmp_name']) && is_file($_FILES['image']['tmp_name']) && file_exists($_FILES['image']['tmp_name'])) {
    	unlink($_FILES['image']['tmp_name']);
    }

	} // END main if
    
    //Kh�ng c� l?i n�o h?t th� c�i d?t avatar l� h�nh upload l�n
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














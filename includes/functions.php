<?php
    //Tạo hằng số URL tuyệt đối
    define('BASE_URL', 'http://localhost/itnew/');
    
    //Xác định hằng số khi nào còn đang phát triển, khi nào đã triển khai
    define('LIVE', FALSE); //FALSE là đang đang phát triển, hiển thị lỗi đầy đủ, TRUE là đã triển khai, báo lỗi đơn giản
    
    //Kiểm tra kết quả có đúng với CSDL không?
    function confirm_query($result, $query) {
        global $dbc;
        if(!$result && !LIVE) {
            die("Query {$query} \n<br/> MySQL Error: " .mysqli_error($dbc));
        } else {
            
        }
    }
    
    // Tạo hàm báo lỗi riêng
    function custom_error_handler($e_number, $e_message, $e_files, $e_line, $e_vars) {
        // Tạo câu báo lỗi riieng
        $message = "<p class='warning'>Có lỗi xảy ra ở file {$e_files} tại dòng {$e_line}: {$e_message} \n";
        //$message .= print_r($e_vars, 1);

        if(!LIVE) {
            // Đang trong quá trình phát triển thì hiển thị đầy đủ thông tin lỗi
            echo "<pre>". $message ."</pre><br/>\n";
        } else {
            // Đang trong quá trình triển khai lên host thì báo lỗi đơn giản
            echo "<p class='warning'>Oh! Đã có lỗi xảy ra rồi. Chúng tôi rất tiếc vì sự bất tiện này.</p>";
        }
    }// End custom_error_handler

    //Sử dụng thông báo lỗi riêng
    set_error_handler('custom_error_handler');
    
    //Hàm chuyển người dùng về trang khác
    function redirect_to($page = 'index.php') {
        $url = BASE_URL . $page;
        header("Location: $url");
        exit();
    }
    
    //Kiểm tra id (cid, pid, cid có hợp lệ hay không?)
    function validate_id($id) {
        if(isset($id) && filter_var($id, FILTER_VALIDATE_INT, array('min_range' =>1))) {
            $val_id = $id;
            return $val_id;
        } else {
            return NULL;
        }
    } // End validate_id
    
    //Lấy trang theo id - làm cho code ngắn hơn ở trang single
    function get_page_by_id($id) {
        global $dbc;
        $q = " SELECT p.page_name, p.page_id, p.content,"; 
        $q .= " DATE_FORMAT(p.post_on, '%b %d, %y') AS date, ";
        $q .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
        $q .= " FROM pages AS p ";
        $q .= " INNER JOIN users AS u ";
        $q .= " USING (user_id) ";
        $q .= " WHERE p.page_id={$id}";
        $q .= " ORDER BY date ASC LIMIT 1";
        $result = mysqli_query($dbc,$q);
        confirm_query($result, $q);
        return $result;
    }
    
    //Hàm cắt nội dung cho tròn chữ
     function the_excerpt($text, $string = 400) {
        $sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
        if(strlen($sanitized) > $string) {
            $cutString = substr($sanitized,0,$string);
            $words = substr($sanitized, 0, strrpos($cutString, ' '));
            return $words;
        } else {
            return $sanitized;
        }
       
    } // End the_excerpt
    
    //Cắt đoạn xuống dòng tạo đoạn văn cho đẹp
     function paragraph($text) {
        $sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
        return str_replace(array("\r\n", "\n"),array("<p>", "</p>"),$sanitized);
    }
    
    //Hàm phân trang cho trang tác giả
    function pagination($cid, $display = 4){
        global $dbc; global $start;
        if(isset($_GET['p']) && filter_var($_GET['p'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
            $page = $_GET['p'];
        } else {
            // Nếu biến p không có, sẽ truy vấn CSDL để tìm xem có bao nhiêu page để hiển thị
            $q = "SELECT COUNT(page_id) FROM pages";
            $r = mysqli_query($dbc, $q);
            confirm_query($r, $q);
            list($record) = mysqli_fetch_array($r, MYSQLI_NUM);
            
            // Tìm số trang bằng cách chia số dữ liệu cho số display
            if($record > $display) {
                $page = ceil($record/$display);
            } else {
                $page = 1;
            }
        }
        
        $output = "<ul class='pagination'>";
        if($page > 1) {
            $current_page = ($start/$display) + 1;
            
            // Nếu không phải ở trang đầu (hoặc 1) thì sẽ hiển thị Trang trước.
            if($current_page != 1) {
                $output .= "<li><a href='author.php?cid={$cid}&s=".($start - $display)."&p={$page}'>Previous</a></li>";
            }
            
            // Hiển thị những phần số còn lại của trang
            for($i = 1; $i <= $page; $i++) {
                if($i != $current_page) {
                    $output .= "<li><a href='author.php?cid={$cid}&s=".($display * ($i - 1))."&p={$page}'>{$i}</a></li>";
                } else {
                    $output .= "<li class='current'>{$i}</li>";
                }
            }// END FOR LOOP
            
            // Nếu không phải trang cuối, thì hiển thị trang kế.
            if($current_page != $page) {
                $output .= "<li><a href='author.php?cid={$cid}&s=".($start + $display)."&p={$page}'>Next</a></li>";
            }
        } // END pagination section
            $output .= "</ul>";
            
            return $output;
    } // END pagination  
    
    //Hàm phân trang cho trang tác giả
    function pagination_cid($cid, $display = 5){
        global $dbc; global $start;
        if(isset($_GET['p']) && filter_var($_GET['p'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
            $page = $_GET['p'];
        } else {
            // Nếu biến p không có, sẽ truy vấn CSDL để tìm xem có bao nhiêu page để hiển thị
            $q = "SELECT COUNT(page_id) FROM pages WHERE cat_id=$cid";
            $r = mysqli_query($dbc, $q);
            confirm_query($r, $q);
            list($record) = mysqli_fetch_array($r, MYSQLI_NUM);
            
            // Tìm số trang bằng cách chia số dữ liệu cho số display
            if($record > $display) {
                $page = ceil($record/$display);
            } else {
                $page = 1;
            }
        }
        
        $output = "<ul class='pagination'>";
        if($page > 1) {
            $current_page = ($start/$display) + 1;
            
            // Nếu không phải ở trang đầu (hoặc 1) thì sẽ hiển thị Trang trước.
            if($current_page != 1) {
                $output .= "<li><a href='index.php?cid={$cid}&s=".($start - $display)."&p={$page}'>Previous</a></li>";
            }
            
            // Hiển thị những phần số còn lại của trang
            for($i = 1; $i <= $page; $i++) {
                if($i != $current_page) {
                    $output .= "<li><a href='index.php?cid={$cid}&s=".($display * ($i - 1))."&p={$page}'>{$i}</a></li>";
                } else {
                    $output .= "<li class='current'>{$i}</li>";
                }
            }// END FOR LOOP
            
            // Nếu không phải trang cuối, thì hiển thị trang kế.
            if($current_page != $page) {
                $output .= "<li><a href='index.php?cid={$cid}&s=".($start + $display)."&p={$page}'>Next</a></li>";
            }
        } // END pagination section
            $output .= "</ul>";
            
            return $output;
    } // END pagination  
    
    
    // Tạo hàm loop qua để thông báo lỗi
    function report_error($mgs) {
        if(isset($mgs)) {
            foreach ($mgs as $m) {
                echo $m;
            }
        }
    } // END report_error
    
     //Kiểm tra xem login hay chưa?
    function is_logged_in() {
        if(!isset($_SESSION['uid'])) {
            redirect_to('login.php');
        }
    } // END is_logged_in
    
    //Kiểm tra xem có đăng nhập chưa? Đăng nhập rồi thì có phải admin không?
    function is_admin() {
        return isset($_SESSION['user_level']) && ($_SESSION['user_level'] == 1);
    }
    
    // Kiểm tra xem đăng nhập rồi mà có phải là admin không
    function admin_access() {
        if(!is_admin()) {
            redirect_to();
        }
    }
    
    //Lấy thông tin người dùng ra từ cái SESSION uid
    function fetch_user($user_id) {
        global $dbc;
        $q = "SELECT * FROM users WHERE user_id = {$user_id}";
        $r = mysqli_query($dbc, $q); confirm_query($r, $q);

        if(mysqli_num_rows($r) > 0) {
            // Nếu có kết quả trả về thì trả về 1 mảng để lấy thông tin ra dùng
            return $result_set = mysqli_fetch_array($r, MYSQLI_ASSOC);
        } else {
            // Không có kết quả 
            return FALSE;
        }
    } // END fetch_user

    //Tạo hàm đếm số lượt xem mỗi bài viết
   function view_count($page_id) {
        $ip = $_SERVER['REMOTE_ADDR'];
        global $dbc;

        // Lấy CSDL dựa trên page_id
        $q = "SELECT num_views, user_ip FROM page_views WHERE page_id = {$page_id}";
        $r = mysqli_query($dbc, $q); confirm_query($r, $q);

        if(mysqli_num_rows($r) > 0) {
            
            // Nếu có kết quả trả về là đã có dữ liệu về trang này, lấy ra lưu lại để so sánh tiếp ip
            list($num_views, $data_ip) = mysqli_fetch_array($r, MYSQLI_NUM);
            
            // So sánh ip, nếu khác thì lưu vào CSDL
            if($data_ip !== $ip) {
            $q = "UPDATE page_views SET num_views = (num_views + 1) WHERE page_id = {$page_id} LIMIT 1";
            $r = mysqli_query($dbc, $q); confirm_query($r, $q);
        }

        } else {
            //Nếu không có kết quả trả về thì chèn vào CSDL
            $q = "INSERT INTO page_views (page_id, num_views, user_ip) VALUES ({$page_id}, 1, '{$ip}')";
            $r = mysqli_query($dbc, $q); confirm_query($r, $q);
            $num_views = 1;
        }
        return $num_views;
    }// Kết thúc đếm số lượt xem mỗi bài viết
    
    
    
    //Sắp xếp thứ tự thành viên bằng USERS
    function sort_table_users($order) {
        switch ($order) {
            case 'fn':
            $order_by = "first_name";
            break;
            
            case 'ln':
            $order_by = "last_name";
            break;
            
            case 'e':
            $order_by = "email";
            break;
            
            case 'ul':
            $order_by = "user_level";
            break;
            
            default:
            $order_by = "user_level";
            break;
        }
        return $order_by;
    } // END sort_table_users
	
	function convert_to_val($num) {
        switch ($num) {
            case '1':
            $num = "Admin";
            break;
            
            case '2':
            $num = "Register Member";
            break;           
            
            default:
            $num = "Register Member";
            break;
        }
        return $num;
    } // END convert_to_val
	
	//Lấy ra nhiều thành viên
    function fetch_users($order) {
        global $dbc;
        
        // Lấy thông tin của tất cả người dùng
        $q = "SELECT * FROM users ORDER BY {$order} ASC";
        $r = mysqli_query($dbc,$q); confirm_query($r, $q);
        
        if(mysqli_num_rows($r) > 1) {
            //Lưu kết quả vào array
            $users = array();

            // Nếu có giá trị thì thêm vào array
            while($results = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                $users[] = $results;
			} // End while
			return $users;
		} else {
			//Nếu không có thông tin người dùng nào cả
			return FALSE;
		}
    }// End fetch_users
	
	//Lấy ra ra 5 thành viên mới nhất
    function fetch_new_users($order) {
        global $dbc;
        
        // Lấy thông tin của tất cả người dùng
        $q = "SELECT * FROM users ORDER BY {$order} DESC LIMIT 5";
        $r = mysqli_query($dbc,$q); confirm_query($r, $q);
        
        if(mysqli_num_rows($r) > 1) {
            //Lưu kết quả vào array
            $users = array();

            // Nếu có giá trị thì thêm vào array
            while($results = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                $users[] = $results;
			} // End while
			return $users;
		} else {
			//Nếu không có thông tin người dùng nào cả
			return FALSE;
		}
    }// End fetch_users
    
    //Kiểm tra kết nối stm
    // Check connection for OOP
    function check_db_conn() {
        if(mysqli_connect_error()) {
            echo "Connection failed: ". mysqli_connect_error();
            exit();
        }
    }
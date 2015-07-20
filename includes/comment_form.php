<?php
    require_once('recaptchalib.php');
    if($_SERVER['REQUEST_METHOD'] == 'POST') {  
        //Tạo biến chứa lỗi
        $errors = array();          
        
        //Kiểm tra name có hợp lệ
        if(!empty($_POST['name'])) {
            $name = mysqli_real_escape_string($dbc,strip_tags($_POST['name']));
        } else {
            $errors[] = "name";
        }
        
        // Kiểm tra email có hợp lệ
        if(isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $e = mysqli_real_escape_string($dbc,strip_tags($_POST['email']));
        } else {
            $errors[] = "email";
        }
        
        // Kiểm tra comment có hợp lệ
        if(!empty($_POST['comment'])) {
            $comment = mysqli_real_escape_string($dbc,$_POST['comment']);
        } else {
            $errors[] = "comment";
        }
        
        //Kiểm tra dữ liệu và giá trị captcha có đúng hay không
         $privatekey = "6Lf-e9oSAAAAAPZy1LTJNkbW4ZutnUEmMGZWKX3i ";
          $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);
        
          if (!$resp->is_valid) {
            // Sai captcha
            $errors[] = 'sai captcha';
          }
         
        
        if(empty($errors)) {
            // Neu ko co loi xay ra, them comment vao csdl
            $q = "INSERT INTO comments (page_id,author, email, comment) VALUES ({$pid},'{$name}','{$e}','{$comment}')";
            $r = mysqli_query($dbc,$q);
            confirm_query($r, $q); 
            if(mysqli_affected_rows($dbc) == 1) {
                // Success
                $messages = "<p class='success'>Cảm ơn bạn đã bình luận.</p>";
                
            } else { // Có lỗi hệ thống
                $messages = "<p class='error'>Bình luận của bạn không thể thực hiện vì lỗi hệ thống.</p>";
            }
        } else {
            // Người dùng quên điền form
            $messages = "<p class='error'>Đã có lỗi xảy ra. Bạn vui lòng kiểm tra lại.</p>";
        }
    
    }
?>

<?php
    //Hiển thị comment từ CSDL
    $q ="SELECT comment_id, author, comment, DATE_FORMAT(comment_date, '%d %M %Y') AS date FROM comments WHERE page_id = {$pid}";
    $r = mysqli_query($dbc,$q);
    confirm_query($r, $q);
    
     if(mysqli_num_rows($r) > 0) {
        //Có comment thì lôi đầu nó ra
        echo "<ol class='disscuss'>";
        while(list($cmt_id, $author, $comment, $date) = mysqli_fetch_array($r, MYSQLI_NUM)) {
            echo "<li class='comment-wrap'>
                  <p class='author'>{$author}</p>
                  <p class='comment-sec'>{$comment}</p>";
				  
			//Nếu là admin thì hiển thị xóa comment
			if(is_admin()) echo "<a id='{$cmt_id}' class='remove'>Xóa</a>";
			
			echo "<p class='date'>{$date}</p> 
                  </li>";
        }//End while
        echo "</ol>";    
     } else {
        //Không có comment hiển thị
        echo "<h3 class='no-page'>Hãy là người đầu tiên comment nhé bạn!!!</h3>";
     }
?>
<?php //if($_SESSION['user_level'] == 0) { echo '';} else { //Đăng nhâp rồi mới hiện comment form?>
<form id="comment-form" action="" method="post">
<?php if(!empty($messages)) echo $messages; ?>
    <fieldset>
    	<legend>Bình luận</legend>
            <div>
            <label for="name">Tên của bạn <span class="required">*</span>
            <?php 
                if(isset($errors) && in_array('name', $errors)) {
                    echo "<p class='warning'>Bạn phải điền tên hợp lệ!!</p>";
                }
            ?>
            </label>
            <input type="text" name="name" id="name" value="" size="20" maxlength="80" tabindex="1" />
        </div>
        <div>
                <label for="email">Email <span class="required">*</span>
                <?php 
                    if(isset($errors) && in_array('email', $errors)) {
                        echo "<p class='warning'>Bạn phải điền email hợp lệ!!</p>";
                    }
                ?>
                </label>
                <input type="text" name="email" id="email" value="" size="20" maxlength="80" tabindex="2" />
            </div>
        <div>
            <label for="comment">Bình luận của bạn <span class="required">*</span>
            <?php 
                if(isset($errors) && in_array('comment', $errors)) {
                    echo "<p class='warning'>Bạn phải viết comment hợp lệ!!</p>";
                }
            ?>    
            </label>
            <div id="comment"><textarea name="comment" rows="10" cols="50" tabindex="3"></textarea></div>
        </div>
        
         <div>
            <label>Vui lòng gõ vào ô bên dưới những ký tự trong hình!!!
            <?php if(isset($errors) && in_array('sai captcha',$errors)) {echo "<span class='warning'>Giá trị bạn nhập không đúng.</span>";}?></label>
            </label>
            <?php
                $publickey = "6Lf-e9oSAAAAAAL43oMxzaLMOC0aTKait1v-dhAk";
                echo recaptcha_get_html($publickey);
            ?>
        </div>
    </fieldset>
    <div><input type="submit" name="submit" value="Gửi bình luận" /></div>
    <?php //}//Kết thúc kiểm tra nguời dùng đã đưang nhâp chưa??>
</form>
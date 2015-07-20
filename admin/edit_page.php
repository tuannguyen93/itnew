<?php $title= 'Sửa bài viết'; include('../includes/header.php');?>
<?php include('../includes/mysqli_connect.php');?>
<?php include('../includes/functions.php');?>
<?php include('../includes/sidebar-admin.php'); ?>
<?php
    //Kiểm tra xem đang nhập rồi mà có phải là admin hay không?
    admin_access(); 
        
    // Kiểm tra pid có hợp lệ không
    if(isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' =>1))) {
        $pid = $_GET['pid'];
    } else {
        // pid không tồn tại thì chuyển người dùng về trang adminh
        redirect_to('admin/view_pages.php');
    }
        
    // Tồn tại pid hợp lệ thì xử lý form
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = array();
        if(empty($_POST['page_name'])) {
            $errors[] = 'page_name';
        } else {
            $page_name = mysqli_real_escape_string($dbc,strip_tags($_POST['page_name']));
        }
        
        if(isset($_POST['category']) && filter_var($_POST['category'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
            $cat_id= $_POST['category'];
        } else {
            $errors[] = "category";
        }
        
        if(isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
            $position = $_POST['position'];
        } else {
            $errors[] = "position";
        }
        
        if(empty($_POST['content'])) {
            $errors[] = 'content';
        } else {
            $content = mysqli_real_escape_string($dbc,$_POST['content']);
        }
      
        if(empty($errors)) {
            // Nếu không có lỗi xảy ra thì chèn dữ liệu vào CSDL
            $q = "UPDATE pages SET ";
            $q .= " page_name = '{$page_name}', ";
            $q .= " cat_id = {$cat_id}, ";
            $q .= " position = {$position}, ";
            $q .= " content = '{$content}', ";
            $q .= " user_id = 1, ";
            $q .= " post_on = NOW() ";
            $q .= " WHERE page_id = {$pid} LIMIT 1";
            $r = mysqli_query($dbc,$q);
            confirm_query($r, $q);
            if(mysqli_affected_rows($dbc) == 1) {
                $messages = "<p class='success'>Sửa bài viết thành công.</p>";
            } else {
                $messages = "<p class='error'>Không thể sửa bài viết do lỗi hệ thống.</p>";
            }
        } else {
            $messages = "<p class='error'>Bạn phải điền các trường bắt buộc.</p>";
        }//End empty($errors)
    } // END IF
    
?>
<div id="content">
    <?php
        // Chọn page trong CSDL để hiển thị ra
        $q = "SELECT * FROM pages WHERE page_id = {$pid}";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
        if(mysqli_num_rows($r) == 1) {
            //Có page trả về
            $page = mysqli_fetch_array($r, MYSQLI_ASSOC);
        } else {
            // Không có page trả về
            $messages = "<p class='warning'>The page does not exist.</p>";
        }
    ?>
<h2>Sửa bài viết: <?php if(isset($page['page_name'])) echo $page['page_name']; ?></h2>
<?php if(!empty($messages)) echo $messages; ?>
    <form id="edit_page" action="" method="post">
        <fieldset>
        	<legend>Add a Page</legend>
                <div>
                    <label for="page">Page Name: <span class="required">*</span>
                        <?php 
                            if(isset($errors) && in_array('page_name', $errors)) {
                                echo "<p class='warning'>Bạn phải điền tên bài viết.</p>";
                            }
                        ?>
                    </label>
                    <input type="text" name="page_name" id="page_name" value="<?php if(isset($page['page_name'])) echo $page['page_name']; ?>" size="20" maxlength="80" tabindex="1" />
                </div>
                
                <div>
                    <label for="category">All categories: <span class="required">*</span>
                        <?php 
                            if(isset($errors) && in_array('category', $errors)) { 
                                echo "<p class='warning'>Bạn phải chọn danh mục.</p>"; 
                            }
                        ?>
                    </label>
                    
                    <select name="category">
                        <option>Select Category</option>
                        <?php
                            $q = "SELECT cat_id, cat_name FROM categories ORDER BY position ASC";
                            $r = mysqli_query($dbc, $q);
                            if(mysqli_num_rows($r) > 0) {
                                while($cats = mysqli_fetch_array($r, MYSQLI_NUM)) {
                                    echo "<option value='{$cats[0]}'";
                                        if(isset($page['cat_id']) && ($page['cat_id'] == $cats[0])) echo "selected='selected'";
                                    echo ">".$cats[1]."</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="position">Position: <span class="required">*</span>
                        <?php 
                            if(isset($errors) && in_array('position', $errors)) {
                                echo "<p class='warning'>Bạn phải chọn vị trí.</p>";
                            }
                        ?>
                    </label>
                    <select name="position">
                        <?php
                            $q = "SELECT count(page_id) AS count FROM pages";
                            $r = mysqli_query($dbc,$q); confirm_query($r, $q);
                            if(mysqli_num_rows($r) == 1) {
                                list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
                                for($i=1; $i<=$num+1; $i++) { 
                                    echo "<option value='{$i}'";
                                        if(isset($page['position']) && $page['position'] == $i) echo "selected='selected'";
                                    echo ">".$i."</otption>";
                                }
                            }
                        ?>
                    </select>
                </div>                
                <div>
                    <label for="page-content">Page Content: <span class="required">*</span>
                        <?php 
                            if(isset($errors) && in_array('content', $errors)) {
                                echo "<p class='warning'>Bạn đã không điền nội dung bài viết.</p>";
                            }
                        ?>
                    </label>
                    <textarea name="content" cols="50" rows="20"><?php if(isset($page['content'])) echo htmlentities($page['content'], ENT_COMPAT, 'UTF-8'); ?></textarea>
                </div>
        </fieldset>
        <p><input type="submit" name="submit" value="Save Changes" /></p>
    </form>
    
</div><!--end content-->
<?php include('../includes/footer.php'); ?>
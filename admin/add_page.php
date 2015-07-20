<?php $title= 'Thêm bài viết'; include('../includes/header.php');?>
<?php include('../includes/mysqli_connect.php');?>
<?php include('../includes/functions.php');?>
<?php include('../includes/sidebar-admin.php'); ?>
    <?php
        //Kiểm tra xem đang nhập rồi mà có phải là admin hay không?
        admin_access(); 
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tạo một biến chứa lỗi
            $errors = array();
            
            if(!empty($_POST['page_name'])) {
                $page_name = mysqli_real_escape_string($dbc,strip_tags($_POST['page_name']));
            } else {
                $errors[] = 'page_name';                
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
            
           if(!empty($_POST['content'])) {
                $content = $_POST['content'];
            } else {
                 $errors[] = 'content';
            }
            
            if(empty($errors)) {
                // Neu khong co loi xay ra, bat dau chen du lieu vao CSDL
                $q = "INSERT INTO pages (user_id, cat_id, page_name, content, position) 
                        VALUES (1, {$cat_id}, '{$page_name}', '{$content}', $position)";
                $r = mysqli_query($dbc, $q);
                confirm_query($r, $q);
               if(mysqli_affected_rows($dbc) == 1) {
                    $messages = '<p class="success">Đã thêm trang mới thành công</p>';
                } else {
                    $messages = '<p class="error">Không thể kết nối với CSDL. Vui lòng kiểm tra lại.</p>';
                }
            } else {
                $messages = "<p class='error'>Bạn phải điền các trường bắt buộc.</p>";
            }//End empty($errors)
        } // END main IF 
    ?>
    <div id="content">
    <h2>Tạo bài viết</h2>
    <?php if(!empty($messages)) echo $messages; ?>
        <form id="login" action="" method="post">
            <fieldset>
            	<legend>Thêm một bài viết</legend>
                    <div>
                        <label for="page">Tên bài viết: <span class="required">*</span>
                            <?php 
                                if(isset($errors) && in_array('page_name', $errors)) {
                                    echo "<p class='warning'>Bạn phải điền tên bài viết</p>";
                                }
                            ?>
                        </label>
                        <input type="text" name="page_name" id="page_name" value="<?php if(isset($_POST['page_name'])) echo strip_tags($_POST['page_name']); ?>" size="20" maxlength="80" tabindex="1" />
                    </div>
                    
                    <div>
                        <label for="category">Danh mục: <span class="required">*</span>
                            <?php 
                                if(isset($errors) && in_array('category', $errors)) {
                                    echo "<p class='warning'>Hãy chọn danh mục</p>";
                                }
                            ?>
                        </label>
                        
                        <select name="category">
                            <option>Select Category</option>
                            <?php
                                $q = "SELECT cat_id, cat_name FROM categories ORDER BY position ASC";
                                $r = mysqli_query($dbc,$q) or die("Query {$q} \n<br/> MySQL Error: " .mysqli_error($dbc));
                                
                                if(mysqli_num_rows($r) >0 ) {
                                    while($cats = mysqli_fetch_array($r, MYSQLI_NUM)) {
                                        echo "<option value='{$cats[0]}'";
                                            if(isset($_POST['category']) && $_POST['category'] == $cats[0]) echo "selected='selected'";
                                        echo ">".$cats[1]."</otption>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="position">Vị trí: <span class="required">*</span>
                            <?php 
                                if(isset($errors) && in_array('position', $errors)) {
                                    echo "<p class='warning'>Hãy chọn vị trí</p>";
                                }
                            ?>
                        </label>
                        <select name="position">
                            <option>Chọn vị trí</option>
                            <?php
                                $q = "SELECT count(page_id) AS count FROM pages";
                                $r = mysqli_query($dbc,$q) or die("Query {$q} \n<br/> MySQL Error: " .mysqli_error($dbc));
                                if(mysqli_num_rows($r) == 1) {
                                    list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
                                    
                                    //Tạo vòng lặp for lấy ra position
                                    for($i=1; $i<=$num+1; $i++) { 
                                        echo "<option value='{$i}'";
                                            if(isset($_POST['position']) && $_POST['position'] == $i) echo "selected='selected'";
                                        echo ">".$i."</otption>";
                                    }//End for
                                }//End IF
                            ?>
                        </select>
                    </div>                
                    <div>
                        <label for="page-content">Nội dung: <span class="required">*</span>
                        <?php 
                            if(isset($errors) && in_array('content', $errors)) {
                                echo "<p class='warning'>Nội dung không được để trống</p>";
                            }
                        ?>
                        </label>
                        <textarea name="content" cols="50" rows="20"><?php if(isset($_POST['content'])) echo htmlentities($_POST['content'], ENT_COMPAT, 'UTF-8'); ?></textarea>
                    </div>
            </fieldset>
            <p><input type="submit" name="submit" value="Add Page" /></p>
        </form>
        
</div><!--end content-->
<?php include('../includes/footer.php'); ?>
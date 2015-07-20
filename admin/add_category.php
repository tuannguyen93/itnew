<?php $title= 'Thêm danh mục'; include('../includes/header.php');?>
<?php include('../includes/mysqli_connect.php');?>
<?php include('../includes/functions.php');?>
<?php include('../includes/sidebar-admin.php'); ?>

    <?php 
        //Kiểm tra xem đang nhập rồi mà có phải là admin hay không?
        admin_access();    
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Tạo 1 biến chứa lỗi
            $errors = array();
            
            //Kiểm tra trường category có trống hay không?
            if(!empty($_POST['category'])) {
                $cat_name = mysqli_real_escape_string($dbc, strip_tags($_POST['category']));
            } else {
                $errors[] = "category";
            }
            
            //Kiểm tra trường position có trống hay không?
            if(!empty($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                $position = $_POST['position'];
            } else {
                $errors[] = "position";
            }
           
            if(empty($errors)) {
                //Nếu không có lỗi thì chèn dữ liệu vào CSDL
                $q = "INSERT INTO categories (user_id, cat_name, position) VALUES (1, '{$cat_name}', '$position')";
                $r = mysqli_query($dbc, $q);
                confirm_query($r, $q);
                 
                if(mysqli_affected_rows($dbc) == 1) {
                    $messages = '<p class="success">Đã thêm danh mục mới thành công</p>';
                } else {
                    $messages = '<p class="error">Không thể kết nối với CSDL. Vui lòng kiểm tra lại.</p>';
                }
            } else {
                $messages = "<p class='error'>Bạn phải điền các trường bắt buộc.</p>";
            }
            //empty($errors)
        }//End main IF
    ?>
    
    <div id="content">
    <h2>Tạo một danh mục</h2>
    <?php if(isset($messages) && !empty($messages)) {echo $messages;} ?>
	<form id="add_cat" action="" method="post">
    <fieldset>
    	<legend>Thêm danh mục</legend>
            <div>
                <label for="category">Tên danh mục: <span class="required">*
                <?php 
                    if(isset($errors) && in_array('category',$errors)) {
                        echo '<p class="warning">Bạn không được bỏ trống danh mục!!!</p>';
                    } 
                ?>
                </span>
                </label>
                
                <input type="text" name="category" id="category" value="<?php (isset($_POST['category']))?strip_tags($_POST['category']):'' ;?>" size="20" maxlength="150" tabindex="1" />
            </div>
            <div>
                <label for="position">Chọn vị trí: <span class="required">*</span>
                <?php 
                    if(isset($errors) && in_array('position',$errors)) {
                        echo '<p class="warning">Bạn không được bỏ trống vị trí!!!</p>';
                    } 
                ?>   
                </label>
                <select name="position" tabindex='2'>
                    <option>Chọn vị trí</option>
                    <?php 
                        //Lấy dữ liệu từ CSSDL
                        $q = "SELECT count(cat_id) AS count FROM categories";
                        $r = mysqli_query($dbc,$q) or die("Query {$q} \n<br/> MySQL Error: " .mysqli_error($dbc));
                        if(mysqli_num_rows($r) == 1) {
                            list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
                            
                            //Tạo vòng lặp for lấy ra position
                            for($i=1; $i<=$num+1; $i++) {
                                echo "<option value='{$i}'";
                                 if(isset($_POST['position']) && $_POST['position'] == $i) echo "selected='selected'";
                                echo ">".$i."</otption>";
                            }//End for
                        }//End if
                    ?>
                </select>
            </div>
    </fieldset>
    <p><input type="submit" name="submit" value="Thêm danh mục" /></p>
</form>

</div><!--end content-->
<?php include('../includes/footer.php'); ?>
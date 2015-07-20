<?php $title= 'Sửa danh mục'; include('../includes/header.php');?>
<?php include('../includes/mysqli_connect.php');?>
<?php include('../includes/functions.php');?>
<?php include('../includes/sidebar-admin.php'); ?>

    <?php
        //Kiểm tra phải admin hay không? Không 
        admin_access();
        
        //Kiểm tra tính hợp lệ của $_GET['cid']
        if(isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
            $cid = $_GET['cid'];
        } else {
            // pid không tồn tại thì chuyển người dùng về trang adminh
            redirect_to('admin/admin.php');
        }
        
        //Kiểm tra xem cái trường nhập có hợp lệ hay không         
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sửa 1 biến chứa lỗi
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
                // Không có lỗi thì chèn dữ liệu vào CSDL
				$q = "UPDATE categories SET cat_name = '{$cat_name}', position = $position WHERE cat_id = {$cid} LIMIT 1";
				$r = mysqli_query($dbc, $q);
				confirm_query($r, $q);
				
				if(mysqli_affected_rows($dbc) == 1) {
					$messages = "<p class='success'>Danh mục đã được sửa thành công.</p>";
				} else {
					$messages = "<p class='warning'>Không thể sửa danh mục vì lỗi hệ thống.</p>";
				}
			} else {
				$messages = "<p class='error'>Bạn phải điền các trường bắt buộc.</p>";
			}//empty($errors)
        }//End main IF
    ?>
    
    <div id="content">
         <?php
            //Lấy dữ liệu categories từ CSDL
            $q = "SELECT cat_name, position FROM categories WHERE cat_id = {$cid}";
            $r = mysqli_query($dbc, $q);
            confirm_query($r, $q);
            if(mysqli_num_rows($r) == 1) {
                // Nếu CSDL có danh mục này, dựa vào cid xuất ra trình duyệt
                list($cat_name, $position) = mysqli_fetch_array($r, MYSQLI_NUM);
            } else {
                // Cid không hợp lệ thì không hiển thị canh mục
                $messages = "<p class='warning'>Danh mục không tồn tại!!!</p>";
            }
        ?>
    <h2>Sửa danh mục</h2>
    <?php if(isset($messages) && !empty($messages)) {echo $messages;} ?>
	<form id="add_cat" action="" method="post">
    <fieldset>
    	<legend>Sửa danh mục</legend>
            <div>
                <label for="category">Tên danh mục: <span class="required">*
                <?php 
                    if(isset($errors) && in_array('category',$errors)) {
                        echo '<p class="warning">Bạn không được bỏ trống danh mục!!!</p>';
                    } 
                ?>
                </span>
                </label>
                
                <input type="text" name="category" id="category" value="<?php if(isset($cat_name)) echo $cat_name; ?>" size="20" maxlength="150" tabindex="1" />
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
                        $q = "SELECT count(cat_id) AS count FROM categories";
                        $r = mysqli_query($dbc,$q) or die("Query {$q} \n<br/> MySQL Error: " .mysqli_error($dbc));
                        if(mysqli_num_rows($r) == 1) {
                            list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
                            for($i=1; $i<=$num+1; $i++) { // Tao vong for de ra option, cong them 1 gia tri cho position
                                echo "<option value='{$i}'";
                                    if(isset($position) && ($position == $i)) echo "selected='selected'";
                                echo ">".$i."</otption>";
                            }
                        }
                    ?>
                </select>
            </div>
    </fieldset>
    <p><input type="submit" name="submit" value="Sửa danh mục" /></p>
</form>

</div><!--end content-->
<?php include('../includes/footer.php'); ?>
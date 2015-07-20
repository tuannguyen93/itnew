<?php $title= 'Quản lý danh mục'; include('../includes/header.php');?>
<?php include('../includes/mysqli_connect.php');?>
<?php include('../includes/functions.php');?>
<?php include('../includes/sidebar-admin.php'); 
        //Kiểm tra xem đang nhập rồi mà có phải là admin hay không?
        admin_access(); 
?>
<div id="content">
<h2>Quản lý danh mục</h2>
<table>
	<thead>
		<tr>
			<th><a href="view_categories.php?sort=cat">Danh mục</a></th>
			<th><a href="view_categories.php?sort=pos">Vị trí</th>
			<th><a href="view_categories.php?sort=by">Viết bởi</th>
            <th>Sửa</th>
            <th>Xóa</th>
		</tr>
	</thead>
	<tbody>
    <?php
        //Xác định sẽ sắp xếp theo tiêu chí nào
        if(isset($_GET['sort'])) {
            switch ($_GET['sort']) {
                              
                case 'cat':
                $order_by = 'cat_name';
                break;
                
                case 'pos':
                $order_by = 'position';
                break;
                
                case 'by':
                $order_by = 'name';
                break;
                
                default:
                $order_by = 'position';
            } 
        } else {
                $order_by = 'position';
        }//End $_GET['sort']
        
        //Lấy dữ liệu từ CSDL
        $q  = " SELECT c.cat_id, c.cat_name, c.position, c.user_id, CONCAT_WS(' ', first_name, last_name) AS name ";
        $q .= " FROM categories AS c ";
        $q .= " JOIN users AS u ";
        $q .= " USING(user_id) ";
        $q .= " ORDER BY {$order_by} ASC ";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
        
        if(mysqli_num_rows($r) > 0) {  
           while($cats = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                echo "
                <tr>
                    <td>{$cats['cat_name']}</td>
                    <td>{$cats['position']}</td>
                    <td>{$cats['name']}</td>
                    <td><a class='edit' href='edit_category.php?cid={$cats['cat_id']}'>Edit</a></td>
                    <td><a class='delete' href='delete_category.php?cid={$cats['cat_id']}&cat_name={$cats['cat_name']}'>Delete</a></td>
                </tr>
                ";
            }//End WHILE
        } else {
            $messages = "<p class='warning'>Không có danh mục nào tồn tại. Hãy tạo một danh mục mới.</p>";
        }//End IF
    ?>
        
	</tbody>
</table>
</div><!--end content-->

<?php include('../includes/footer.php'); ?>
<?php
    $title = "Quản lý thành viên";
    include('../includes/header.php');
    require_once('../includes/mysqli_connect.php');
    require_once('../includes/functions.php');
    include('../includes/sidebar-admin.php');
    // Kiểm tra quyền admin
    admin_access();  
?>
<div id="content">
<h2>Manage Users</h2>
    <table>
<thead>
	<tr>
        <th><a href="manage_users.php?sort=ln">Tên</a></th>
		<th><a href="manage_users.php?sort=fn">Họ</a></th>
		<th><a href="manage_users.php?sort=e">Email</a></th>
        <th><a href="manage_users.php?sort=ul">Cấp độ thành viên</a></th>
        <th>Sửa đổi thành viên</th>
        <th>Xóa thành viên</th>
	</tr>
</thead>
<tbody>
    <?php 
        // Kiểm tra biến $sort có tồn tại không?
        $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'ul';

        // Sắp xếp thứ tự bản bằng biến
        $order_by = sort_table_users($sort);
        
        // Lấy thông tin thành viên từ CSDL bằng hàm tự tạo fetch_users
        $users = fetch_users($order_by);

        // In kết quả ra trình duyệt
        foreach ($users as $user) {
			$user_level = convert_to_val($user['user_level']);
            echo "
                <tr>
                    <td>".$user['first_name']."</td>
                    <td>".$user['last_name']."</td>
                    <td>".$user['email']."</td>
                    <td>".$user_level."</td>
                    <td><a class='edit' href='edit_user.php?uid=".urlencode($user['user_id'])."'>Sửa</a></td>
                    <td><a class='delete' href='delete_user.php?uid=".urlencode($user['user_id'])."&user_name={$user['first_name']}'>Xóa</a></td>
                <tr>";
            } // End foreach  
    ?>
   </tbody>
</table>
</div>
<?php include('../includes/footer.php'); ?>
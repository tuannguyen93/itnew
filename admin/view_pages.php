<?php $title= 'Quản lý bài viết'; include('../includes/header.php');?>
<?php include('../includes/mysqli_connect.php');?>
<?php include('../includes/functions.php');?>
<?php include('../includes/sidebar-admin.php');
//Kiểm tra xem đang nhập rồi mà có phải là admin hay không?
admin_access(); 
?>

<div id="content">
<h2>Quản lý trang viết</h2>
<table>
	<thead>
		<tr>
			<th><a href="view_pages.php?sort=pg">Tiêu đề</a></th>
			<th><a href="view_pages.php?sort=on">Viết vào</th>
			<th><a href="view_pages.php?sort=by">Viết bởi</th>
            <th>Nội dung</th>
            <th>Sửa</th>
            <th>Xóa</th>
		</tr>
	</thead>
	<tbody>
    <?php
        //Xác định sẽ sắp xếp theo tiêu chí nào
        if(isset($_GET['sort'])) {
            switch ($_GET['sort']) {
                              
                case 'pg':
                $order_by = 'page_name';
                break;
                
                case 'on':
                $order_by = 'date';
                break;
                
                case 'by':
                $order_by = 'name';
                break;
                
                default:
                $order_by = 'date';
            } 
        } else {
                $order_by = 'date';
        }//End $_GET['sort']
        
        //Lấy dữ liệu từ CSDL
        $q  = " SELECT p.page_id, p.page_name, p.content, 
                DATE_FORMAT(p.post_on, '%d %M %Y') AS date, 
                CONCAT_WS(' ', first_name, last_name) AS name ";
        $q .= " FROM pages AS p ";
        $q .= " JOIN users AS u ";
        $q .= " USING(user_id) ";
        $q .= " ORDER BY {$order_by} ASC";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
        
        if(mysqli_num_rows($r) > 0) {     
           while($page = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                echo "
                <tr>
                    <td>{$page['page_name']}</td>
                    <td>{$page['date']}</td>
                    <td>{$page['name']}</td>
                    <td>".the_excerpt($page['content'])."</td>
                    <td><a class='edit' href='edit_page.php?pid={$page['page_id']}'>Edit</a></td>
                    <td><a class='delete' href='delete_page.php?pid={$page['page_id']}&page_name={$page['page_name']}'>Delete</a></td>
                </tr>
                ";
            }//End WHILE
        } else {
            $messages = "<p class='warning'>Không có bài viết nào tồn tại. Hãy tạo một bài viết mới.</p>";
        }//End IF 
    ?>
	</tbody>
</table>
</div><!--end content-->
<?php include('../includes/footer.php'); ?>
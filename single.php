<?php 
    include('includes/mysqli_connect.php');
    include('includes/functions.php');
    
    if($pid = validate_id($_GET['pid'])) {
        
            //Pid hợp lệ thì tiến hành lấy dữ liệu
            $set = get_page_by_id($pid);
            
            //Mỗi khi trang được tải lại và khác ip thì cập nhật 1 lần xem, nếu chưa từng xem thì lưu vào CSDL
            $page_view = view_count($pid);
            
            $posts = array(); // Tạo 1 array lưu giá trị để xuất dữ liệu ra #content
            
        if(mysqli_num_rows($set) > 0) {
            // Nếu có giá trị để hiển thị thì lưu vào array post xài sau
            $pages = mysqli_fetch_array($set, MYSQLI_ASSOC); 
            $title = $pages['page_name'];
            $posts[] = array(
                        'page_name' => $pages['page_name'], 
                        'content' => $pages['content'], 
                        'author' => $pages['name'], 
                        'post_on' => $pages['date'],
                        'aid' => $pages['user_id'],
                        );
        } else {
            echo "<p>Bài viết không tồn tại.</p>";
        }
    } else {
        // Pid không hợp lệ thì chuyển người dùng về index.php
        redirect_to();
    }
    
    include('includes/header.php');
    include('includes/sidebar-a.php'); 
?>
<div id="content">
    <?php 
        foreach($posts as $post) {
        echo "
            <div class='post'>
                <h2>{$post['page_name']}</h2>
                <p>".paragraph($post['content'])."</p>
                <p class='meta'>
                    <strong>Viết bởi:</strong><a href='author.php?aid={$post['aid']}'> {$post['author']}</a> | 
                    <strong>Vào lúc: </strong> {$post['post_on']} | 
                    <strong>Số lượt xem: </strong> {$page_view}
                    
                    </p>
            </div>
        ";
    } // End foreach.
    ?>
    <?php include('includes/comment_form.php'); ?>

</div><!--end content-->
<?php 
    include('includes/sidebar-b.php');
    include('includes/footer.php'); 
?>
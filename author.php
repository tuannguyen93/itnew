<?php
$title = 'Ngư�?i dùng';
include('includes/header.php');
?>
<?php include('includes/mysqli_connect.php'); ?>
<?php include('includes/functions.php'); ?>
<?php include('includes/sidebar-a.php'); ?>
<div id="content">
    <?php
    if ($aid = validate_id($_GET['aid'])) {
        // Xác định số bài viết muốn hiển thị trên trình duyệt
        $display = 5;
        // Xác định vị trí bắt đầu
        $start = (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $_GET['s'] : 0;

        // aid hợp lệ thì lôi dữ liệu ra
        $q = " SELECT p.page_id, p.page_name, p.content,";
        $q .= " DATE_FORMAT(p.post_on, '%b %d, %y') AS date, ";
        $q .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
        $q .= " FROM pages AS p";
        $q .= " INNER JOIN users AS u";
        $q .= " USING (user_id)";
        $q .= " WHERE u.user_id={$aid}";
        $q .= " ORDER BY date ASC LIMIT {$start}, {$display}";
        $r = mysqli_query($dbc, $q);
        confirm_query($r, $q);
        if (mysqli_num_rows($r) > 0) {
            //Phân trang ở trên
            echo pagination($aid, $display);
            echo "<br/>";
            // Nếu có dữ liệu thì hiển thị ra
            while ($author = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                echo "
                            <div class='post'>
                                <h2><a href='single.php?pid={$author['page_id']}'>{$author['page_name']}</a></h2>
                                <p>" . the_excerpt($author['content']) . " ... <a href='single.php?pid={$author['page_id']}'>Read more</a></p>
                                <p class='meta'><strong>Posted by:</strong><a href='author.php?aid={$author['user_id']}'> {$author['name']}</a> | <strong>On: </strong> {$author['date']} </p>
                            </div>
                        ";
            } // END WHILE
            // Phân trang ở dưới
            echo pagination($aid, $display);
        } else {
            // Nếu người dùng chưa có bài viết nào
            echo "<p class='warning'Các bài viết không tồn tại.<p>";
        }
    } else {
        //aid không hợp lệ
        redirect_to();
    }
    ?>
</div><!--end content-->
<?php include('includes/sidebar-b.php'); ?>
<?php include('includes/footer.php'); ?>
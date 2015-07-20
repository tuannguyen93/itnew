<?php include('includes/header.php');?>
<?php include('includes/mysqli_connect.php');?>
<?php include('includes/functions.php');?>
<?php include('includes/sidebar-a.php'); ?>
<div id="content">
    <?php
        //Nếu có biến cid thì hiển thị bài viết của danh mục
        if(isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range' =>1))) {
            $cid = $_GET['cid'];
            
                // Xác định số bài viết muốn hiển thị trên trình duyệt
                $display = 5;
                // Xác định vị trí bắt đầu
                $start = (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $_GET['s'] : 0;
                
                //Bắt đầu lấy dữ liệu ra
                $q = " SELECT p.page_name, p.page_id, p.content,"; 
                $q .= " DATE_FORMAT(p.post_on, '%d %M, %Y') AS date, ";
                $q .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
                $q .= " FROM pages AS p ";
                $q .= " INNER JOIN users AS u ";
                $q .= " USING (user_id) ";
                $q .= " WHERE p.cat_id={$cid} ";
                $q .= " ORDER BY date ASC LIMIT {$start}, {$display} ";
                $r = mysqli_query($dbc,$q);
                confirm_query($r, $q);
                if(mysqli_num_rows($r) > 0) {
                    //Phân trang ở trên
                     echo pagination_cid($cid, $display);
                     echo "<br/>";
                 
                    // Nếu có dữ liệu lấy ra thì hiển thị
                    while($pages = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                        echo "
                            <div class='post'>
                                <h2><a href='single.php?pid={$pages['page_id']}'>{$pages['page_name']}</a></h2>
                                <p>".the_excerpt($pages['content'])." ... <a href='single.php?pid={$pages['page_id']}'>Read more</a></p>
                                <p class='meta'><strong>Posted by:</strong> <a href='author.php?aid={$pages['user_id']}'> {$pages['name']}</a> | <strong>On: </strong> {$pages['date']} </p>
                            </div>
                        ";
                    } // End while loop
                    
                    // Phân trang ở dưới
                    echo pagination_cid($cid, $display);
                } else {
                    echo "<p class='no-page'>Chưa có bài viết trong chuyên mục này.</p>";
                }//End mysqli_num_rows($r) > 0
            } else {
                    //Hiển thị bài viết mới nhất ở trang index.php
                $q = " SELECT p.page_name, p.page_id, p.content,"; 
                $q .= " DATE_FORMAT(p.post_on, '%d %M, %Y') AS date, ";
                $q .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
                $q .= " FROM pages AS p ";
                $q .= " INNER JOIN users AS u ";
                $q .= " USING (user_id) ";
                $q .= " ORDER BY date DESC LIMIT 0, 10";
                $r = mysqli_query($dbc,$q);
                confirm_query($r, $q);
                if(mysqli_num_rows($r) > 0) {
                    // Nếu có dữ liệu lấy ra thì hiển thị
                    while($pages = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                        echo "
                            <div class='post'>
                                <h2><a href='single.php?pid={$pages['page_id']}'>{$pages['page_name']}</a></h2>
                                <p>".the_excerpt($pages['content'])." ...<a href='single.php?pid={$pages['page_id']}'>Read more</a></p>
                                 <p class='meta'><strong>Posted by:</strong> <a href='author.php?aid={$pages['user_id']}'> {$pages['name']}</a> | <strong>On: </strong> {$pages['date']} </p>
                            </div>
                        ";
                    } // End while 
                } else {
                    echo "<p class='no-page'>Chưa có bài viết trong chuyên mục này.</p>";
                }//End mysqli_num_rows($r) > 0
            }//Kết thúc hiển thị bài viết ở trang chủ
    ?>
</div><!--end content-->
<?php include('includes/sidebar-b.php');?>
<?php include('includes/footer.php'); ?>
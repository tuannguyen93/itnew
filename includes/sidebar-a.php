<div id="content-container">
    <div id="section-navigation">
        <h2>Danh mục</h2>
	   <ul class="navi">
            <?php
                //Kiểm tra $_GET[ơ'cid']
                if(isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
                    $cid = $_GET['cid'];
                } else {
                    $cid = NULL;
                }
                    //Lấy dữ liệu từ CSDL
                    $q = "SELECT cat_id, cat_name FROM categories ORDER BY position ASC";
                    $r = mysqli_query($dbc, $q);
                    confirm_query($r, $q);
                        
                    while($cats = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                        echo "<li><a href='index.php?cid={$cats['cat_id']}'";
                                
                        //Kiểm tra xem category nào đang được chọn                    
                        if($cats['cat_id'] == $cid) {
                            echo "class='selected'";
                        }                        
                        echo ">". $cats['cat_name'] ."</a></li>";
                    }//End check $cats['cat_id']
                
            ?>
	   </ul>
</div><!--end section-navigation-->
<?php include('includes/mysqli_connect.php');?>
<?php include('includes/functions.php');?>
<?php
    if(isset($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
        $e = mysqli_real_escape_string($dbc, $_GET['email']);
        
        // Truy van csdl voi email vua nhan duoc
        $q = "SELECT user_id FROM users WHERE email = '{$e}'";
        $r = mysqli_query($dbc, $q); confirm_query($r, $q);
        if(mysqli_num_rows($r) == 1) {
            echo "NO"; // not available
        } else {
            echo "YES"; // email avalialbe
        }
    }
?>
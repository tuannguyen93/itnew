<?php
    //Kết nối với cơ sở dữ liêu - CSDL
    $dbc = mysqli_connect('localhost', 'root', '','itnews');
    
    //K?t n?i CSDL không thành công thì báo l?i ra trình duy?t
    if(!$dbc) {
        trigger_error("Không thể kết nối dữ liệu đến CSDL:" . mysqli_connect_error());
    } else {
        //Ð?t phuong th?c k?t n?i là utf-8
        mysqli_set_charset($dbc, 'utf-8');
    }
?>
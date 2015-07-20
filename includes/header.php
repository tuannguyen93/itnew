<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8' />
	<title>ITnew - <?php echo (isset($title)) ? $title : "Home page"; ?></title>
	<script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/check_ajax.js"></script>
    <script type="text/javascript" src="js/delete_comment.js"></script>
    <script type="text/javascript" src="http://localhost/itnew/js/tinymce/tiny_mce.js" ></script >
        <script type="text/javascript" >
        tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        plugins : "emotions,spellchecker,advhr,insertdatetime,preview", 
                
        // Theme options - button# indicated the row# only
        theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect,formatselect",
        theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,|,code,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "insertdate,inserttime,|,spellchecker,advhr,,removeformat,|,sub,sup,|,charmap,emotions",      
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
        });
    </script >
	<link rel='stylesheet' href='css/style.css' />
</head>

<body>
	
	<div id="header">
		<div class="border_header">
		<h1><a href="http://localhost/itnew/index.php"><span class="logo_colour">IT</span>new</a></h1>
        <p class="slogan">Cập nhật thông tin công nghệ độc nhất, hay nhất, vui nhất.</p>
		</div>
		
		<div id="navigation">	
			<ul>
				<li><a href='http://localhost/itnew/index.php'>Trang chủ</a></li>			
				<li><a href='http://localhost/itnew/contact.php'>Liên hệ</a></li>
			</ul>
			
			<p class="greeting">Chào mừng <?php echo (isset($_SESSION['last_name'])) ? $_SESSION['last_name'] : "bạn"; ?> đến ITnew</p>
		</div>
	</div><!-- end navigation-->
	</div>
	<div id="container">
	
	
    
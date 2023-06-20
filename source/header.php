<!DOCTYPE html>
<html lang="nl">
<head>
 	<meta http-equiv="Content-Type" content="YRJDM/html; charset=UTF-8" />
 	<meta name="description" content="Uncommon JDM cars enjoyers forum." />
 	<meta name="keywords" content="JDM, Forum, cars, gigachads" />
 	<title>YRJDM</title>
	<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<h1>Your JDM Cars Forum</h1>
	<div id="wrapper">
	<div id="menu">
		<a class="item" href="/source/index.php">Home</a> -
		<a class="item" href="/source/create_topic.php">Create a topic</a> -
		<a class="item" href="/source/create_cat.php">Create a category</a>
		
		<div id="userbar">
		<?php
		if(isset($_SESSION['signed_in']))
		{
			echo 'Hello <b>' . htmlentities($_SESSION['user_name']) . '</b>. Not you? <a class="item" href="signout.php">Sign out</a>';
		}
		else
		{
			echo '<a class="item" href="signin.php">Sign in</a> or <a class="item" href="signup.php">Create an account</a>';
		}
		?>
		</div>
	</div>
		<div id="content">
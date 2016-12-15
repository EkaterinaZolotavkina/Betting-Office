<?php
session_start();
require_once 'db.php';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta name="keywords" content="" />
		<meta name="description" content="" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Букмекер</title>
		<link href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="style.css" /> 	
	</head>
	<body>
		<div id="bg">
			<div id="outer">
				<div id="header">
					<div id="logo">
						<h1>
							<a href="index.php">Букмекерская контора</a>
						</h1>
					</div>
					<div id="nav">
						<ul>
						<?php
						if(isset($_SESSION['user']))
						{
							echo '<li class="first active">
							<a href="profile.php?id=' . $_SESSION['user'] . '">Личный кабинет</a>
							</li>
							<li>
							<a href="logout.php?logout">Выход</a>
							</li>';
						}
						else{
						?>
							<li class="first active">
								<a href="register.php">Регистрация</a>
							</li>
							<li>
								<a href="login.php">Авторизация</a>
							</li>
						<?php
						}
						?>
						</ul>
						<br class="clear" />
					</div>
				</div>
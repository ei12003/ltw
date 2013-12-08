<?php
session_start();
if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = null;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Sistema de Faturação Online </title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.js"></script>
		<script type="text/javascript" src="search.js"></script>
	</head>
	<body>
		<div id="cabecalho">
			<h1>Sistema de Faturação Online</h1>
		</div>
		<div id="menu">
			<ul>
			<li><a href="index.php">Início</a></li>
			<?
			if($_SESSION['login']==null || $_SESSION['login']=="error"){
				echo '<li><a href="login.php">Login</a></li>';
				echo '<li><a href="register.php">Register</a></li>';
				
			}
			else{
				echo '<li><a href="search.php">Search</a></li>';
				if($_SESSION['permission']==1)
					echo '<li><a href="manage.php">Manage Users</a></li>';
				
				echo '<li><a href="action/logout.php">Logout</a></li>';
				}
			
			?>
				
			</ul>
			
		</div>
		
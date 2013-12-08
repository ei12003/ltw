<?php include_once './header.php'; ?>
<?
if(isset($_SESSION['register'])){
	if (($_SESSION['register'] == "success") || (isset($_SESSION['login'])))
		header('Location: index.php');
	else if ($_SESSION['register'] == "failed"){
		echo 'Register Failed: Try Again';
		$_SESSION['register']=null;
	}
	else
		$_SESSION['register']=null;
}
?>


<h1>Register</h1>

<form name="log" action="api/addUser.php" method="post">
Username: <input class="form" type="text" name="username"><br />
Password: <input class="form" type="password" name="password"><br />
<input name="submit" type="submit" value="Submit">
</form>

<?php include_once './footer.php'; ?>
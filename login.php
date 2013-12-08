<?php include_once './header.php';

if ($_SESSION['login'] == "error") {
echo 'Login Failed: Try Again';
$_SESSION['login']=null;
}
?>

<form name="log" action="action/login.php" method="post">
Username: <input class="form" type="text" name="username"><br />
Password: <input class="form" type="password" name="password"><br />
<input name="submit" type="submit" value="Submit">
</form>

 <?php include_once './footer.php'; ?>
<? 
session_start();
if (!isset($_SESSION['login'])) {
    $_SESSION['login'] = null;
}
	$failed = 1;
	if (isset($_POST['username']) && isset($_POST['password'])) {
		$db = new PDO('sqlite:../data/database.db');
		
		$query = 'SELECT Username, Password, Permission FROM users WHERE Username = \''.$_POST['username'].'\' AND Password = \''.$_POST['password'].'\'';
		$rows = $db->query($query);

		foreach($rows as $row){
		if(isset($row['Username']))
			$failed = 0;
		}
		
		if($failed==1)
		{
			$_SESSION['login'] = "error";
			//ERROR?
			$_SESSION['permission'] = null;
			header("Location: ../login.php");
		}
		else
		{
			$_SESSION['login'] = $_POST['username'];
			$_SESSION['permission'] = $row['Permission'];
			header("Location: ../search.php");
		}
			
	}
?>
 
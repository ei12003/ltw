
<?
session_start();

if (( (!isset($_SESSION['login'])) && (isset($_POST['username']) && isset($_POST['password']))) ||
	(isset($_SESSION['login']) && $_SESSION['permission']==1))
{
	$db = new PDO('sqlite:../data/database.db');		
	$query = 'Insert Into users values(\''.$_POST['username'].'\',\''.$_POST['password'].'\',3);';
	$result = $db->query($query);
	
	if($result){
		if(!isset($_SESSION['login'])){
			$_SESSION['login'] = $_POST['username'];
			$_SESSION['permission'] = 3;
			header('Location:../index.php');
		}
		else{
			echo "success";
		}
	}
	else
		echo "failed";
}
?>


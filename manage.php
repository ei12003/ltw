<?php include_once './header.php'?>



<?
if($_SESSION['login']==null || $_SESSION['login']=="error" || $_SESSION['permission']!=1)
echo "Not Authorized";
else
{

	$db = new PDO('sqlite:data/database.db');
	$query = 'SELECT Username, Permission FROM users';
	$rows = $db->query($query);
	
	?>
		
	<table border="1" class="usersList">
	
	<td>Username</td><td><b>Type</b></td>
	
	<?
	foreach($rows as $row){		
		?>
	<tr class="<? echo $row['Username']; ?>" >
		<td><? echo $row['Username']; ?></td>
		<td>
		<select class="user_types" id="<? echo $row['Username'];?>">
		<option <? if($row['Permission']==1) echo "selected"; ?> >Admin</option>
		<option <? if($row['Permission']==2) echo "selected"; ?> >Editor</option>
		<option <? if($row['Permission']==3) echo "selected"; ?> >Reader</option>
		</select>
		</td>
		<td><button class="deleteUser" id ="<? echo $row['Username'];?>">Delete</button></td>
	</tr>
		
		<?
	}
	echo "</table>";
	?>
	<br />
	<form name="log" action="api/addUser.php" method="post">
		<input name="submit" type="submit" value="Add User">
		Username: <input class="form" type="text" name="username">
		Password: <input class="form" type="password" name="password"><br />
		<select class="form" name="mydropdown"><option value="Milk">Fresh Milk</option><option value="Cheese">Old Cheese</option><option value="Bread">Hot Bread</option>
</select>
	</form>

	<?
}
?>

<script>
$(document).on('change','.user_types',function(){
	$.post( "api/updateUser.php", { user: this.id, new_perm: this.value } );	
});

$(document).on('click','.deleteUser',function(){
	$.post( "api/deleteUser.php", { user: this.id} );	
	$("tr").remove('.'+this.id);
});
$(document).on('click','input[type=\"submit\"]',function(e){
	e.preventDefault();
	$user = $("input[type=\"text\"]").val();
	$.post( "api/addUser.php", {username: $user, password: $("input[type=\"password\"]").val()} );
	$(".usersList").append('<tr class="'+$user+'"><td>'+$user+'</td><td><select class="user_types" id="'+$user+'"><option>Admin</option><option  >Editor</option><option selected >Reader</option></select></td>		<td><button class="deleteUser" id ="'+$user+'">Delete</button></td>	</tr>');	
});
</script>

<?php include_once './footer.php'; ?>


<?php
	require_once 'dbcon.php';
 
	if(isset($_GET['delete_id']))
	{
		$stmt_select = $DB_con->prepare('SELECT userprofile FROM users WHERE userid =:uid');
		$stmt_select->execute(array(':uid'=>$_GET['delete_id']));
		$imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		unlink("user_images/".$imgRow['userprofile']);
		$stmt_delete = $DB_con->prepare('DELETE FROM users WHERE userid =:uid');
		$stmt_delete->bindParam(':uid',$_GET['delete_id']);
		$stmt_delete->execute();	
		header("Location: index.php");
	}
?>
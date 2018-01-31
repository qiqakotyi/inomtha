<div class="container">
<h1 align="center">PHP/MySQL Add, Edit, Delete, With User Profile.</h1>
	<div class="page-header">
    	<h1 class="h2">&nbsp; List of Members<a class="btn btn-success" href="addmember.php" style="margin-left: 770px;"><span class="glyphicon glyphicon-user"></span>&nbsp; Add Member</a></h1><hr>
    </div>
<div class="row">
<?php
	$stmt = $DB_con->prepare('SELECT userid, username, description, userprofile FROM users ORDER BY userid DESC');
	$stmt->execute();
if($stmt->rowCount() > 0)
{
	while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		extract($row);
		?>
		<div class="col-xs-3">
			<h3 class="page-header" style="background-color:cadetblue" align="center"><?php echo $username."<br>".$description; ?></h3>
			<img src="uploads/<?php echo $row['userprofile']; ?>" class="img-rounded" width="250px" height="250px" /><hr>
			<p class="page-header" align="center">
			<span>
			<a class="btn btn-primary" href="editform.php?edit_id=<?php echo $row['userid']; ?>"><span class="glyphicon glyphicon-pencil"></span> Edit</a> 
			<a class="btn btn-warning" href="?delete_id=<?php echo $row['userid']; ?>" title="click for delete" onclick="return confirm('Are You Sure You Want To Delete This User?')"><span class="glyphicon glyphicon-trash"></span> Delete</a>
			</span>
			</p>
		</div>       
		<?php
	}
}
else
{
	?>
	<div class="col-xs-12">
		<div class="alert alert-warning">
			<span class="glyphicon glyphicon-info-sign"></span>&nbsp; No Data Found.
		</div>
	</div>
	<?php
}
?>
</div>
</div>
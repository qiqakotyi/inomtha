<?php
	error_reporting( ~E_NOTICE );
	require_once 'dbcon.php';
 
	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$id = $_GET['edit_id'];
		$stmt_edit = $DB_con->prepare('SELECT username, description, userprofile FROM users WHERE userid =:uid');
		$stmt_edit->execute(array(':uid'=>$id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
	else
	{
		header("Location: index.php");
	}
	if(isset($_POST['btn_save_updates']))
	{
		$username = $_POST['user_name'];
		$description = $_POST['description'];		
		$imgFile = $_FILES['user_image']['name'];
		$tmp_dir = $_FILES['user_image']['tmp_name'];
		$imgSize = $_FILES['user_image']['size'];
		if($imgFile)
		{
			$upload_dir = 'uploads/';
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
			$userprofile = rand(1000,1000000).".".$imgExt;
			if(in_array($imgExt, $valid_extensions))
			{			
				if($imgSize < 5000000)
				{
					unlink($upload_dir.$edit_row['userprofile']);
					move_uploaded_file($tmp_dir,$upload_dir.$userprofile);
				}
				else
				{
					$errMSG = "Sorry, Your File Is Too Large To Upload. It Should Be Less Than 5MB.";
				}
			}
			else
			{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF Extension Files Are Allowed.";		
			}	
		}
		else
		{
			$userprofile = $edit_row['userprofile'];
		}
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('UPDATE users SET username=:uname, description=:udes, userprofile=:upic WHERE userid=:uid');
			$stmt->bindParam(':uname',$username);
			$stmt->bindParam(':udes',$description);
			$stmt->bindParam(':upic',$userprofile);
			$stmt->bindParam(':uid',$id);
 
			if($stmt->execute()){
				?>
                <script>
				alert('Successfully Updated...');
				window.location.href='home.php';
				</script>
                <?php
			}
			else{
				$errMSG = "Sorry User Could Not Be Updated!";
			}
		}			
	}
?>
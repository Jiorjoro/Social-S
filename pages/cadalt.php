<html>
	<head>
		<title>Alterar Cadastro | Social S</title>
		<link rel="shortcut icon" href="../media/default/favicon.png" type="image/x-icon">
	</head>
<body>
		<center>
		
			<?php 
				session_start();
										
				$_SESSION['cadAction'] = 'alterar';
				$userId = $_SESSION['cadUserId'];
				
				require '../php/dbconection.php';
				
				$sql = "SELECT `email`, `userName`, `userPicture` FROM logins WHERE userId='$userId'"; // sql
				$result = mysqli_query($conn, $sql);				
				
				//pega as variaveis
				if (mysqli_num_rows($result) == 1) {
					while($row = mysqli_fetch_assoc($result)) {
						$email = $row['email'];
						$userName = $row['userName'];
						$oldPic = $_SESSION['oldPic'] = $row['userPicture'];						
					}
				}
			?>
			
			<form method='post' action='../php/conc.php' enctype="multipart/form-data" name='login'>
			<label>Email: </label>
			<input type='text' name='email' value='<?php echo $email; ?>' /><br />
			<label>Senha: </label>
			<input type='text' name ='senha' /><br />
			<label>Nome: </label>
			<input type='text' name='userName' value='<?php echo $userName; ?>' /><br />
			<label>Foto padrão: <?php echo $oldPic; ?></label><br />
			<input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
			<input type="file" name="fileToUpload" accept="image/*" ><br />
			<?php if(isset($_SESSION['uploadErr']) && !empty($_SESSION['uploadErr'])){ echo $_SESSION['uploadErr']; } ?><br />			
			<br/>
			<input type='submit' value='ALTERAR' />
			</form>
		</center>
</body>
</html>
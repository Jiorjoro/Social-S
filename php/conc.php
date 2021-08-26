<html>
	<body>
		<?php
			session_start();//iniciou sessão
			
			require 'functions.php';
			
			require 'dbconection.php';
			
			date_default_timezone_set("America/Belem");	
			
			//checa se é cadastro ou alteração
			if($_SESSION['cadAction'] == 'cadastrar'){
				$email = qBoa($_POST['email']);
				$senha = md5(qBoa($_POST['senha']));
				$userName = qBoa($_POST['userName']);
				$userPicture = '../media/usersPictures/defaultIcon.png';
				
				$target_file = '';
				if (!empty($_FILES['fileToUpload']['tmp_name'])) {
					
					//preparação dos dados			
					$target_dir = "../media/usersPictures/"; // pasta onde vai
					$target_file = $target_dir .  date("Ymd_His") . '.' . pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION); //nome que vai receber			
					$extension = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION)); // extensão
					$fileMime = explode('/', $_FILES['fileToUpload']['type'])[0]; // imagem / video
					$uploadErr = ''; // erro pra retornar ao usuário
					empty($_FILES['fileToUpload']);
					//checa se é imagem
					if (isset($_POST['submit'])) {
						$check = getimagesize($_FILES['fileToUpload']['tmp_name']);
						if ($check !== false) {
							echo $check['mime'];
						} else if ( $fileMime == 'image') {
							//nada muda, era só pra testar mermo
						} else {
							$uploadErr =  'Somente IMAGENS podem ser enviadas';					
						}
					}
					
					// checa as extensões
					if ($extension != 'png' 
					&& $extension != 'jpg' 
					&& $extension != 'jpeg' 
					&& $extension != 'gif') {
						$uploadErr = 'Formato Incompatível.';
					}
					
					// limite de tamanho (em bytes)
					if ($_FILES['fileToUpload']['size'] > 50000000) {
						$uploadErr =  'Limite de arquivos (50MB) Excedido';
					}
					
					// se tudo tiver de boa salva o arquivo
					if ($uploadErr == '') {
						move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file);
						if ($fileMime == 'image') {
							$userPicture = $target_file;
						}
						unset($_SESSION['uploadErr']);
					} else {				
						$_SESSION['uploadErr'] = $uploadErr;
						header("Location: ../pages/cadlog.php");
						exit();
					}
					
				}
				
				//código da MySQLi
				$sql = mysqli_prepare($conn, "INSERT INTO `logins` (`email`, `senha`, `userName`, `userPicture`) VALUES (?,?,?,?)");
				mysqli_stmt_bind_param($sql, "ssss", $email, $senha, $userName, $userPicture);
				mysqli_stmt_execute($sql);
				mysqli_stmt_close($sql);
				mysqli_close($conn);
				
				// limpa a sessão
				session_unset();
				session_destroy();
				
				//retorna para outra checagem
				header("Location: ../pages/login.php");
				exit();
				
			} else if($_SESSION['cadAction'] == 'alterar'){
				$userId = qBoa($_SESSION['cadUserId']);
				$email = qBoa($_POST['email']);				
				$userName = qBoa($_POST['userName']);
				$oldPic = $_SESSION['oldPic'];
				$userPicture = '../media/usersPictures/' . basename($_FILES['fileToUpload']['name']);
				
				if($oldPic != $userPicture && !empty($_FILES['fileToUpload']['tmp_name'])) {	
					
					$target_file = '';
											
					//preparação dos dados			
					$target_dir = "../media/usersPictures/"; // pasta onde vai
					$target_file = $target_dir .  date("Ymd_His_") . $userId . '.' . pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION); //nome que vai receber			
					$extension = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION)); // extensão
					$fileMime = explode('/', $_FILES['fileToUpload']['type'])[0]; // imagem / video
					$uploadErr = ''; // erro pra retornar ao usuário
					
					//checa se é imagem
					if (isset($_POST['submit'])) {
						$check = getimagesize($_FILES['fileToUpload']['tmp_name']);
						if ($check !== false) {
							echo $check['mime'];
						} else if ( $fileMime == 'image') {
							//nada muda, era só pra testar mermo
						} else {
							$uploadErr =  'Somente IMAGENS podem ser enviadas';					
						}
					}					
					
					// checa as extensões
					if ($extension != 'png' 
					&& $extension != 'jpg' 
					&& $extension != 'jpeg' 
					&& $extension != 'gif') {
						$uploadErr = 'Formato Incompatível.';
					}
					
					// limite de tamanho (em bytes)
					if ($_FILES['fileToUpload']['size'] > 50000000) {
						$uploadErr =  'Limite de arquivos (50MB) Excedido';
					}
					
					// se tudo tiver de boa salva o arquivo
					if ($uploadErr == '') {
						move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file);
						if ($fileMime == 'image') {
							$userPicture = $target_file;
						}
						unset($_SESSION['uploadErr']);
					} else {				
						$_SESSION['uploadErr'] = $uploadErr;
						header("Location: ../pages/cadalt.php");
						exit();
					}
						
					
				} else if ($oldPic != $userPicture && empty($_FILES['fileToUpload']['tmp_name'])) {
					$userPicture = $oldPic;
				}
				
				if(!empty($_POST['senha'])) {
					$senha = md5(qBoa($_POST['senha']));
					//código da MySQLi
					$sql = mysqli_prepare($conn, "UPDATE `logins` SET `email`=?,`senha`=?, `userName`=?, `userPicture`=? WHERE userId=?");
					mysqli_stmt_bind_param($sql, "ssssi", $email, $senha, $userName, $userPicture, $userId);
					
				} else if (empty($_POST['senha'])) {
					//código da MySQLi
					$sql = mysqli_prepare($conn, "UPDATE `logins` SET `email`=?, `userName`=?, `userPicture`=? WHERE userId=?");
					mysqli_stmt_bind_param($sql, "sssi", $email, $userName, $userPicture, $userId);
					
				}
				
				mysqli_stmt_execute($sql);
				mysqli_stmt_close($sql);
				mysqli_close($conn);
				
				// limpa a sessão
				session_unset();
				session_destroy();
				
				//retorna para outra checagem
				header("Location: ../pages/cadcheck.php");
				exit();
			}
		?>		
	</body>
</html>
<?php
	
	session_start();
	
	require("functions.php");
	require("dbconection.php");
	
	//* separa os códigos de trocar foto/senha
	if($_POST['submit'] == "Trocar Senha"){
		$oldPass = md5($_POST['oldPass']);
		$userId = $_SESSION['userId'];
		$newPass = $_POST['newPass'];
		$newPassC = $_POST['newPassC'];
		
		//pega a senha real
		$sql = $conn->prepare("SELECT senha FROM logins WHERE userId = ?");
		$sql->bind_param('i', $userId);
		$sql->execute();
		$result = $sql->get_result();
		
		while($row = $result->fetch_assoc()){
			$realPass = $row['senha'];
		}
		$sql->close();
		
		//checa se a senha correta foi informada
		if($oldPass == $realPass){
			
			//verifica se a nova senha coincide
			if($newPass == $newPassC){
				$sql = $conn->prepare("UPDATE logins SET senha=? WHERE userId=?");
				$sql->bind_param('si', md5($newPass), $userId);
				$sql->execute();
				$conn->close();
				
				$_SESSION['updateMsg'] = "Senha Trocada";
				header("Location: ../pages/userConfigPanel.php");
				exit();
			} else {
				$_SESSION['updateMsg'] = "Novas Senhas Não Coincidem";
				header("Location: ../pages/userConfigPanel.php");
				exit();
			}
		} else {
			$_SESSION['updateMsg'] = "Senha Atual Incorreta";
			header("Location: ../pages/userConfigPanel.php");
			exit();
		}
	
	//* Trocar Imagem
	} elseif($_POST['submit'] == "Trocar Foto"){
		
		$userId = $_SESSION['userId'];
		
		/* começo do código de imagem */
		date_default_timezone_set("America/Belem");	
		$target_file = '';
		
		if (!empty($_FILES['fileToUpload']['tmp_name'])) {
			
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
				} elseif ( $fileMime == 'image') {
					//nada muda, era só pra testar mermo
				} else {
					$uploadErr =  'Somente IMAGENS podem ser enviadas';					
				}
			}					
			
			// checa as extensões
			if ($extension != 'png' 
			&& $extension != 'jpg' 
			&& $extension != 'jpeg' 
			&& $extension != 'gif' 
			&& $extension != 'jfif' ) {
				$uploadErr = 'Formato Incompatível';
			}
			
			// limite de tamanho (em bytes)
			if ($_FILES['fileToUpload']['size'] > 50000000) {
				$uploadErr =  'Limite de arquivos(50MB) Excedido';
			}
			
			// se tudo tiver de boa salva o arquivo
			if ($uploadErr == '') {
				// código sql
				$sql = $conn->prepare("UPDATE logins SET userPicture=? WHERE userId=?");
				$sql->bind_param('si', $target_file, $userId);
				$sql->execute();
				$sql->close();
				$conn->close();

				// atualiza o usuário
				$_SESSION['userPicture'] = $target_file;
				if(isset($_COOKIE['userPicture'])){
					setcookie('userPicture', $target_file, time() + (86400 * 3), "/");
				}

				// salva o arquivo
				move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file);
				unset($_SESSION['uploadErr']);
				
			} else {				
				$_SESSION['uploadErr'] = $uploadErr;
				header("Location: ../pages/userConfigPanel.php");
				exit();
			}
			
		}
		/* fim do código de imagem */
		
		header("Location: ../pages/userConfigPanel.php");
		exit();
		
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="../css/css.css">
	<link rel="stylesheet" href="../css/cadastro.css">
	<link href="../css/feather.css" rel="stylesheet" type="text/css">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="../media/default/favicon.png" type="image/x-icon">
	<title>Cadastro | Social S</title>
</head>
<body>
	<center>
		<?php //essa parte do php é só pra exibir uma mensagem de erro no login
			session_start();
				
			$_SESSION['cadAction'] = 'cadastrar';
			if(isset($_SESSION['email'])){
				$email = $_SESSION['email'];
			} else {
				$email = '';
			}
		?>
		<div class="container">
			<div class="imgLogo">
				<a href="login.php"><img src="../media/default/logo.png" alt="Logo Senai" width="30%"></a>
			</div>
			<div class="divisor">
			</div>
			<div class="container2">
			<a class="bolsonaro" href="login.php"><i class="feather-arrow-left"> Início </i></a>
				<form class='formCadastrar' method='post' action='../php/conc.php' enctype="multipart/form-data" name='login'>
						<label>Email:</label>
					<input type='text' name='email' placeholder='Email' value='<?php echo $email; ?>' /><br />
						<label>Senha:</label>
					<input type='password' name ='senha' placeholder='Senha' /><br />
						<label>Nome:</label>
					<input type='text' name='userName' placeholder='Seu nome' /><br />
						<!-- <label>Sobrenome: </label>
					<input type='text' name='userSobrenome' placeholder='Seu sobrenome' /> <br /> -->
					<input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
					<label class='labelNovaFoto' for="fileToUpload">
                    	<i class='feather-paperclip'></i>
                    	Escolha sua nova foto
                	</label>
					<input type="file" name="fileToUpload" id="fileToUpload"><br />
						<?php if(isset($_SESSION['uploadErr']) && !empty($_SESSION['uploadErr'])){ echo $_SESSION['uploadErr']; } ?><br />
					<input type='submit' value='CADASTRAR' />
				</form>
			</div>
		</div>
	</center>
</body>
</html>

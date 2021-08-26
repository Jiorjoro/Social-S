<?php // se houver cookie pula para o site
	session_start();
	if (isset($_COOKIE['userId']) && isset($_COOKIE['userName'])) {			
		header("Location: feed.php");				
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="../css/login.css">
		<link rel="stylesheet" href="../css/css.css">
		<link href="../css/feather.css" rel="stylesheet" type="text/css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
		<link rel="shortcut icon" href="../media/default/favicon.png" type="image/x-icon">
		<title>Login | Social S</title>
	</head>
<body>
	
	<div class="imgLogo">
		<img src="../media/default/logo.png" alt="Logo Senai" width="50%">
	</div>
	<div class="divisor">
	</div>
	<div class="login">
		<form class="formLogin" method='post' action='../php/conl.php' name='login'>
				<label>Insira seu email: </label>
			<input class="inputLogin" type='text' name='email' placeholder='Seu email'/>
				<label>Sua senha:</label>
			<input class="inputSenha" type='password' name ='senha' placeholder='Sua senha'/>
				<p>Mantenha-me logado</p>
			<input class="manterOn" type='checkbox' name='keepLogged' value='true'/>
			<?php //essa parte do php é só pra exibir uma mensagem de erro no login				
				if(!empty($_SESSION['loginError'])){
					echo $_SESSION['loginError'];
				}
			?>
			<input class="botaoLogar" type='submit' value='Logar'/>
		</form>
	</div>
	<div class='cadastrar'>
		<a href="cadlog.php">Cadastrar</a>
	</div>
</body>
</html>

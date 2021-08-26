<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cadcheck.css">
    <link rel="stylesheet" href="../css/css.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
	<link rel="shortcut icon" href="../media/default/favicon.png" type="image/x-icon">
    <title>Cadastro | Social S</title>
</head>
	<body>
		<center>
			<form method='post' action='<?php echo $_SERVER["PHP_SELF"] ?>' name='login'>
				<label>Confira se o email já está cadastrado</label>
				<input type='text' name='email' placeholder='Email' /><br />
				<br/>
				<input type='submit' value='VERIFICAR' /> <br><br>
				<?php 
					session_start();
					
					require '../php/functions.php';
					
					if ($_SERVER["REQUEST_METHOD"] == "POST"){
						$email = qBoa($_POST['email']);
						
						require '../php/dbconection.php';
						
						//código da MySQLi
						$sql = mysqli_prepare($conn, "SELECT `userId` FROM logins WHERE email=?");
						mysqli_stmt_bind_param($sql, "s", $email);
						mysqli_stmt_execute($sql);
						$result = mysqli_stmt_get_result($sql);
		
						//resultado do pedigo parte do login
						if (mysqli_num_rows($result) == 1) {
							while($row = mysqli_fetch_assoc($result)) {
								$_SESSION['cadUserId'] = $row['userId'];
								echo "<br/>Email Já Cadastrado: Id = " . $row['userId'] . "<br/>";
								echo "<br/><a href='cadalt.php'>Alterar Cadastro</a>";
							}
						} else if (mysqli_num_rows($result) == 0) {
							$_SESSION['email'] = $email;
							echo "<br/>Email Ainda Não Cadastrado<br/>";
							echo "<br/><a href='cadlog.php'>Cadastrar</a>";
						}
						mysqli_stmt_close($sql);
						mysqli_close($conn);
					}
				?>
			</form>
		</center>
	</body>
</html>
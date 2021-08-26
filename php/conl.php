<html>
	<body>
		<?php
			session_start();//iniciou sessão
			
			require 'functions.php';
			
			//checa se o login está em branco 
			if(empty($_POST['email']) || empty($_POST['senha'])){
				$_SESSION['loginError'] = 'PREENCHA TODOS OS DADOS';
				header("Location: ../pages/login.php");
				exit();
			} else { 						
				
				// define as variáveis
				$email = qBoa($_POST['email']);
				$senha = md5(qBoa($_POST['senha']));
				
				require 'dbconection.php';
				
				//código da MySQLi
				$sql = mysqli_prepare($conn, "SELECT userId, userName, userPicture FROM logins WHERE email=? AND senha=?");
				mysqli_stmt_bind_param($sql, "ss", $email, $senha);
				mysqli_stmt_execute($sql);
				$result = mysqli_stmt_get_result($sql);

				//resultado do pedigo parte do login
				if (mysqli_num_rows($result) == 1) {
					while($row = mysqli_fetch_assoc($result)) {
						//salva o userId e nome para o site
						if (isset($_POST['keepLogged']) && $_POST['keepLogged'] == true) { //salva em cookie
							setcookie('userId', $row['userId'], time() + (86400 * 3), "/");
							setcookie('userName', $row['userName'], time() + (86400 * 3), "/");
							setcookie('userPicture', $row['userPicture'], time() + (86400 * 3), "/");
						}
						//salva em sessão
						$_SESSION['userId'] = $row['userId'];
						$_SESSION['userName'] = $row['userName'];
						$_SESSION['userPicture'] = $row['userPicture'];

					}
					mysqli_stmt_close($sql);
					mysqli_close($conn);
					header("Location: ../pages/feed.php");
					exit();
				} else if (mysqli_num_rows($result) == 0) {
					$_SESSION['loginError'] = "Dados Invalidos";
					mysqli_stmt_close($sql);
					mysqli_close($conn);
					header("Location: ../pages/login.php");
					exit();
				}
			}
		?>		
	</body>
</html>
<html>
	<body>
		<?php
			session_start();
			
			// deleta a sessão
			session_unset();
			session_destroy();
			
			//deleta os cookies
			if(isset($_COOKIE['userId']) || isset($_COOKIE['userName']) || isset($_COOKIE['userPicture'])){
				setcookie('userId', '', time() - (86400 * 4), "/");
				setcookie('userName', '', time() - (86400 * 4), "/");
				setcookie('userPicture', '', time() - (86400 * 4), "/");
				unset($_COOKIE['userId']);
				unset($_COOKIE['userName']);
				unset($_COOKIE['userPicture']);
			}
			
			header("Location: ../pages/login.php");
		?>		
	</body>
</html>
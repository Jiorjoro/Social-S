<nav class="navbar cabecalhoSite">
	<a href="feed.php"><img class="logo-site" src="../media/default/logo.png" alt="Logo" width="40%"></a>
		<div class="perfil-buscador">
			<!-- form para pesquisa -->
			<form class='buscador' method='post' action="busca.php" name='login'>
				<select class='dropbox' name='scope'>
					<option value='tags'>Tags</option>
					<option value='postContent'>Posts</option>
					<option value='profile'>Pessoas</option>
				</select>
				<i class="feather-search"></i>
					<input class='pesq'type='search' name='pesquisa' placeholder='Pesquisar' />
					<input class='botaoPostar' type='submit' value='Buscar' />
			</form>
			<!-- fim do form para pesquisa -->
			<!-- dropbox do usuário -->
			<ul class="lista-nav">
				<li class="nav-item dropdown">
					<img class='userPicture' src="
							<?php
								echo $_SESSION['userPicture'];
							?>" width='60px'/>
					<ul class="dropdown-menu">
						<li><a href="perfil.php?pU=<?php echo $userId; ?>" class="dropdown-item user"><i class="feather-user"></i>Meu Usuário</a></li>
						<li><a href="userConfigPanel.php" class="dropdown-item config"><i class="feather-settings"></i>Configurações</a></li>
						<li><div class="dropdown-divisor"></div></li>
						<li><a href="../php/logout.php" class="dropdown-item sair"><i class="feather-log-out"></i>Sair</a></li>
					</ul>
				</li>
			</ul>
			<!-- fim do dropbox do usuário -->
		</div>
</nav>
<?php
	//dados para fazer a conexão
	$bdid = 'socials_bd';
	$server = 'socials_bd.mysql.dbaas.com.br';
	/* user em casa */
	$bduser = 'socials_bd';
	$bdpass = 'tEr24082021!';
	
	$conn = new mysqli($server, $bduser, $bdpass, $bdid); // conecta no BD
	
	mysqli_set_charset($conn, 'utf8mb4');
?>
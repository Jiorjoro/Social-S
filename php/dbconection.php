<?php
	//dados para fazer a conexão
	$bdid = '' /* nome do bd */;
	$server = '' /* servidor */;
	$bduser = '' /* usuário do bd */ ;
	$bdpass = '' /* senha do bd */ ;
	
	$conn = new mysqli($server, $bduser, $bdpass, $bdid); // conecta no BD
	
	mysqli_set_charset($conn, 'utf8mb4'); // evita erros de encodificação
?>

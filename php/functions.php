<?php
	
	function qBoa($valor) {
		$valor = trim($valor);
		$valor = filter_var($valor, FILTER_SANITIZE_STRING);
		return $valor;
	}
	
?>
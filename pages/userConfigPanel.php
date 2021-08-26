<?php 
	require '../php/coockiecheck.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/config.css">
    <link href="../css/feather.css" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../media/default/favicon.png" type="image/x-icon">
    <title>Configurações | Social S</title>
</head>
<body>

    <?php
		include "../templates/cabecalho.php"; 
	?>

<form class='formCadastrar' method='post' action='../php/userConfig.php' enctype="multipart/form-data" name='changePass'>
    <div class="quadradoTrocarpass">
        <h3 class='titlePass'>Alterar Senha</h3>
			<input class='password' type='password' name ='oldPass' placeholder='Senha antiga'/>
			<input class='password' type='password' name ='newPass' placeholder='Nova senha'/>
            <input class='password' type='password' name ='newPassC' placeholder='Confirme a nova senha'/>
			<?php 
				if(isset($_SESSION['updateMsg']) && !empty($_SESSION['updateMsg'])) {
					echo $_SESSION['updateMsg']; } 
			?>
        <input class='botaoPass' type='submit' name='submit' value='Trocar Senha'/>
    </div>

<form class='trocarPic' method='post' action='../php/userConfig.php' enctype="multipart/form-data" name='changePic'>        
    <div class="quadradoTrocarPic">
        <h3 class='titlePic'>Alterar Foto de perfil</h3>
            <input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
                <label class='labelNovaFoto' for="fileToUpload">
                    <i class='feather-paperclip'></i>
                    Escolha sua nova foto
                </label>
			    <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*" />
                <?php 
                    if(isset($_SESSION['uploadErr']) && !empty($_SESSION['uploadErr'])) {
                        echo $_SESSION['uploadErr']; } 
                ?>
            <input class='botaoPic' type='submit' name='submit' value='Trocar Foto'/>
    </div>

	
	<?php include "../templates/rodape.php"; ?>
	
</body>
<script src="../js/visuals.js"></script>
<script>
//eventos
document.body.addEventListener("load", setRodape());

</script>
</html>
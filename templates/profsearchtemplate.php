<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" href="../css/searchtemplate.css">
	<link rel="stylesheet" href="../css/global.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
</head>
<body>
	<a href="../pages/perfil.php?pU=<?php echo $profUserId; ?>"><table class='container'>
		<tr>
			<td class='profUserPic'>
				<img src="<?php echo $profUserPic; ?>" style='height: 80px; width: 80px; border-radius: 40px;' />
			</td>
			<td>
				<div class='profUserName'>
					<?php echo strtoupper($profUserName); ?>
				</div>
				
				<div class='profUserEmail'>
					<?php echo $profUserEmail; ?>
				</div>
			</td>
	</table></a>
</body>
</html>
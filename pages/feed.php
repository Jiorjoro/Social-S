<?php 
	require '../php/coockiecheck.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/global.css">
    <link href="../css/feather.css" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
	<link rel="shortcut icon" href="../media/default/favicon.png" type="image/x-icon">
    <title>Navegação | Social S</title>
</head>
<body> 

	<?php
		include "../templates/cabecalho.php"; 

		include "../templates/topTagsTemplate.php";
	?>

    <div class="containerConteudo">
    <div id='feedTray' class="pesquisaFeed">						
		<!-- ↓ área para criar um post do jorge -->
		<?php

			require "../php/dbconection.php";

			$getAccess = $conn->prepare("SELECT userAccess FROM logins WHERE userId=?");
			$getAccess->bind_param('i', $userId);
			$getAccess->execute();
			$acRes = $getAccess->get_result();

			while($access = $acRes->fetch_assoc()){
				$userAccess = $access['userAccess'];
			}
			$getAccess->close();

			if($userAccess != "espectador"){
				echo "<div class='fazerUmaPublicacao'>
					<h2 class='textoFazerPost'>Faça um post!</h2>
					<form class='formPost' method='post' action='../php/creatpost.php' name='login' enctype='multipart/form-data'>
						<input type='hidden' name='MAX_FILE_SIZE' value='50000000' />			
						
						<textarea id='digitarTextoPub' name='postTxt' class='digitarTextoPub' maxlength='300' placeholder='O que deseja postar?'></textarea>";
								if(isset($_SESSION['postTxt'])) { 
									echo $_SESSION['postTxt']; 
								}
						
						echo "<input class='digitarTags' placeholder='Tags' type='text' name ='postTags'>";
								if(isset($_SESSION['postTags'])) { 
									echo $_SESSION['postTags']; 
								} 

						echo "<input class='form-control' type='file' name='fileToUpload' id='inputGroupFile' /><br />";
								if(isset($_SESSION['uploadErr']) && !empty($_SESSION['uploadErr'])){
									echo $_SESSION['uploadErr'];
							}
						echo "<input class='enviarPost' type='submit' name='submit' value='Postar' />
					</form>
				</div>";
				}
		?>
		<!-- ↑ área para criar um post do jorge -->
        <div class="divisorLayouts"></div>
			<?php	//popula o feed
			
				require '../php/dbconection.php'; // os dados de conexão

				// pega os posts do bd
				$sql = "SELECT * FROM posts AS p INNER JOIN logins AS u ON p.postUserID = u.userID 
				ORDER BY postId DESC LIMIT 5";			
				$result = mysqli_query($conn, $sql);  //pega os dados da postagem
				
				while ($row = mysqli_fetch_assoc($result)) { //preenche as postagens da pagina

					$postId = $row['postId'];
					$postUserName = $row['userName'];
					$postUserPic = $row['userPicture'];
					$postTxt = $row['postTxt'];
					$postImg = $row['postImg'];
					$postVideo = $row['postVideo'];
					$postTags = $row['postTags'];
					$postComments = "";

					// pega os comentários do post
					$commSql = $conn->prepare("SELECT u.userName, c.commentTxt, DATE_FORMAT(c.commentDate, '%H:%i - %d/%m/%Y') AS commentDate FROM `postcomments` AS c 
					INNER JOIN logins AS u ON c.commentUserId = u.userId WHERE commentPostId = ? ORDER BY commentId ASC");
					$commSql->bind_param('i', $postId);
					$commSql->execute();
					$resultc = $commSql->get_result();

					while ($rowc = $resultc->fetch_assoc()) { //preenche os comentários do post
						
						$commentUserName = $rowc['userName'];
						$commentTxt = $rowc['commentTxt'];
						$commentDate = $rowc['commentDate'];
						
						ob_start();
							include "../templates/postCommentTemplate.php";
						$postComments .= ob_get_clean();

					}

					$commSql->close();

					// pega a imagem do like
					$likeSql = $conn->prepare("SELECT IF((COUNT(likeId)) > 0, '../media/default/fullStarLike.png', 
					'../media/default/emptyStarLike.png') AS postLikeImg FROM postlikes WHERE likePostId=? AND likeUserId=?");
					$likeSql->bind_param("ii", $postId, $_SESSION['userId']);
					$likeSql->execute();
					$resultLike = $likeSql->get_result();

					while($rowl = $resultLike->fetch_assoc()){
						$postLike = $rowl['postLikeImg'];
					}

					$likeSql->close();

					//quantidade de likes
					$sqlL = "SELECT COUNT(likeId) AS totLike FROM postlikes WHERE likePostId = $postId";
					$likeRes = $conn->query($sqlL);

					while($rowL = $likeRes->fetch_assoc()){
						$postTotLike = $rowL['totLike'];
					}

					$likeRes->close();

					include '../templates/posttemplate.php';

				}
				
				$_SESSION['lastPostId'] = $postId;
								
				$conn->close();
			
			?>
		</div>

</div>
</div>
    <button id="scrollToTopBtn" onclick="scrollToTop()"> <i class="feather-chevron-up"></i> </button>
	
	<?php include "../templates/rodape.php"; ?>
	
</body>
<script src="../js/visuals.js"></script>
<script src="../js/postFuncs.js"></script>
<script>
//eventos
window.addEventListener("scroll", function(){loadFeed('feed');});
document.body.addEventListener("load", setRodape());

</script>
</html>
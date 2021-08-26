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
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
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
		<?php	//teste com as postagens
			require '../php/dbconection.php'; // os dados de conexão
			
			if($_SERVER['REQUEST_METHOD']=='POST') {
				if(!empty($_POST['pesquisa'])) {
					$pesquisa = $_SESSION['pesquisa'] = $_POST['pesquisa'];
					$scope =  $_SESSION['scope'] = $_POST['scope'];
				}
			}
			$pesquisa = $_SESSION['pesquisa'];
			$scope =  $_SESSION['scope'];
			
			// define qual a sql
			if ($scope == 'tags' || $scope == 'postContent') {

				if ($scope == 'tags') {
					$sql = mysqli_prepare($conn, "SELECT * FROM posts AS p INNER JOIN logins AS u ON p.postUserID = u.userID 
					WHERE p.postTags LIKE CONCAT('%', ?,'%') ORDER BY postId DESC");				
					mysqli_stmt_bind_param($sql, "s", $pesquisa);
					
				} else if ($scope == 'postContent') {
					$sql = mysqli_prepare($conn, "SELECT * FROM posts AS p INNER JOIN logins AS u ON p.postUserID = u.userID 
					WHERE (p.postTags LIKE CONCAT('%', ?,'%') OR p.postTxt LIKE CONCAT('%', ?,'%')) 
					ORDER BY postId DESC");
					mysqli_stmt_bind_param($sql, "ss", $pesquisa, $pesquisa);
				}
				
				mysqli_stmt_execute($sql);
				$result = mysqli_stmt_get_result($sql);
		
				if(mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) { //preenche as postagens da pagina
						
						$postId = $row['postId'];
						$postUserName = $row['userName'];
						$postUserPic = $row['userPicture'];
						$postTxt = $row['postTxt'];
						$postImg = $row['postImg'];
						$postTags = $row['postTags'];
						$postComments = "";

						//pega os comentários do post
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
					
				} else {
					echo "<h2>Sem Resultados na Busca</h2>";
				}
			} else if ($scope == 'profile') {
				
				require '../php/dbconection.php'; // os dados de conexão

				// monta a sql
				$sql = $conn->prepare("SELECT userId, email, userName, userPicture FROM logins 
				WHERE userName LIKE CONCAT('%', ?,'%')");
				$sql->bind_param('s', $pesquisa);
				$sql->execute();
				$result = $sql->get_result();  //pega os dados da postagem

				if(mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result)) {


						//preenche as variáveis
						$profUserId = $row['userId'];
						$profUserName = $row['userName'];
						$profUserPic = $row['userPicture'];
						$profUserEmail = $row['email'];

						include '../templates/profsearchtemplate.php';

					}
				} else {
					echo "<h2>Sem Resultados na Busca</h2>";
				}
			}
		?>
       
</div>
</div>
    
	<button id="scrollToTopBtn" onclick="scrollToTop()"> <i class="feather-chevron-up"></i> </button>
	
	<?php include "../templates/rodape.php"; ?>
	
</body>
<script src="../js/visuals.js"></script>
<script src="../js/postFuncs.js"></script>
<script>
//eventos

document.body.onload = setRodape();

window.addEventListener("scroll", function(){loadFeed('busca');});

</script>
</html>
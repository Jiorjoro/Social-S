<?php	//popula o feed

	session_start();

	require 'dbconection.php'; // os dados de conexão
	require('functions.php');

	$lastId = $_POST['lastPostId'];
	if($lastId == 0 && isset($_SESSION['lastPostId'])){
		$lastId = $_SESSION['lastPostId']; 
		unset($_SESSION['lastPostId']);
	}
	if($lastId != 'undefined' && !empty(trim($lastId)) && $lastId > 1){
		
		// por as postagens
		$sql = $conn->prepare("SELECT * FROM posts AS p INNER JOIN logins AS u ON p.postUserID = u.userID WHERE (p.postId < ?) ORDER BY postId DESC LIMIT 5");
		$sql->bind_param('i', $lastId);
		$sql->execute();
		$result = $sql->get_result();
		$posts = "";
		$toSend = [];
		
		if(mysqli_num_rows($result) > 0){
			while ($row = $result->fetch_assoc()) { //preenche as postagens da pagina

				$postId = $row['postId'];
				$postUserName = $row['userName'];
				$postUserPic = $row['userPicture'];
				$postTxt = $row['postTxt'];
				$postImg = $row['postImg'];
				$postVideo = $row['postVideo'];
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

				ob_start();
					include '../templates/posttemplate.php';
				$posts .= ob_get_clean();
				
			}
			
			$toSend['posts'] = $posts;
			$toSend['lastPostId'] = strval($postId);
			$toSend = json_encode($toSend);
			echo $toSend;
			
		} else {

			$toSend['posts'] = "";
			$toSend['lastPostId'] = "1";
			$toSend = json_encode($toSend);
			echo $toSend;

		}

		
		$sql->close();
		$conn->close();
	} else {
		$toSend['posts'] = "";
		$toSend['lastPostId'] = "1";
		$toSend = json_encode($toSend);
		echo $toSend;
	}
?>
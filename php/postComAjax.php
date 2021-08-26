<?php	//popula o feed
	
	session_start();
	
	require('functions.php');		
	require 'dbconection.php';

	$getAccess = $conn->prepare("SELECT userAccess FROM logins WHERE userId=?");
	$getAccess->bind_param('i', $_SESSION['userId']);
	$getAccess->execute();
	$acRes = $getAccess->get_result();

	while($access = $acRes->fetch_assoc()){
		$userAccess = $access['userAccess'];
	}
	$getAccess->close();

	if($userAccess != "espectador"){
		
		$comment = qBoa($_POST['userComment']);
		$postComments = "";
		
		if (strlen(str_replace(' ', '', $comment)) > 0) {

			$postId = qBoa($_POST['postId']);
			
			//posta o commentário
			$sql = $conn->prepare("INSERT INTO `postcomments` (`commentPostId`, `commentUserId`, `commentTxt`) VALUES (?, ?, ?)");
			$sql->bind_param('iis', $postId, $_SESSION['userId'], $comment);
			$sql->execute();
			$sql->close();
			
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
			
			echo $postComments;
			
			$commSql->close();
		} else {
			echo 'Erro Nos Comentários';
		}
	}
	$conn->close();
?>
<?php
    require('../php/coockiecheck.php');
 
    require '../php/dbconection.php'; // os dados de conexão

    // monta a sql
    $sql = $conn->prepare("SELECT email, userName, userPicture FROM logins WHERE userId=? ");
    $sql->bind_param('i', $_GET['pU']);
    $sql->execute();
    $result = $sql->get_result();  //pega os dados do perfil

    while($row = mysqli_fetch_assoc($result)) {
        //preenche as variáveis
        $profUserName = $row['userName'];
        $profUserPic = $row['userPicture'];
        $profUserEmail = $row['email'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/perfil.css">
    <link rel="stylesheet" href="../css/global.css">
	<link rel="stylesheet" href="../css/index.css">
    <link href="../css/feather.css" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../media/default/favicon.png" type="image/x-icon">
    <title>Perfil | Social S</title>
</head>
<body>
   
	<?php
		include "../templates/cabecalho.php"; 
	?>

    <div class="conteudoPerfil">
        <img class='profilePic' src="<?php echo $profUserPic;?>"/>
            <div class="containerUser">
                <div class="userName"> <i class="feather-user">  <?php echo $profUserName;?></div></i>
                <div class="userMail"> <i class="kk feather-mail"> <?php echo $profUserEmail;?></div></i>
            </div>

    </div>

    <div class="allLike">
        <?php
            require "../php/functions.php";
            require "../php/dbconection.php";

            $profUserId = qBoa($_GET['pU']);

            //total de postagens
            $totPSql = $conn->prepare("SELECT COUNT(postId) AS totPosts FROM posts WHERE postUserId = ?");
            $totPSql->bind_param('i', $profUserId);
            $totPSql->execute();
            $totPRes = $totPSql->get_result();

            while($rowTotP = $totPRes->fetch_assoc()){
                $profUserTotPost = $rowTotP['totPosts'];
            }

            $totPSql->close();

            //total de likes
            $totLSql = $conn->prepare("SELECT COUNT(likeId) AS totLikes FROM postLikes AS l 
            INNER JOIN posts AS p ON p.postId = l.likePostId  WHERE postUserId = ?");
            $totLSql->bind_param('i', $profUserId);
            $totLSql->execute();
            $totLRes = $totLSql->get_result();

            while($rowTotL = $totLRes->fetch_assoc()){
                $profUserTotLike = $rowTotL['totLikes'];
            }

            $totLSql->close();

            $conn->close();
        ?>
        <h2 class='h2Like'>Total de Curtidas/Posts</h2>
        <div class="divisorHumilde"></div>
        <i class='feather-award'>  <?php echo $profUserTotLike; ?></i>
        <i class='feather-bookmark'>  <?php echo $profUserTotPost; ?></i>
    </div>

    <div class="containerFeed">
        <?php //popula o feed

            require '../php/dbconection.php'; // os dados de conexão

            // por as postagens
            $sql = $conn->prepare("SELECT * FROM posts AS p INNER JOIN logins AS u ON p.postUserID = u.userID WHERE postUserId=? ORDER BY postId DESC");
            $sql->bind_param('i', $_GET['pU']);
            $sql->execute();
            $result = $sql->get_result();  //pega os dados da postagem

            while ($row = mysqli_fetch_assoc($result)) { //preenche as postagens da pagina
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

                include '../templates/posttemplate.php';
            }

            $sql->close();
            $conn->close();
        ?>
    </div>

	
	<?php include "../templates/rodape.php"; ?>
	
	<button id="scrollToTopBtn" onclick="scrollToTop()"> <i class="feather-chevron-up"></i> </button>
	
</body>
<script src="../js/visuals.js"></script>
<script src="../js/postFuncs.js"></script>
<script>
//eventos
document.body.addEventListener("load", setRodape());

</script>
</html>
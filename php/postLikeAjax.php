<?php
    
    session_start();

    require "functions.php";
    require "dbconection.php";

    $getAccess = $conn->prepare("SELECT userAccess FROM logins WHERE userId=?");
    $getAccess->bind_param('i', $_SESSION['userId']);
    $getAccess->execute();
    $acRes = $getAccess->get_result();

    while($access = $acRes->fetch_assoc()){
        $userAccess = $access['userAccess'];
    }
    $getAccess->close();

    if($userAccess != "espectador"){

        $postId = $_POST['postId'];
        $toSend = [];

        $sql = $conn->prepare("SELECT likeId FROM postlikes WHERE likePostId=? AND likeUserId=?");
        $sql->bind_param("ii", $postId, $_SESSION['userId']);
        $sql->execute();
        $result = $sql->get_result();

        if(mysqli_num_rows($result) > 0){
            while($row = $result->fetch_assoc()){
                $likeId = $row['likeId'];
            }
            $stmt = $conn->prepare("DELETE FROM `postLikes` WHERE likeId=?");
            $stmt->bind_param('i', $likeId);
            $stmt->execute();
            $stmt->close();

            $toSend['src'] = "../media/default/emptyStarLike.png"; //classe da estrela APAGADA
            
        } elseif($result->num_rows == 0){
            $stmt = $conn->prepare("INSERT INTO postLikes (likePostId, likeUserId) VALUES (?, ?)");
            $stmt->bind_param('ii', $postId, $_SESSION['userId']);
            $stmt->execute();
            $stmt->close();

            $toSend['src'] = "../media/default/fullStarLike.png"; //classe da estrela ACESA

        }

        //quantidade de likes
        $sqlL = $conn->prepare("SELECT COUNT(likeId) AS totLike FROM postlikes WHERE likePostId=?");
        $sqlL->bind_param('i', $postId);
        $sqlL->execute();
        $likeRes = $sqlL->get_result();

        while($rowL = $likeRes->fetch_assoc()){
            $postTotLike = $rowL['totLike'];
        }

        $likeRes->close();

        $toSend['likes'] = $postTotLike;

        $sql->close();

        $toSend = json_encode($toSend);

        echo $toSend;
    }
    $conn->close();
?>
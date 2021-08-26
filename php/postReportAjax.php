<?php 

    session_start();

    require "dbconection.php";

    $postId = $_POST['postId'];
    $userId = $_SESSION['userId'];

    $checkSql = $conn->prepare("SELECT reportId FROM postReports WHERE reportPostId=? AND reportUserId=?");
    $checkSql->bind_param("ii", $postId, $userId);
    $checkSql->execute();
    $checkRes = $checkSql->get_result();

    if($checkRes->num_rows == 0){

        $reportSql = $conn->prepare("INSERT INTO postReports (reportPostId, reportUserId) VALUES (?, ?)");
        $reportSql->bind_param("ii", $postId, $userId);
        $reportSql->execute();
        $reportSql->close();

        echo json_encode(["msg"=>"Obrigado Por Sua Denúncia!"]);
    } elseif($checkRes->num_rows > 0){
        echo json_encode(["msg"=>"Você já denunciou esta postagem"]);
    }
    
    $checkRes->close();
    $conn->close();
    
?>
<?php

    require "../php/dbconection.php";

    $tops = array();

    $sql = "SELECT Tag FROM Rank_Rec_Tags LIMIT 4";
    $result = mysqli_query($conn, $sql);

    while($row = $result->fetch_assoc()){
        array_push($tops, $row['Tag']);
    }

    $conn->close();

?>

<div class="quadradoTopics">
        <h2 class="titleTopic">Hashtags em alta</h2>
            <p class="topicHash"><?php echo $tops[0]; ?></p>
            <p class="topicHash"><?php echo $tops[1]; ?></p>    
            <p class="topicHash"><?php echo $tops[2]; ?></p>
            <p class="topicHash"><?php echo $tops[3]; ?></p>
</div>
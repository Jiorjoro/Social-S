<?php
    echo "<table class='containerPub'><tr>
		<td class='postL'>";
        if (!empty($postTxt)) { 
            echo "
            <div class='textoDaPessoa'>
                $postTxt
            </div>"; 
        }
        if (!empty($postImg)) { 
            echo "<center> <img class='imag' src='$postImg'> </center>"; 
        } else if (!empty($postVideo)) { 
            echo "<center> <video class='video' type='video/mp4' src='$postVideo' controls></video> </center>";
        } echo "
    </td>
    <td class='postR'>
        <img class='fotoDaPessoaDoPost' src='$postUserPic'>
            <div class='nomeDaPessoa'>$postUserName</div>
                <div class='tagsDaPessoa'>$postTags</div>
		<div class='comentarioDaPessoa' id='postComments".$postId."'>
            ".$postComments."
        </div>
            <input class='comentar' placeholder='Faça um comentário' type='text' id='postUserCom".$postId."' value='' onkeydown='comCheckKey(this)'> </input>
                <button class='enviarComent' onclick='sendPostComment(".$postId.")'>Comentar</button>
            <div class='curtidas'>
                <div class='iconsPublic'><i class='feather-alert-triangle' onclick='reportPost(".$postId.")'>Denunciar</i></div>
                <div class='iconsPublic'><img src='".$postLike."' style='width: 1.7rem;' class='feather-star' onclick='likeAPost(this, ".$postId.")' /></div>
                <p id='postTotLike".$postId."' class='aindaBem'>".$postTotLike."</p>
        </td>
        </tr> 
        </table>";
?>
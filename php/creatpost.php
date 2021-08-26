<?php
  
  require 'functions.php';
  
  if (!empty(qBoa($_POST['postTxt'])) || !empty($_FILES['fileToUpload']['tmp_name'])) {
  
    session_start();
    
    require 'dbconection.php';        
    
    date_default_timezone_set("America/Belem");

    //pega variaveis
    $postUserId = $_SESSION['userId'];
    $postTxt = $_SESSION['postTxt'] = qBoa($_POST['postTxt']);
    $postTags = $_SESSION['postTags'] = qBoa($_POST['postTags']);
    $postImg = '';  
    $postVideo = '';
    
    echo $_FILES['fileToUpload']['tmp_name'];
    /* começo do código de imagem */
    $target_file = '';
    if (!empty($_FILES['fileToUpload']['tmp_name'])) {
      
      //preparação dos dados      
      $target_dir = "../media/uploads/"; // pasta onde vai
      $target_file = $target_dir .  date("Ymd_His_") . $postUserId . '.' . pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION); //nome que vai receber      
      $extension = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION)); // extensão
      $fileMime = explode('/', $_FILES['fileToUpload']['type'])[0]; // imagem / video
      $uploadErr = ''; // erro pra retornar ao usuário
      
      //checa se é imagem
      if (isset($_POST['submit'])) {
        $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
        if ($check !== false) {
          echo $check['mime'];
        } else if ( $fileMime == 'image' || $fileMime == 'video') {
          //nada muda, era só pra testar mermo
        } else {
          $uploadErr =  'Somente IMAGENS ou VÍDEOS podem ser enviadas(os)';          
        }
      }          
      
      // checa as extensões
      $permitedExt = array('png', 'jpg', 'jpeg', 'gif', 'jfif');
      array_push($permitedExt, 'mp4', 'mov', 'mpg', 'mpeg', 'wmv', 'mkv', 'webm');
      if(!in_array($extension, $permitedExt)){
        $uploadErr = 'Formato Incompatível.';
      }
      
      // limite de tamanho (em bytes)
      if ($_FILES['fileToUpload']['size'] > 50000000) {
        $uploadErr =  'Limite de arquivos (50MB) Excedido';
      }
      
      // se tudo tiver de boa salva o arquivo
      if ($uploadErr == '') {
        move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file);
        if ($fileMime == 'image') {
          $postImg = $target_file;
        } else if ($fileMime == 'video') {
          $postVideo = $target_file;
        }
        unset($_SESSION['uploadErr']);
      } else {        
        $_SESSION['uploadErr'] = $uploadErr;
        header("Location: ../pages/feed.php");
        exit();
      }
      
    }
    /* fim do código de imagem */

    //código da MySQLi pro post
    $sql = mysqli_prepare($conn, "INSERT INTO posts (`postUserId`, `postTxt`, `postImg`, `postVideo`, `postTags`) VALUES (?,REPLACE(?, '\n', '<br>'),?,?,?)");
    mysqli_stmt_bind_param($sql, "issss", $postUserId, $postTxt, $postImg, $postVideo, $postTags);
    mysqli_stmt_execute($sql);
    mysqli_stmt_close($sql);
    
    if(strlen(str_replace(' ', '', $postTags)) > 0){
      //código da MySQLi pras Tags
      $LilTag = explode('#', str_replace(' ', '', $postTags));
      foreach($LilTag as $tag) {
        if($tag != ''){
          $tag = "#" . $tag;
          $sql = mysqli_prepare($conn, "INSERT INTO posttags (`Tag`) VALUES (?)");
          mysqli_stmt_bind_param($sql, "s", $tag);
          mysqli_stmt_execute($sql);
          mysqli_stmt_close($sql);
        }
      }
    }

    //limpa a interface do usuário
    unset($_SESSION['postTxt']);
    unset($_SESSION['postTags']);
    
    mysqli_close($conn);
  }
  header("Location: ../pages/feed.php");
  exit();

?>
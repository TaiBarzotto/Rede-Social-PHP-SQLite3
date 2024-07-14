<?php
    require '../configuracoes.php';
    autenticar(); 

    $idPost=$_POST['idPost'];

    $stmt=$posts->query('DELETE FROM post WHERE id='.$idPost.'');
    if($stmt){
        header('Location: ../perfil.php?msg=Post deletado');
    }
<?php

    require '../configuracoes.php';
    autenticar();

    $id=$_POST['idPost'];
    $jaCurtiu=$_POST['jaCurtiu'];

    $stmt=$posts->prepare('SELECT * FROM post WHERE id=:id');
    $stmt->bindValue(':id',$id);
    $infos=$stmt->execute()->fetchArray(SQLITE3_ASSOC);

    $stmt=$likes->prepare('SELECT * FROM likes WHERE idPost=:id');
    $stmt->bindValue(':id',$id);
    $curtidos=$stmt->execute();
    
    
    if ($jaCurtiu==0){
        $stmt=$likes->prepare('INSERT INTO likes(idPost, idUsuario) VALUES (:idPost, :idUsuario)');
        $stmt->bindValue(':idPost', $id);
        $stmt->bindValue(':idUsuario', $_SESSION['idUsuario']);
        $result=$stmt->execute();

    }else{
        $stmt=$likes->prepare('DELETE FROM likes WHERE idPost=:idPost and idUsuario=:idUsuario');
        $stmt->bindValue(':idPost', $id);
        $stmt->bindValue(':idUsuario', $_SESSION['idUsuario']);
        $result=$stmt->execute();
    }
    $count=$likes->query('SELECT COUNT (*) FROM likes WHERE idPost='.$id.'');
    $like=$count->fetchArray(SQLITE3_ASSOC);
    
    $stmt=$posts->prepare('UPDATE post SET likes=:likes WHERE id=:id');
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':likes', $like['COUNT (*)']);
    $liked=$stmt->execute();

    if ($liked){
        header('Location: /posts/abrirPost.php?num='.$id);
    }


    

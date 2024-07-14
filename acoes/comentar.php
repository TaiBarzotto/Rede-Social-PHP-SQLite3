<?php
                    
    require '../configuracoes.php';
    autenticar();    

    $id=$_POST['id'];
    $comentarios=$_POST['comentario'];

    $stmt=$comentario->prepare('INSERT INTO comentario(idPost, comentario, idUsuario) VALUES (:idPost, :comentario, :idUsuario)');
    $stmt->bindValue(':idPost', $id);
    $stmt->bindValue(':comentario', $comentarios);
    $stmt->bindValue(':idUsuario', $_SESSION['idUsuario']);
    $result=$stmt->execute();

    $count=$comentario->query('SELECT COUNT (*) FROM comentario WHERE idPost='.$id.'');
    $comment=$count->fetchArray(SQLITE3_ASSOC);
    
    $stmt=$posts->prepare('UPDATE post SET comentarios=:comentarios WHERE id=:id');
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':comentarios', $comment['COUNT (*)']);
    $comments=$stmt->execute();

    if($result){
        header("Location: ../posts/abrirPost.php?num=$id");
    }else{
    header("Location: ../posts/abrirPost.php?num=$id,msg=erro");
    }
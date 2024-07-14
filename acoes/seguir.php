<?php
                    
    require '../configuracoes.php';  
    autenticar();

    $jaSegue=$_POST['jaSegue'];

    $idSeguindo=$_POST['idSeguindo'];

    $stmt=$db->prepare('SELECT * FROM users WHERE id=:id');
    $stmt->bindValue(':id',$idSeguindo);
    $infos=$stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($jaSegue==0){
        $stmt=$seguidores->prepare('INSERT INTO seguidores (idUsuario, idSeguindo) VALUES (:id,:seguindo)');
        $stmt->bindParam(':id', $_SESSION['idUsuario']);
        $stmt->bindParam(':seguindo', $idSeguindo);
        $seguiu=$stmt->execute();

    }else{
        $stmt=$seguidores->prepare('DELETE FROM seguidores WHERE idSeguindo=:id');
        $stmt->bindParam(':id', $idSeguindo);
        $seguiu=$stmt->execute();
        
    }

    $count=$seguidores->query('SELECT COUNT (*) FROM seguidores WHERE idSeguindo='.$idSeguindo.'');
    $seguidor=$count->fetchArray(SQLITE3_ASSOC);
  
    $stmt=$db->prepare('UPDATE users SET seguidores=:seguidores WHERE id=:id');
    $stmt->bindValue(':id', $idSeguindo);
    $stmt->bindValue(':seguidores', $seguidor['COUNT (*)']);
    $seguiu=$stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if($seguiu){
       header('Location: ../index.php?msg=erro ao seguir!');
    }else{
       header('Location: ../index.php');
    }


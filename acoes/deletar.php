<?php 
    require '../configuracoes.php';
    autenticar(); 

    $stmt=$db->query('DELETE FROM users WHERE id='.$_SESSION['idUsuario'].'');
    $stmt=$posts->query('DELETE FROM post WHERE idUsuario='.$_SESSION['idUsuario'].'');
    $stmt=$seguidores->query('DELETE FROM seguidores WHERE idUsuario='.$_SESSION['idUsuario'].'');
    $stmt=$seguidores->query('DELETE FROM seguidores WHERE idSeguindo='.$_SESSION['idUsuario'].'');
    $stmt=$likes->query('DELETE FROM likes WHERE idUsuario='.$_SESSION['idUsuario'].'');
    $stmt=$comentario->query('DELETE FROM comentario WHERE idUsuario='.$_SESSION['idUsuario'].'');

    session_destroy();
    header('Location: ../login.php?msg=Perfil deletado');
?>
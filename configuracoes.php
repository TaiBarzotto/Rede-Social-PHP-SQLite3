<?php
$db= new SQLite3(__DIR__.'/users.sqlite');
$posts= new SQLite3(__DIR__.'/post.sqlite');
$comentario= new SQLite3(__DIR__.'/comentario.sqlite');
$seguidores= new SQLite3(__DIR__.'/seguidores.sqlite');
$likes= new SQLite3(__DIR__.'/likes.sqlite');
$visualizacoes= new SQLite3(__DIR__.'/visualizacoes.sqlite');

function autenticar(){
    session_start();
    if (!$_SESSION['auth']){
        header('Location: ../login.php?msg=Faça Login');
        exit;
    } 
}
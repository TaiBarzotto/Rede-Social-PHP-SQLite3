<?php
    require "configuracoes.php";
    autenticar();
    
    $stmt=$posts->query('SELECT * FROM post ORDER BY RANDOM()');
    
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Pagina Inicial</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/navbar-static/">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link active" href="perfil.php">Perfil</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/posts/novoPost.php">Nova Foto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/posts/novoTexto.php">Novo Texto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
            </ul>
            <p class="msg">
                <?php if (isset($_GET['msg'])){echo $_GET['msg'];}?>
            </p>
            <form class="pesquisa" action="/acoes/pesquisar.php" method="post" class="form-inline">
                <input name="usuario"  type="search" placeholder="Pesquisar usuário" aria-label="Pesquisar">
                <button type="submit" name="acessoPerfil">Pesquisar</button>
            </form>
        </div>
</nav>
    <section>
        <?php
         while ($dados = $stmt->fetchArray(SQLITE3_ASSOC)) {
             $usuario=$db->query('SELECT * FROM users WHERE id='.$dados['idUsuario'].'')->fetchArray();
             echo'
                <div class="post">
                    <form action="/acoes/pesquisar.php" method="post">
                        <input type="hidden" name="usuario" value="'.$usuario['usuarios'].'">
                        <button class="botaoPerfil" type="submit" name="acessoPerfil">
                        <img class="fotoPerfil" src="posts/imagens/'.$usuario['fotoPerfil'].'" alt="" width="50px"><span>'.$usuario['usuarios'].'</span>
                        </button>
                    </form>';
                if ($dados['foto']!=null){     
                    echo'<div>
                        <p class="postagem"><a href="../posts/abrirPost.php?num='.$dados['id'].'"><h3 class="postagem">'.$dados["descricao"].'<br><img class="postImg" src="/posts/imagens/'.$dados["foto"].'" alt="post" width="300px"></p></a>
                        </h3><p><img src="/posts/imagens/2684022.svg" alt="" width="20px"> '.$dados["likes"].'    
                        <span class="comment"><img src="/posts/imagens/chat-heart.svg" alt="" width="20px"> '.$dados["comentarios"].'</span></p>
                    
                    </div>
                    </div>';

                }else{echo'
                    <div>
                    <p class="postagem"><a href="../posts/abrirPost.php?num='.$dados['id'].'">
                    <h3 class="postagem">'.$dados["descricao"].'</a></p></h3>
                    <p><img src="/posts/imagens/2684022.svg" alt="" width="20px"> '.$dados["likes"].'   
                    <span class="comment"><img src="/posts/imagens/chat-heart.svg" alt="" width="20px"> '.$dados["comentarios"].'</span></p>
                    </div>              
                    </div>';
                }
            }
            
        ?>
    </div>
</section>
</body>
</html>


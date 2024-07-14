<?php

    require "../configuracoes.php";
    autenticar();
    
    $results=$posts->query('SELECT id, foto, likes, descricao FROM post WHERE idUsuario='.$_SESSION['idUsuario'].' ORDER BY id DESC;');
    
    if(isset($_POST['enviar'])){        
        $_SESSION['biografia']=$_POST['biografia'];
        $stmt=$db->prepare('UPDATE users SET biografia=:bio WHERE id=:id');
        $stmt->bindValue(':id', $_SESSION['idUsuario']);
        $stmt->bindValue(':bio', $_POST['biografia']);
        $novabio=$stmt->execute();

        if(!$novabio){
            header('Location: /acoes/biografia.php?msg=Biografia não atualizada. Tente novamente mais tarde!');
        }else{
            header('Location: ../perfil.php?msg=Biografia atualizada com sucesso!');
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/profile.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
        <title>Biografia</title>
    </head>
<body>

<section id="about-section" class="pt-5 pb-5">
    <div class="container wrapabout col-md-auto">
        <div class="red"></div>
        <form action="/perfil.php" method="post">
            <button class="voltar" type="submit">&#9204</button>
        </form>
        <div class="row">
            <div class="col-lg-6 align-items-center justify-content-left">
                <div class="blockabout">
                    <div class="blockabout-inner text-center text-sm-start">
                        <div class="title-big pb-3 mb-3">
                            <h3>Biografia</h3>
                        </div>
                        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                        <div class="form-group">
                            <label for="texto">Sua biografia: </label>
                            <textarea class="form-control" name="biografia" rows="3"></textarea><br>
                            <button name="enviar" class="w-100 btn btn-lg btn-secondary" type="submit">Enviar</button>
                        </div><br>
                       
                        <a class="link" href="/acoes/deletar.php">Deletar conta</a>
                        <a class="link" href="/acoes/editar.php">Editar perfil</a>
                        <br><br>

                        <p><?php
                        if (isset($_GET['msg'])){
                            echo $_GET['msg'];
                        }
                        ?></p>
                        
                        <div class="container" >
                            <div class="table">
                                <table class="table">
                                <?php
                                    while ($dados = $results->fetchArray(SQLITE3_ASSOC)) {
                                        if ($dados['foto']!=null){     
                                            echo'<tr><div class="row">
                                            <div class="col-sm">
                                            <h3 class="postagem">'.$dados["descricao"].'
                                            <a class="post" href="../posts/abrirPost.php?num='.$dados['id'].'"><p><img class="imgPost" src="/posts/imagens/'.$dados["foto"].'" alt="post" width="150px">
                                            </a></h3>
                                            <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                            </svg> '.$dados["likes"].'</span>
                                            </div>
                                            <form action="/acoes/deletarPost.php" method="post">
                                            <input type="hidden" name="idPost" value="'.$dados['id'].'">
                                            <button class="link" name="deletar" type="submit">Deletar Post</button>
                                            </form>
                                            </div></tr>';
                                            
                                        }else{echo'<tr><div class="row">
                                            <div class="col-sm">
                                            <a class="post" href="../posts/abrirPost.php?num='.$dados['id'].'"><h3 class="postagem">'.$dados["descricao"].'</h3></a>
                                            <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                            </svg> '.$dados["likes"].'</p>
                                            </div>   
                                            <form action="/acoes/deletarPost.php" method="post">
                                            <input type="hidden" name="idPost" value="'.$dados['id'].'">
                                            <button class="link" name="deletar" type="submit">Deletar Post</button>
                                            </form>                                     
                                            </div> </tr>';
                                        }
                                    }
                                ?>
                                </table>
                            </div>
                        </div>                      
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mt-5 mt-lg-0 align-items-center justify-content-center">
                <figure class="potoaboutwrap">
                    <img src="/posts/imagens/<?php echo $_SESSION['fotoPerfil']?>" alt="foto do perfil" width="400px"/>
                </figure>
            </div>
        </div>
    </div>
</section>
</body>
</html>
    

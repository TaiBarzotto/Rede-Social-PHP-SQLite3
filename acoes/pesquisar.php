<?php
                    
    require '../configuracoes.php';
    autenticar();    

    $usuario=$_POST['usuario'];

    if ($usuario!=$_SESSION['user']){

        $stmt=$db->prepare('SELECT * FROM users WHERE usuarios =:usuarios');
        $stmt->bindValue(':usuarios',$usuario);
        $resultado=$stmt->execute();
        $user=$resultado->fetchArray(SQLITE3_ASSOC);
        
        if (!$user){
            header('Location: ../index.php?msg=O usuário pesquisado não existe!');
        }else{
            if(isset($_POST['acessoPerfil'])){
                $dia=date('Ymd');
                $mes=date('Ym');
                $ano=date('Y');
                
                $jaAcessado=$visualizacoes->query('SELECT * FROM visualizacoes WHERE dia='.$dia.' AND idAcessado='.$user['id'].' AND idAcesso='.$_SESSION['idUsuario'].'')->fetchArray(SQLITE3_ASSOC);
                
                if(!$jaAcessado){
                    $stmt=$visualizacoes->query('INSERT INTO visualizacoes (dia, mes, ano, idAcessado, idAcesso) VALUES('.$dia.','.$mes.','.$ano.','.$user['id'].','.$_SESSION['idUsuario'].')');
                }
            }
        }
        
        $results=$posts->query('SELECT id, foto, likes, descricao FROM post WHERE idUsuario='.$user['id'].' ORDER BY id DESC;');
        
    } else{
        header('Location: ../index.php?msg=Você está pesquisando seu próprio usuário');
    }

    
    $jaSegue=0;
    $result=$seguidores->query('SELECT idSeguindo FROM seguidores WHERE idUsuario='.$_SESSION['idUsuario'].'');
    while($dados=$result->fetchArray(SQLITE3_ASSOC)){
        if ($dados['idSeguindo']==$user['id']){
            $jaSegue=1;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../profile.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
        <title>Pesquisar Usuário</title>
    </head>
<body>

<section id="about-section" class="pt-5 pb-5">
    <div class="container wrapabout col-md-auto">
    <form action="/index.php" method="post">
        <button class="voltar" type="submit">&#9204</button>
    </form>
        <div class="row">
            <div class="col-lg-6 align-items-center justify-content-left d-flex mb-5 mb-lg-0">
                <div class="blockabout">
                    <div class="blockabout-inner text-center text-sm-start">
                            <h3>Biografia</h3>
                            <?php 
                                echo $user['biografia'];
                            ?>
                        <div class="sosmed-horizontal pt-3 pb-3">
                            <p class="description-p text-muted pe-0 pe-lg-0">
                                <?php 
                                    echo '<p>Seguidores: '.$user['seguidores'].'<br>';
                                    if($jaSegue==0){
                                        echo '<form action="seguir.php" method="post">
                                            <input type="hidden" name="jaSegue" value="'.$jaSegue.'">
                                            <input type="hidden" name="idSeguindo" value="'.$user['id'].'">
                                            <button class="seguir" type="submit">SEGUIR</button>
                                        </form>';
                                    }else{
                                    echo '<form action="seguir.php" method="post">
                                            <input type="hidden" name="jaSegue" value="'.$jaSegue.'">
                                            <input type="hidden" name="idSeguindo" value="'.$user['id'].'">
                                            <button class="seguir" type="submit">DEIXAR DE SEGUIR</button>
                                        </form>';
                                    }
                                    ?>
                        </div>
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
                                            </div></tr>';
                                            
                                        }else{echo'<tr><div class="row">
                                            <div class="col-sm">
                                            <a class="post" href="../posts/abrirPost.php?num='.$dados['id'].'"><h3 class="postagem">'.$dados["descricao"].'</h3></a>
                                            <p><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                                            </svg> '.$dados["likes"].'</p>
                                            </div>                                        
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
            <div class="col-lg-6 mt-5 mt-lg-0">
                <figure class="potoaboutwrap">
                    <img src="/posts/imagens/<?php echo $user['fotoPerfil']?>" alt="foto do perfil" width="400px"/>
                </figure>
            </div>
        </div>
    </div>
</section>
</body>
</html>

<?php

    require "configuracoes.php";
    autenticar();

    $acessoDia=$visualizacoes->query('SELECT COUNT (*) as access FROM visualizacoes WHERE idAcessado='.$_SESSION['idUsuario'].' AND dia='.date('Ymd').'')->fetchArray(SQLITE3_ASSOC);
    $acessoMes=$visualizacoes->query('SELECT COUNT (*) as access FROM visualizacoes WHERE idAcessado='.$_SESSION['idUsuario'].' AND mes='.date('Ym').'')->fetchArray(SQLITE3_ASSOC);
    $acessoAno=$visualizacoes->query('SELECT COUNT (*) as access FROM visualizacoes WHERE idAcessado='.$_SESSION['idUsuario'].' AND ano='.date('Y').'')->fetchArray(SQLITE3_ASSOC);
    $acessoTotal=$visualizacoes->query('SELECT COUNT (*) as access FROM visualizacoes WHERE idAcessado='.$_SESSION['idUsuario'].'')->fetchArray(SQLITE3_ASSOC);
    
    $seguidores=$seguidores->query('SELECT COUNT (*) as seguidores FROM seguidores WHERE idSeguindo='.$_SESSION['idUsuario'].'')->fetchArray(SQLITE3_ASSOC);
    $results=$posts->query('SELECT id, foto, likes, descricao FROM post WHERE idUsuario='.$_SESSION['idUsuario'].' ORDER BY id DESC;');
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/profile.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
        <title>Perfil</title>
    </head>
<body>

<section id="about-section" class="pt-5 pb-5">
    <div class="container wrapabout col-md-auto">
        <div class="red"></div>
        <form action="/index.php" method="post">
            <button class="voltar" type="submit">&#9204</button>
        </form>
        <div class="row">
            <div class="col-lg-6 align-items-center justify-content-left">
                <div class="blockabout ">
                    <div class="blockabout-inner  text-center text-sm-start">
                        <div class="title-big pb-3 mb-3">
                            <h3>Biografia</h3>
                        </div>
                        <p class="description-p text-muted pe-0 pe-lg-0">
                            <?php if ($_SESSION['biografia']!=null){
                                echo $_SESSION['biografia'].'<br><br><a class="link" href="/acoes/biografia.php">Alterar biografia</a><br><br>';
                            }
                            else{
                                echo '<a class="link" href=/acoes/biografia.php>Cadastrar biografia</a>';
                            }
                            echo '<p>Seguidores: '.$seguidores['seguidores'].'</p>';
                            ?> 
                        </p>
                        <h5>Pessoas que viram seu perfil:</h5>
                            <table>
                                <tr>
                                    <th>Hoje:</th>
                                    <th>Mês:</th>
                                    <th>Ano:</th>
                                    <th>Total:</th>
                                </tr>
                                <tr>
                                    <td><?php echo $acessoDia['access']?></td>
                                    <td><?php echo $acessoMes['access']?></td>
                                    <td><?php echo $acessoAno['access']?></td>
                                    <td><?php echo $acessoTotal['access']?></td>
                                </tr>
                            </table>
                            <br>

                        <a class="link" href="/acoes/deletar.php">Deletar conta</a>
                        <a class="link" href="/acoes/editar.php">Editar perfil</a>
                        <br><br>
                        
                        <p class="msg"><?php
                            if (isset($_GET['msg'])){
                                echo $_GET['msg'];
                            }
                            ?>
                        </p>
                       
                        <div class="container" >
                            <div class="table col-md-auto">
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
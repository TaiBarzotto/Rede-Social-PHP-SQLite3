<?php
                    
    require '../configuracoes.php';
    autenticar();

    
    $id=$_GET['num'];

    $stmt=$posts->prepare('SELECT * FROM post WHERE id=:id');
    $stmt->bindValue(':id',$id);
    $infos=$stmt->execute()->fetchArray(SQLITE3_ASSOC);

    $stmt=$comentario->prepare('SELECT * FROM comentario WHERE idPost=:id');
    $stmt->bindValue(':id',$id);
    $result=$stmt->execute();

    $stmt=$db->prepare('SELECT * FROM users WHERE id=:id');
    $stmt->bindValue(':id', $user['idUsuario'] );
    $userComent=$stmt->execute()->fetchArray(SQLITE3_ASSOC);

    $jaCurtiu=0;
    $stmt=$likes->prepare('SELECT idUsuario FROM likes WHERE idPost=:id');
    $stmt->bindParam(':id', $id);
    $like=$stmt->execute();
    while($dados=$like->fetchArray(SQLITE3_ASSOC)){
        if ($dados['idUsuario']==$_SESSION['idUsuario']){
            $jaCurtiu=1;
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="../profile.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
        <title>POST</title>
    </head>
<body>
<p><?php
if (isset($_GET['msg'])){
    echo $_GET['msg'];
}
?></p>
<section id="about-section" class="pt-5 pb-5">
    <div class="container wrapabout col-md-auto">
        <form action="/index.php" method="post">
            <button class="voltar" type="submit">&#9204</button>
        </form>
        <div class="row justify-content-md-center">
            <div class="col-lg-3 align-items-center justify-content-center d-inflex mb-5 mb-lg-0 viewport width=">
            <div class="blockabout">
                <?php if ($infos['foto']==null){
                    echo '<h2>'.$infos["descricao"].'</h2>';
                }else{
                    echo '<img class="post" src="/posts/imagens/'.$infos["foto"].'" alt="foto do post" width="260px"/>';
                }
                ?>
            </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0">
                <?php if ($infos['foto']==null){
                    echo '';
                }else{
                    echo '<h4><i>'.$infos["descricao"].'</i></h4>';
                }
                while ($comments=$result->fetchArray(SQLITE3_ASSOC)){
                    $stmt=$db->prepare('SELECT * FROM users WHERE id=:id');
                    $stmt->bindValue(':id', $comments['idUsuario'] );
                    $userComent=$stmt->execute()->fetchArray(SQLITE3_ASSOC);
                    echo $userComent['usuarios'].': '.$comments['comentario']."<br>";
                }
                ?>

            </div>
        </div>
            <div class="row justify-content-md-center">
            <div class="col-lg-3 align-items-center justify-content-center d-inflex mb-5 mb-lg-0">
            <div class="blockabout">
                <?php 
                if($jaCurtiu==0){
                    echo '<form action="/acoes/curtir.php" method="post">
                    <input type="hidden" name="jaCurtiu" value="'.$jaCurtiu.'">
                    <input type="hidden" name="idPost" value="'.$id.'">
                    <button class="like" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 20 20">
                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                    </svg></button>
                    </form>';
                }else{
                    echo '<form action="/acoes/curtir.php" method="post">
                    <input type="hidden" name="jaCurtiu" value="'.$jaCurtiu.'">
                    <input type="hidden" name="idPost" value="'.$id.'">
                    <button class="like" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
                    </svg></button>
                    </form>';
                }
                ?>
            </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0">
                <form action="/acoes/comentar.php" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="comentario" placeholder="Adicione um comentário">
                    <div class="input-group-append">
                        <input type="hidden" name="id" value="<?php echo $id?>">
                        <button class="btn btn-outline-secondary" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                        </svg></button>
                    </div>
                </div>
                    <input type="hidden" name="num" value="<?php $id?>">
                </form>
            </div>
        </div>
    </div>
</section>
</body>
</html>



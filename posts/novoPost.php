<?php

    require '../configuracoes.php';
    autenticar();
    
    if (isset($_POST['enviar'])){
        if (! empty ($_FILES['imgPost']['name'])){

            $nomeImg=$_FILES['imgPost']['name'];
            $typeImg=$_FILES['imgPost']['type'];
            $tmpImg=$_FILES['imgPost']['tmp_name'];
            $sizeImg=$_FILES['imgPost']['size'];
            $data=date("Y-m-d");
            $dataUpload = date("Y-m-d_H-i");
            $erros=array();

            $maxSize= 1024*1024*5;
            if ($sizeImg>$maxSize){
                $erros[]= "O arquivo ultrapassa o limite de 5 MB<br>";
            }

            $tiposPermitido=['image/png','image/jpg', 'image/jpeg', 'image/gif'];
            if (! in_array($typeImg, $tiposPermitido )){
                $erros[]= "Não é possível fazer o upload desse tipo de arquivo!<br>Por favor, faça upload de arquivos .gif, .png, .jpg ou .jpeg<br>";
            }

            if(!empty($erros)){
                foreach($erros as $erro){
                    echo $erro;
                }
            }else{
                $descricao=$_POST['descricao'];
                $novoNome=$dataUpload."-".$nomeImg;
                $caminho= "imagens/";
                if(strlen($descricao)>100){
                    header('Location: /posts/novoPost.php?msg=A descrição supera o limite de 100 caracteres!');
                }else{
                if(move_uploaded_file($tmpImg, $caminho.$novoNome)){
                    header('Location: ../perfil.php?msg=post feito com sucesso!');
                }else{
                    header('Location: ../perfil.php?msg=erro ao fazer upload!');
                }

                $stmt=$posts->prepare('INSERT INTO post (idUsuario,foto,dia,descricao) VALUES (:id,:post,:dia,:descricao)');
                $stmt->bindParam(':id', $_SESSION['idUsuario']);
                $stmt->bindParam(':descricao', $descricao);
                $stmt->bindParam(':dia', $data);
                $stmt->bindParam(':post', $novoNome);
                $stmt->execute();
            }
            }
        }
    }


    ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../signin.css" rel="stylesheet">
    <title>Novo Post </title>
</head>
<body class="text-center">
    <main class="form-signin">

        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <h1 class="">Novo Post</h1>
            <p>
                <?php if (isset($_GET['msg'])){echo $_GET['msg'];}?>
            </p>
            <div class="mb-3">
                <label class="form-label" for="imgPost">Selecione a imagem:</label>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" name="imgPost">
                </div>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição: </label>
                <input type="text" class="form-control" name="descricao" placeholder="Adicione uma descrição" required>
            </div>
            <button name="enviar" class="w-100 btn btn-lg btn-secondary" type="submit">Postar</button>
        </form>
    </main>
</body>
</html>


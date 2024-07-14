<?php

    require '../configuracoes.php';
    autenticar();
    

    if (isset($_POST['enviar'])){
                $descricao=$_POST['texto'];
                if(strlen($descricao)>100){
                    header('Location: /posts/novoTexto.php?msg=O texto supera o limite de 100 caracteres!');
                }else{
                $dataUpload = date("Y-m-d");

                $stmt=$posts->prepare('INSERT INTO post (idUsuario,descricao,dia) VALUES (:id,:descricao,:dia)');
                $stmt->bindParam(':id', $_SESSION['idUsuario']);
                $stmt->bindParam(':descricao', $descricao);
                $stmt->bindParam(':dia', $dataUpload);
                $result=$stmt->execute();
                }
                if ($result){
                header('Location: ../perfil.php?msg=post feito com sucesso!');
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
    <title>Novo Texto </title>
</head>
<body class="text-center">
    <main class="form-signin">

        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <h1 class="">Novo Post</h1>
            <p>
                <?php if (isset($_GET['msg'])){echo $_GET['msg'];}?>
            </p>
            <div class="form-group">
                <label for="texto">No que você está pensando: </label>
                <textarea class="form-control" name="texto" rows="3"></textarea>
            </div><br>
            <button name="enviar" class="w-100 btn btn-lg btn-secondary" type="submit">Postar</button>
        </form>
    </main>
</body>
</html>
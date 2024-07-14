<?php

    require '../configuracoes.php';
    autenticar();
    
    if (isset($_POST['enviar'])){
        
        if (empty ($_FILES['imgPost']['name'])){
            $nomeImg=$_SESSION['fotoPerfil'];
            $novoNome=$nomeImg;
        }else{
            $nomeImg=$_FILES['imgPost']['name'];
            $novoNome=$dataUpload."-".$nomeImg;
        }
        $typeImg=pathinfo($nomeImg);
        $tmpImg=$_FILES['imgPost']['tmp_name'];
        $sizeImg=$_FILES['imgPost']['size'];
        $data=date("Y-m-d");
        $dataUpload = date("Y-m-d_H-i");
        $erros=array();

        $maxSize= 1024*1024*5;
        if ($sizeImg>$maxSize){
            $erros[]= "O arquivo ultrapassa o limite de 5 MB<br>";
            }
        $tiposPermitido=['png','jpg', 'jpeg', 'gif'];
        if (! in_array($typeImg['extension'], $tiposPermitido )){
            $erros[]= "Não é possível fazer o upload desse tipo de arquivo!<br>Por favor, faça upload de arquivos .gif, .png, .jpg ou .jpeg<br>";
            }

        if(!empty($erros)){
            foreach($erros as $erro){
                echo $erro;
            }
            }else{
                $caminho= "../posts/imagens/";

                $nome=$_POST['nome'];
                $usuarios=$_POST['user'];
                $telefone=$_POST['telefone'];
                $email=$_POST['email'];

                $pesquisaUsuario=$db->prepare("SELECT usuarios FROM users WHERE usuarios =:user");
                $pesquisaUsuario->bindValue(':user',$user);
                $usuarioJaCadastrado=$pesquisaUsuario->execute()->fetchArray(SQLITE3_ASSOC);

                if($usuarioJaCadastrado){
                    header('Location: editar.php?msg=Usuário já existe, por favor crie outro');
                }else{
                
                $_SESSION['nome']=$_POST['nome'];
                $_SESSION['user']=$_POST['user'];
                $_SESSION['telefone']=$_POST['telefone'];
                $_SESSION['email']=$_POST['email'];
                $_SESSION['fotoPerfil']=$novoNome;

                
                $stmt=$db->prepare('UPDATE users SET fotoPerfil=:foto, email=:email, usuarios=:usuarios, nome=:nome, telefone=:telefone WHERE id=:id ');
                $stmt->bindParam(':id', $_SESSION['idUsuario']);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':foto', $novoNome);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':usuarios', $usuarios);
                $stmt->bindParam(':telefone', $telefone);
                $stmt->execute();
                if ($nomeImg){
                if(move_uploaded_file($tmpImg, $caminho.$novoNome)){
                    header('Location: ../perfil.php?msg=atualização feito com sucesso!');
                }
                else{
                    header('Location: ../perfil.php');
                }
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
    <title>Editar perfil</title>
</head>
<body class="text-center">
    <main class="form-signin">
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
            <h1 class="">Editar Perfil</h1>
            <p>
                <?php if (isset($_GET['msg'])){echo $_GET['msg'];}?>
            </p>
            <div class="mb-3">
                <label class="form-label" for="imgPost">Nova foto de perfil:</label>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" name="imgPost" value="<?php echo $_SESSION['fotoPerfil']?>">
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email: </label>
                <input type="email" class="form-control" name="email" value="<?php echo $_SESSION['email']?>">
            </div>
            <div class="mb-3">
                <label for="user" class="form-label">Usuário: </label>
                <input type="text" class="form-control" name="user" value="<?php echo $_SESSION['user']?>">
            </div>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo: </label>
                <input type="text" class="form-control" name="nome" value="<?php echo $_SESSION['nome']?>">
            </div>
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone: </label>
                <input type="tel" class="form-control" name="telefone" value="<?php echo $_SESSION['telefone']?>">
            </div>
            <button name="enviar" class="w-100 btn btn-lg btn-secondary" type="submit">Atualizar</button>
        </form>
    </main>
</body>
</html>

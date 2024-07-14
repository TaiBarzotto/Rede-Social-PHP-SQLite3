<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="signin.css" rel="stylesheet">
    <title>Login</title>
</head>
<body class="text-center">
    <main class="form-signin">

        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <h1 class="">Login</h1>
            <p>
                <strong><?php if (isset($_GET['msg'])){echo $_GET['msg'];}?></strong>
            </p>
            <div class="mb-3">
                <label for="email" class="form-label">Email: </label>
                <input type="email" class="form-control" name="email" placeholder="Digite seu email (nome@email.com)" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha: </label>
                <input type="password" class="form-control" name="senha" placeholder="Digite sua senha" required>
            </div>
            <button nome="enviar" class="w-100 btn btn-lg btn-secondary" type="submit">Entrar</button>
        </form>
        <p>Não tem login? <a href="acoes/cadastro.php">Cadastre-se</a></p>
    </main>
</body>
</html>

<?php

require "configuracoes.php";

$email=$_POST['email'];
$senha=$_POST['senha'];

$stmt=$db->prepare('SELECT * FROM users WHERE email=:email');
$stmt->bindValue(':email',$email);
$usuario=$stmt->execute()->fetchArray(SQLITE3_ASSOC);

if(!$email==null){
if(!$usuario){
    header('Location: ../login.php?msg=Usuário não encontrado. Por favor cadastre-se!');
    exit;
}else{
    if(password_verify($senha,$usuario['senha'])){
        session_start();
        $_SESSION['idUsuario']=$usuario['id'];
        $_SESSION['user']=$usuario['usuarios'];
        $_SESSION['nome']=$usuario['nome'];
        $_SESSION['email']=$usuario['email'];
        $_SESSION['likes']=$usuario['likes'];
        $_SESSION['telefone']=$usuario['telefone'];
        $_SESSION['fotoPerfil']=$usuario['fotoPerfil'];
        $_SESSION['biografia']=$usuario['biografia'];
        $_SESSION['seguidores']=$usuario['seguidores'];
        $_SESSION['visu'];
        $_SESSION['auth']= true;
        header('Location: ./index.php');
    }else{
        header('Location: ./login.php?msg=Senha não confere');
    }  
}
}


?>
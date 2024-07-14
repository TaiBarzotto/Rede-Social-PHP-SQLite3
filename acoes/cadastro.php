<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="../signin.css" rel="stylesheet">
    <title>Cadastro</title>   
</head>
<body class="text-center">
    <main class="form-signin">

        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <h1 class="">Cadastre-se</h1>
            <p>
                <strong><?php if (isset($_GET['msg'])){echo $_GET['msg'];}?></strong>
            </p>

            <div class="mb-3">
                <label for="email" class="form-label">Email: </label>
                <input type="email" class="form-control" name="email" placeholder="Digite um email (nome@email.com)" required>
            </div>
            <div class="mb-3">
                <label for="user" class="form-label">Usuário: </label>
                <input type="text" class="form-control" name="user" placeholder="Crie um usuário" required>
            </div>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo: </label>
                <input type="text" class="form-control" name="nome" placeholder="Digite seu nome completo" required>
            </div>
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone: </label>
                <input type="tel" class="form-control" name="telefone" placeholder="+55(XX)XXXXX-XXXX" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha: </label>
                <input type="password" class="form-control" name="senha" placeholder="Crie uma senha" required>
            </div>
            <button name="cadastrar" class="w-100 btn btn-lg btn-secondary" type="submit">Cadastrar</button>
        </form>
    </main>
</body>
</html>

<?php

require '../configuracoes.php';

$email=$_POST['email'];
$senha=password_hash($_POST['senha'],PASSWORD_DEFAULT);
$user=$_POST['user'];
$telefone=$_POST['telefone'];
$nome=$_POST['nome'];
$fotoPerfil='Standard_profile_picture.jpg';

$pesquisaUsuario=$db->prepare("SELECT usuarios FROM users WHERE usuarios =:user");
$pesquisaUsuario->bindValue(':user',$user);
$usuarioJaCadastrado=$pesquisaUsuario->execute()->fetchArray(SQLITE3_ASSOC);

if (isset($_POST['cadastrar'])){
    if($usuarioJaCadastrado){
        header('Location: cadastro.php?msg=Usuário já existe, por favor crie outro');
    }else
    {
        $stmt=$db->prepare('INSERT INTO users (email, senha, usuarios,fotoPerfil, nome, telefone ) VALUES (:email,:senha,:user,:fotoPerfil,:nome,:telefone)');
        $stmt->bindValue(':email',$email);
        $stmt->bindValue(':senha',$senha);
        $stmt->bindValue(':user',$user);
        $stmt->bindValue(':fotoPerfil',$fotoPerfil);
        $stmt->bindValue(':nome',$nome);
        $stmt->bindValue(':telefone',$telefone);
        $result=$stmt->execute();
        
        if($result==false){
            header('Location: ../login.php?msg=Email já cadastrado. Faça login!');
        }else{
            header('Location: ../login.php?msg=Cadastro realizado com sucesso. Faça login!');
        }
        
    }
}
?>
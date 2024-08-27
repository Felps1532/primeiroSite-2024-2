<?php
session_start(); 

include("conexao.php");

if (isset($_POST['login_usuario'])) {
    $email_usuario = $_POST['email_usuario'];
    $senha_usuario = $_POST['senha_usuario'];

    // Preparar a consulta SQL para selecionar o usuário
    $stmt = $conn->prepare("SELECT * FROM tbl_usuarios WHERE email_usuario = ? AND senha_usuario = ?");
    $stmt->bind_param("ss", $email_usuario, $senha_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o usuário existe
    if ($result->num_rows > 0) {
        // Usuário encontrado
        $usuario = $result->fetch_assoc();
        
        // Armazena os dados do usuário na sessão
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
        $_SESSION['nivel'] = $usuario['nivel'];  // Corrigido para pegar o nível corretamente

        // Acessa o nível do usuário
        $nivel = $usuario['nivel'];

        // Redireciona com base no nível
        switch ($nivel) {
            case 0:
                header("Location: principal.php");
                break;
            case 1:
                header("Location: principal.php");
                break;
            // default:
            //     // Se o nível não for 0 ou 1, pode redirecionar para uma página padrão
            //     header("Location: principal.php"); -> principal do login!
            //     break;
        }
        
        exit;

    } else {
        // Credenciais inválidas
        $erro_login = "E-mail ou senha inválidos.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login Rathergames</title>
    <link rel="icon" type="image/x-icon" href="imagens/gamepad-solid-branco.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" />
</head>

<body>
    <div class="d-flex justify-content-center align-items-center">
        <i class="fa-solid fa-gamepad"></i>
        <h1 class="titulo-rathergames text-uppercase ms-2"><strong>RatherGames</strong></h1>
    </div>

    <div class="position-absolute top-50 start-50 translate-middle">
        <h1><strong>Login</strong></h1>

        <form action="index.php" method="POST">
            <div class="input-group mb-3">
                <input name="email_usuario" type="email" class="form-control" placeholder="Seu e-mail" required>
            </div>

            <div class="input-group mb-3">
                <input name="senha_usuario" type="password" class="form-control" placeholder="Sua senha" required>
            </div>

            <?php if (isset($erro_login)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $erro_login; ?>
                </div>
            <?php endif; ?>

            <div>
                <button name="login_usuario" type="submit" class="btn btn-primary w-100">Login</button>
            </div>
        </form>

        <div class="d-flex mt-10" style="margin-top: 7px;">
            <a href="registrarRathergames.php" class="btn btn-primary w-100">Registrar</a>
        </div>
    </div>

</body>

</html>

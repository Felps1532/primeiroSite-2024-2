<?php
include("conexao.php");

$sql = "SELECT * FROM tbl_usuarios";
$result = $conn->query($sql);

if (isset($_POST['cadastrar_usuario'])) {
    // Dados do usuário para inserir
    $id_usuario = $_POST['id_usuario'];

    $nome_usuario = $_POST['nome_usuario'];
    $sobrenome_usuario = $_POST['sobrenome_usuario'];
    $email_usuario = $_POST['email_usuario'];
    $telefone_usuario = $_POST['telefone_usuario'];
    $senha_usuario = $_POST['senha_usuario'];
    $nivel = 0;

    // Preparar e executar a consulta SQL para inserir os dados no banco de dados
    $stmt = $conn->prepare("INSERT INTO tbl_usuarios (`nome_usuario`, `sobrenome_usuario`, `email_usuario`, `telefone_usuario`, `senha_usuario`, `nivel`) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nome_usuario, $sobrenome_usuario, $email_usuario, $telefone_usuario, $senha_usuario, $nivel);
    $stmt->execute();

    // redireciona para "tal" página após o botão de enviar for clicado
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Registrar Rathergames</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="imagens/gamepad-solid-branco.png" />

    <!-- Font Awesome icons (free version)-->
    <!-- <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script> -->

    <!-- BOOTSTRAP cdn-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />

    <!-- Core theme CSS (includes Bootstrap)-->
    <!-- <link href="css/styles.css" rel="stylesheet"> -->

    <!-- novo CSS criado -->
    <link rel="stylesheet" href="css/styles2.css">

    <!-- script do font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>

    <a href="index.php"><i class="fa-regular fa-circle-left back-arrow"></i></a>

    <!-- TÍTULO -->

    <div class="d-flex justify-content-center align-items-center">

        <i class="fa-solid fa-gamepad"></i>
        <h1 class="titulo-rathergames text-uppercase ms-2"><strong>RatherGames</strong></h1>

    </div>



    <!-- ÁREA DE REGISTRO -->
    <div class="position-absolute top-50 start-50 translate-middle">

        <h1 class=""><strong>Registre-se</strong></h1>

        <form action="registrarRathergames.php" method="POST">
            <div class="input-group">
                <input required name="nome_usuario" type="text" class="form-control" placeholder="Nome">
                <input required name="sobrenome_usuario" type="text" class="form-control" placeholder="Sobrenome">
            </div>
            <div class="input-group mb-3">
                <input required name="email_usuario" type="email" class="form-control" placeholder="Seu melhor e-mail">
                <span class="input-group-text" id="basic-addon2">@exemplo.com</span>
            </div>
            <div class="input-group mb-3">
                <input required name="telefone_usuario" type="tel" class="form-control" placeholder="Telefone">
            </div>
            <div class="input-group mb-3">
                <input required name="senha_usuario" type="password" class="form-control" placeholder="Crie uma senha forte">
            </div>

            <div style="text-align: center;">
                <button name="cadastrar_usuario" type="submit" class="btn btn-primary w-100">Cadastrar</button>
            </div>
    </div>
    </form>

</body>

</html>
<?php
include("conexao.php");

session_start(); // Inicia a sessão

// Verifica se o usuário está logado e se tem nível 1 (administrador)
if (!isset($_SESSION['nivel']) || $_SESSION['nivel'] != 1) {
    // Se o usuário não for administrador, redireciona para "acesso-negado.php" ou outra página
    header("Location: logoff.php");
    exit(); // Termina o script para garantir que o código abaixo não seja executado
}

// Consultando em SQL para selecionar todos os dados da tabela
$sql = "SELECT * FROM tbl_usuarios";
$result = $conn->query($sql);

// NOVO ALTERAR USUÁRIOS - UPDATE tbl_usuarios SET nome_usuario = 'João' WHERE id_usuario = 11

if (isset($_POST['alterar_usuario'])) {

    $id_usuario = $_POST['id_usuario'];
    $nome_usuario = $_POST['nome_usuario'];
    $sobrenome_usuario = $_POST['$sobrenome_usuario'];
    $telefone_usuario = $_POST['telefone_usuario'];
    $senha_usuario = $_POST['senha_usuario'];
    $nivel = $_POST['nivel'];

    $sql = "UPDATE tbl_usuarios SET ";
    $updates = [];

    // se nome não estiver vazio adicione essa string no array '$updates'
    if (!empty($nome_usuario)) {
        $updates[] = "nome_usuario = '$nome_usuario'";
    }

    if (!empty($sobrenome_usuario)) {
        $updates[] = "sobrenome_usuario = '$sobrenome_usuario'";
    }

    if (!empty($email_usuario)) {
        $updates[] = "email_usuario = '$email_usuario'";
    }

    if (!empty($telefone_usuario)) {
        $updates[] = "telefone_usuario = '$telefone_usuario'";
    }

    if (!empty($senha_usuario)) {
        $updates[] = "senha_usuario = '$senha_usuario'";
    }

    if (!empty($nivel)) {
        $updates[] = "nivel = '$nivel'";
    }

    if (!empty($updates)) {
        $sql .= implode(", ", $updates);
        $sql .= " WHERE id_usuario = '$id_usuario'";

        $resultado = mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn) > 0) { ?>
            <script>
                alert("Alterado com Sucesso!");
                window.location.href = "associados.php";
            </script>
        <?php } else { ?>
            <script>
                alert("Erro na alteração, por favor repita!");
            </script>
        <?php }
    } else { ?>
        <script>
            alert("Nenhum dado para alterar!");
        </script>
    <?php }
}

// EXCLUIR USUÁRIO 

if (isset($_POST['excluir_jogos'])) {
    $id_jogos = $_POST['id_jogos'];
    $sql = "DELETE FROM tbl_games WHERE id_jogos = '$id_jogos'";
    $resultado = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) { ?>
        <!---Alert----->
<script>
    alert("Excluído!");
    window.location.href = "jogos.php";
</script>
<?php } else { ?>
<!---Alert----->
<script>
    alert("Erro na exclusão, por favor repita!");
</script>
<?php }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Rathergames</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="imagens/gamepad-solid-branco.png" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
        type="text/css" />

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet">

    <!-- Eu preciso do script do font awesome -->
    <!-- tá aqui embaixo -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="principal.php">RatherGames</a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                            href="principal.php#avalie">Avalie os jogos</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                            href="principal.php#sobre">Sobre</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                            href="logoff.php">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead bg-primary text-white text-center">
        <div class="d-flex align-items-center flex-column">
            <!-- Masthead Avatar Image-->
            <i class="fa-solid fa-user" style="font-size: 100px;margin-bottom: 25px;"></i>
            <!-- Masthead Heading-->
            <h1 class="masthead-heading text-uppercase mb-0">Associados</h1>
            <h1 class="masthead-heading text-uppercase mb-0">Rathergames</h1>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fa-solid fa-rocket"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Masthead Subheading-->
            <p class="masthead-subheading font-weight-light mb-0">Conheça os <u>melhores avaliadores da atualidade</u>!
            </p>
        </div>
    </header>
    <!-- Portfolio Section-->
    <section class="page-section portfolio" id="">
        <div class="container">
            <!-- Portfolio Section Heading-->

            <!-- Icon Divider // foguetinho agora-->

            <!-- LISTA DE ASSOCIADOS-->

            <div class="m-5">
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Lista dos Associados
                </h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fa-solid fa-rocket"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center text-secondary" scope="col">id_usuario</th>
                            <th class="text-center text-secondary" scope="col">nome_usuario</th>
                            <th class="text-center text-secondary" scope="col">sobrenome_usuario</th>
                            <th class="text-center text-secondary" scope="col">email_usuario</th>
                            <th class="text-center text-secondary" scope="col">telefone_usuario</th>
                            <th class="text-center text-secondary" scope="col">senha_usuario</th>
                            <th class="text-center text-secondary" scope="col">nivel</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0)
                            // Output dos dados de cada linha
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='fw-bold'>" . $row["id_usuario"] . "</td>";
                                echo "<td>" . $row["nome_usuario"] . "</td>";
                                echo "<td>" . $row["sobrenome_usuario"] . "</td>";
                                echo "<td>" . $row["email_usuario"] . "</td>";
                                echo "<td>" . $row["telefone_usuario"] . "</td>";
                                echo "<td>" . $row["senha_usuario"] . "</td>";
                                echo "<td>" . $row["nivel"] . "</td>";
                                echo "</tr>";
                            } else {
                            echo "<tr><td colspan='9' class='text-center'>Nenhum registro encontrado...</td></tr>";
                        }
                        // Fechar conexão
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
    </section>

    <!-- Contact Section-->
    <section class="page-section pt-0" id="registrar">
        <div class="container">
            <!-- Contact Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Alterar Usuário</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fa-solid fa-pen-to-square"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Seção Alterar Usuário -->
            <div class="row justify-content-center">
                <div class="p-0 col-lg-8 col-xl-7">
                    <form action="associados.php" method="POST" enctype="multipart/form-data">

                        <!-- ID do Usuário -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="id_usuario" type="number" placeholder="" required/>
                            <label>ID do Usuário</label>
                            <div class="invalid-feedback">
                            </div>
                        </div>

                        <!-- Nome do Usuário -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="nome_usuario" type="text" placeholder="" />
                            <label>Nome do Usuário</label>
                            <div class="invalid-feedback">
                            </div>
                        </div>

                        <!-- Sobrenome do Usuário -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="sobrenome_usuario" type="text" placeholder="" />
                            <label>Sobrenome do Usuário</label>
                            <div class="invalid-feedback">
                            </div>
                        </div>

                        <!-- E-mail do Usuário -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="email_usuario" type="email" placeholder="" />
                            <label>E-mail do Usuário</label>
                            <div class="invalid-feedback">
                            </div>
                        </div>

                        <!-- Telefone do Usuário -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="telefone_usuario" type="tel" placeholder="" />
                            <label>Telefone do Usuário</label>
                            <div class="invalid-feedback">
                            </div>
                        </div>

                        <!-- Senha do Usuário -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="senha_usuario" type="password" placeholder="" />
                            <label>Senha do Usuário</label>
                            <div class="invalid-feedback">
                            </div>
                        </div>

                        <!-- Nível do Usuário -->
                        <h3 style="color: #6C757D; font-weight: normal;">Nível do Usuário</h3>
                        <select required name="nivel" class="form-select" style="margin: 20px 0px 20px 0px;">
                            <option disabled selected>Nível do Usuário</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                        </select>

                        <!-- colocar foto do usuário -->

                        <!-- Upload de Capa para Registrar -->
                        <!-- <div class="mt-3">
                            <div class="mt-5">
                                <h3 style="color: #6C757D; font-weight: normal;">Upload de Capa</h3>
                                <div class="mb-3">
                                    <label for="formFileRegistrar" class="form-label">Selecione uma imagem</label>
                                    <input required name="local_imagem" class="form-control" type="file"
                                        id="formFileRegistrar" accept="image/*">
                                </div>
                                <div>
                                    <img class="center" id="previewRegistrar" src="" alt="Preview da Imagem"
                                        style="max-width: 25%; display: none;">
                                </div>
                            </div>
                        </div> -->

                        <div class="d-none" id="submitSuccessMessage">
                            <div class="text-center mb-3">
                                <div class="fw-bolder">Formulário enviado com sucesso!</div>
                            </div>
                        </div>
                        <button style="margin-top: 12px;" name="alterar_usuario" class="btn btn-primary btn-xl"
                            type="submit">Alterar</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="footer text-center">
        <div class="container">
            <div class="row">
                <!-- Footer Location-->

                <!-- Footer Social Icons-->
                <div class="col-lg-12 mb-5 mb-lg-0">
                    <h4 class="text-uppercase mb-4">Redes sociais</h4>
                    <!-- <a class="btn btn-outline-light btn-social mx-1" href="#!"><i class="fab fa-fw fa-facebook-f"></i></a> -->
                    <a class="btn btn-outline-light btn-social mx-1" href="https://www.instagram.com/felps_eu/"
                        rel="external" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="https://www.linkedin.com/in/felipe-belomi/"
                        rel="external" target="_blank"><i class="fab fa-fw fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-light btn-social mx-1" href="https://github.com/felps1532" rel="external"
                        target="_blank"><i class="fa-brands fa-github"></i></a>
                    <!-- https://github.com/felps1532 -->
                </div>

                <!-- Footer About Text-->
                <div class="col-lg-12" style="margin-top: 20px;">
                    <h4 class="text-uppercase mb-4">Agradecimentos</h4>
                    <p class="lead mb-0">
                        A sua avaliação é muito importante &#x1F44D;
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Copyright Section-->
    <div class="copyright py-4 text-center text-white">
        <div class="container"><small>Copyright &copy; Site do Felps 2024</small></div>
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>
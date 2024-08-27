<?php
include ("conexao.php");

// Consultando em SQL para selecionar todos os dados da tabela
$sql = "SELECT * FROM tbl_games";
$result = $conn->query($sql);

if (isset($_POST['enviar_jogo'])) {
    // Dados para inserir
    $statusJogo = $_POST['statusJogo'];
    $nome_jogo = $_POST['nome_jogo'];
    $descricao_jogo = $_POST['descricao_jogo'];
    $nota_jogo = $_POST['nota_jogo'];

    // Verificar se um arquivo foi enviado
    if (isset($_FILES['local_imagem']) && $_FILES['local_imagem']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['local_imagem']['tmp_name'];
        $fileName = $_FILES['local_imagem']['name'];
        $fileSize = $_FILES['local_imagem']['size'];
        $fileType = $_FILES['local_imagem']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Configurar o diretório onde o arquivo será salvo
        $uploadFileDir = './imagens/';
        $dest_path = $uploadFileDir . $fileName;

        // Verificar se o diretório existe, se não, criar
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        // Mover o arquivo para o diretório desejado
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $message = 'Imagem enviada com sucesso.';
            $local_imagem = $dest_path; // Salvar o caminho completo para o banco de dados
        } else {
            $message = 'Erro ao mover o arquivo para o diretório de upload.';
            $local_imagem = null; // Se não mover o arquivo, não salva o caminho no banco
        }
    } else {
        $message = 'Nenhuma imagem foi enviada ou houve um erro no upload.';
        $local_imagem = null; // Nenhuma imagem foi enviada
    }

    // Preparar e executar a consulta SQL para inserir os dados no banco de dados
    $stmt = $conn->prepare("INSERT INTO tbl_games (`nome_jogo`,`statusJogo`, `local_imagem`, `descricao_jogo`, `nota_jogo`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nome_jogo, $statusJogo, $local_imagem, $descricao_jogo, $nota_jogo);

    
}

// EDITAR DADOS
if (isset($_POST['editar_jogos'])) {
    $id_jogos = $_POST['id_jogos'];
    $nome_jogo = $_POST['nome_jogo'];
    $statusJogo = $_POST['statusJogo'];
    $descricao_jogo = $_POST['descricao_jogo'];
    $nota_jogo = $_POST['nota_jogo'];

    // Exibir variáveis para depuração
    echo "ID Jogo: $id_jogos<br>";
    echo "Nome Jogo: $nome_jogo<br>";
    echo "Status Jogo: $statusJogo<br>";
    echo "Descrição Jogo: $descricao_jogo<br>";
    echo "Nota Jogo: $nota_jogo<br>";

    // Consulta os dados atuais do jogo
    $query = "SELECT * FROM tbl_games WHERE id_jogos = '$id_jogos'";
    $resultado = mysqli_query($conn, $query);
    if (!$resultado) {
        die("Erro na consulta ao banco de dados: " . mysqli_error($conn));
    }
    $jogo_atual = mysqli_fetch_assoc($resultado);

    // Se não encontrar o jogo, exibe um erro
    if (!$jogo_atual) { ?>
        <script>
            alert("Jogo não encontrado!");
            window.location.href = "jogos.php";
        </script>
        <?php
        exit();
    }

    // Inicializa o local_imagem com o valor atual
    $local_imagem = $jogo_atual['local_imagem'];

    // Processa o upload da imagem, se houver uma nova imagem
    if (isset($_FILES['local_imagem']) && $_FILES['local_imagem']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['local_imagem']['tmp_name'];
        $fileName = $_FILES['local_imagem']['name'];
        $fileSize = $_FILES['local_imagem']['size'];
        $fileType = $_FILES['local_imagem']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Configurar o diretório onde o arquivo será salvo
        $uploadFileDir = './imagens/';
        $dest_path = $uploadFileDir . $fileName;

        // Verificar se o diretório existe, se não, criar
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        // Mover o arquivo para o diretório desejado
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            echo "Imagem enviada com sucesso.<br>";
            $local_imagem = $dest_path; // Atualiza o caminho completo da nova imagem
        } else {
            echo "Erro ao mover o arquivo para o diretório de upload.<br>";
        }
    } else {
        echo "Nenhuma nova imagem foi enviada ou houve um erro no upload.<br>";
    }

    // Construir a query SQL para atualização
    $sql = "UPDATE tbl_games SET 
            nome_jogo = '$nome_jogo', 
            statusJogo = '$statusJogo', 
            descricao_jogo = '$descricao_jogo', 
            nota_jogo = '$nota_jogo',
            local_imagem = '$local_imagem'
            WHERE id_jogos = '$id_jogos'";

    echo "SQL Query: $sql<br>";

    $resultado = mysqli_query($conn, $sql);

    if (!$resultado) {
        die("Erro na atualização: " . mysqli_error($conn));
    }

    if (mysqli_affected_rows($conn) > 0) { ?>
        <script>
            alert("Alterado com Sucesso!");
            window.location.href = "jogos.php";
        </script>
    <?php } else { ?>
        <script>
            alert("Erro na alteração, por favor repita!");
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
            <a class="navbar-brand" href="index.php">RatherGames</a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                            href="index.php#avalie">Avalie os jogos</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                            href="index.php#sobre">Sobre</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                            href="#registre">Registre-se</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                            href="#contact">Associados</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead bg-primary text-white text-center">
        <div class="d-flex align-items-center flex-column">
            <!-- Masthead Avatar Image-->
            <i class="fa-solid fa-robot" style="font-size: 100px;margin-bottom: 25px;"></i>
            <!-- Masthead Heading-->
            <h1 class="masthead-heading text-uppercase mb-0">JOGOS</h1>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fa-solid fa-rocket"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Masthead Subheading-->
            <p class="masthead-subheading font-weight-light mb-0">Lista dos <u>melhores jogos da atualidade!</u></p>
        </div>
    </header>
    <!-- Portfolio Section-->
    <section class="page-section portfolio" id="avalie">
        <div class="container">
            <!-- Portfolio Section Heading-->

            <!-- Icon Divider // foguetinho agora-->


            <!-- LISTA DE ASSOCIADOS-->

            <div class="m-5">
                <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Lista dos Jogos</h2>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fa-solid fa-rocket"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center text-secondary" scope="col">id jogo</th>
                            <th class="text-center text-secondary" scope="col">nome do jogo</th>
                            <th class="text-center text-secondary" scope="col">status</th>
                            <th class="text-center text-secondary" scope="col">endereço</th>
                            <th class="text-center text-secondary" scope="col">descrição</th>
                            <th class="text-center text-secondary" scope="col">data de modificação</th>
                            <th class="text-center text-secondary" scope="col">nota do jogo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0)
                            // Output dos dados de cada linha
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='fw-bold'>" . $row["id_jogos"] . "</td>";
                                echo "<td>" . $row["nome_jogo"] . "</td>";
                                echo "<td>" . $row["statusJogo"] . "</td>";
                                echo "<td><img style='width: 100px; border-radius: 10px;' src='" . $row["local_imagem"] . "' alt='Imagem do jogo' /></td>";
                                echo "<td>" . $row["descricao_jogo"] . "</td>";
                                echo "<td>" . $row["log"] . "</td>";
                                echo "<td>" . $row["nota_jogo"] . "</td>";
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
    <section class="page-section pt-0" id="registre">
        <div class="container">
            <!-- Contact Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Registre um Jogo</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fa-solid fa-rocket"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Seção registre um jogo-->
            <div class="row justify-content-center">
                <div class="p-0 col-lg-8 col-xl-7">
                    <form action="jogos_old.php" method="POST" enctype="multipart/form-data">

                        <!-- Nome do jogo -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="nome_jogo" type="text"
                                placeholder="Digite o nome do jogo..." required />
                            <label>Nome do jogo</label>
                            <div class="invalid-feedback" data-sb-feedback="text:required">Este campo é obrigatório!
                            </div>
                        </div>

                        <!-- Descrição do jogo -->
                        <div class="form-floating mb-3">
                            <input required name="descricao_jogo" class="form-control" type="text"
                                placeholder="Descreva o jogo com suas palavras" style="height: 10rem"
                                data-sb-validations="required" />
                            <label>Descrição do jogo</label>
                            <div class="invalid-feedback" data-sb-feedback="text:required">Este campo é obrigatório!
                            </div>
                        </div>

                        <!-- Nota do jogo -->
                        <div class="form-floating mb-3">
                            <input required name="nota_jogo" class="form-control" type="number"
                                placeholder="Dê uma nota ao jogo." data-sb-validations="required"></input>
                            <label>Nota do jogo</label>
                        </div>

                        <!-- Status do jogo -->
                        <h3 style="color: #6C757D; font-weight: normal;">Status do jogo</h3>
                        <select required name="statusJogo" class="form-select" aria-label="Default select example"
                            style="margin: 20px 0px 20px 0px;" required>
                            <option disabled selected>Status atual do jogo</option>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>

                        <!-- Upload de Capa -->
                        <div class="mt-3">
                            <div class="mt-5">
                                <h3 style="color: #6C757D; font-weight: normal;">Upload de Capa</h3>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Selecione uma imagem</label>
                                    <input required name="local_imagem" class="form-control" type="file" id="formFile"
                                        accept="image/*">
                                </div>
                                <div>
                                    <img class="center" id="preview" src="" alt="Preview da Imagem"
                                        style="max-width: 25%; display: none;">
                                </div>
                            </div>
                        </div>

                        <!-- Script para pré-visualização da imagem -->
                        <script>
                            document.getElementById('formFile').addEventListener('change', function (event) {
                                const file = event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function (e) {
                                        const img = document.getElementById('preview');
                                        img.src = e.target.result;
                                        img.style.display = 'block';
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });
                        </script>

                        <div class="d-none" id="submitSuccessMessage">
                            <div class="text-center mb-3">
                                <div class="fw-bolder">Formulário enviado com sucesso!</div>
                            </div>
                        </div>
                        <button name="enviar_jogo" class="btn btn-primary btn-xl" type="submit">Cadastrar jogo</button>
                    </form>

                </div>
            </div>
        </div>
    </section>

    <!-- EDITAR CONTEÚDO -->

    <section class="page-section pt-0" id="registre">
        <div class="container">
            <!-- Contact Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">EDITAR CONTEÚDO</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fa-solid fa-pen-to-square"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Seção registre um jogo-->
            <div class="row justify-content-center">
                <div class="p-0 col-lg-8 col-xl-7">
                    <form action="jogos_old.php" method="POST" enctype="multipart/form-data">

                        <!-- ID do jogo -->
                        <div class="form-floating mb-3">
                            <input required class="form-control" name="id_jogos" type="number"
                                placeholder="Digite o id do jogo..." />
                            <label>ID do jogo</label>
                            <div class="invalid-feedback" data-sb-feedback="text:required">Este campo é obrigatório!
                            </div>
                        </div>

                        <!-- Nome do jogo -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="nome_jogo" type="text"
                                placeholder="Digite o nome do jogo..." />
                            <label>Nome do jogo</label>
                            <div class="invalid-feedback" data-sb-feedback="text:required">Este campo é obrigatório!
                            </div>
                        </div>

                        <!-- Descrição do jogo -->
                        <div class="form-floating mb-3">
                            <input name="descricao_jogo" class="form-control" type="text"
                                placeholder="Descreva o jogo com suas palavras" style="height: 10rem"
                                data-sb-validations="required" />
                            <label>Descrição do jogo</label>
                            <div class="invalid-feedback" data-sb-feedback="text:required">Este campo é obrigatório!
                            </div>
                        </div>

                        <!-- Nota do jogo -->
                        <div class="form-floating mb-3">
                            <input name="nota_jogo" class="form-control" type="number"
                                placeholder="Dê uma nota ao jogo." data-sb-validations="required"></input>
                            <label>Nota do jogo</label>
                        </div>

                        <!-- Status do jogo -->
                        <h3 style="color: #6C757D; font-weight: normal;">Status do jogo</h3>
                        <select name="statusJogo" class="form-select" aria-label="Default select example"
                            style="margin: 20px 0px 20px 0px;">
                            <option disabled selected>Status atual do jogo</option>
                            <option value="ativo">Ativo</option>
                            <option value="inativo">Inativo</option>
                        </select>

                        <!-- Upload de Capa -->
                        <div class="mt-3">
                            <div class="mt-5">
                                <h3 style="color: #6C757D; font-weight: normal;">Upload de Capa</h3>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Selecione uma imagem</label>
                                    <input name="local_imagem" class="form-control" type="file" id="formFile"
                                        accept="image/*">
                                </div>
                                <div>
                                    <img class="center" id="preview" src="" alt="Preview da Imagem"
                                        style="max-width: 25%; display: none;">
                                </div>
                            </div>
                        </div>

                        <!-- Script para pré-visualização da imagem -->
                        <script>
                            document.getElementById('formFile').addEventListener('change', function (event) {
                                const file = event.target.files[0];
                                if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function (e) {
                                        const img = document.getElementById('preview');
                                        img.src = e.target.result;
                                        img.style.display = 'block';
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });
                        </script>

                        <div class="d-none" id="submitSuccessMessage">
                            <div class="text-center mb-3">
                                <div class="fw-bolder">Edição realizada com sucesso!</div>
                            </div>
                        </div>
                        <button name="editar_jogos" class="btn btn-primary btn-xl" type="submit">Editar campos
                            preenchidos</button>
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
                <div class="mb-5 mb-lg-0">
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
                <div class="" style="margin-top: 20px;">
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
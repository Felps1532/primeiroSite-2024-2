<?php

session_start();
include("conexao.php");

$sql = "SELECT * FROM tbl_games";
$result = $conn->query($sql);

// se não achar o usuário volta para a tela de login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

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

    <!-- CSS para as estrelas de avaliação -->
    <style>
        :root {
            --primary-colour: #ffffff;
            --secondary-colour: hsl(0, 0%, 41%);

            --star-colour: hsl(38 90% 55%);
        }

        .container .container__items {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0 .5em;
            width: 100%;
            height: 100%;
        }

        .container .container__items input {
            display: none;
        }

        .container .container__items label {
            width: 20%;
            aspect-ratio: 1;
            cursor: pointer;
        }

        .container .container__items label .star-stroke {
            display: grid;
            place-items: center;
            width: 100%;
            height: 100%;
            background: var(--secondary-colour);
            clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        }

        .container .container__items input:hover~label .star-stroke,
        .container .container__items input:checked~label .star-stroke {
            background: var(--star-colour);
        }

        .container .container__items input:checked~label .star-stroke .star-fill {
            background: var(--star-colour);
        }
    </style>
</head>

<body id="page-top">

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top">RatherGames</a>
            <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                            href="#avalie">Avalie os jogos</a></li>
                    <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded"
                            href="#sobre">Sobre</a></li>
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
            <i class="fa-solid fa-gamepad" style="font-size: 100px; margin-bottom: 25px;"></i>


            <!--  TEMPORÁRIO! -->
            <h1>Bem-vindo, <?php echo $_SESSION['nome_usuario']; ?>!</h1>
            <p>Você está logado no</p>


            <!-- Masthead Heading-->
            <h1 class="masthead-heading text-uppercase mb-0">RatherGames</h1>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i style="font-size: 35px;" class="fa-solid fa-rocket"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- Masthead Subheading-->
            <p class="masthead-subheading font-weight-light mb-0">Avalie os <u>melhores jogos da atualidade</u>!</p>
        </div>
    </header>
    <!-- Portfolio Section-->
    <section class="page-section portfolio" id="avalie">
        <div class="container">
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Avalie os jogos</h2>
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div><i class="fa-solid fa-rocket" style="font-size: 32px;"></i></div>
                <div class="divider-custom-line"></div>
            </div>

            <div class="row justify-content-center">

                <?php
                $sql = "SELECT * FROM tbl_games";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $id = $row['id_jogos'];
                        ?>

                        <div class="col-md-6 col-lg-4 mb-5">
                            <div class="portfolio-item mx-auto" data-bs-toggle="modal"
                                data-bs-target="#modal-<?php echo $id; ?>">
                                <div
                                    class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                                    <div class="portfolio-item-caption-content text-center text-white"><i
                                            class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <img class="img-fluid col" src="<?php echo $row["local_imagem"] ?>" />
                            </div>

                            <div class="container text-center">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <p class="fw-bold mt-2 col"><?php echo $row["nome_jogo"] ?></p>
                                    </div>
                                    <div class="col">
                                        <div class="container__items">
                                            <?php
                                            for ($i = 1; $i <= $row["nota_jogo"]; $i++) {
                                                echo "<i class='fa-solid fa-star text-warning'></i>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modal-<?php echo $id; ?>" tabindex="-1"
                            aria-labelledby="modalLabel-<?php echo $id; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel-<?php echo $id; ?>">
                                            <?php echo $row['nome_jogo']; ?>
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img class="img-fluid" src="<?php echo $row['local_imagem']; ?>"
                                            alt="<?php echo $row['nome_jogo']; ?>">
                                        <p><?php echo $row['descricao_jogo']; ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <!-- SESSÃO SOBRE-->
    <section class="page-section bg-primary text-white mb-0" id="sobre">
        <div class="container">
            <!-- About Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-white">Sobre</h2>
            <!-- Icon Divider-->
            <div class="divider-custom divider-light">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fa-solid fa-rocket"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <!-- About Section Content-->
            <div class="row">
                <div class="ms-auto">
                    <p class="lead">Este site foi criado com o intuito de os jogadores poderem avaliar os jogos!</p>
                </div>
                <div class="me-auto">
                    <p class="lead">
                        A avaliação dos jogadores nos jogos eletrônicos é crucial tanto para desenvolvedores quanto para
                        a comunidade gamer. Feedback positivo sobre jogos favoritos destaca acertos e incentiva
                        melhorias contínuas, enquanto críticas construtivas em jogos menos apreciados oferecem insights
                        valiosos para correções e inovações. Essa interação promove a evolução da qualidade dos jogos,
                        alinhando-os melhor às expectativas dos jogadores e enriquecendo a experiência de jogo para
                        todos.</p>
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
        <div class="container"><small>Copyright &copy; Site do Felps 2024
            </small></div>
        <?php if (isset($_SESSION['nivel']) && $_SESSION['nivel'] == 1): ?>
            <a style="display: block;" href="jogos.php">Jogos</a>
            <a style="display: block;" href="associados.php">Associados</a>
        <?php endif; ?>

    </div>

    <!-- Modals -->
    <!-- Modal 1-->
    <!-- <div class="col-md-6 col-lg-4 mb-5">
        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#<?php // echo $row['id_jogos'] ?>"
            data-id="<?php // echo $row['id_jogos']; ?>" data-nome="<?php // echo $row['nome_jogo']; ?>"
            data-descricao="<?php // echo $row['descricao']; ?>" data-imagem="<?php // echo $row['local_imagem']; ?>">
            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
                <div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i>
                </div>
            </div>
            <img class="img-fluid col" src="<?php // echo $row['local_imagem']; ?>" />
        </div>

        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col">


                </div>
                <div class="col">
                    <div class="container__items">
                        <?php // for ($i = 1; $i <= 5; $i++) { ?>
                            <i class="fa-solid fa-star text-warning"></i>
                        <?php // } ?>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

    <!-- JavaScript para o modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('<?php echo $row['id_jogos'] ?>');
            modal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var nomeJogo = button.getAttribute('data-nome');
                var descricao = button.getAttribute('data-descricao');
                var imagem = button.getAttribute('data-imagem');

                // Preencher os dados na modal
                modal.querySelector('.portfolio-modal-title').textContent = nomeJogo;
                modal.querySelector('.modal-body img').src = imagem;
                modal.querySelector('.modal-body p').textContent = descricao;
            });
        });
    </script>
</body>

</html>
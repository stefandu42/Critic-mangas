<!DOCTYPE HTML>
<html lang="fr">
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo VIEWS_PATH?>css/style.css" media="all">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Metakritik</title>
        <!--Fonts-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Antic+Slab&family=Trirong:wght@300&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Quattrocento&display=swap" rel="stylesheet">

    </head>
    <body>
    <!--navbar-->
    <?php if(!empty($_SESSION['connected'])){?>
        <header>
            <nav class="navbar navbar-dark navbar-expand-lg backgroundGray">
                <div class="container-fluid">
                    <a class="navbar-brand fs-1 fw-bold text-warning" href="index.php?action=exploration"><img src="views/images/logo.png" alt="METAKRITIK" width="90"> METAKRITIK</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                        <div class="d-flex" id="font-header">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <?php if(STATUS == 'Admin'){ ?>
                                <li class="nav-item">
                                    <a class="nav-link fs-2 text-warning btn-outline-secondary" href="index.php?action=admin" aria-disabled="true">Gestion Admin</a>
                                </li>
                                <?php } ?>
                                <li class="nav-item">
                                    <a class="nav-link fs-2 text-white btn-outline-secondary" href="index.php?action=exploration" aria-disabled="true">Exploration</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-2 text-white btn-outline-secondary" href="index.php?action=profil" aria-disabled="true">Profil</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-2 text-white img-fluid btn-outline-secondary" href="index.php?action=logout"  aria-disabled="true"> Se déconnecter </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

        </header>
    <?php } ?>
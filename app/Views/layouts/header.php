<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina ?? App::getName() ?></title>

    <link rel="shortcut icon" href="<?= App::getBasePath() ?>/public/uploads/image/logo.ico" type="image/x-icon">

    <!-- CSS Base -->
    <link rel="stylesheet" href="<?= App::getBasePath() ?>/public/css/style.css">

    <?php require_once __DIR__ . '/../../Helpers/ViewHelper.php'; ?>

    <!-- CSS EspecÃ­fico da PÃ¡gina -->
    <?php if (isset($cssPagina)): ?>
        <link rel="stylesheet" href="<?= App::getBasePath() ?>/public/css/<?= $cssPagina ?>">
    <?php endif; ?>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSS da NavegaÃ§Ã£o -->
    <link rel="stylesheet" href="<?= App::getBasePath() ?>/public/css/nav.css">
    <link rel="stylesheet" href="<?= App::getBasePath() ?>/public/css/footer.css">
</head>
<body>